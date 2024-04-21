<?php 
// check have user or not
session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}
// ##################


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
          <div class="row"> </div>
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
  </body>
</html>
