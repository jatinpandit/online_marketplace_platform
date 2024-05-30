<?php


class Catalog_Block_Product_View  extends Core_Block_Template{
    protected $_catArray = [];
    
    public function __construct(){
        $this->setTemplate('catalog/product/view.phtml');
    }

    public function getProductData(){
        return Mage::getModel('catalog/product')->load($this->getRequest()->getParams('id' , 0));
    }
   
    public function getCategoryIdByName($id){
        if(isset($this->_catArray[$id])){
            return $this->_catArray[$id];
        }else{
            $catData = Mage::getModel('catalog/category')->getCollection();
            foreach ($catData->getData() as $value) {
                $this->_catArray[$value->getCategoryId()] = $value->getCategoryName();
            }
            return $this->_catArray[$id];
        }
    }
}