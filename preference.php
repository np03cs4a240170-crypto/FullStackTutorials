<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    setcookie("theme", $_POST['theme'], time() + 86400*30);
    header("Location: dashboard.php");
}
?>

<html>
<body>

<h2>Select Theme</h2>

<form method="post">
<select name="theme">
    <option value="light">Light</option>
    <option value="dark">Dark</option>
</select>
<button type="submit">Save</button>
</form>

</body>
</html>
