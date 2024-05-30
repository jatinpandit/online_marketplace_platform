<?php

class Admin_Controller_Order extends Core_Controller_Admin_Action
{

    protected $_allowedAction = [];

    public function getCss()
    {
        $layout = $this->getLayout();
        $layout->getChild('head')
            ->addCss('admin/header.css')
            // // ->addCss('product/form.css')
            ->addCss('order/admin/list.css')
            ->addCss('order/admin/itemView.css')
            ->addCss('adminMain.css');
    }


    public function listAction(){
        $layout = $this->getLayout();
        $this->getCss();
        $child = $layout->getChild('content');
        $orderList = $layout->createBlock('order/admin_list');
        $child->addChild('orderList',$orderList);
        $layout->toHtml();      
    }

    public function saveAction(){
        $data = $this->getRequest()->getParams('status_update');
        $order = Mage::getModel('sales/order')->load($data['order_id']);
        $historyData = [
            'order_id' => $order->getId(),
            'from_status' => $order->getStatus(),
            'to_status' => $data['status'],
            'action_by' => 'admin'
        ];
        $order->addData('status', $data['status'])
            ->save();

        Mage::getModel('sales/order_status_history')->addHistory($historyData);
        $this->redirect('admin/order/list');
    }


    public function itemViewAction(){
        $layout = $this->getLayout();
        $this->getCss();
        $child = $layout->getChild('content');
        $itemView = $layout->createBlock('order/admin_itemView');
        $child->addChild('itemView',$itemView);
        $layout->toHtml();   
    }

    public function cancellationReqAction(){

        $res = $this->getRequest()->getParams('res');
        $orderId = $this->getRequest()->getParams('oId');
        $order = Mage::getModel('sales/order')->load($orderId);
        $historyModel = Mage::getModel('sales/order_status_history'); 
        if($res == 'yes'){
            $historyData = [
                'order_id' => $order->getId(),
                'from_status' => Sales_Model_Order::CANCELLATION_REQUEST_CUSTOMER,
                'to_status' => Sales_Model_Order::CANCELLED_ACTION,
                'action_by' => Sales_Model_Order::ACTION_BY_ADMIN
            ];
            $order->addData('status', Sales_Model_Order::CANCELLED_ACTION)
                ->save();
            $historyModel->addHistory($historyData);
        }else{
            $status = $historyModel->getReqHistoryData($orderId)->getFromStatus();
            $historyData = [
                'order_id' => $order->getId(),
                'from_status' => Sales_Model_Order::CANCELLATION_REQUEST_CUSTOMER,
                'to_status' => $status,
                'action_by' => Sales_Model_Order::ACTION_BY_ADMIN
            ];
            $order->addData('status', $status)
            ->save();
            $historyModel->addHistory($historyData);
        }
        $this->redirect('admin/order/list');
        
    }



}

