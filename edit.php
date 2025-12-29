<?php
include "db.php";

$id = $_GET['id'];

// Fetch student data
$sql = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$student = $stmt->fetch();

// Update student
if (isset($_POST['update'])) {
    $sql = "UPDATE students SET name=?, email=?, course=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $_POST['name'],
        $_POST['email'],
        $_POST['course'],
        $id
    ]);

    header("Location: index.php");
}

// Delete student
if (isset($_POST['delete'])) {
    $sql = "DELETE FROM students WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>

<h2>Edit / Delete Student</h2>

<form method="POST">
    Name: <input type="text" name="name" value="<?php echo $student['name']; ?>"><br><br>
    Email: <input type="email" name="email" value="<?php echo $student['email']; ?>"><br><br>
    Course: <input type="text" name="course" value="<?php echo $student['course']; ?>"><br><br>

    <button type="submit" name="update">Update</button>
    <button type="submit" name="delete" onclick="return confirm('Are you sure?')">Delete</button>
</form>

<a href="index.php">Back</a>

</body>
</html>
