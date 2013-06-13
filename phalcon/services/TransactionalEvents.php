<?php
namespace Services\Transactional;

require_once('models-transact/Event.php');

use \Ingresse\Transactional;

class Events {
    
    public function searchEvents($app) {        
        //$phql = "SELECT * FROM Ingresse\Transactional\Event limit 100";
        //$query = $app->modelsManager->createQuery($phql);
        //$events = $query->execute();
        $eventModel = new \Ingresse\Transactional\Event();
        $events = $eventModel->find(array('limit' => 100));

        $data = array();
        foreach($events as $event){
            $data[] = array(
                'id' => $event->id,
                'title' => $this->checkEncode($event->title)
            );
        }

        $json = json_encode($data);
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
