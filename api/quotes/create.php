<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
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

// looking to see if author id and category_id exist in db - if not, print message and exit()


if(isset($data->quote) and isset($data->author_id) and isset($data->category_id)) {
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    $quote->create();
    echo json_encode(
        array("id"=> $db->lastInsertId(), "quote"=>$quote->quote, "author_id"=>$quote->author_id, "category_id"=>$quote->category_id)
    );
} else {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
}