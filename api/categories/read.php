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

//Instantiate blog category object
$category = new Category($db);

//category query
$result = $category->read();

//Get row count
$num = $result->rowCount();

//Check for Categories
if($num > 0) {
    //Author array
    $category_arr = array();
    //$category_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = array(
            'id'=>$id,
            'category'=>$category
        );

        //Push data
        array_push($category_arr, $category_item);
    }

    if ($category_arr){
    //turn to JSON and output data
    echo (json_encode($category_arr));
    }

} else {
    echo json_encode(
        array('message' => 'No Categories Found')
    );
}

?>
