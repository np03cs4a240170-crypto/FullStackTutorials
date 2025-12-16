<?php
$errors = [];
$success = "";

$name = $email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm_password"];

    if (empty($name)) {
        $errors["name"] = "Name is required";
    }

    if (empty($email)) {
        $errors["email"] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Invalid email format";
    }

    if (empty($password)) {
        $errors["password"] = "Password is required";
    } elseif (strlen($password) < 8) {
        $errors["password"] = "Password must be at least 8 characters";
    }

    if ($password !== $confirm) {
        $errors["confirm"] = "Passwords do not match";
    }

    if (empty($errors)) {
        $file = "users.json";

        if (!file_exists($file)) {
            $errors["file"] = "users.json not found";
        } else {
            $data = file_get_contents($file);
            $users = json_decode($data, true);

            if (!is_array($users)) {
                $users = [];
            }

            $users[] = [
                "name" => $name,
                "email" => $email,
                "password" => password_hash($password, PASSWORD_DEFAULT)
            ];

            file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));
            $success = "Registration successful!";
            $name = $email = "";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <style>
        body { font-family: Arial; }
        .error { color: red; }
        .success { color: green; }
        label { display: block; margin-top: 10px; }
    </style>
</head>
<body>

<h2>User Registration</h2>

<?php if ($success): ?>
    <div class="success"><?= $success ?></div>
<?php endif; ?>

<form method="post">

    <label>
        Name:
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
        <span class="error"><?= $errors["name"] ?? "" ?></span>
    </label>

    <label>
        Email:
        <input type="text" name="email" value="<?= htmlspecialchars($email) ?>">
        <span class="error"><?= $errors["email"] ?? "" ?></span>
    </label>

    <label>
        Password:
        <input type="password" name="password">
        <span class="error"><?= $errors["password"] ?? "" ?></span>
    </label>

    <label>
        Confirm Password:
        <input type="password" name="confirm_password">
        <span class="error"><?= $errors["confirm"] ?? "" ?></span>
    </label>

    <br>
    <button type="submit">Register</button>

</form>

<?php if (!empty($errors["file"])): ?>
    <div class="error"><?= $errors["file"] ?></div>
<?php endif; ?>

</body>
</html>
