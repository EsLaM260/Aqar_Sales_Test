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
    <div class="detailsPage">
      <!-- Start Sidebar -->
      <aside>
        <a class="logo" href="index.php">
          <img src="image/logo.png" alt="Logo" />
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
                  <a href="addProperty.php"> أضافه عقار </a>
                </li>
                <li>
                  <a href="showProperty.php"> عرض العقارات </a>
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
                  <a href="addConstruction.php"> أضافه مقاولة </a>
                </li>
                <li>
                  <a href="showConstruction.php"> عرض المقاولات </a>
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
                <img src="image/logo.png" alt="" />
              </a>
            </div>
            <div class="tab">
              <span class="mdi mdi-table-of-contents"></span>
            </div>
            <div class="search">
              <input type="text" placeholder="ابحث" />
            </div>
          </div>
          <div class="last">
            <img src="image/profile.png" alt="profile" />
            <form action="index.php" method="post">
              <button type="submit" name="logout">تسجيل خروج</button>
            </form>
          </div>
        </header>
        <!-- End Header -->
        <div class="details">
          <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
              <div class="product-details">
                <img src="image/background01.jpg" alt="" />
                <div class="main-data">
                  <ul>
                    <li>
                      <span class="mdi mdi-clock-outline"></span>
                      50 دقيقه
                    </li>
                    <li>
                      <a href="" class="category">بيع</a>
                    </li>
                  </ul>
                  <p>عنوان المنزل</p>
                  <h3>$ <span>2000</span></h3>
                  <p class="address">
                    <span class="mdi mdi-map-marker"></span>
                    القاهره ,اكتوبر
                  </p>
                </div>
                <div class="specifications">
                  <h3>المواصفات</h3>
                  <ul>
                    <li>
                      <span class="mdi mdi-bed-empty icon"></span>
                      2 غرفه
                    </li>
                    <li>
                      <span class="mdi mdi-shower icon"></span>
                      1 حمام
                    </li>
                    <li>
                      <span class="mdi mdi-fullscreen icon"></span>
                      200 متر
                    </li>
                  </ul>
                </div>
                <p class="description">
                  <span>الوصف</span>
                  تتميز هذه الشقة بموقع ممتاز في قلب وسط المدينة، حيث يوفر لك كل
                  ما تحتاجه من راحة وسهولة الوصول إلى جميع وسائل الراحة
                  والخدمات. تقع الشقة في مبنى حديث ومتطور، مع تصميم داخلي فاخر
                  ومرافق عصرية.
                </p>
                <div class="location">
                  <h3>الموقع</h3>
                  <p>القاهره ,اكتوبر</p>
                  <div class="map" id="showmap"></div>
                </div>
                <div class="Features">
                  <h3>مميزات العقار</h3>
                  <div class="sub">
                    <i class="fa-solid fa-check"></i>
                    <span>شرفة</span>
                  </div>
                  <div class="sub">
                    <i class="fa-solid fa-check"></i>
                    <span>اجهزة المطبخ</span>
                  </div>
                  <div class="sub">
                    <i class="fa-solid fa-check"></i>
                    <span>حديقة خاصه</span>
                  </div>
                  <div class="sub">
                    <i class="fa-solid fa-check"></i>
                    <span>تدفئة و تكييف مركزي</span>
                  </div>
                  <div class="sub">
                    <i class="fa-solid fa-check"></i>
                    <span>أمن</span>
                  </div>
                  <div class="sub">
                    <i class="fa-solid fa-check"></i>
                    <span>موقف سيارات</span>
                  </div>
                  <div class="sub">
                    <i class="fa-solid fa-check"></i>
                    <span>غرفة خدم</span>
                  </div>
                  <div class="sub">
                    <i class="fa-solid fa-check"></i>
                    <span>مسموح بالحيوانات الاليفة</span>
                  </div>
                  <div class="sub">
                    <i class="fa-solid fa-check"></i>
                    <span>حمام سباحة</span>
                  </div>
                  <div class="sub">
                    <i class="fa-solid fa-check"></i>
                    <span>عداد كهرباء</span>
                  </div>
                  <div class="sub">
                    <i class="fa-solid fa-check"></i>
                    <span>عداد مياه</span>
                  </div>
                  <div class="sub">
                    <i class="fa-solid fa-check"></i>
                    <span>غاز طبيعي</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="user-data">
                <div class="top">
                  <img src="image/profile.png" alt="" />
                  <div>
                    <h4>إسلام</h4>
                    <p>
                      <span>3 اعلانات</span>
                      <span>عضو منذ عام 2024</span>
                    </p>
                  </div>
                </div>
                <div class="bottom">
                  <a href="" class="call">
                    <i class="fa-solid fa-phone"></i>
                    اتصل الان
                  </a>
                  <a href="" class="whatsApp">
                    <i class="fa-brands fa-whatsapp"></i>
                    واتساب
                  </a>
                </div>
              </div>
              <div class="advice">
                <h3>إرشادات السلامة</h3>
                <div>
                  <i class="fa-solid fa-check"></i>
                  <p>
                    الحرص علي مقابلة البائع شخصيا والتأكد من هويته ( يفضل
                    مقابلته بمكان عام بحضور أحد الأصدقاء ).
                  </p>
                </div>
                <div>
                  <i class="fa-solid fa-check"></i>
                  <p>التأكد من معاينة المنتج وفحصه من قبل مختصين.</p>
                </div>
                <div>
                  <i class="fa-solid fa-check"></i>
                  <p>توثيق عملية البيع/الشراء مع ذكر تفاصيل كاملة للمنتج.</p>
                </div>
                <div>
                  <i class="fa-solid fa-check"></i>
                  <p>
                    عدم تحويل أي أموال إلا بعد التأكد من ( هوية البائع و توثيق
                    عملية البيع وإستلام المنتج ).
                  </p>
                </div>
                <div>
                  <i class="fa-solid fa-check"></i>
                  <p>الحرص علي الحصول علي سند قبض موقع من البائع.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
      <!-- End Main Content -->
    </div>
    <!-- Script -->
    <script src="js/main.js" type="module"></script>
  </body>
</html>
