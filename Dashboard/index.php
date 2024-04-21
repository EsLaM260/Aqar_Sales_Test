<?php
// check have user or not
session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}
// handle logout
if (isset($_POST["logout"])) {
  session_destroy();
  header("location: login.php");
}


?>
<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- mdi Icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css">
  <title>Dashboard</title>
</head>
<body>
  <div class="dashboardPage">
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
          <!-- <a href="login.php">تسجيل خروج</a> -->
        </div>
      </header>
      <!-- End Header -->
      <!-- Start Welcome -->
      <section class="welcome">
        <h1>اهلا اسلام</h1>
        <p>مرحبا بعودتك</p>
      </section>
      <!-- End Welcome -->
      <!-- Start Statistics -->
      <section class="statistics">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="box">
              <span>
                <p>جميع المستخدمين</p>
                <h2>246</h2>
              </span>
              <span class="mdi mdi-account-group-outline icon"></span>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="box">
              <span>
                <p>جميع العقارات</p>
                <h2>246</h2>
              </span>
              <span class="mdi mdi-home-city icon"></span>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="box">
              <span>
                <p>عقارات معروضه للبيع</p>
                <h2>216</h2>
              </span>
              <span class="mdi mdi-home-lightning-bolt-outline icon"></span>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="box">
              <span>
                <p>عقارات معروضه للايجار</p>
                <h2>30</h2>
              </span>
              <span class="mdi mdi-home-clock icon"></span>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="box">
              <span>
                <p>جميع المقاولات</p>
                <h2>300</h2>
              </span>
              <span class="mdi mdi-account-hard-hat-outline icon"></span>
            </div>
          </div>
        </div>
      </section>
      <!-- End Statistics -->
    </main>
    <!-- End Main Content -->
  </div>
  <!-- Script -->
  <script src="js/main.js" type="module"></script>
</body>

</html>