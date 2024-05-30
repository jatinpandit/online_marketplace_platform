<?php

class Agent_Controller_Index extends Core_Controller_Front_Action
{



    public function getCss()
    {
        $layout = $this->getLayout();
        $layout->getChild('head')
            ->addCss('header.css')
            ->addCss('footer.css')
            ->addCss('1columnMain.css')
            ->addCss('customer/account/login.css')
            ->addCss('customer/account/register.css')
            ->addCss('customer/account/dashboard.css');
    }

    public function indexAction()
    {
        $layout = $this->getLayout();
        $this->getCss();
        $child = $layout->getChild('content');
        $registerForm = $layout->createBlock('agent/agent');
        $child->addChild('registerForm', $registerForm);
        $layout->toHtml();
    }


    public function branchAction()
    {
        $agentId = $this->getRequest()->getParams('agent_id');

            $branchesData = Mage::getModel('agent/branch')->getCollection()
                ->addFieldToFilter('agent_id', $agentId)
                ->getData();
            $branches = [];
            foreach ($branchesData as $branchData) {
                $branch = array(
                    'id' => $branchData->getId(),
                    'name' => $branchData->getName()
                );
                $branches[] = $branch;
            }
        
        echo json_encode($branches);
    }


}

