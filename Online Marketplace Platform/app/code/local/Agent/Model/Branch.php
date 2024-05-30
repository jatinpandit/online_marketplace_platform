<?php

class Agent_Model_Branch extends Core_Model_Abstract{
    
    public function init(){
        $this->_resourceClass = "Agent_Model_Resource_Branch";
        $this->_collectionClass = "Agent_Model_Resource_Collection_Branch";
        $this->_modelClass = "agent/branch";
    }

}