<?php
// Include database setup
require_once 'database_setup.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize input data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    try {
        // Insert data into database
        $sql = "INSERT INTO contacts (name, email, message) VALUES (:name, :email, :message)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);
        $stmt->execute();

        $success = true;

    } catch(PDOException $e) {
        $error = "Error saving message: " . $e->getMessage();
    }

} else {
    // Redirect if accessed directly
    header("Location: contact_form.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Sent</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php if (isset($success)): ?>
            <h1>Thank You!</h1>
            <p>Your message has been sent successfully.</p>
            <div class="form-container">
                <p><strong>Name:</strong> <?php echo $name; ?></p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
                <p><strong>Message:</strong> <?php echo nl2br($message); ?></p>
            </div>
        <?php else: ?>
            <h1>Error</h1>
            <p><?php echo $error; ?></p>
        <?php endif; ?>

        <div class="navigation">
            <a href="contact_form.html" class="button">← Send Another Message</a>
            <a href="on_get_messages.php" class="button">View All Messages</a>
            <a href="index.html" class="button">Home</a>
        </div>
    </div>
</body>
</html>