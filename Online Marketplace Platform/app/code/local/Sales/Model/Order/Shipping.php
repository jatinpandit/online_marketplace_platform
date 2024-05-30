<?php

class Sales_Model_Order_Shipping extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClass = "Sales_Model_Resource_Order_Shipping";
        $this->_collectionClass = "Sales_Model_Resource_Collection_Order_Shipping";
        $this->_modelClass = "sales/order_shipping";
    }

    public function addShipping($quoteShipping, $orderId){
        $quoteShipping->removeData('shipping_id')
            ->removeData('quote_id');
        $this->setData($quoteShipping->getData())
            ->addData('order_id', $orderId)
            ->save();
        return $this;
    }
}