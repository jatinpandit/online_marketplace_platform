<?php

class Sales_Model_Order_Status_History extends Core_Model_Abstract
{

    protected $_statusName = [];

    public function init()
    {
        $this->_resourceClass = "Sales_Model_Resource_Order_Status_History";
        $this->_collectionClass = "Sales_Model_Resource_Collection_Order_Status_History";
        $this->_modelClass = "sales/order_status_history";
    }


    public function addHistory($historyData){
        $this->setData($historyData)
        ->save();
    }

    public function getReqHistoryData($orderId){
        return $this->getCollection()
            ->addFieldToFilter('order_id',$orderId)
            ->setOrderBy('history_id DESC')
            ->getFirstItem();
    }

    public function getStatusNameById($id){
        if($this->_statusName){
            return $this->_statusName[$id];
        }else{
            $statusData = Mage::getModel('sales/status')->getCollection()
            ->getData();

            if($statusData){
                foreach ($statusData as $_status) {
                    $this->_statusName[$_status->getStatusId()] = $_status->getStatusName();
                }
            }
            return $this->_statusName[$id];
        }

    }

}