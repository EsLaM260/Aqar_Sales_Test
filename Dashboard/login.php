<?php
// check have user or not
session_start();
// Check if the user is logged in
if (isset($_SESSION['username'])) {
  header("Location: index.php");
}
// connection database
$conn = mysqli_connect("localhost","root","","aqar_sales");
// handle login
if (isset($_POST["submit"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $user = mysqli_query($conn,"SELECT * FROM `admin` WHERE `username` = '$username' && `password` = '$password'");
  $result = mysqli_num_rows($user); 
  if ( $result > 0) {
    $_SESSION["username"] = $username;
    header("location: index.php");
  }else{
    $messagewrong = "<span class='wrong'>اسم المستخدم أو كلمة السر خطأ</span>";
  }
  $siferText =  sha1($password);
}
// handle change password
if (isset($_POST["change"])) {
  $username = $_POST["username"];
  $user_id =  mysqli_query($conn,"SELECT `id` FROM `admin` WHERE `username` = '$username'");
  if ($user_id->num_rows > 0) {
    while($row = $user_id->fetch_assoc()){
      $_SESSION["loginId"] = $row["id"];
    }
    header("Location: changepassword.php");
  }else{
    // show this in form
    $messageUser = "<span class='wrong'>قم بكتابه اسم المستخدم الصحيح</span>";
  }
}



?>



<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- mdi Icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/main.css" />
  <title>لوحه التحكم</title>
</head>
<body>
  <div class="loginpage">
    <div class="layer">
      <div class="form">
        <form action="login.php" method="post">
          <h2>تسجيل الدخول</h2>
          <div class="input-box">
            <span class="mdi mdi-account-key"></span>
            <input type="text" name="username" placeholder="ادخل اسم المستخدم">
          </div>
          <div class="input-box">
            <span class="mdi mdi-lock"></span>
            <input type="password" name="password" placeholder="ادخل كلمه السر">
            <span class="mdi mdi-eye-off-outline icon-display"></span>
          </div>
          <?php if (!empty($messageUser)):  ?>
            <?=$messageUser;?>
            <?php endif ?>
            <?php if (!empty($messagewrong)):  ?>
              <?=$messagewrong;?>
              <?php endif ?>
              <button type="submit" name="submit">تسجيل الدخول</button>
              <button type="submit" name="change" class="change">هل نسيت كلمة السر؟</button>
        </form>
      </div>
    </div>
  </div>
  <!-- Script -->
  <script src="js/main.js" type="module"></script>
</body>

</html>