<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
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

</head>
<body>
    <?php include 'partials/custHeader.php'; ?>
    <section class="banner">
        <div class="container">
            <h2>Gallery</h2>
        </div>
    </section>

    <section class="slogan">
        <div class="container">
            <h3>Our Slogan</h3>
            <p class="beautiful-font">Making your stay unforgettable</p>
        </div>
    </section>
    <div class="album" style="display:flex;justify-content:center;">
    <div class="responsive-container-block bg">
    <div class="responsive-container-block img-cont">
      <img class="img" src="images/ban1.jpeg">
      <img class="img" src="images/ban2.jpeg">
      <img class="img img-last" src="images/ban3.jpeg">
      <img class="img img-big img-last" src="images/conferencehall.jpeg">

    </div>
    <div class="responsive-container-block img-cont">
      <img class="img img-big" src="images/cabin.jpeg">
      <img class="img img-big img-last" src="images/doublebed.jpeg">
      <img class="img img-big img-last" src="images/gym.webp">


    </div>
    <div class="responsive-container-block img-cont">
      <img class="img" src="images/bar.jpeg">
      <img class="img" src="images/resturant.webp">
      <img class="img" src="images/singlebed.jpeg">
    </div>
  </div>
</div>

    
    <?php include 'partials/footer.php'; ?>
   


</body>
</html>
<!-- Swiper JS -->
<script src="js/swiper-bundle.min.js"></script>

<!-- Scroll Reveal -->
<script src="js/scrollreveal.js"></script>

<!-- JavaScript -->
<script src="js/script.js"></script>

