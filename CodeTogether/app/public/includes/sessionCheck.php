<?php
if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'light';
}

if (!isset($_SESSION['rain_enabled'])) {
    $_SESSION['rain_enabled'] = false;
}

$theme = $_SESSION['theme'];
$rainEnabled = $_SESSION['rain_enabled'];
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?= htmlspecialchars($theme) ?>" data-rain="<?= $rainEnabled ? 'on' : 'off' ?>">
</html>