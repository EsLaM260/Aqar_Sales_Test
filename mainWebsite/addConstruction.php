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

// handle insert data
if (isset($_POST["send"])) {
  $errors = [];
  $title = $_POST["title"];
  $category = $_POST["category"];
  $address = $_POST["address"];
  $country = $_POST["country"];
  $paid = $_POST["paid"];
  $description = $_POST["description"];
  $lat = $_POST["lat"];
  $lng = $_POST["lng"];
  // $Video = $_FILES["Video"];
  // $Images = $_FILES["Images"];

  // ################################   All Validation ################################
  // validation title
  if (empty($title)) {
    $errors["Err_title"] = "ادخل الاسم";
  } else {
    $title = test_input($title);
    // check if title only contain letter and white space allowed
    if (!preg_match("/^[a-zA-Z\d\s]*$/", $title)) {
      $errors["Err_title"] = "يُسمح فقط بالأحرف والأرقام والمسافات الاساسية";
    }
  }
  // validation address
  if (empty($address)) {
    $errors["Err_address"] = "ادخل العنوان";
  } else {
    $address = test_input($address);
    // check if address only contain letter and white space allowed
    if (!preg_match("/^[a-zA-Z\d\s]*$/", $address)) {
      $errors["Err_address"] = "يُسمح فقط بالأحرف والأرقام والمسافات الاساسية";
    }
  }
  // validation description
  if (empty($description)) {
    $errors["Err_description"] = "ادخل الوصف";
  } else {
    $description = test_input($description);
    // check if description only contain letter and white space allowed
    if (!preg_match("/^[a-zA-Z\d\s]*$/", $description)) {
      $errors["Err_description"] = "يُسمح فقط بالأحرف والأرقام والمسافات الاساسية";
    }
  }
  // validation video
  $target_file = NULL;
  if (isset($_FILES["Video"]) && $_FILES["Video"]["error"] == 0 && $_FILES["Video"]["size"] > 0) {
    $video = $_FILES["Video"];
    $allowed_extensions = array("mp4", "avi", "mov", "mkv");
    // Define folder to save uploaded videos
    $upload_dir = "../Videos/";
    // Generate a unique filename based on current date and random number
    $file_name = "data_" . date("YmdHis") . "_" . mt_rand(1000, 9999) . "." . pathinfo($video['name'], PATHINFO_EXTENSION);
    // Combine upload directory and file name
    $target_file = $upload_dir . $file_name;
    // Check if the file is a valid video file
    $file_ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (!in_array($file_ext, $allowed_extensions)) {
      $errors["Video"] = "تنسيق ملف غير صالح. يُسمح فقط بملفات MP4 وAVI وMOV وMKV.";
    } else {
      if (move_uploaded_file($video['tmp_name'], $target_file)) {
        // Check the duration of the video file
        $ffprobe_output = shell_exec("ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 " . escapeshellarg($target_file));
        $duration = round(floatval($ffprobe_output));
        // check if video more than 5 min = 300 sec
        if ($duration > 300) {
          $errors["Video"] = "تتجاوز مدة الفيديو الحد المسموح به وهو 5 دقائق.";
          // Delete the file if its duration exceeds the limit
          unlink($target_file);
        }
      }
    }
  }
  // validation image
  if (isset($_FILES["Images"]) && $_FILES["Images"]["error"][0] == 0) {
    $allImages = [];
    $images = $_FILES["Images"];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 40 * 1024 * 1024; // 40 MB in bytes
    $totalImages = count($images['tmp_name']);

    for ($i = 0; $i < $totalImages; $i++) {
      $file_name = $images['name'][$i];
      $file_size = $images['size'][$i];
      $file_type = $images['type'][$i];
      $file_error = $images['error'][$i];

      if ($file_error == UPLOAD_ERR_OK) {

        if ($file_size > $maxSize) {
          $errors["image"] = "Image '$file_name' size should not exceed 40 MB";
          break; // Break the loop if one file exceeds the size limit
        } elseif (!in_array($file_type, $allowedTypes)) {
          $errors["image"] = "'$file_name' يُسمح فقط بالصور بتنسيقات JPEG وPNG وGIF";
          break; // Break the loop if one file has an invalid format
        } else {
          // Generate a unique file name
          $extension = pathinfo($file_name, PATHINFO_EXTENSION);
          $newFileName = date("YmdHis") . '_' . mt_rand(1000, 9999) . '.' . $extension;

          // Move the uploaded file to the desired directory with the new name
          $uploadDir = '../Images/';
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
            break; // Break the loop if one file has an error
          }
        }
      } else {
        $errors["image"] =  "Error in uploading file '$file_name'";
        break; // Break the loop if one file has an error
      }
    }
  } else {
    $errors["image"] = "الصور مطلوبة";
  }

  // check if array of error is empty
  if (empty($errors)) {
    $date = date("Y-m-d");
    $queryConstruction = "INSERT INTO `construction` (`title`, `construction_category_id`, `address`, `country_id`, `paid`, `description`, `location-lat`, `location-lng`, `video`, `create_at`, `user_id`) VALUES ('$title','$category','$address','$country','$paid','$description','$lat','$lng','$target_file','$date','0')";
    if (mysqli_query($connection, $queryConstruction)) {
      $Construction_id = $connection->insert_id;
      // get all images and insert it into db
      foreach ($allImages as $item) {
        $name = $item["name"];
        $queryPhoto = "INSERT INTO `photo_construction`(`construction_id`,`image`) VALUES ('$Construction_id','$name')";
        if (mysqli_query($connection, $queryPhoto)) {
          $success = "تم الرفع بنجاح";
        }
      }
    } else {
      echo "false";
    }
  }
  if (!empty($errors)) {
    if (isset($_FILES["Video"]) && $_FILES["Video"]["error"] == 0 && $_FILES["Video"]["size"] > 0) {
      unlink($target_file);
    }
    if (isset($_FILES["images"]) && $_FILES["images"]["error"][0] == 0) {
      foreach ($allImages as $item) {
        unlink($item["path"]);
      }
    }
  }
  print_r($errors);
}



