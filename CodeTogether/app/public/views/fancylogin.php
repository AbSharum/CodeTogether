<!DOCTYPE html>
<html lang="en">
<head>
  <title>Code Together Account Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel = "stylesheet" href = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/public/css/fancy.css"> 
</head>
<body class = "bg-dark text-light">
    <canvas id="matrix-canvas"></canvas>

    <div class="container">
        <div class="card p-4 mx-4" style="max-width: 400px;">
            <div class="card-matrix w-full">
                <h2 class="card-title text-center mb-4 text-2x1 font-bold" style="color:#0f0;">Code Together Login</h2>
                
                <form action = "index.php?action=login" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="text-sm mt-2 text-left" style="color:#0f0;">
                            <input type="checkbox" onclick="showPass()" style="margin-rigth: 4px;">Show Password<br>
                            <input type="checkbox" id="rememberMe" name="rememberMe" value = "1" style="margin-right: 4px;">
                            <label class="form-check-label" for="rememberMe">Remember Me</label>
                        </div>
                    </div>  
                    
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-success">Access System</button>
                    </div>
                </form>
                
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-success" onclick="window.location.href='index.php?action=createAccount'">Create Account</button>
                </div>
                <p class="mt-4"><a href="/public/Privacy.html">Privacy Policy</a></p><br> 
                <p><a href="/public/Terms.html">Terms and Conditions</a></p>
            </div>
        </div>
    </div>
    
    <script src="/public/js/fancyLogin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
