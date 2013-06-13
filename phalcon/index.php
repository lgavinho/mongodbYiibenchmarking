<?php 

//database connection
require_once('services/TransactionalEvents.php');
require_once('services/ActiveEvents.php');


try {
    
    //Register an autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(array(
        'models-transact/'
        //'models-active/'
    ))->register();

    $di = new \Phalcon\DI\FactoryDefault();

    //Set up the database service
    $di->set('dbsql', function(){
        $conn = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host"      => "localhost",
            "username"  => "root",
            "password"  => "",
            "dbname"    => "ingresse_11062013",
        ));
        return $conn;
    });
    
    $di->set('dbactive', function() {
        $mongo = new Mongo();
        return $mongo->selectDb("ingresse");
    }, true);
    
    $di->set('collectionManager', function(){
        return new Phalcon\Mvc\Collection\Manager();
    }, true);

    $app = new \Phalcon\Mvc\Micro();

    //Bind the DI to the application
    $app->setDI($di);

    //define the routes here

    //Retrieves all events
    $app->get('/events', function () use ($app) {        
        $response = $app->response;                      
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Headers', 'X-Requested-With');      
        
        try {
            //$eventService = new Services\Transactional\Events();
            $eventService = new Services\Active\Events();
            echo $eventService->searchEvents($app);
        }
        catch (Exception $e) {
            $error = array('status' => false,
                           'error'  => 'API error: ' . $e->getMessage());
            echo json_encode($error);
        }

    });
    
    $app->get('/preflight', function() use ($app) {
        $content_type = 'application/json';
        $status = 200;
        $description = 'OK';
        $response = $app->response;
        
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $description;
        $response->setRawHeader($status_header);
        $response->setStatusCode($status, $description);
        $response->setContentType($content_type, 'UTF-8');
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Headers', 'X-Requested-With');
        $response->setHeader("Access-Control-Allow-Headers: Authorization");
        $response->setHeader('Content-type: ' . $content_type);
    });    

    $app->handle();    
    
    
}
catch(Exception $e) {
    $error = array('status' => false,
                   'error'  => 'PhalconException: ' . $e->getMessage());
    echo json_encode($error);
}



?>