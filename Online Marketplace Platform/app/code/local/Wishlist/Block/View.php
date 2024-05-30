<?php

class Wishlist_Block_View extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('wishlist/view.phtml');
    }

    public function getWishlist(){

        return Mage::getModel('wishlist/wishlist')->getCollection()
            ->addFieldToFilter('customer_id', Mage::getSingleton('core/session')->get('logged_in_customer_id'))
            ->getData();
    }

    public function getWishlistItem($id){
        return Mage::getModel('wishlist/item')->getCollection()
        ->addFieldToFilter('wishlist_id',$id)
        ->getData();
    }

    public function getProduct($id){
        return Mage::getModel('catalog/product')->load($id);
    }
}