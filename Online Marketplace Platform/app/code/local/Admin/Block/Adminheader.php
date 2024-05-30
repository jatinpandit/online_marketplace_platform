<?php

class Admin_Block_Adminheader extends Core_Block_Template {

    public $text = "";
    public $link = "";

    public function __construct(){
         $this->setTemplate('admin/adminHeader.phtml');
    }

    public function getDataText(){
        $action = Mage::getModel('core/request')->getControllerName();
        if($action == 'catalog_product'){
            $this->text = 'Add New Product';
            $this->link = Mage::getBaseUrl('admin/catalog_product/form');
        }elseif ($action == 'banner') {
            $this->text = 'Add New Banner';
            $this->link = Mage::getBaseUrl('admin/banner/form');
        }elseif  ($action == 'catalog_category') {
            $this->text = 'Add New Category';
            $this->link = Mage::getBaseUrl('admin/catalog_category/form');
        }elseif  ($action == 'sales_payment') {
            $this->text = 'Add New Payment Method';
            $this->link = Mage::getBaseUrl('admin/sales_payment/form');
        }elseif  ($action == 'sales_shipping') {
            $this->text = 'Add New shipping Method';
            $this->link = Mage::getBaseUrl('admin/sales_shipping/form');
        }elseif  ($action == 'sales_status') {
            $this->text = 'Add New status';
            $this->link = Mage::getBaseUrl('admin/sales_status/form');
        }elseif  ($action == 'import') {
            $this->text = 'Add New Csv';
            $this->link = Mage::getBaseUrl('admin/import/form');
        }else{
            $this->text = '';
        }
    }
}