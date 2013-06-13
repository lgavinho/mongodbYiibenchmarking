<?php
namespace Services\Active;

require_once('models-active/Event.php');

use \Ingresse\Active;

class Events {
    
    public function searchEvents($app) {        
        $eventModel = new \Ingresse\Active\Events();
        $events = $eventModel->find(array('limit' => 8));

        $data = array();
        foreach($events as $event){
            $data[] = array(
                'id' => $event->eventId,
                'title' => $this->checkEncode($event->eventTitle)
            );
        }
        
        $info = array(
            'currentPage'   => 1,
            'lastPage'      => 1,
            'totalResults'  => count($events)
        );

        $pack = array(
            'data'              => $data,
            'paginationInfo'    => $info
        );
        
        $json = json_encode($pack);
        if (!$json) {
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    $error =  ' - No errors';
                break;
                case JSON_ERROR_DEPTH:
                    $error =  ' - Maximum stack depth exceeded';
                break;
                case JSON_ERROR_STATE_MISMATCH:
                    $error =  ' - Underflow or the modes mismatch';
                break;
                case JSON_ERROR_CTRL_CHAR:
                    $error =  ' - Unexpected control character found';
                break;
                case JSON_ERROR_SYNTAX:
                    $error =  ' - Syntax error, malformed JSON';
                break;
                case JSON_ERROR_UTF8:
                    $error =  ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
                default:
                    $error =  ' - Unknown error';
                break;
            }                

            return json_encode(array('status' => false,
                                   'error'  => 'Error ao gerar resposta em JSON. ' . $error));
        }
        else {
            return $json;
        }
    }
    
    function checkEncode($string) {
 		if( !mb_check_encoding($string,'UTF-8')) {
    		return mb_convert_encoding($string,'UTF-8','ISO-8859-1');
  		} else {
    		return $string;
  		}
}
    
}


?>
