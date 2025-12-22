<?php
function uploadPortfolioFile($file) {
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
    $maxSize = 2 * 1024 * 1024;

    if ($file['error'] !== 0) {
        throw new Exception("Upload error.");
    }

    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception("Invalid file type.");
    }

    if ($file['size'] > $maxSize) {
        throw new Exception("File too large.");
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newName = "portfolio_" . time() . "." . $ext;

    if (!move_uploaded_file($file['tmp_name'], "uploads/" . $newName)) {
        throw new Exception("Failed to save file.");
    }

    return "File uploaded successfully!";
}
?>
<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $message = uploadPortfolioFile($_FILES['portfolio']);
    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}
?>
<?php include 'includes/header.php'; ?>

<h2>Upload Portfolio</h2>
<p><?php echo $message; ?></p>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="portfolio" required>
    <button type="submit">Upload</button>
</form>

<?php include 'includes/footer.php'; ?>

