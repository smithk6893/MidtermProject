<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//required files
require('../../config/Database.php');
require('../../models/Author.php');

//Database
$database = new Database();
$db = $database->connect();

//Instantiate Author object
$author = new Author($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//Set ID to update
$author->id = $data->id;

//Delete Author
if($author->delete()) {
    echo json_encode(
        array("id"=>$author->id)
    );
} else {
    echo json_encode(
        array('message' => 'Author Not Deleted')
    );
}