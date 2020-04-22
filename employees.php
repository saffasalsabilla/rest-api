<?php
include("connection.php");
$db = new dbObj();
$connection = $db->getConn();
$request_method = $_SERVER["REQUEST_METHOD"];
switch($request_method){
    case 'GET':
        if(!empty($_GET["id"])){
            $id=intval($_GET["id"]);
            get_employess($id);
        }else{
            getEmployees();
        }
        break;
    case 'POST':
        insertEmployee();
        break;
    case 'PUT':
        $id=intval($_GET["id"]);
        updateEmployee($id);
        break;
    case 'DELETE':
        $id=intval($_GET["id"]);
        deleteEmployee($id);
        break;
    default:
        header("Method not allowed");
        break;
}

function get_employees(){
    global $connection;
    $query = "SELECT * FROM `employee`";
    $response = array();
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $response[] = $row;
    }
    header('json');
    echo json_encode($response);
}

function getEmployees($id = 0){
    global $connection;
    $query = "SELECT * FROM `employee`";

    if ($id !=0) {
        $query.= "WHERE id =".$id."LIMIT 1";
    }

    $response = array();
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $response[] = $row;
    }
    header('json');
    echo json_encode($response);
}

function insertEmployee(){
    global $connection;
    $dta = json_decode(file_get_contents("php://input"), true);
    $name = $dta['nama'];
    $salary = $dta['salary'];
    $age = $dta['age'];
    $query = "INSERT INTO `employee` (`id`, `nama`, `salary`, `age`) VALUES ('$id', '$nama', '$salary', '$age');";
    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Success Insert'
        );
    }else {
        $response = array(
            'status' => 0,
            'status_message' => 'Failed Insert'
        );
    }
    header('json');
    echo json_encode($response);
}

function updateEmployee($id){
    global $connection;
    $dta = json_decode(file_get_contents("php://input"), true);
    $name = $dta['nama'];
    $salary = $dta['salary'];
    $age = $dta['age'];
    $query = "UPDATE `employee` SET `nama` = '$nama', `salary` = '$salary', `age` = '$age' WHERE `employee`.`id` = $id;";
    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Success Update'
        );
    }else {
        $response = array(
            'status' => 0,
            'status_message' => 'Failed Update'
        );
    }
    header('json');
    echo json_encode($response);
}

function deleteEmployee($id){
    global $connection;
    $query = "DELETE FROM `employee` WHERE `employee`.`id` = $id";
    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Success Delete'
        );
    }else {
        $response = array(
            'status' => 0,
            'status_message' => 'Failed Delete'
        );
    }
    header('json');
    echo json_encode($response);
}

?>