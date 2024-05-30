<?php

class Admin_Block_Home extends Core_Block_Template
{

   public function __construct()
   {
      $this->setTemplate('admin/home.phtml');
   }

   public function getArrayCategoryData()
   {
      $data = [];
      $item = Mage::getModel('sales/order_item')->getCollection()
        ->addFieldToSelect([
            'cp.category_id AS category_id',
            'c.category_name AS category_name',
            'SUM(qty) AS total_sold'
        ])
        ->join('catalog_product AS cp', 'cp.product_id = sales_order_item.product_id', '')
        ->join('catalog_category AS c', 'c.category_id = cp.category_id', '')
        ->setGroupBy('cp.category_id')
        ->getData();
         // var_dump($item);
         // echo 111;
      if(isset($item)){
         foreach ($item as $value) {
            $data[] = $value->getData();
         }
      }

      return $data;
   }


}