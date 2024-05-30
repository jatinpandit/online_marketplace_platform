<?php

class Wishlist_Model_Resource_Wishlist extends Core_Model_Resource_Abstract{

    public function __construct(){
        $this->init("wishlist","wishlist_id");
    }
}