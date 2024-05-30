<?php

class Wishlist_Model_Item extends Core_Model_Abstract{
    
    public function init(){
        $this->_resourceClass = "Wishlist_Model_Resource_Item";
        $this->_collectionClass = "Wishlist_Model_Resource_Collection_Item";
        $this->_modelClass = "Wishlist/item";
    }

}