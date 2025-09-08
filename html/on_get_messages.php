<?php
// Include database setup
require_once 'database_setup.php';

try {
    // Fetch all messages from database
    $sql = "SELECT * FROM contacts ORDER BY created_at DESC";
    $stmt = $pdo->query($sql);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $error = "Error fetching messages: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Messages</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>All Contact Messages</h1>

        <?php if (isset($error)): ?>
            <p>Error: <?php echo $error; ?></p>
        <?php elseif (empty($messages)): ?>
            <p>No messages found. <a href="contact_form.html">Submit the first message!</a></p>
        <?php else: ?>
            <?php foreach ($messages as $msg): ?>
                <div class="form-container" style="margin-bottom: 20px; border-left: 4px solid #007bff;">
                    <h3><?php echo htmlspecialchars($msg['name']); ?></h3>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($msg['email']); ?></p>
                    <p><strong>Message:</strong> <?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                    <p><strong>Submitted:</strong> <?php echo $msg['created_at']; ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="navigation">
            <a href="contact_form.html" class="button">Submit New Message</a>
            <a href="index.html" class="button">← Back to Home</a>
        </div>
    </div>
</body>
</html>