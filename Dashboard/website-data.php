<?php
// check have user or not
session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}

// connection database
$connection = mysqli_connect("localhost", "root", "", "aqar_sales");
// handle form and validation
// test input function
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if (isset($_POST["bannerform"])) {
  $errors = [];
  $name = $_POST["name"];
  $screen = $_POST["screen"];
  // $Images = $_FILES["Images"];

  // ################################   All Validation ################################
  // validation name
  if (empty($name)) {
    $errors["Err_name"] = "ادخل الاسم";
  } else {
    $name = test_input($name);
    // check if name only contain letter and white space allowed
    if (!preg_match("/^[a-zA-Z\d\s]*$/", $name)) {
      $errors["Err_name"] = "يُسمح فقط بالأحرف والأرقام والمسافات الاساسية";
    }
  }

  // validation image
  if (isset($_FILES["Images"]) && $_FILES["Images"]["error"] == 0) {
    $allImages = [];
    $images = $_FILES["Images"];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 40 * 1024 * 1024; // 40 MB in bytes
    $file_name = $images['name'];
    $file_size = $images['size'];
    $file_type = $images['type'];
    $file_error = $images['error'];

    if ($file_error == UPLOAD_ERR_OK) {

      if ($file_size > $maxSize) {
        $errors["image"] = "Image '$file_name' size should not exceed 15 MB";
      } elseif (!in_array($file_type, $allowedTypes)) {
        $errors["image"] = "'$file_name' يُسمح فقط بالصور بتنسيقات JPEG وPNG وGIF";
      } else {
        // Generate a unique file name
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $newFileName = date("YmdHis") . '_' . mt_rand(1000, 9999) . '.' . $extension;

        // Move the uploaded file to the desired directory with the new name
        $uploadDir = '../Banner/';
        $uploadFile = $uploadDir . $newFileName;
        if (move_uploaded_file($images['tmp_name'][$i], $uploadFile)) {
          // File successfully uploaded, store its data in the array
          $allImages[] = [
            'name' => $newFileName,
            'type' => $file_type,
            'path' => $uploadFile
          ];
        } else {
          $errors["image"] = "Error in uploading file '$file_name'";
        }
      }
    } else {
      $errors["image"] =  "Error in uploading file '$file_name'";
    }
  } else {
    $errors["image"] = "الصور مطلوبة";
  }
}




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
      <!-- Start Banner Form -->
      <section class="property-form">
        <h1>أضافة لافته</h1>
        <div class="form">
          <form action="website-data.php" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-lg-6 col-md-6">
                <div class="box">
                  <label for="">الاسم</label>
                  <input type="text" name="name" placeholder="الاسم" />
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="box">
                  <label for="">الشاشة</label>
                  <select name="screen" id="">
                    <option value="mobile">موبايل</option>
                    <option value="website">موقع</option>
                  </select>
                  <div class="select-box" tabindex="0">
                    <!-- Make it focusable -->
                    <div class="select-selected">موبايل</div>
                    <div class="select-items select-hide">
                      <div>موبايل</div>
                      <div>موقع</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="box">
                  <label for="">صور (اختر العديد من الصور)</label>
                  <div id="uploadContainer" onclick="document.getElementById('fileInput').click()">
                    <span class="mdi mdi-cloud-upload icon"></span>
                    <span>ارفع صورك</span>
                  </div>
                  <div id="imageContainer"></div>
                  <input type="file" name="Images" id="fileInput" style="display: none" />
                  <!-- onchange="handleFiles(this.files)" -->
                </div>
              </div>
              <button type="submit" name="bannerform" class="submit">اضافه</button>
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