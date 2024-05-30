<?php

class Sales_Model_Order_Customer extends Core_Model_Abstract{
    public function init(){
        $this->_resourceClass = "Sales_Model_Resource_Order_Customer";
        $this->_collectionClass = "Sales_Model_Resource_Collection_Order_Customer";
        $this->_modelClass = "sales/order_customer";
    }

    public function addCustomer($customerData, $orderId){
        $this->setData($customerData->getData());
        $this->removeData('quote_id');
        $this->removeData('quote_customer_id');
        $this->addData('order_id',$orderId);
        $this->save();
    }
}