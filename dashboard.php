<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
}

$theme = $_COOKIE['theme'] ?? 'light';
?>

<html>
<head>
<style>
body {
    background: <?= $theme == 'dark' ? 'black' : 'white' ?>;
    color: <?= $theme == 'dark' ? 'white' : 'black' ?>;
}
</style>
</head>

<body>

<h2>Dashboard</h2>
<p>Theme: <?= $theme ?></p>

<a href="preference.php">Change Theme</a><br><br>
<a href="logout.php">Logout</a>

</body>
</html>
