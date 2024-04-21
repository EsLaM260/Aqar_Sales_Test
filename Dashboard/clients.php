<?php
// check have user or not
session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}
// ##################


$username = "localhost";
$connection = mysqli_connect("localhost", "root", "", "aqar_sales");
$query = mysqli_query($connection, "SELECT * FROM `user`");
$data = [];
while ($row = mysqli_fetch_assoc($query)) {
  $data[] = $row;
};
// echo "<pre>";
// print_r($data);
?>

<!DOCTYPE html>
<html lang="en" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- mdi Icon -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" />
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/main.css" />
    <title>Dashboard</title>
  </head>
  <body>
    <div class="showPage">
      <!-- Start Sidebar -->
      <aside>
        <a class="logo" href="index.php">
          <img src="image/logo.png" alt="Logo">
        </a>
        <ul>
          <li>
            <a href="index.php">
              <span class="mdi mdi-view-dashboard"></span>
              لوحة تحكم
            </a>
          </li>
          <li class="sidebar-submenu">
            <a href="">
              <span class="mdi mdi-home-city"></span>
              عقارات
            </a>
            <div class="sidebar-submenu-item">
              <ul>
                <li>
                  <a href="addProperty.php">
                    أضافه عقار
                  </a>
                </li>
                <li>
                  <a href="showProperty.php">
                    عرض العقارات
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-submenu">
            <a href="">
              <span class="mdi mdi-home-city"></span>
              مقاولات
            </a>
            <div class="sidebar-submenu-item">
              <ul>
                <li>
                  <a href="addConstruction.php">
                    أضافه مقاولة
                  </a>
                </li>
                <li>
                  <a href="showConstruction.php">
                    عرض المقاولات
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <a href="clients.php">
              <span class="mdi mdi-account-check"></span>
              العملاء
            </a>
          </li>
          <li>
            <a href="website-data.php">
              <span class="mdi mdi-web-check"></span>
              تفاصيل الموقع
            </a>
          </li>
        </ul>
      </aside>
      <!-- End Sidebar -->
      <!-- Start Main Content -->
      <main>
        <!-- Start Header -->
        <header>
          <div class="first">
            <div class="logo">
              <a href="index.php">
                <img src="image/logo.png" alt="">
              </a>
            </div>
            <div class="tab">
              <span class="mdi mdi-table-of-contents"></span>
            </div>
            <div class="search">
              <input type="text" placeholder="ابحث">
            </div>
          </div>
          <div class="last">
            <img src="image/profile.png" alt="profile">
            <form action="index.php" method="post">
              <button type="submit" name="logout">تسجيل خروج</button>
            </form>
          </div>
        </header>
        <!-- End Header -->
        <div class="allproduct-list">
          <div class="row">
            <!-- <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="client-data">
                <div class="main">
                  <div class="image">
                    <img src="image/profile.png" alt="profiles">
                  </div>
                  <h3>Eslam Mostafa</h3>
                </div>
                <div class="other">
                  <p>
                    Email : <span>example@gmail.com</span>
                  </p>
                  <p>
                    Phone : <span>1238545644</span>
                  </p>
                  <p>
                    address : <span>Egypt</span>
                  </p>
                  <p>
                    Date of barth : <span>12/8/2000</span>
                  </p>
                </div>
                <div class="btn open-id">check ID</div>
                <div class="id-container">
                  <div class="img">
                    <span class="close-image-id"><i class="fa-solid fa-xmark"></i></span>
                    <img src="image/background01.jpg" alt="ID Image">
                    <button>Correct Id</button>
                  </div>
                </div>
              </div>
            </div> -->
          </div>
          <div class="number-list">
            <ul>
              <li>
                <button class="prev-btn"><i class="fa-solid fa-chevron-left"></i></button>
              </li>
              <li class="number-page active">1</li>
              <li>
                <button class="next-btn"><i class="fa-solid fa-chevron-right"></i></button>
              </li>
            </ul>
          </div>
        </div>
      </main>
      <!-- End Main Content -->
    </div>
    <!-- Script -->
    <script src="js/main.js" type="module"></script>
    <script type="module">

      let product  = <?= json_encode($data); ?>;
      console.log(product);

      import {displayAllProduct} from './js/displayProduct.js';
      import {checkId} from './js/verifyId.js';
      displayAllProduct(product , checkId);

    </script>
  </body>
</html>
