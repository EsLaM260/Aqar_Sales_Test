<?php
// $connection = mysqli_connect("localhost", "root", "", "aqar_sales");
// $allusers = mysqli_query($connection, "SELECT * FROM `user`");
// $banner_data = mysqli_query($connection, "SELECT * FROM `banner_data`");
// $dataOfUser = [];
// while ($row = mysqli_fetch_assoc($allusers)) {
//   $dataOfUser[] = $row;
// }

// $res = [
//   "status"=>200,
//   "user"=>$dataOfUser
// ];

// echo json_encode($res);

// header("Content-Type: application/json");






// Connect to the database
$connection = mysqli_connect("localhost", "root", "", "aqar_sales");
if (mysqli_connect_errno()) {
    echo json_encode(['status' => 500, 'message' => "Failed to connect to MySQL: " . mysqli_connect_error()]);
    exit();
}

// Function to fetch all data from a specific table
function getAllDataFromTable($connection, $tableName) {
    $query = "SELECT * FROM `$tableName`";
    $result = mysqli_query($connection, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

// Function to insert data into a specified table
function insertDataIntoTable($connection, $tableName, $data) {
    $columns = implode(", ", array_keys($data));
    $values = implode(", ", array_map(function ($value) use ($connection) {
        return "'" . mysqli_real_escape_string($connection, $value) . "'";
    }, array_values($data)));

    $sql = "INSERT INTO `$tableName` ($columns) VALUES ($values)";
    if (mysqli_query($connection, $sql)) {
        return ['status' => 200, 'message' => "Data inserted successfully"];
    } else {
        return ['status' => 500, 'message' => "Error inserting data: " . mysqli_error($connection)];
    }
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'fetchAllData':
        // Get all table names from the database
        $result = mysqli_query($connection, "SHOW TABLES");
        $tables = [];
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }

        // Fetch all data from each table
        $allData = [];
        foreach ($tables as $table) {
            $allData[$table] = getAllDataFromTable($connection, $table);
        }

        // Prepare the response
        echo json_encode(['status' => 200, 'data' => $allData]);
        break;

    case 'insertData':
        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tableName = $_POST['table'] ?? '';
            $data = json_decode($_POST['data'], true);
            
            if (empty($tableName) || empty($data)) {
                echo json_encode(['status' => 400, 'message' => "Missing table name or data"]);
                exit();
            }
            
            // Insert data into table
            $result = insertDataIntoTable($connection, $tableName, $data);
            echo json_encode($result);
        } else {
            echo json_encode(['status' => 405, 'message' => "Method not allowed"]);
        }
        break;

    default:
        echo json_encode(['status' => 400, 'message' => "Invalid action parameter"]);
        break;
}
header('Content-Type: application/json');

// Close the database connection
mysqli_close($connection);




















// // Establish a connection to the database
// $connection = mysqli_connect("localhost", "root", "", "aqar_sales");

// // Function to fetch all data from a specific table
// function getAllDataFromTable($connection, $tableName) {
//     $query = "SELECT * FROM `$tableName`";
//     $result = mysqli_query($connection, $query);
//     $data = [];
//     while ($row = mysqli_fetch_assoc($result)) {
//         $data[] = $row;
//     }
//     return $data;
// }

// // Get all table names from the database
// $result = mysqli_query($connection, "SHOW TABLES");
// $tables = [];
// while ($row = mysqli_fetch_row($result)) {
//     $tables[] = $row[0];
// }

// // Fetch all data from each table
// $allData = [];
// foreach ($tables as $table) {
//     $allData[$table] = getAllDataFromTable($connection, $table);
// }

// // Prepare the response array
// $res = [
//     "status" => 200,
//     "data" => $allData
// ];

// // Output the results (for example as JSON)
// header('Access-Control-Allow-Origin: application/json');
// header('Content-Type: application/json');

// echo json_encode($res);

// // Close the database connection
// mysqli_close($connection);

?>
