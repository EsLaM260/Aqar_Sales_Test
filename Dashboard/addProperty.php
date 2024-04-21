<?php
// check have user or not
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}
// ##################


if (isset($_POST["send"])) {
  
}


$username = "localhost";
$connection = mysqli_connect("localhost", "root", "", "aqar_sales");
$query = mysqli_query($connection, "SELECT * FROM `user`");


// echo "<pre>";
// print_r($data);
?>

<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <!-- Make sure you put this AFTER Leaflet's CSS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <!-- mdi Icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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
      <!-- Start Property Form -->
      <section class="property-form">
        <h1>أضافه عقار</h1>
        <div class="form">
          <form action="addProperty.php" method="get">
            <div class="row">
              <div class="col-lg-4 col-md-6">
                <div class="box">
                  <label for="">عنوان العقار</label>
                  <input type="text" placeholder="عنوان العقار" name="title" />
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="box">
                  <label for=""> نوع العقار</label>
                  <select name="type" id="">
                    <option value="architecture">عماير</option>
                    <option value="land">اراضي</option>
                    <option value="apartment">شقق</option>
                    <option value="furnished Apartment">شقق مفروشه</option>
                    <option value="furnished studios">استديوهات مفروشه</option>
                    <option value="role in architecture">دور</option>
                    <option value="Villa">فلل</option>
                    <option value="Shop">محلات</option>
                    <option value="house">بيت</option>
                    <option value="ٌrest">استراحه</option>
                    <option value="office">مكتب</option>
                    <option value="farm">مزرعه</option>
                    <option value="storehouse">مستودع</option>
                    <option value="camp">مخيم</option>
                    <option value="room">غرف</option>
                    <option value="chalet">شاليه</option>
                    <option value="company">شركات</option>
                    <option value="hall">قاعات</option>
                  </select>
                  <div class="select-box" tabindex="0">
                    <!-- Make it focusable -->
                    <div class="select-selected">اخترالنوع</div>
                    <div class="select-items select-hide">
                      <div>عماير</div>
                      <div>اراضي</div>
                      <div>شقق</div>
                      <div>شقق مفروشه</div>
                      <div>استديوهات مفروشه</div>
                      <div>دور</div>
                      <div>فلل</div>
                      <div>محلات</div>
                      <div>بيت</div>
                      <div>استراحه</div>
                      <div>مكتب</div>
                      <div>اراضي</div>
                      <div>مزرعه</div>
                      <div>عماير</div>
                      <div>مستودع</div>
                      <div>مخيم</div>
                      <div>غرف</div>
                      <div>شاليه</div>
                      <div>شركات</div>
                      <div>قاعات</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="box">
                  <label for="">فئة العقار</label>
                  <select name="category" id="">
                    <option value="sale">للبيع</option>
                    <option value="rent">للايجار</option>
                    <option value="daily rent">للايجار اليومي</option>
                  </select>
                  <div class="select-box" tabindex="0">
                    <!-- Make it focusable -->
                    <div class="select-selected">اختر فئة</div>
                    <div class="select-items select-hide">
                      <div>للبيع</div>
                      <div>للإيجار</div>
                      <div>للإيجار اليومي</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="box">
                  <label for="">عدد الغرف</label>
                  <select name="number-of-room" id="">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                  </select>
                  <div class="select-box" tabindex="0">
                    <!-- Make it focusable -->
                    <div class="select-selected">1</div>
                    <div class="select-items select-hide">
                      <div>1</div>
                      <div>2</div>
                      <div>3</div>
                      <div>4</div>
                      <div>5</div>
                      <div>6</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="box">
                  <label for="">عدد الحمامات</label>
                  <select name="number-of-bath" id="">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                  </select>
                  <div class="select-box" tabindex="0">
                    <!-- Make it focusable -->
                    <div class="select-selected">1</div>
                    <div class="select-items select-hide">
                      <div>1</div>
                      <div>2</div>
                      <div>3</div>
                      <div>4</div>
                      <div>5</div>
                      <div>6</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="box">
                  <label for="">السعر</label>
                  <input type="number" name="price" placeholder="السعر" />
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="box">
                  <label for="">المساحه</label>
                  <input type="number" name="space" placeholder="المساحه" />
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="box">
                  <label for="">العنوان</label>
                  <input type="text" name="address" placeholder="العنوان" />
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="box">
                  <label for="">فيديو (mp4)</label>
                  <input type="text" placeholder="لينك الفيديو" />
                </div>
              </div>
              <div class="col-12">
                <div class="box">
                  <label for="">الوصف</label>
                  <textarea rows="3" name="discription" placeholder="الوصف"></textarea>
                </div>
              </div>
              <div class="col-12">
                <div class="box stylemap">
                  <label for="">اختر موقعك</label>
                  <input type="text" name="lat">
                  <input type="text" name="lng">
                  <div id="map"></div>
                </div>
              </div>
              <div class="col-12">
                <div class="box">
                  <label for="">الصور (اختر العديد من الصور)</label>
                  <div id="uploadContainer" onclick="document.getElementById('fileInput').click()">
                    <span class="mdi mdi-cloud-upload icon"></span>
                    <span>ارفع الصور</span>
                  </div>
                  <div id="imageContainer"></div>
                  <input type="file" name="images[]" id="fileInput" multiple style="display: none" />
                  <!-- onchange="handleFiles(this.files)" -->
                </div>
              </div>
              <div class="col-12">
                <div class="box last">
                  <div class="subbox">
                    <input type="checkbox" name="features" id="Fully-furnished" value="Fully furnished" />
                    <label for="Fully-furnished">شرفة</label>
                  </div>
                  <div class="subbox">
                    <input type="checkbox" name="features" id="Balcony" value="Balcony" />
                    <label for="Balcony">اجهزة المطبخ</label>
                  </div>
                  <div class="subbox">
                    <input type="checkbox" name="features" id="Central" value="Central" />
                    <label for="Central">حديقة خاصة</label>
                  </div>
                  <div class="subbox">
                    <input type="checkbox" name="features" id="Security" value="Security" />
                    <label for="Security">تدفئة و تكييف مركزي</label>
                  </div>
                  <div class="subbox">
                    <input type="checkbox" name="features" id="Elevator" value="Elevator" />
                    <label for="Elevator">أمن</label>
                  </div>
                  <div class="subbox">
                    <input type="checkbox" name="features" id="Garage" value="Garage" />
                    <label for="Garage">موقف سيارات</label>
                  </div>
                  <div class="subbox">
                    <input type="checkbox" name="features" id="Maids-room" value="Maids room" />
                    <label for="Maids-room">غرفة خدم</label>
                  </div>
                  <div class="subbox">
                    <input type="checkbox" name="features" id="swimming-pool" value="swimming pool" />
                    <label for="swimming-pool">مسموح بلحيوانات الاليفة</label>
                  </div>
                  <div class="subbox">
                    <input type="checkbox" name="features" id="pets-allowed" value="pets allowed" />
                    <label for="pets-allowed">حمام سباحه</label>
                  </div>
                  <div class="subbox">
                    <input type="checkbox" name="features" id="pets-allowed" value="pets allowed" />
                    <label for="pets-allowed">عداد كهرباء</label>
                  </div>
                  <div class="subbox">
                    <input type="checkbox" name="features" id="pets-allowed" value="pets allowed" />
                    <label for="pets-allowed">عداد مياه</label>
                  </div>
                  <div class="subbox">
                    <input type="checkbox" name="features" id="pets-allowed" value="pets allowed" />
                    <label for="pets-allowed">غاز طبيعي</label>
                  </div>
                </div>
              </div>
              <button type="submit" name="send" class="submit">أضافه</button>
            </div>
          </form>
        </div>
      </section>
      <!-- End Property Form -->
    </main>
    <!-- End Main Content -->
  </div>
  <!-- Script -->
  <script src="js/main.js" type="module"></script>
</body>

</html>