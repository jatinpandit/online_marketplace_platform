<?php

class Catalog_Model_Product extends Core_Model_Abstract{

    // protected $_catData= [];
    public function init(){
        $this->_resourceClass = "Catalog_Model_Resource_Product";
        $this->_collectionClass = "Catalog_Model_Resource_Collection_Product";
        $this->_modelClass = "catalog/product";
    }

    public function getStatus(){
        if (isset($this->_data['status'])) {
            $mapping = [
                1=>"Enable",
                0=>"Disabel"
            ];
            return $mapping[$this->_data['status']];
        }
    }

    public function inventoryConvert($orderId){
        $orderItem = Mage::getModel('sales/order_item')->getCollection()
            ->addFieldToFilter('order_id', $orderId)
            ->getData();
        
            foreach ($orderItem as $_item) {
                $this->load($_item->getProductId());
                $this->addData('inventory', $this->getInventory()-$_item->getQty());
                $this->save();
            }
    }

    public function _afterSave()
    {
        $items = Mage::getModel("sales/quote_item")
            ->getCollection()
            ->addFieldToFilter("product_id", $this->getProductId())
            ->getData();
        if(!empty($items)){
            foreach ($items as $_item) {
                $_item->addData("price", $this->getPrice())->save();
                Mage::getModel("sales/quote")->load($_item->getQuoteId())->save();
            }
        }
    }
}