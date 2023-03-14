<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//required files
require('../../config/Database.php');
require('../../models/Category.php');

//Database
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$category = new Category($db);

//Get id from URL
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

//author query
$category->read_single();

//Create array
$category_arr = array(
    'id' => $category->id,
    'category' => $category->category
);

if($category->category !== null){
    //Change to JSON data
    print_r(json_encode($category_arr, JSON_NUMERIC_CHECK));
    }

else
    {
        echo json_encode(
            array('message' => 'category_id Not Found')
        );
    }

?>