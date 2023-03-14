<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//required files
require('../../config/Database.php');
require('../../models/Category.php');

//Database
$database = new Database();
$db = $database->connect();

//Instantiate Category object
$category = new Category($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//need to work with isset here I think

if (isset($data->category)) {
    $category->category = $data->category;
    $category->create();
    echo json_encode(
        array("id"=> $db->lastInsertId(), "category"=>$category->category)
    );
} else {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
}