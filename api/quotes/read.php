<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//required files
require('../../config/Database.php');
require('../../models/Quote.php');

//Database
$database = new Database();
$db = $database->connect();

//Instantiate quote object
$quote = new Quote($db);

//category query
$result = $quote->read();

//Get row count
$num = $result->rowCount();

//Check for Quotes
if($num > 0) {
    //Quote array
    $quote_arr = array();
    //$quote_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'author' => $author,
            'category' => $category
        );

        //Push data
        array_push($quote_arr, $quote_item);
    }

    //turn to JSON and output data
    echo (json_encode($quote_arr));

} else {
    echo json_encode(
        array('message' => 'No Quotes Found')
    );
}

?>