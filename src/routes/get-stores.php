<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;



$app->get('/test', function(Request $request, Response $response){

    return "API WORKS BRO!!";

});



// SELECT * stores
$app->get('/getstores', function(Request $request, Response $response){

    $qry = "SELECT CustomerName, lat, lng, Address, Email, State, Country, ProductCategories, Phone FROM store_details";

    try{
        // Get DB OBJECT
        $db = new db_con();
        $db = $db->connect();

        $stmt = $db->query($qry);

        $allstores = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;

        return json_encode($allstores);


    }catch(PDOException $e){
        return '{"error":{"text":'.$e->getMessage().'}}';
    }


});
