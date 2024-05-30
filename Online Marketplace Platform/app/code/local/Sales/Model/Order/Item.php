<?php

class Sales_Model_Order_Item extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClass = "Sales_Model_Resource_Order_Item";
        $this->_collectionClass = "Sales_Model_Resource_Collection_Order_Item";
        $this->_modelClass = "sales/order_item";
    }

    public function addItem($itemdata, $orderId){
        $this->setData($itemdata);
        $this->removeData('item_id');
        $this->removeData('quote_id');
        $this->addData('order_id',$orderId);
        $this->save();
    }

    public function getProduct()
    {
        return Mage::getModel('catalog/product')->load($this->getProductId());
    }
}