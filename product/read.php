<?php
/*
*headers about who can read this file and which type of content it will return.
*This file can be read by anyone (asterisk * means all) and will return a data in JSON format
*/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
include_once("../config/database.php");
include_once("../objects/product.php");

$database=new Database();//Makes an instance of the class included above
$db = $database->getConnection();//initialise $db to return valu of the getConnection function in Database class  

// initialize object and pass $db to new product object. 
$product = new Product($db);


//query products 
$stmt=$product->read();
$num=$stmt->rowCount();

if ($num>0) {
	//$prod_arr=new array();
	$prod_arr['records']=array();
	// retrieve our table contents
	// fetch() is faster than fetchAll()
	// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
	while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
		//extract row
		//this will make $row["name"] 
		//to $name only
		extract($row);
		$product_item=array(
			"id"=>$id,
			"name"=>$name,
			"description"=>html_entity_decode($description),
			"price"=>$price,
			"category_id"=>$category_id,
			"category_name"=>$category_name
		);
		array_push($prod_arr["records"],$product_item);
	}
	//show response code- 200 OK
	http_response_code(200);
	//show products in JSON
	echo json_encode($prod_arr);
}else{
	//http response 404 not found
	http_response_code(404);
	//no records response to user
	echo json_encode(
		array('message' => "No products Found" )
	);
}   
