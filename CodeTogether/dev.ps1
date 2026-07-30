<#
Windows equivalent of dbMod.sh, docker-compose-start.sh, and freshDb.sh, consolidated
into one entry point.

Usage:
  .\dev.ps1 start [-Detach]   Bring the docker compose stack down and back up
  .\dev.ps1 fresh             Wipe mariadb data + uploads, then start fresh (detached)
  .\dev.ps1 db                Open an interactive mariadb shell using .env creds
#>

param(
    [Parameter(Position = 0)]
    [ValidateSet("start", "fresh", "db")]
    [string]$Command,

    # Named explicitly (not "-d") because PowerShell prefix-matches short
    # flags against its own common parameters, and "-d" silently resolves
    # to "-Debug" instead of reaching this script's own arguments.
    [switch]$Detach
)

$ErrorActionPreference = "Stop"
$root = $PSScriptRoot
Set-Location $root

function Read-DotEnv {
    $envPath = Join-Path $root ".env"
    if (-not (Test-Path $envPath)) {
        throw ".env not found at $envPath"
    }
    $vars = @{}
    foreach ($line in Get-Content $envPath) {
        $trimmed = $line.Trim()
        if ($trimmed -and -not $trimmed.StartsWith("#") -and $trimmed -match '^([^=]+)=(.*)$') {
            $vars[$matches[1].Trim()] = $matches[2].Trim()
        }
    }
    return $vars
}

function Start-Stack {
    param([switch]$Detach)

    # docker-compose.yml lives at repo root (not app/), unlike the original
    # docker-compose-start.sh which cd'd into app first.
    New-Item -ItemType Directory -Force -Path (Join-Path $root "app\public\uploads") | Out-Null
    # No chown/chmod step here: Docker Desktop's WSL2 backend makes Windows
    # bind mounts writable to the container by default, so it's not needed.

    docker compose down
    if ($LASTEXITCODE -ne 0) { throw "docker compose down failed" }

    if ($Detach) {
        docker compose up -d
    } else {
        docker compose up
    }
    if ($LASTEXITCODE -ne 0) { throw "docker compose up failed" }
}

function Reset-Db {
    docker compose down
    if ($LASTEXITCODE -ne 0) { throw "docker compose down failed" }

    Remove-Item -Recurse -Force -ErrorAction SilentlyContinue (Join-Path $root "mariadb\mariadb-data")
    Remove-Item -Recurse -Force -ErrorAction SilentlyContinue (Join-Path $root "app\public\uploads")

    Start-Stack -Detach
    Clear-Host
}

function Open-DbShell {
    $envVars = Read-DotEnv
    $user = $envVars["MYSQL_USER"]
    $pass = $envVars["MYSQL_PASSWORD"]
    $db = $envVars["MYSQL_DATABASE"]

    Write-Host "Connecting to database '$db' as user '$user'..."
    docker exec -it mariadb mariadb -u"$user" -p"$pass" "$db"
}

switch ($Command) {
    "start" { Start-Stack -Detach:$Detach }
    "fresh" { Reset-Db }
    "db"    { Open-DbShell }
    default {
        Write-Host "Usage: .\dev.ps1 <start|fresh|db> [-Detach]"
        Write-Host "  start [-Detach]   Rebuild and start the docker compose stack"
        Write-Host "  fresh             Wipe DB + uploads, then start fresh"
        Write-Host "  db                Open an interactive mariadb shell"
        exit 1
    }
}
