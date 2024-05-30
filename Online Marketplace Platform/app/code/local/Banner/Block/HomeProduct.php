<?php 

class Banner_Block_HomeProduct extends Core_Block_Template{
    
    public function __construct(){
        $this->setTemplate('banner/homeProduct.phtml');
    }

    public function getTrendingProduct()
    {
        return Mage::getModel('catalog/product')->getCollection()
            ->addFieldToFilter('product_id', ['in'=>[1,2,6,8]]);
    }

    public function getBestSallerProduct()
    {
        return Mage::getModel('catalog/product')->getCollection()
            ->addFieldToFilter('product_id', ['in'=>[11,10,15,35,33]]);
    }

    public function getProduct()
    {
        $productIdsRange1 = range(1, 15); 
        $productIdsRange2 = range(32, 41);
        $combinedProductIds = array_merge($productIdsRange1, $productIdsRange2);
        shuffle($combinedProductIds); 
        $selectedProductIds = array_slice($combinedProductIds, 0, 10);
        return Mage::getModel('catalog/product')->getCollection()
            ->addFieldToFilter('product_id', ['in'=> $selectedProductIds]);
    }

}