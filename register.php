<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO students (student_id, name, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $student_id, $name, $password);
    $stmt->execute();

    header("Location: login.php");
}
?>

<html>
<body>
<h2>Register</h2>

<form method="post">
    Student ID: <input type="text" name="student_id"><br><br>
    Name: <input type="text" name="name"><br><br>
    Password: <input type="password" name="password"><br><br>
    <button type="submit">Register</button>
</form>

</body>
</html>
