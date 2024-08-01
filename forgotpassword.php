<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Verify the user's email
    $sql = "SELECT customer_id FROM Customers WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate a reset token
        $token = bin2hex(random_bytes(50));
        $stmt->bind_result($customer_id);
        $stmt->fetch();

        // Update the database with the reset token and expiration time
        $expires = time() + 1800; // Token expires in 30 minutes
        $sql = "UPDATE Customers SET reset_token = ?, reset_expires = ? WHERE customer_id = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssi", $token, $expires, $customer_id);
        $stmt->execute();

        // Send an email
        $reset_link = "https://shivasimkhada.com.np/resetpassword.php?token=" . $token;
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: " . $reset_link;
        $headers = "From: no-reply@yourdomain.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "A password reset link has been sent to your email address.";
        } else {
            echo "Failed to send email.";
        }
    } else {
        echo "No account found with that email address.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>
</head>

<body>
    <form action="forgotpassword.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Send Reset Link</button>
    </form>
</body>

</html>