<?php

class Order_Block_Admin_ItemView extends Core_Block_Template
{

    public function __construct()
    {
        $this->setTemplate('order/admin/itemView.phtml');
    }

    public function getCustomerData(){
        return Mage::getModel('sales/order_customer')->getCollection()
            ->addFieldToFilter('order_id', $this->getRequest()->getParams('oId'))
            ->getFirstItem();
    }

    public function getPaymentData(){
        return Mage::getModel('sales/order_payment')->getCollection()
            ->addFieldToFilter('order_id', $this->getRequest()->getParams('oId'))
            ->getFirstItem();
    }

    public function getShippingData(){
        return Mage::getModel('sales/order_shipping')->getCollection()
            ->addFieldToFilter('order_id', $this->getRequest()->getParams('oId'))
            ->getFirstItem();
    }

    public function getOrdersItem()
    {
        return Mage::getModel('sales/order_item')->getCollection()
            ->addFieldToFilter('order_id',  $this->getRequest()->getParams('oId'))
            ->getData();
    }

    public function getOrder(){
        return Mage::getModel('sales/order')->getCollection()
            ->addFieldToFilter('order_id', $this->getRequest()->getParams('oId'))
            ->getFirstItem();
    }
    
    public function getStatusData(){
        return Mage::getModel('sales/status')->getCollection()
            ->getData();
    }

    public function getHistoryData(){
        return Mage::getModel('sales/order_status_history')->getCollection()
            ->addFieldToFilter('order_id', $this->getRequest()->getParams('oId'))
            ->getData();
    }

}