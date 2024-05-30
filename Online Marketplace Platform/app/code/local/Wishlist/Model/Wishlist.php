<?php

class Wishlist_Model_Wishlist extends Core_Model_Abstract{
    
    public function init(){
        $this->_resourceClass = "Wishlist_Model_Resource_Wishlist";
        $this->_collectionClass = "Wishlist_Model_Resource_Collection_Wishlist";
        $this->_modelClass = "wishlist/wishlist";
    }

}