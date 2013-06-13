<?php

namespace Ingresse\Transactional;

use \Phalcon\Mvc\Model\Message;
use \Phalcon\Mvc\Model\Validator\InclusionIn;
use \Phalcon\Mvc\Model\Validator\Uniqueness;

class Event extends \Phalcon\Mvc\Model
{

    public function getSource()
    {
        return "event";
    } 

    public function initialize()
    {     
        $this->setConnectionService('dbsql');
    }

}

?>