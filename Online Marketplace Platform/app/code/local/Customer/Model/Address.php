<?php

class Customer_Model_Address extends Core_Model_Abstract{
    
    public function init(){
        $this->_resourceClass = "Customer_Model_Resource_Address";
        $this->_collectionClass = "Customer_Model_Resource_Collection_Address";
        $this->_modelClass = "customer/address";
    }

    public function getAddressCollection(){
        return Mage::getModel('customer/address')->getCollection()
        ->addFieldToFilter('customer_id', Mage::getSingleton('core/session')->get('logged_in_customer_id'));
    }

    public function addAddress($data){
        $this->setData($data);
        $this->removeData('quote_customer_id')
            ->removeData('quote_id')
            ->removeData('email')
            ->addData('customer_id', Mage::getSingleton('core/session')->get('logged_in_customer_id'));
        $count = 0;
        $sizeAddCollection = sizeof($this->getAddressCollection()->getData());
        foreach ($this->getAddressCollection()->getData() as $_address) {
            $_address->removeData('address_id');
            $oldAddressData = $_address->getData();
            if ($this->compareAddresses($oldAddressData, $this->getData()) == false) {
                $count++;
            }
        }
        if($count == $sizeAddCollection){
             $this ->save();
        }
    }

    public function compareAddresses($oldAddressData, $newAddressData) {

        foreach ($oldAddressData as $key => $value) {
            if ($newAddressData[$key] !== $value) {
            // print_r($newAddressData[$key] ."->". $value);
                return false; 
            }
        }
        return true;
    }
}