<?php

class Order_Block_Admin_List extends Core_Block_Template
{

    public function __construct()
    {
        $this->setTemplate('order/admin/list.phtml');
    }

    public function getOrders($statusFilter = null)
    {
        $collection = Mage::getModel('sales/order')->getCollection()
            ->setOrderBy('order_id DESC');

        if ($statusFilter !== null) {
            $collection->addFieldToFilter('status', $statusFilter);
        }
        return $collection;

    }

    public function getOrdersItem($id)
    {
        return Mage::getModel('sales/order_item')->getCollection()
            ->addFieldToFilter('order_id', $id)
            ->getData();
    }

    public function getProduct($id)
    {
        return Mage::getModel('catalog/product')->load($id);
    }

    public function getStatusBackgroundColor($status)
    {
        switch ($status) {
            case '1':
                return '#F0F8FF';
            case '2':
                return '#FFFACD';
            case '3':
                return '#98FB98';
            case '5':
                return '#FFA07A';
            case '6':
                return '#D3D3D3';
            case '7':
                return '#E6E6FA';
            case '4':
                return '#87CEEB';
            default:
                return '#FFFFFF';
        }
    }

    
    public function getStatusData(){
        return Mage::getModel('sales/status')->getCollection()
            ->getData();
    }

}