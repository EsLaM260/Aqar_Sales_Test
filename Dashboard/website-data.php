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
    <!-- Leaflet CSS -->
    <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script
      src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
      integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
      crossorigin=""></script>
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
    <div class="addPage">
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
        <!-- Start Banner Form -->
        <section class="property-form">
          <h1>أضافة لافته</h1>
          <div class="form">
            <form action="">
              <div class="row">
                <div class="col-lg-6 col-md-6">
                  <div class="box">
                    <label for="">العنوان</label>
                    <input type="text" placeholder="العنوان" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="box">
                    <label for="">الشاشة</label>
                    <div class="select-box" tabindex="0">
                      <!-- Make it focusable -->
                      <div class="select-selected">اختر شاشة</div>
                      <div class="select-items select-hide">
                        <div>الموبايل</div>
                        <div>الموقع</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="box">
                    <label for="">الصور (اختر العديد من الصور)</label>
                    <div
                      id="uploadContainer"
                      onclick="document.getElementById('fileInput').click()">
                      <span class="mdi mdi-cloud-upload icon"></span>
                      <span>ارفع الصور</span>
                    </div>
                    <div id="imageContainer"></div>
                    <input
                      type="file"
                      id="fileInput"
                      style="display: none"
                      
                      />
                      <!-- onchange="handleFiles(this.files)" -->
                  </div>
                </div>
                <button type="submit" class="submit">اضافه</button>
              </div>
            </form>
          </div>
        </section>
        <!-- End Banner Form -->
        <!-- Start Web-details Form -->
        <section class="property-form">
          <h1>اضافه تفاصيل الموقع</h1>
          <div class="form">
            <form action="">
              <div class="row">
                <div class="col-lg-6 col-md-6">
                  <div class="box">
                    <label for="">رقم الهاتف</label>
                    <input type="text" placeholder="رقم الهاتف" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="box">
                    <label for="">البريد الالكتروني</label>
                    <input type="email" placeholder="البريد الالكتروني" />
                  </div>
                </div>
                <button type="submit" class="submit">أضافه</button>
              </div>
            </form>
          </div>
        </section>
        <!-- End Web-details Form -->
      </main>
      <!-- End Main Content -->
    </div>
    <!-- Script -->
    <script src="js/main.js" type="module"></script>
  </body>
</html>
