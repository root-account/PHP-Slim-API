<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db_con.php';

$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});


// stores routes
require '../src/routes/get-stores.php';

// Qoutation Items routes
require '../src/routes/qoute_items.php';


/************************** CROSS ORIGIN HEADERS ******************************/

// Specify domains from which requests are allowed
header('Access-Control-Allow-Origin: *');

// Specify which request methods are allowed
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');

// Additional headers which may be sent along with the CORS request
// The X-Requested-With header allows jQuery requests to go through
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// Set the age to 1 day to improve speed/caching.
header('Access-Control-Max-Age: 86400');



$app->run();