?>
<!DOCTYPE html>
<html lang="en">

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
  <title>لوحة التحكم</title>
</head>

<body>
  <div class="addPage">
    <!-- Start Header -->
    <header class="not_home">
      <div class="container1">
        <a href="../index.html" class="logo">
          <img src="image/01.jpg" alt="Icon">
        </a>
        <ul>
          <li class="language">
            <a href="">
              <img src="image/EnglashFlag.png" alt="EnglashFlag">
              <span>English</span>
            </a>
          </li>
          <li>
            <a href="login.php">Log In</a>
          </li>
          <li class="ads">
            <a href="addproperty.php">Post property</a>
          </li>
          <li class="ads">
            <a href="addConstruction.php">Post construction</a>
          </li>
        </ul>
        <div class="responsiveMenu">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </header>
    <!-- End Header -->
    <div class="maincontent">
      <!-- Start Construction Form -->
      <section class="property-form">
        <h1>
          اضافة مقاوله
          <?php if (!empty($success)) : ?>
            <span class="success"> : <?= $success ?> </span>
          <?php endif ?>
        </h1>
        <div class="form">
          <form action="addConstruction.php" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-lg-4 col-md-6">
                <div class="box">
                  <label for="">عنوان المقاوله</label>
                  <?php if (!empty($errors["Err_title"])) : ?>
                    <span class="error"> : <?= $errors["Err_title"] ?> </span>
                  <?php endif ?>
                  <input type="text" name="title" placeholder="عنوان المقاوله" />
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="box">
                  <label for="">فئة البناء</label>
                  <select name="category" id="">
                    <option value="1">مكافحة الحشرات</option>
                    <option value="2">الاقفال</option>
                    <option value="3">مقاول صحي</option>
                    <option value="4">التكييف</option>
                    <option value="5">أصباغ</option>
                    <option value="6">أعمال الديكور</option>
                    <option value="7">مشاتل و حدائق</option>
                    <option value="8">صيانة أجهزه منزلية</option>
                    <option value="9">مصاعد</option>
                    <option value="10">نجار</option>
                    <option value="11">حدادة</option>
                    <option value="12">الابواب</option>
                    <option value="13">ألمنيوم</option>
                    <option value="14">مقاولات بناء</option>
                    <option value="15">كاشي و سيراميك</option>
                    <option value="16">عازل</option>
                    <option value="17">فني زجاج</option>
                    <option value="18">مقاول كهرباء</option>
                    <option value="19">أعمال التهوية</option>
                    <option value="20">خزانات مياه</option>
                    <option value="21">مواد بناء</option>
                  </select>

                  <div class="select-box" tabindex="0">
                    <!-- Make it focusable -->
                    <div class="select-selected">اختر فئة</div>
                    <div class="select-items select-hide">
                      <div>مكافحة الحشرات</div>
                      <div>الاقفال</div>
                      <div>مقاول صحي</div>
                      <div>التكييف</div>
                      <div>أصباغ</div>
                      <div>أعمال الديكور</div>
                      <div>مشاتل و حدائق</div>
                      <div>صيانة أجهزه منزلية</div>
                      <div>مصاعد</div>
                      <div>نجار</div>
                      <div>حدادة</div>
                      <div>الابواب</div>
                      <div>ألمنيوم</div>
                      <div>مقاولات بناء</div>
                      <div>كاشي و سيراميك</div>
                      <div>عازل</div>
                      <div>فني زجاج</div>
                      <div>مقاول كهرباء</div>
                      <div>أعمال التهوية</div>
                      <div>خزانات مياه</div>
                      <div>مواد بناء</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-14 col-md-6">
                <div class="box">
                  <label for="">العنوان</label>
                  <?php if (!empty($errors["Err_address"])) : ?>
                    <span class="error"> : <?= $errors["Err_address"] ?> </span>
                  <?php endif ?>
                  <input type="text" name="address" placeholder="عنوان" />
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="box">
                  <label for="">الدولة</label>
                  <select name="country">
                    <option value="1">عمان</option>
                    <option value="2">مصر</option>
                    <option value="3">كويت</option>
                    <option value="4">امارات</option>
                    <option value="5">قطر</option>
                    <option value="6">سعودية</option>
                    <option value="7">بحرين</option>
                    <option value="8">الاردن</option>
                  </select>
                  <div class="select-box" tabindex="0">
                    <!-- Make it focusable -->
                    <div class="select-selected">1</div>
                    <div class="select-items select-hide">
                      <div>عمان</div>
                      <div>مصر</div>
                      <div>كويت</div>
                      <div>امارات</div>
                      <div>قطر</div>
                      <div>سعودية</div>
                      <div>بحرين</div>
                      <div>الاردن</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="box">
                  <label for="">مدفوع؟</label>
                  <select name="paid" id="">
                    <option value="1">True</option>
                    <option value="0">False</option>
                  </select>
                  <div class="select-box" tabindex="0">
                    <!-- Make it focusable -->
                    <div class="select-selected">True</div>
                    <div class="select-items select-hide">
                      <div>True</div>
                      <div>False</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="box">
                  <label for="">وصف</label>
                  <?php if (!empty($errors["Err_description"])) : ?>
                    <span class="error"> : <?= $errors["Err_description"] ?> </span>
                  <?php endif ?>
                  <textarea rows="3" name="description" placeholder="وصف"></textarea>
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
                  <label for="">فيديو</label>
                  <?php if (!empty($errors["Video"])) : ?>
                    <span class="error"> : <?= $errors["Video"] ?> </span>
                  <?php endif ?>
                  <div id="uploadContainer" onclick="document.getElementById('fileInputVideo').click()">
                    <span class="mdi mdi-cloud-upload icon"></span>
                    <span>ارفع فيديو</span>
                  </div>
                  <div id="videoContainer"></div>
                  <input type="file" name="Video" id="fileInputVideo" style="display: none" />
                  <!-- onchange="handleFiles(this.files)" -->
                </div>
              </div>
              <div class="col-12">
                <div class="box">
                  <label for="">صور (اختر العديد من الصور)</label>
                  <?php if (!empty($errors["image"])) : ?>
                    <span class="error"> : <?= $errors["image"] ?> </span>
                  <?php endif ?>
                  <div id="uploadContainer" onclick="document.getElementById('fileInput').click()">
                    <span class="mdi mdi-cloud-upload icon"></span>
                    <span>ارفع صورك</span>
                  </div>
                  <div id="imageContainer"></div>
                  <input type="file" name="Images[]" id="fileInput" multiple style="display: none" />
                  <!-- onchange="handleFiles(this.files)" -->
                </div>
              </div>
              <button type="submit" name="send" class="submit">أضافه</button>
            </div>
          </form>
        </div>
      </section>
      <!-- End Construction Form -->
    </div>

  </div>
  <!-- Script -->
  <script src="js/main.js" type="module"></script>
</body>

</html>