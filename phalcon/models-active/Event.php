<?php

namespace Ingresse\Active;

class Events extends \Phalcon\Mvc\Collection {
    
    public function getSource() {
        return 'event';
    }
    
    public function initialize()
    {     
        $this->setConnectionService('dbactive');
    }
}

?>
