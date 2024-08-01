<<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="css/about.css">
    <link rel="stylesheet" href="css/gallery.css">
    <!-- Swiper JS CSS-->
    <link rel="stylesheet" href="css/swiper-bundle.min.css">
    <!-- Scroll Reveal -->
    <link rel="stylesheet" href="css/scrollreveal.min.js">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Contact us</title>
    <style>
        body {
            background-image: url('images/contactus.jpeg');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            color: #333;
        }
        .contact-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            margin: 20px;
        }
        .form-container, .info-container {
            width: 100%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .info-container h2, .form-container h2 {
            margin-bottom: 20px;
            color: #5A9;
        }
        .info-container p, .info-container a {
            margin-bottom: 10px;
            display: block;
            font-size: 16px;
        }
        .info-container a {
            color: #5A9;
            text-decoration: none;
        }
        .info-container a:hover {
            text-decoration: underline;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-container input, .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .submit-button {
            background-color: #5A9;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }
        .submit-button:hover {
            background-color: #4A8;
        }
        .social-media-icons {
            display: flex;
            gap: 15px;
        }
        .social-media-icons a {
            color: inherit;
            text-decoration: none;
            font-size: 24px;
        }
        @media (min-width: 768px) {
            .contact-container {
                flex-direction: row;
                justify-content: space-between;
            }
            .form-container, .info-container {
                width: 45%;
            }
        }
    </style>
</head>
 
<body>
    <?php include 'partials/custHeader.php'; ?>
 
    <!-- Contact section -->
    <section class="contact-section">
        <div class="contact-container">
            <div class="info-container">
                <h2>Contact Information</h2>
                <div class="info-block">
                    <h3>Hotel Location</h3>
                    <p>Neelkantha, Dhading</p>
                    <p>Tel: +977-98541056815, +977-9840030049</p>
                    <p>Viber / WhatsApp: 9840030049</p>
                    <a href="mailto:info@snowpal.com.np">info@snowpal.com.np</a>
                </div>
                <div class="info-block">
                    <h3>Sales Office</h3>
                    <p>Chhetrapati, Kathmandu</p>
                    <p>Tel: +977-9851076838, +977-9813841152</p>
                    <a href="mailto:info@snowpal.com.np">info@snowpal.com.np</a>
                    <p>Hours: 10:00 am to 6:00 pm</p>
                </div>
                <div class="info-block">
                    <h3>Social Media</h3>
                    <div class="social-media-icons">
                        <a href="#"><i class="icon-facebook" style="color:blue;"></i></a>
                        <a href="#"><i class="icon-instagram"></i></a>
                    </div>
                </div>
            </div>

            <div class="form-container">
                <h2>Your Details</h2>
                <form action="process_form.php" method="POST">
                    <label for="name">Name: </label>
                    <input type="text" id="name" name="name" required>
                    
                    <label for="email">Email: </label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="phone">Phone: </label>
                    <input type="tel" id="phone" name="phone">
                    
                    <label for="message">Message: </label>
                    <textarea id="message" name="message" rows="4" required></textarea>
                    
                    <button type="submit" class="submit-button">Submit</button>
                </form>
            </div>
        </div>
    </section>
 
    <?php include 'partials/footer.php'; ?>
 
</body>
 
</html>

<!-- Swiper JS -->
<script src="js/swiper-bundle.min.js"></script>

<!-- Scroll Reveal -->
<script src="js/scrollreveal.js"></script>

<!-- JavaScript -->
<script src="js/script.js"></script>