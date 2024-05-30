<?php

class Page_Block_Header extends Core_Block_Template
{

   protected $link = '';

   public function __construct()
   {
      $this->setTemplate('page/Header.phtml');
   }


   public function getCustomerName()
   {
      return Mage::getModel('customer/account')->getCollection()
         ->addFieldToFilter('customer_id', Mage::getSingleton('core/session')->get('logged_in_customer_id'))
         ->getData();
   }

   public function logInOutText()
   {
      $nameArr = $this->getCustomerName();
      if (empty (Mage::getSingleton('core/session')->get('logged_in_customer_id'))) {
         $logInOutText = 'Log-in';
         $this->link = Mage::getBaseUrl('customer/account/login');
      } else {
         $logInOutText = $nameArr[0]->getFirstName();
         // $this->link = Mage::getBaseUrl('customer/account/logout');
      }
      return $logInOutText;
   }

   public function getCategoryData()
   {
      return Mage::getModel('catalog/category')->getCollection();
   }

   public function getItemData()
   {
      $customerId = Mage::getSingleton('core/session')->get('logged_in_customer_id');
      $quoteData = Mage::getModel('sales/quote')->loadQuoteByCustomer($customerId);

      if (!empty ($customerId) && !empty ($quoteData) && empty ($quoteData->getOrderId())) {
         return Mage::getModel('sales/quote_item')->getCollection()
            ->addFieldToFilter('quote_id', $quoteData->getQuoteId());
      } else {
         $quoteId = Mage::getSingleton('core/session')->get('quote_id');
         return Mage::getModel('sales/quote_item')->getCollection()
            ->addFieldToFilter('quote_id', $quoteId);
      }

   }


   public function getHint($q)
   {
      $productModel = Mage::getModel('catalog/product')->getCollection()
         ->getData();

      $productName = [];

      foreach ($productModel as $_product) {
         $productName[] = $_product->getName();
      }


      $q = $_REQUEST["q"];

      $hint = "";

      // lookup all hints from array if $q is different from ""
      if ($q !== "") {
         $q = strtolower($q);
         $len = strlen($q);
         foreach ($productName as $name) {
            if (stristr($q, substr($name, 0, $len))) {
               if ($hint === "") {
                  $hint = $name;
               } else {
                  $hint .= ", $name";
               }
            }
         }
      }

      // Output "no suggestion" if no hint was found or output correct values
      echo $hint === "" ? "no suggestion" : $hint;
   }
}
