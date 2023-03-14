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

//author query
$result = $author->read();

//Get row count
$num = $result->rowCount();

//Check for authors
if($num > 0) {
    //Author array
    $author_arr = array();
    //$author_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $author_item = array(
            'id'=>$id,
            'author'=>$author
        );

        //Push data
        array_push($author_arr, $author_item);
    }

    //turn to JSON and output data
    echo (json_encode($author_arr));

} else {
    echo json_encode(
        array('message' => 'No Authors Found')
    );
}

?>