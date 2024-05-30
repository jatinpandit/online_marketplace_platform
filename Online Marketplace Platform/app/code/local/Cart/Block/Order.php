<?php

class Cart_Block_Order extends Core_Block_Template{

    public function __construct(){
        $this->setTemplate('cart/orderDone.phtml');
    }

    public function getAddressData(){
        return  Mage::getModel('sales/quote_customer')->getCollection()
                ->addFieldToFilter('customer_id',Mage::getSingleton('core/session')->get('logged_in_customer_id'));
    }

}