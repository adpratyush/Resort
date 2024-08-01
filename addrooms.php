<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// Start the session
session_start();

// Check if user is logged in as admin, if not, redirect to login page
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'Database/db_connection.php';

// Initialize variables
$message = '';
$rooms = [];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Process the form data
    $room_type = $_POST['room_type'];
    $room_count = $_POST['room_count'];
    $cost = $_POST['cost'];

    // Check if file is uploaded
    if (isset($_FILES['room_image']) && $_FILES['room_image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['room_image']['tmp_name'];
        $file_name = $_FILES['room_image']['name'];
        $photo_path = "images/" . $file_name; // Update path to images folder
        move_uploaded_file($file_tmp, $photo_path);
    } else {
        // Handle error if no file is uploaded
        $message = "Error: Please select a room image.";
    }

    // Insert room details into database if file is uploaded
    if (!empty($photo_path)) {
        $sql = "INSERT INTO Rooms (room_type, room_count, cost, room_image) VALUES ('$room_type', '$room_count', '$cost', '$photo_path')";
        if ($conn->query($sql) === TRUE) {
            $message = "Room added successfully";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}

// Remove room from database if room_id is provided
if (isset($_GET['remove_id'])) {
    $remove_id = $_GET['remove_id'];
    
    // Delete bookings associated with the room
    $sql_delete_bookings = "DELETE FROM bookings WHERE room_id = '$remove_id'";
    if ($conn->query($sql_delete_bookings) === TRUE) {
        // Now, delete the room
        $sql_remove = "DELETE FROM Rooms WHERE room_id = '$remove_id'";
        if ($conn->query($sql_remove) === TRUE) {
            $message = "Room removed successfully";
        } else {
            $message = "Error: " . $conn->error;
        }
    } else {
        $message = "Error deleting bookings: " . $conn->error;
    }
}

// Fetch all room data from the database
$sql = "SELECT * FROM Rooms";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Rooms</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/demo.css">

    <style>

.container {
    width: 90%; /* Adjusted width for responsiveness */
    margin: 0 auto;
    padding: 20px;
    max-width: 1200px; /* Adjusted max-width for larger screens */
}

h2 {
    color: #4CAF50;
    margin-top: 30px;
}

form {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    max-width: 100%; /* Adjusted max-width for responsiveness */
    margin-left: auto;
    margin-right: auto;
}

form label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

form input[type="text"],
form input[type="number"],
form input[type="file"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

form button {
    background-color: #87CEEB;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
}

form button:hover {
    background-color: #45a049;
}

table {
    width: 100%;
    border-collapse: collapse;
    background:#fff;
}

th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #4CAF50;
    color: #fff;
}

img {
    max-width: 100px;
    max-height: 100px;
    border-radius: 5px;
}

p.message {
    color: #4CAF50;
    font-weight: bold;
}

p.empty {
    color: #777;
    font-style: italic;
}

a.remove-link {
    color: #f44336;
    text-decoration: none;
    cursor: pointer;
}

a.remove-link:hover {
    text-decoration: underline;
}

/* Responsive Media Queries */
@media screen and (max-width: 768px) {
    .container {
        padding: 10px;
    }
    form {
        max-width: 100%;
    }
}

    </style>
</head>
<body>
    <?php include 'partials/adminHeader.php'; ?>

<section class="home">
    <div class="container">
        <h2>Add Room</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <label for="room_type">Room Type:</label><br>
            <input type="text" id="room_type" name="room_type" required><br>
            <label for="room_count">Room Count:</label><br>
            <input type="number" id="room_count" name="room_count" required><br>
            <label for="cost">Cost (per night):</label><br>
            <input type="text" id="cost" name="cost" required><br> <!-- Changed input type to text for decimal input -->
            <label for="room_image">Room Image:</label><br>
            <input type="file" id="room_image" name="room_image" accept="image/jpeg, image/jpg, image/png, image/gif" required><br><br>
            <button type="submit" name="submit">Add Room</button>
        </form>

        <p class="message"><?php echo $message; ?></p>

        <h2>Added Rooms</h2>
        <?php if (!empty($rooms)) { ?>
            <table>
                <tr>
                    <th>Room ID</th>
                    <th>Room Type</th>
                    <th>Room Count</th>
                    <th>Cost (per night)</th>
                    <th>Availability</th>
                    <th>Room Image</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($rooms as $room) { ?>
                    <tr>
                        <td><?php echo $room['room_id']; ?></td>
                        <td><?php echo $room['room_type']; ?></td>
                        <td><?php echo $room['room_count']; ?></td>
                        <td><?php echo $room['cost']; ?></td>
                        <td><?php echo $room['available'] ? 'Yes' : 'No'; ?></td>
                        <td><img src="<?php echo $room['room_image']; ?>" alt="Room Image" style="width: 100px;"></td>
                        <td><a class="remove-link" href="?remove_id=<?php echo $room['room_id']; ?>">Remove</a></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p class="empty">No rooms available</p>
        <?php } ?>
    </div>
        </section> 
</body>
</html>
