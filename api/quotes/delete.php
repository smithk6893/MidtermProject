<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//required files
require('../../config/Database.php');
require('../../models/Quote.php');

//Database
$database = new Database();
$db = $database->connect();

//Instantiate Category object
$quote = new Quote($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//Set ID to update
$quote->id = $data->id;

//Delete Category
if($quote->delete()) {
    echo json_encode(
        array("id"=>$quote->id)
    );
} else {
    echo json_encode(
        array('message' => 'No Quotes Found')
    );
}