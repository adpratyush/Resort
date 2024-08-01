<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $new_password = $_POST['password'];

    // Validate the token
    $sql = "SELECT customer_id, reset_expires FROM Customers WHERE reset_token = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($customer_id, $reset_expires);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && $reset_expires > time()) {
        // Update the password
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $sql = "UPDATE Customers SET password = ?, reset_token = NULL, reset_expires = NULL WHERE customer_id = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("si", $hashed_password, $customer_id);
        if ($stmt->execute()) {
            echo "Your password has been successfully reset.";
        } else {
            echo "Failed to reset password.";
        }
    } else {
        echo "Invalid or expired token.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <form action="resetpassword.php" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
