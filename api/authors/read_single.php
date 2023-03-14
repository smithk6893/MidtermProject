<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//required files
require('../../config/Database.php');
require('../../models/Author.php');

//Database
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$author = new Author($db);

//Get id from URL
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

//author query
$author->read_single();

//Create array
$author_arr = array(
    'id' => $author->id,
    'author' => $author->author
);


if($author->author !== null){
    //Change to JSON data
    print_r(json_encode($author_arr, JSON_NUMERIC_CHECK));
    }

else
    {
        echo json_encode(
            array('message' => 'author_id Not Found')
        );
    }

?>