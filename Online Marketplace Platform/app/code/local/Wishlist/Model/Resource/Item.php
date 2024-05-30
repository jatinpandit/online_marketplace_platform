<?php

class Wishlist_Model_Resource_Item extends Core_Model_Resource_Abstract{

    public function __construct(){
        $this->init("wishlist_item","wishlist_item_id");
    }
}