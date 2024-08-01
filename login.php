<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'Database/db_connection.php';

session_start();

if (isset($_SESSION['username'])) {
    // If already logged in, redirect to the appropriate page
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == 'customer') {
            header("Location: welcomeCustomer.php");
        } elseif ($_SESSION['role'] == 'admin') {
            header("Location: welcomeadmin.php");
        }
        exit();
    }
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the login is for a customer
    $sql_customer = "SELECT * FROM Customers WHERE username = ?";
    $stmt_customer = $conn->prepare($sql_customer);
    $stmt_customer->bind_param('s', $username);
    $stmt_customer->execute();
    $result_customer = $stmt_customer->get_result();

    if ($result_customer->num_rows > 0) {
        $customer_data = $result_customer->fetch_assoc();
        if (password_verify($password, $customer_data['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'customer';
            $_SESSION['customer_id'] = $customer_data['customer_id']; // Store customer_id in session
            header("Location: welcomeCustomer.php");
            exit();
        } else {
            $message = "Invalid username or password.";
        }
    }

    // Check if the login is for an admin
    $sql_admin = "SELECT * FROM HotelAdmin WHERE username = ?";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->bind_param('s', $username);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();

    if ($result_admin->num_rows > 0) {
        $admin_data = $result_admin->fetch_assoc();
        if (password_verify($password, $admin_data['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'admin';
            header("Location: welcomeadmin.php");
            exit();
        } else {
            $message = "Invalid username or password.";
        }
    }

    // If neither customer nor admin, show error message
    $message = "Invalid username or password.";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
  <div class="container">
    <div class="row px-3">
      <div class="col-lg-10 col-xl-9 card flex-row mx-auto px-0">
        <div class="img-left d-none d-md-flex"></div>

        <div class="card-body">
          <h4 class="title text-center mt-4">
            Login into account
          </h4>
          <?php if (!empty($message)) { ?>
            <p class="text-danger"><?php echo $message; ?></p>
          <?php } ?>
          <form class="form-box px-3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-input">
              <span><i class="fa fa-envelope-o"></i></span>
              <input type="text" name="username" placeholder="Username" tabindex="10" required>
            </div>
            <div class="form-input">
              <span><i class="fa fa-key"></i></span>
              <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="mb-3">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="cb1" name="">
                <label class="custom-control-label" for="cb1">Remember me</label>
              </div>
            </div>

            <div class="mb-3">
              <button type="submit" class="btn btn-block text-uppercase">
                Login
              </button>
            </div>

            <hr class="my-4">

            <div class="text-center mb-2">
              Don't have an account?
              <a href="signup.php" class="register-link">
                Register here
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
