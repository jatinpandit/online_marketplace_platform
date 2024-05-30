<?php

class Agent_Model_Agent extends Core_Model_Abstract{
    
    public function init(){
        $this->_resourceClass = "Agent_Model_Resource_Agent";
        $this->_collectionClass = "Agent_Model_Resource_Collection_Agent";
        $this->_modelClass = "agent/agent";
    }

   
}