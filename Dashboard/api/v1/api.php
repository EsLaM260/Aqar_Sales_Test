<?php

// Connect to the database
$connection = mysqli_connect("localhost", "root", "", "aqar_sales");
// $connection = mysqli_connect("localhost", "root", "Any_Test123", "id22173684_aqar_sales");
if (mysqli_connect_errno()) {
  echo json_encode(['status' => 500, 'message' => "Failed to connect to MySQL: " . mysqli_connect_error()]);
  exit();
}

// Function to fetch all data from a specific table
function getAllDataFromTable($connection, $tableName)
{
  $query = "SELECT * FROM `$tableName`";
  $result = mysqli_query($connection, $query);
  $data = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
  }
  return $data;
}

// $action = $_GET['action'] ?? '';
$method = $_SERVER["REQUEST_METHOD"];
switch ($method) {
  case 'GET':
    $AllData = [];
    $AllData["Properties"] = getAllDataFromTable($connection, "all_properties");
    $AllData["Construction"] = getAllDataFromTable($connection, "all_construction");
    $AllData["banner_data"] = getAllDataFromTable($connection, "banner_data");
    $AllData["construction_category"] = getAllDataFromTable($connection, "construction_category");
    $AllData["property_category"] = getAllDataFromTable($connection, "property_category");
    $AllData["country"] = getAllDataFromTable($connection, "country");
    $AllData["specification"] = getAllDataFromTable($connection, "specification");
    $AllData["user"] = getAllDataFromTable($connection, "user");

    // Prepare the response
    header('Content-Type: application/json'); // Set content type header
    echo json_encode(['status' => 200, 'data' => $AllData]);
    break;

  case 'POST':
    $data_of_api = json_decode(file_get_contents('php://input'), true);
    $table_name = $data_of_api["table_name"];
    $table_data = $data_of_api["table_data"];
    // $table_image = $data_of_api["table_image"];
    $table_spec = $data_of_api["table_spec"];

    if ($table_name == "property") {
      // main data
      $title = $table_data["title"];
      $type_of_property = $table_data["type_of_property"];
      $property_category_id = $table_data["property_category_id"];
      $number_of_room = $table_data["number_of_room"];
      $number_of_bath = $table_data["number_of_bath"];
      $price = $table_data["price"];
      $property_area = $table_data["property_area"];
      $address = $table_data["address"];
      $description = $table_data["description"];
      $country_id = $table_data["country_id"];
      $paid = $table_data["paid"];
      $location_lat = $table_data["location_lat"];
      $location_lng = $table_data["location_lng"];
      $video = $table_data["video"];
      $visible = $table_data["visible"];
      $create_at = $table_data["create_at"];
      $user_id = $table_data["user_id"];
      // insert main data
      $query = "INSERT INTO `property`(`ranking`, `title`, `type_of_property`, `property_category_id`, `number_of_room`, `number_of_bath`, `price`, `property_area`, `address`, `description`, `country_id`, `paid`, `location_lat`, `location_lng`, `video`, `visible`, `create_at`, `user_id`) VALUES ('0','$title','$type_of_property','$property_category_id','$number_of_room','$number_of_bath','$price','$property_area','$address','$description','$country_id','$paid','$location_lat','$location_lng','$video','$visible','$create_at','$user_id')";
      mysqli_query($connection, $query);

      // insert images and specification
      $property_id = $connection->insert_id;
      // insert images
      if (isset($table_image)) {
        $table_image = $_FILES["table_image"];
        $totalImages = count($table_image['tmp_name']);
        for ($i = 0; $i < $totalImages; $i++) {
          $name = $table_image['name'][$i];
          $extension = pathinfo($name, PATHINFO_EXTENSION);
          $newFileName = date("YmdHis") . '_' . mt_rand(1000, 9999) . '.' . $extension;
          // Move the uploaded file to the desired directory with the new name
          $uploadDir = '../../../Images';
          $uploadFile = $uploadDir . $newFileName;
          move_uploaded_file($images['tmp_name'][$i], $uploadFile);
          // insert into db
          $queryPhoto = "INSERT INTO `photo_property`(`image`, `property_id`) VALUES ('$newFileName','$property_id')";
          mysqli_query($connection, $queryPhoto);
        }
      }
      // insert specification
      foreach ($table_spec as $item) {
        $queryCheckbox = "INSERT INTO `property-specification`(`property_id`, `specification_id`) VALUES ('$property_id ','$item')";
        mysqli_query($connection, $queryCheckbox);
      }
      $response = ['status' => 200, 'message' => "Property data inserted successfully"];
    } elseif ($table_name == "construction") {

      $title = $table_data["title"];
      $construction_category_id = $table_data["construction_category_id"];
      $address = $table_data["address"];
      $country_id = $table_data["country_id"];
      $paid = $table_data["paid"];
      $description = $table_data["description"];
      $location_lat = $table_data["location_lat"];
      $location_lng = $table_data["location_lng"];
      $video = $table_data["video"];
      $create_at = $table_data["create_at"];
      $user_id = $table_data["user_id"];

      $query = "INSERT INTO `construction`(`ranking`, `title`, `construction_category_id`, `address`, `country_id`, `paid`, `description`, `location_lat`, `location_lng`, `video`, `create_at`, `user_id`) VALUES ('0','$title','$construction_category_id','$address','$country_id','$paid','$description','$location_lat','$location_lng','$location_lat','$video','$create_at','$user_id')";
      mysqli_query($connection, $query);
      // insert images
      $Construction_id = $connection->insert_id;
      if (isset($table_image)) {
        $table_image = $_FILES["table_image"];
        $totalImages = count($table_image['tmp_name']);
        for ($i = 0; $i < $totalImages; $i++) {
          $name = $table_image['name'][$i];
          $extension = pathinfo($name, PATHINFO_EXTENSION);
          $newFileName = date("YmdHis") . '_' . mt_rand(1000, 9999) . '.' . $extension;
          // Move the uploaded file to the desired directory with the new name
          $uploadDir = '../../../Images';
          $uploadFile = $uploadDir . $newFileName;
          move_uploaded_file($images['tmp_name'][$i], $uploadFile);
          // insert into db
          $queryPhoto = "INSERT INTO `photo_construction`(`image`, `construction_id `) VALUES ('$newFileName','$Construction_id')";
          mysqli_query($connection, $queryPhoto);
        }
      }
      $response = ['status' => 200, 'message' => "construction data inserted successfully"];
    } elseif ($table_name == "user") {

      $firebase_id = $table_data["firebase_id"];
      $name = $table_data["name"];
      $phone = $table_data["phone"];
      $email = $table_data["email"];
      $address = $table_data["address"];
      $barth_of_date = $table_data["barth_of_date"];
      $gender = $table_data["gender"];
      $check_card_image = $table_data["check_card_image"];
      // images
      $uploadDir = '../../../Images/';

      $photo = $_FILES["photo"];
      $photoname = $photo["name"];
      $extension = pathinfo($photoname, PATHINFO_EXTENSION);
      $newPhotoName = date("YmdHis") . '_' . mt_rand(1000, 9999) . '.' . $extension;
      $photoFile = $uploadDir . $newPhotoName;

      $card_id_image = $_FILES["card_id_image"];
      $card_name = $card_id_image["name"];
      $extension = pathinfo($card_name, PATHINFO_EXTENSION);
      $new_card_Name = date("YmdHis") . '_' . mt_rand(1000, 9999) . '.' . $extension;
      $photoFile = $uploadDir . $new_card_Name;

      if (move_uploaded_file($photo["tmp_name"], $newPhotoName) && move_uploaded_file($card_id_image["tmp_name"], $new_card_Name)) {
        $query = "INSERT INTO `user`(`firebase_id`, `name`, `phone`, `email`, `address`, `barth_of_date`, `gender`, `photo`, `card_id_image`, `check_card_image`) VALUES ('$firebase_id','$name','$phone','$email','$address','$barth_of_date','$gender','$newPhotoName','$new_card_Name','$check_card_image')";
        mysqli_query($connection, $query);
        $response = ['status' => 200, 'message' => "User data inserted successfully"];
      }

    }
    header('Content-Type: application/json');
    echo json_encode($response);
    break;
  case 'DELETE':
    $data_of_api = json_decode(file_get_contents('php://input'), true);
    $table_name = $data_of_api["table_name"];
    $id = $data_of_api["row_id"];

    if ($table_name == "property") {
      $query = "DELETE FROM `property` WHERE `id` = '$id'";

      if (mysqli_query($connection, $query)) {
        $queryGetData = "SELECT * FROM `photo_property` WHERE `property_id`= `$id`";
        $result = mysqli_query($connection, $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
          $data[] = $row;
        }
        $numberOfImage = count($data["image"]);
        for ($i = 0; $i < $numberOfImage; $i++) {
          $pathImage = "../../../Images/" . $data[$i]["image"];
          unlink($pathImage);
        }
        mysqli_query($connection, "DELETE FROM `photo_property` WHERE `property_id`= `$id`");
        echo json_encode(['status' => 200, 'message' => "delete successfully"]);
      } else {
        echo json_encode(['status' => 400, 'message' => "delete Error"]);
      }
    } elseif ($table_name == "construction") {
      $query = "DELETE FROM `construction` WHERE `id` = '$id'";

      if (mysqli_query($connection, $query)) {
        $queryGetData = "SELECT * FROM `photo_construction` WHERE `construction_id`= `$id`";
        $result = mysqli_query($connection, $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
          $data[] = $row;
        }
        $numberOfImage = count($data["image"]);
        for ($i = 0; $i < $numberOfImage; $i++) {
          $pathImage = "../../../Images/" . $data[$i]["image"];
          unlink($pathImage);
        }
        mysqli_query($connection, "DELETE FROM `photo_construction` WHERE `construction_id`= `$id`");
        echo json_encode(['status' => 200, 'message' => "delete successfully"]);
      } else {
        echo json_encode(['status' => 400, 'message' => "delete Error"]);
      }
    } elseif ($table_name == "user") {

      $selectQuery = "SELECT * FROM `user` WHERE `id` = '$id'";
      $result = mysqli_query($connection, $selectQuery);
      $data = mysqli_fetch_assoc($result);
      $pathFile = "../../../Images/";
      $profilePhoto = $pathFile . $data["photo"];
      $idPhoto = $pathFile . $data["card_id_image"];

      if (unlink($profilePhoto)) {
        unlink($idPhoto);
        $query = "DELETE FROM `user` WHERE `id` = '$id'";
        mysqli_query($connection, $query);
        echo json_encode(['status' => 200, 'message' => "delete successfully"]);
      } else {
        echo json_encode(['status' => 400, 'message' => "delete Error"]);
      }
    } else {
      echo json_encode(['status' => 400, 'message' => "Invalid table name"]);
      exit();
    }


    header('Content-Type: application/json');
    break;
}



// Close the database connection
mysqli_close($connection);
