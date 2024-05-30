<?php 

class Sales_Block_Admin_Payment_Form extends Core_Block_Template{
    
    public function __construct(){
        $this->setTemplate('sales/admin/payment/form.phtml');
    }

    public function getPaymentData()
    {
        return Mage::getModel('sales/payment')->load($this->getRequest()->getParams('id',0));
    }
}