<?php
// check have user or not
session_start();
// connection database
$conn = mysqli_connect("localhost", "root", "", "aqar_sales");
// #######
$userId = $_SESSION["loginId"];
$userData = mysqli_query($conn, "SELECT * FROM `admin` WHERE `id` = '$userId' ");
$result = mysqli_num_rows($userData);
while ($row = $userData->fetch_assoc()) {
  $dbPassword = $row["password"];
}
if (isset($_POST["submit"])) {
  if ($dbPassword == $_POST["currentpassword"]) {
    $newPassword = $_POST["newpassword"];
    if ($_POST["newpassword"] == $_POST["confirmpassword"] && $_POST["newpassword"] != "") {
      mysqli_query($conn,"UPDATE `admin` SET password = '$newPassword'  WHERE id=$userId");
      header("Location: login.php");
    }else{
      $notmatch = "<span class='wrong'>أعد كتابة كلمة المرور الجديدة بشكل صحيح</span>";
    }

  }else{
    $worngpass = "<span class='wrong'>كلمة المرور الخاصة بك خاطئة</span>";
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
        <form action="changepassword.php" method="post">
          <h2>تغيير كلمه السر</h2>
          <div class="input-box">
            <span class="mdi mdi-account-key"></span>
            <input type="text" name="currentpassword" placeholder="ادخل كلمه السر القديمة">
          </div>
          <div class="input-box">
            <span class="mdi mdi-lock"></span>
            <input type="text" name="newpassword" placeholder="ادخل كلمه السر الحديثة">
          </div>
          <div class="input-box">
            <span class="mdi mdi-lock"></span>
            <input type="text" name="confirmpassword" placeholder="تأكيد كلمة السر">
          </div>
          <?php if (!empty($notmatch)):  ?>
            <?=$notmatch;?>
            <?php endif ?>
          <?php if (!empty($worngpass)):  ?>
            <?=$worngpass;?>
            <?php endif ?>
          <button type="submit" name="submit">تسجيل الدخول</button>
        </form>
      </div>
    </div>
  </div>
  <!-- Script -->
  <script src="js/main.js" type="module"></script>
</body>
</html>