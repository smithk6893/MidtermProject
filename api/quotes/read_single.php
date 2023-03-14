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

//Get id from URL

//$quote->author_id = isset($_GET['author_id']) ? $_GET['author_id'] : die();
//$quote->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : die();
//$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

if( isset($_GET['id'])){
   
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die();
        //quote query
    $quote->read_single();

    //Create array
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author'=>$quote->author,
        'category'=>$quote->category
    );

    if($quote->quote !== null){
        //Change to JSON data
        print_r(json_encode($quote_arr, JSON_NUMERIC_CHECK));
        }

    else
        {
            echo json_encode(
                array('message' => 'No Quotes Found')
            );
        }
}

else if(isset($_GET['author_id']) and isset($_GET['category_id'])){
   
    $quote->author_id = isset($_GET['author_id']) ? $_GET['author_id'] : die();
    $quote->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : die();
        //quote query
    $result = $quote->read_single();

    $num = $result->rowCount();

    if($num > 0) {
        //Quote array
        $quote_arr = array();
        

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

            echo (json_encode($quote_arr)); 
    
}
    else
    {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }

}

else if(isset($_GET['author_id'])){
   
    $quote->author_id = isset($_GET['author_id']) ? $_GET['author_id'] : die();
        //quote query
    $result = $quote->read_single();

    $num = $result->rowCount();

    if($num > 0) {
        //Quote array
        $quote_arr = array();
        

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

            echo (json_encode($quote_arr)); 
    
}
    else
    {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }

}

else if(isset($_GET['category_id'])){
   
    $quote->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : die();
        //quote query
    $result = $quote->read_single();

    $num = $result->rowCount();

    if($num > 0) {
        //Quote array
        $quote_arr = array();
        

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

            echo (json_encode($quote_arr)); 
    
}
    else
    {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }

}

?>
