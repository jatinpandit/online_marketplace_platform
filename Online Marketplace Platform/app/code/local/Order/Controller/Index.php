<?php

class Order_Controller_Index extends Core_Controller_Front_Action
{

    protected $_allowedAction = ['login'];

    public function init(){
        $action = $this->getRequest()->getActionName();
        if(!in_array($action, $this->_allowedAction) &&
                !Mage::getSingleton('core/session')->get('logged_in_customer_id')
        ){
            $this->getRequest()->redirect('customer/account/login');
        }
    }

    public function getCss()
    {
        $layout = $this->getLayout();
        $layout->getChild('head')
            ->addCss('header.css')
            ->addCss('footer.css')
            ->addCss('1columnMain.css')
            ->addCss('order/view.css');
    }


    public function indexAction(){
        $layout = $this->getLayout();
        $this->getCss();

        $child = $layout->getChild('content');
        $orderView = $layout->createBlock('order/orderView');
        $child->addChild('orderView', $orderView);

        $layout->toHtml();
    }

    public function saveAction(){
        $orderId = $this->getRequest()->getParams('oId');
        $order = Mage::getModel('sales/order')->load($orderId);
        $historyData = [
            'order_id' => $order->getId(),
            'from_status' => $order->getStatus(),
            'to_status' => Sales_Model_Order::CANCELLATION_REQUEST_CUSTOMER,
            'action_by' => Sales_Model_Order::ACTION_BY_CUSTOMER
        ];
        $order->addData('status', Sales_Model_Order::CANCELLATION_REQUEST_CUSTOMER)
            ->save();

        Mage::getModel('sales/order_status_history')->addHistory($historyData);
        $this->redirect('order/index/index');
    }
    
}

