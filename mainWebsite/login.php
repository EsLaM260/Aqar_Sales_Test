<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Real State</title>
  <!-- mdi icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css">
  
</head>

<body>
  <div class="containerAll">
    <div class="layer">
      <form action="">
        <h1>Login</h1>
        <div id="phoneDiv" class="position-relative">
          <span class="mdi mdi-phone"></span>
          <select id="countrySelect">
            <option value="1">+1 (United States)</option>
            <option value="91">+91 (India)</option>
            <option value="20">+20 egypt</option>
            <!-- Add more country codes as needed -->
          </select>
          <input type="tel" id="phoneInput" placeholder="Enter your phone number">
          <button id="continueBtn" class="btn">Continue</button>
        </div>

        <div id="otpDiv" style="display: none;">
          <pin-view id="pinView"></pin-view>
          <button id="otpButton">Verify OTP</button>
        </div>
      </form>
    </div>
  </div>

  <!-- bootstrap -->
  <script src="js/jquery-3.6.0.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- main js -->
  <script src="js/main.js" type="module"></script>
</body>

</html>