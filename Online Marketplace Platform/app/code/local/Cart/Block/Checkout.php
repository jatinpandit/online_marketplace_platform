<?php

class Cart_Block_Checkout extends Core_Block_Template{

    public function __construct(){
        $this->setTemplate('cart/checkout.phtml');
    }

    public function getAddressData(){
        return  Mage::getModel('customer/address')->getCollection()
                ->addFieldToFilter('customer_id',Mage::getSingleton('core/session')->get('logged_in_customer_id'));
    }

    public function getaddressId(){
        return  Mage::getModel('sales/quote_customer')->getCollection()
                ->addFieldToFilter('customer_id',Mage::getSingleton('core/session')->get('logged_in_customer_id'));
    }

    public function getPaymentMethods(){
        return  Mage::getModel('sales/payment')->getCollection()->getData();
    }

    public function getShippingMethods(){
        return  Mage::getModel('sales/shipping')->getCollection()->getData();
    }

}