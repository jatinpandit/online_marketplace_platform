<?php

class Agent_Block_Agent extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('agent/index.phtml');
    }

    public function getAgentData(){

        return Mage::getModel('agent/agent')->getCollection()
            // ->addFieldToSelect(['ccc_agent.name As name', 'ccc_agent.agent_id As agent_id'])
            // ->join('ccc_branch as cb', 'ccc_agent.agent_id = cb.agent_id')
            // ->addFieldToFilter('cb.name',['like'=>'%111%'])
            ->getData();
    }

    public function getBranchData(){
        return Mage::getModel('agent/branch')->getCollection()
            ->getData();
    }
}