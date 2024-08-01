<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('Images/banner2.jpeg');
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input[type="text"],
        input[type="password"],
        input[type="tel"],
        input[type="email"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        .signup-success {
            color: green;
            text-align: center;
        }
        .signup-error {
            color: red;
            text-align: center;
        }
        .signup-image {
            display: block;
            margin: 0 auto;
            width: 200px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Customer Signup</h2>

        <?php
        include 'Database/db_connection.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];

            // Check if username already exists
            $check_username_sql = "SELECT * FROM Customers WHERE username = ?";
            $stmt = $conn->prepare($check_username_sql);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<p class='signup-error'>Username already exists. Please choose a different username.</p>";
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Insert new customer record into the database
                $insert_sql = "INSERT INTO Customers (name, username, password, address, phone, email) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insert_sql);
                $stmt->bind_param('ssssss', $name, $username, $hashed_password, $address, $phone, $email);

                if ($stmt->execute()) {
                    echo "<p class='signup-success'>Sign up successful. You can now <a href='login.php'>login</a> with your username and password.</p>";
                } else {
                    echo "<p class='signup-error'>Error: " . $stmt->error . "</p>";
                }
            }

            $stmt->close();
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Sign Up</button>
            <h3>Already Registered?</h3>
        </form>
        <a href="login.php"><button>Login</button></a>
    </div>
</body>
</html>
