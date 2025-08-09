<?php


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cart & Checkout-thank - Lustra Beauty </title>
  <link rel="stylesheet" href="cart.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <style>
    /* Global styles to ensure html and body take full height */
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      overflow-x: hidden;
      font-family: sans-serif;
    }

    /* Style for the main container with the background image */
    .step-thankyou {
      background-image: url("images/cart thank you backround image.avif");
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      min-height: 100vh;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Style for the main, transparent box that will contain everything */
    .thankyou-box {
      /* Made background fully transparent now */
      background: transparent;
      padding: 20px; /* Some overall padding for the transparent box if needed */
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4); /* A slightly stronger shadow for the transparent box effect */
      max-width: 650px; /* Make it larger as requested */
      width: 90%;
      box-sizing: border-box;
      display: flex; /* Use flexbox to easily center content horizontally */
      flex-direction: column; /* Stack children vertically */
      align-items: center; /* Center items horizontally within the flex container */
      position: relative; /* Needed for positioning the logo or inner image if desired */
    }

    /* Style for the transparent image (e.g., logo) that appears on top of the transparency */
    .thankyou-logo {
        position: absolute; /* Position it relative to .thankyou-box */
        top: 20px; /* Adjust as needed */
        right: 20px; /* Adjust as needed */
        width: 100px; /* Set a size for your logo/image */
        height: auto;
        opacity: 0.7; /* Make the logo slightly transparent if desired */
        z-index: 10; /* Ensure it's on top of the content-wrapper */
    }

    .thankyou-content-wrapper {
      background: rgba(199, 195, 199, 0.9); /* Your semi-transparent white background */
      padding: 50px 40px; /* Padding inside this inner wrapper */
      border-radius: 10px; /* Slightly less rounded than the outer box to differentiate */
      text-align: center;
      width: 100%; /* Make it fill the thank you box width */
      box-sizing: border-box;
      z-index: 5; /* Ensure content is above the main background but below logo if logo is outside */
    }

    /* Styles for the heading inside the thank you box */
    .thankyou-content-wrapper h2 { /* Targeting h2 inside the new wrapper */
      color: #F003C5;
      margin-bottom: 15px;
      font-size: 2.2em;
    }

    /* Styles for the paragraph inside the thank you box */
    .thankyou-content-wrapper p { /* Targeting p inside the new wrapper */
      color: #333;
      margin-bottom: 30px;
      font-size: 1.2em;
      line-height: 1.6;
    }

    /* Styles for the "Back to Home" button */
    .home-btn {
      padding: 12px 30px;
      background-color: #af3b9a;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      transition: background 0.3s ease;
      display: inline-block;
      font-weight: bold;
      font-size: 1.1em;
    }

    /* Hover effect for the button */
    .home-btn:hover {
      background-color: #bb57ac;
    }

  </style>
</head>
<body>

<div class="step-thankyou">
    <div class="thankyou-box">
        <div class="thankyou-content-wrapper">
            <h2>Thank You for Your Order!</h2>
            <p>Your purchase has been confirmed.</p>
            <a href="index.php" class="home-btn">Back to Home</a>
        </div>
    </div>
</div>


</body>
</html>