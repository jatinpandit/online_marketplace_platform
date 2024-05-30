<?php

class Order_Block_OrderView extends Core_Block_Template{

    protected $_orderId = [];
    
    public $_uniqueIds = [];

    protected $_statusData = [];

    public function __construct(){
        $this->setTemplate('order/view.phtml');
    }

    public function getOrderIds(){
        return $this->_uniqueIds;
    }

    public function getOrders(){
        $orderData  = Mage::getModel('sales/order_customer')->getCollection()
            ->addFieldToFilter('customer_id', Mage::getSingleton('core/session')->get('logged_in_customer_id'))
            ->setOrderBy('order_id DESC');
        foreach ($orderData->getData() as $_order) {
            $this->_orderId[] = $_order->getOrderId();
        }   

        if(!empty($this->_orderId)){
            return Mage::getModel('sales/order')->getCollection()
                ->addFieldToFilter('order_id', ['in' => $this->_orderId])
                ->setOrderBy('order_id DESC');
        }else{
            return false;
        }
    }

    public function getProductData($id = ""){
        return Mage::getModel('catalog/product')->load($id);
    }

    public function getItemData($id){
        return Mage::getModel('sales/order_item')->getCollection()
        ->addFieldToFilter('order_id', $id);
    }

    public function getStatusName($statusId){    
        if(empty($this->_statusData)){
            $status = Mage::getModel('sales/status')->getCollection()->getData();
            if(!empty($status)){
                foreach ($status as $_status) {
                    $this->_statusData [$_status->getStatusId()] = $_status->getStatusName(); 
                }
            }
        }
        if (isset($statusId)) {
            return $this->_statusData[$statusId];
        }


    }
}