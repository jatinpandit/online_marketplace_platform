<?php

class Sales_Model_Order extends Core_Model_Abstract
{

    const ACTION_BY_ADMIN = 'admin';
    const ACTION_BY_CUSTOMER = 'customer';
    const CANCELLATION_REQUEST_CUSTOMER = '8';
    const CANCELLED_ACTION = '5';

    public function init()
    {
        $this->_resourceClass = "Sales_Model_Resource_order";
        $this->_collectionClass = "Sales_Model_Resource_Collection_order";
        $this->_modelClass = "sales/order";
    }


    protected function _beforeSave()
    {
        if(empty($this->getOrderNumber())){
            // $randomComponent = mt_rand(100000, 999999);
            // $this->addData('order_number',$randomComponent);   
            $prefix = 'ORD-';
            $sequentialNumber = sizeof($this->getCollection()->getData()) + 1;
            $suffix = '-001';
            $this->addData('order_number', $prefix . $sequentialNumber . $suffix)->save();
        }

    }

    public function addOrder(Sales_Model_Quote $data){
        $defaultStatus = Sales_Model_Status::DEFAULT_ORDER_STATUS;
        $this->setData($data->getData())
        ->removeData('quote_id')
        ->removeData('payment_id')
        ->removeData('shipping_id')
        ->removeData('customer_id')
        ->removeData('order_id')
        ->addData('status', $defaultStatus)
        ->save();

        return $this;
    }

}
