<?php

class Cart_Block_Cartview extends Core_Block_Template{

    public function __construct(){
        $this->setTemplate('cart/cartview.phtml');
    }

    public function getItemData(){


        $customerId = Mage::getSingleton('core/session')->get('logged_in_customer_id');
        $quoteData = Mage::getModel('sales/quote')->loadQuoteByCustomer($customerId);

        if(!empty($customerId) && !empty($quoteData) && empty($quoteData->getOrderId())){
            return Mage::getModel('sales/quote_item')->getCollection()
            ->addFieldToFilter('quote_id', $quoteData->getQuoteId());
        }else{
            $quoteId = Mage::getSingleton('core/session')->get('quote_id');
            return Mage::getModel('sales/quote_item')->getCollection()
                ->addFieldToFilter('quote_id', $quoteId);
        }
    }

    public function quoteDataUsingCustomerId(){
        return Mage::getModel('sales/quote')->getCollection()
            ->addFieldToFilter('customer_id', Mage::getSingleton('core/session')->get('logged_in_customer_id'))
            ->getFirstItem();
    }

    public function getProduct($id){
        return Mage::getModel('catalog/product')->load($id);
    }

    public function getQuoteData($quoteId){
        if($quoteId == null){
            return Mage::getModel('sales/quote')->load($this->quoteDataUsingCustomerId()->getQuoteId());
        }
        return Mage::getModel('sales/quote')->load($quoteId);
    }

}