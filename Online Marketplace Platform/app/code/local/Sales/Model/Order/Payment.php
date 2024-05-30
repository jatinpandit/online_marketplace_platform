<?php

class Sales_Model_Order_Payment extends Core_Model_Abstract
{

    protected $paymentData = [];

    public function init()
    {
        $this->_resourceClass = "Sales_Model_Resource_Order_Payment";
        $this->_collectionClass = "Sales_Model_Resource_Collection_Order_Payment";
        $this->_modelClass = "sales/order_payment";
    }


    public function addPayment($quotePayment, $orderId){
        $quotePayment->removeData('payment_id')
        ->removeData('quote_id');
        $this->setData($quotePayment->getData())
            ->addData('order_id', $orderId)
            ->save();
        return $this;
    }

}