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
      <div class="form">
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
          <div id="recaptcha-container"></div>
          <button id="continueBtn" class="btn" onclick="phoneAuth()">Continue</button>
        </div>

        <div id="otpDiv" style="display: none;">
          <input type="text" id="verificationcode" placeholder="OTP Code">
          <button id="otpButton" onclick="codeVerify()">Verify OTP</button>
        </div>
      </div>
    </div>
  </div>

  <!-- bootstrap -->
  <script src="js/jquery-3.6.0.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- main js -->
  <script src="js/main.js" type="module"></script>

  <!-- firebase -->
  <script src="https://www.gstatic.com/firebasejs/8.2.6/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.2.6/firebase-analytics.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.2.6/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.2.6/firebase-database.js"></script>
  <script>
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
      apiKey: "AIzaSyBJ7w1DjWhIgpzYuSPPytZtT1C3UlGq-Bo",
      authDomain: "aqar-sales.firebaseapp.com",
      databaseURL: "https://aqar-sales-default-rtdb.firebaseio.com",
      projectId: "aqar-sales",
      storageBucket: "aqar-sales.appspot.com",
      messagingSenderId: "220367685767",
      appId: "1:220367685767:web:9acb4e2f4ee70335885022",
      measurementId: "G-P24TV4XJZJ"
    };

    firebase.initializeApp(firebaseConfig);
    render();

    function render() {
      window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
      recaptchaVerifier.render();
    }

    const phoneDiv = document.getElementById("phoneDiv");
    const otpDiv = document.getElementById("otpDiv");
    // inputs
    const countrySelect = document.getElementById("countrySelect");
    const phoneInput = document.getElementById("phoneInput");
    const verificationcodeInput = document.getElementById("verificationcode");
    // click btn
    const continueBtn = document.getElementById("continueBtn");
    const otpButton = document.getElementById("otpButton");

    function showOtpInput() {
      phoneDiv.style.display = "none";
      otpDiv.style.display = "block";
    }

    function phoneAuth() {
      let finalNumber = `+${countrySelect.value}${phoneInput.value}`;
      firebase.auth().signInWithPhoneNumber(finalNumber, window.recaptchaVerifier).then(function(confirmationResult) {
        window.confirmationResult = confirmationResult;
        coderesult = confirmationResult;
        showOtpInput();
        console.log('OTP Sent');
      }).catch(function(error){
        console.log(error);
      })
    }

    function codeVerify(){
      let theCode = verificationcodeInput.value;
      coderesult.confirm(theCode).then(function(){
        console.log("success");
      }).catch(function(error){
        console.log("error");
      })
    }

  </script>

</body>

</html>