<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/demo.css">
    <title>Welcome Admin</title>
    <style>
        section {
            padding: 20px;
            margin: 20px;
            background-color: #ffffff;
            /* border-radius: 10px; */
            /* box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); */
        }

        h1 {
            color: #4CAF50;
            font-size: 32px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color:#87CEEB;
            color: white;
        }

        img {
            max-width: 200px; /* Adjusted size for larger room images */
            max-height: 200px; /* Adjusted size for larger room images */
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }
        a button{
            width:auto;
            margin-top:2em;
        }

        @media (max-width: 768px) {
            body{
                height:10vh;
                width:10px;
            }
            section {
                padding: 10px;
                margin: 10px;
            }

            h1 {
                font-size: 1.5rem; /* Smaller font size for smaller devices */
            }

            th, td {
                padding: 8px;
            }

            button {
                padding: 8px 16px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.25rem; /* Even smaller font size for very small devices */
            }

            th, td {
                padding: 6px;
            }

            button {
                padding: 6px 12px;
            }
        }
    </style>
</head>
<body>
    <?php
    // Start the session
    session_start();

    // Check if user is logged in as admin, if not, redirect to login page
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    // Check if user is logged in as admin, if not, redirect to login page
    if ($_SESSION['role'] != 'admin') {
        header("Location: login.php");
        exit();
    }
    // Logout logic
    // Check if logout link is clicked
    if(isset($_GET['logout'])) {
        // Unset all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to index.php page
        header("Location: index.php");
        exit;
    }

    // Get the username of the logged-in admin
    $admin_username = $_SESSION['username'];

    // Include admin header
    

    // Include database connection
    include 'Database/db_connection.php';

    // Fetch room data from the database
    $sql = "SELECT r.room_id, r.room_type, r.room_image, r.room_count, COALESCE(SUM(b.room_count), 0) AS booked_count
            FROM Rooms r
            LEFT JOIN bookings b ON r.room_id = b.room_id
            WHERE b.status = 'confirmed'
            GROUP BY r.room_id";
    $result = mysqli_query($conn, $sql);
    ?>
    <?php include 'partials/adminHeader.php';?>
    <section class="home">
        
        <h1>Room Information</h1>
        <table>
            <tr>
                <th>Room Image</th>
                <th>Room Type</th>
                <th>Total Rooms</th>
                <th>Rooms Booked</th>
            </tr>
            <?php
            // Display room data
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><img src='{$row['room_image']}' alt='{$row['room_type']}'></td>";
                    echo "<td>{$row['room_type']}</td>";
                    echo "<td>{$row['room_count']}</td>";
                    echo "<td>{$row['booked_count']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No rooms found</td></tr>";
            }
            ?>
        </table>
    </section>

</body>
</html>
