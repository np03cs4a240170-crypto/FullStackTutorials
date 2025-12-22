<?php
include 'includes/header.php';

/* ========= REQUIRED FUNCTIONS ========= */

function formatName($name) {
    return ucwords(strtolower(trim($name)));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function cleanSkills($string) {
    $skills = explode(",", $string);
    return array_map('trim', $skills);
}

function saveStudent($name, $email, $skillsArray) {
    $data = $name . "|" . $email . "|" . implode(",", $skillsArray) . PHP_EOL;
    file_put_contents("students.txt", $data, FILE_APPEND);
}

/* ========= FORM SUBMISSION LOGIC ========= */

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $name   = formatName($_POST['name']);
        $email  = $_POST['email'];
        $skills = cleanSkills($_POST['skills']);

        if (empty($name) || empty($email) || empty($skills)) {
            throw new Exception("All fields are required.");
        }

        if (!validateEmail($email)) {
            throw new Exception("Invalid email format.");
        }

        saveStudent($name, $email, $skills);
        $message = "<p style='color:green;'>Student saved successfully!</p>";

    } catch (Exception $e) {
        $message = "<p style='color:red;'>" . $e->getMessage() . "</p>";
    }
}
?>

<h2>Add Student</h2>

<?php echo $message; ?>

<form method="post">
    <label>Name:</label><br>
    <input type="text" name="name"><br><br>

    <label>Email:</label><br>
    <input type="text" name="email"><br><br>

    <label>Skills (comma separated):</label><br>
    <input type="text" name="skills"><br><br>

    <button type="submit">Save Student</button>
</form>

<?php
include 'includes/footer.php';
?>

