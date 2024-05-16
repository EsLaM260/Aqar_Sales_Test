<?php
// check have user or not
session_start();

// Check if the user is logged in
// if (!isset($_SESSION['username'])) {
//   header("Location: login.php");
// }
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




if (isset($_POST["send"])) {
  $errors = [];
  $title = $_POST["title"];
  $type = $_POST["type"];
  $category = $_POST["category"];
  $number_of_room = $_POST["number-of-room"];
  $number_of_bath = $_POST["number-of-bath"];
  $price = $_POST["price"];
  $space = $_POST["space"];
  $address = $_POST["address"];
  $country = $_POST["country"];
  $paid = $_POST["paid"];
  $description = $_POST["description"];
  $lat = $_POST["lat"];
  $lng = $_POST["lng"];

  // ################################   All Validation ################################
  // validation title
  if (empty($title)) {
    $errors["Err_title"] = "ادخل الاسم";
  } else {
    $title = test_input($title);
    // check if title only contain letter and white space allowed
    if (!preg_match("/^[a-zA-Z\d\s\p{Arabic}]*$/u", $title)) {
      $errors["Err_title"] = "يُسمح فقط بالأحرف والأرقام والمسافات الاساسية";
    }
  }
  // validation price
  if (empty($price)) {
    $errors["Err_price"] = "ادخل السعر";
  } else {
    $price = test_input($price);
    // check if price only number
    if (!is_numeric($price)) {
      $errors["Err_price"] = "يسمح فقط بالارقام";
    }
  }
  // validation space
  if (empty($space)) {
    $errors["Err_space"] = "ادخل المساحه";
  } else {
    $space = test_input($space);
    // check if space only number
    if (!is_numeric($space)) {
      $errors["Err_space"] = "يسمح فقط بالارقام";
    }
  }
  // validation address
  if (empty($address)) {
    $errors["Err_address"] = "ادخل العنوان";
  } else {
    $address = test_input($address);
    // check if address only contain letter and white space allowed
    if (!preg_match("/^[a-zA-Z\d\s\p{Arabic}]*$/u", $address)) {
      $errors["Err_address"] = "يُسمح فقط بالأحرف والأرقام والمسافات الاساسية";
    }
  }
  // validation description
  if (empty($description)) {
    $errors["Err_description"] = "ادخل الوصف";
  } else {
    $description = test_input($description);
    // check if description only contain letter and white space allowed
    if (!preg_match("/^[a-zA-Z\d\s\p{Arabic}]*$/u", $description)) {
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
  if (isset($_FILES["images"]) && $_FILES["images"]["error"][0] == 0) {
    $allImages = [];
    $images = $_FILES["images"];
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
          $errors["image"] = "Image '$file_name' size should not exceed 15 MB";
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
    $queryProperty = "INSERT INTO `property`(`title`, `type_of_property`, `property_category_id`, `number_of_room`, `number_of_bath`, `price`, `property_area`, `address`, `description`, `country_id`, `location_lat`, `location_lng`, `video`, `create_at`, `user_id`) VALUES ('$title','$type','$category','$number_of_room','$number_of_bath','$price','$space','$address','$description','$country','$lat','$lng','$target_file','$date','0')";
    if (mysqli_query($connection, $queryProperty)) {
      $property_id = $connection->insert_id;
      // get all images and insert it into db
      foreach ($allImages as $item) {
        $name = $item["name"];
        $queryPhoto = "INSERT INTO `photo_property`(`image`, `property_id`) VALUES ('$name','$property_id')";
        if (mysqli_query($connection, $queryPhoto)) {
          $success = "تم الرفع بنجاح";
        }
      }
      // insert features into db
      $features = $_POST["features"];
      foreach ($features as $item) {
        $queryCheckbox = "INSERT INTO `property-specification`(`property_id`, `specification_id`) VALUES ('$property_id ','$item')";
        mysqli_query($connection, $queryCheckbox);
      }
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
  <title>Dashboard</title>
</head>

<body>
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
  <!-- Start Property Form -->
  <div class="maincontent">
    <section class="property-form">
      <h1>
        أضافه عقار
        <?php if (!empty($success)) : ?>
          <span class="success"> : <?= $success ?> </span>
        <?php endif ?>
      </h1>
      <div class="form">
        <form action="addproperty.php" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-lg-4 col-md-6">
              <div class="box">
                <label for="">اسم العقار</label>
                <?php if (!empty($errors["Err_title"])) : ?>
                  <span class="error"> : <?= $errors["Err_title"] ?> </span>
                <?php endif ?>
                <input type="text" placeholder="اسم العقار" name="title" />
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
                  <option value="1">للبيع</option>
                  <option value="2">للايجار</option>
                  <option value="3">للايجار اليومي</option>
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
                <?php if (!empty($errors["Err_price"])) : ?>
                  <span class="error"> : <?= $errors["Err_price"] ?> </span>
                <?php endif ?>
                <input type="number" name="price" placeholder="السعر" />
              </div>
            </div>
            <div class="col-lg-4 col-md-6">
              <div class="box">
                <label for="">المساحه</label>
                <?php if (!empty($errors["Err_space"])) : ?>
                  <span class="error"> : <?= $errors["Err_space"] ?> </span>
                <?php endif ?>
                <input type="number" name="space" placeholder="المساحه" />
              </div>
            </div>
            <div class="col-lg-4 col-md-6">
              <div class="box">
                <label for="">العنوان</label>
                <?php if (!empty($errors["Err_address"])) : ?>
                  <span class="error"> : <?= $errors["Err_address"] ?> </span>
                <?php endif ?>
                <input type="text" name="address" placeholder="العنوان" />
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
                <label for="">الوصف</label>
                <?php if (!empty($errors["Err_description"])) : ?>
                  <span class="error"> : <?= $errors["Err_description"] ?> </span>
                <?php endif ?>
                <textarea rows="3" name="description" placeholder="الوصف"></textarea>
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
              </div>
            </div>
            <div class="col-12">
              <div class="box">
                <label for="">الصور (اختر العديد من الصور)</label>
                <?php if (!empty($errors["image"])) : ?>
                  <span class="error"> : <?= $errors["image"] ?> </span>
                <?php endif ?>
                <div id="uploadContainer" onclick="document.getElementById('fileInput').click()">
                  <span class="mdi mdi-cloud-upload icon"></span>
                  <span>ارفع الصور</span>
                </div>
                <div id="imageContainer"></div>
                <input type="file" name="images[]" id="fileInput" multiple style="display: none" />
              </div>
            </div>
            <div class="col-12">
              <div class="box last">
                <div class="subbox">
                  <input type="checkbox" name="features[]" id="Fully-furnished" value="1" />
                  <label for="Fully-furnished">مفروشة بلكامل</label>
                </div>
                <div class="subbox">
                  <input type="checkbox" name="features[]" id="Balcony" value="2" />
                  <label for="Balcony">شرفة</label>
                </div>
                <div class="subbox">
                  <input type="checkbox" name="features[]" id="Kitchen_appliances" value="3" />
                  <label for="Kitchen_appliances">اجهزة المطبخ</label>
                </div>
                <div class="subbox">
                  <input type="checkbox" name="features[]" id="Private_garden" value="4" />
                  <label for="Private_garden">حديقة خاصة</label>
                </div>
                <div class="subbox">
                  <input type="checkbox" name="features[]" id="Central_heating" value="5" />
                  <label for="Central_heating">تدفئة و تكييف مركزي</label>
                </div>
                <div class="subbox">
                  <input type="checkbox" name="features[]" id="Elevator" value="6" />
                  <label for="Elevator">مصعد</label>
                </div>
                <div class="subbox">
                  <input type="checkbox" name="features[]" id="Security" value="7" />
                  <label for="Security">أمن</label>
                </div>
                <div class="subbox">
                  <input type="checkbox" name="features[]" id="Garage" value="8" />
                  <label for="Garage">موقف سيارات</label>
                </div>
                <div class="subbox">
                  <input type="checkbox" name="features[]" id="Maids-room" value="9" />
                  <label for="Maids-room">غرفة خدم</label>
                </div>
                <div class="subbox">
                  <input type="checkbox" name="features[]" id="swimming-pool" value="10" />
                  <label for="swimming-pool">حمام سباحة</label>
                </div>
                <div class="subbox">
                  <input type="checkbox" name="features[]" id="pets-allowed" value="11" />
                  <label for="pets-allowed">مسموح بلحيوانات الاليفة</label>
                </div>
                <div class="subbox">
                  <input type="checkbox" name="features[]" id="Electricity-meter" value="12" />
                  <label for="Electricity-meter">عداد كهرباء</label>
                </div>
                <div class="subbox">
                  <input type="checkbox" name="features[]" id="Water-meter" value="13" />
                  <label for="Water-meter">عداد ماء</label>
                </div>
                <div class="subbox">
                  <input type="checkbox" name="features[]" id="Gas-meter" value="14" />
                  <label for="Gas-meter">عداد غاز</label>
                </div>
              </div>
            </div>
            <button type="submit" name="send" class="submit">أضافه</button>
          </div>
        </form>
      </div>
    </section>
  </div>
  <!-- End Property Form -->
  <!-- Script -->
  <script src="js/main.js" type="module"></script>
</body>

</html>