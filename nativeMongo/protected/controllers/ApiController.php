<?php

class ApiController extends Controller {

    /**
     * Key which has to be in HTTP USERNAME and PASSWORD headers 
     */
    Const APPLICATION_ID = 'ASCCPE';

    /**
     * All fields for query
     */
    Const ALL_FIELDS = '*';
 
    /**
     * Default response format
     * either 'json' or 'xml'
     */
    private $format = 'json'; 
 
    // Actions
    public function actionList() {
        $m = new Mongo();
        $db = $m->ingresse;
        $collection = $db->event;
        $events = $collection->find()->limit(8);
        
        $data = array();
        foreach($events as $event){
            $data[] = array(
                'id' => $event['eventId'],
                'title' => $event['eventTitle']
            );
        }
        
        $info = array(
            'currentPage'   => 1,
            'lastPage'      => 1,
            'totalResults'  => $events->count()
        );

        $pack = array(
            'data'              => $data,
            'paginationInfo'    => $info
        );
        
        $this->_sendResponse(200, CJSON::encode($pack));

        Yii::app()->end();        
    }


    public function actionView()
    {        
    
        
    }

    
    public function actionCreate() {

    }


    public function actionUpdate() {

    }


    public function actionDelete() {

    }
  
    
    public function actionPreflight() {
        $content_type = 'application/json';
        $status = 200;
 
        // set the status
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
 
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Authorization");
        header('Content-type: ' . $content_type);
    }   
    
    
    
}