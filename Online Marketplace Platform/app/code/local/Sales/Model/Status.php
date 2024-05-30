<?php

class Sales_Model_Status extends Core_Model_Abstract
{

    const DEFAULT_ORDER_STATUS = 1;
    const DEFAULT_ORDER_STATUS_TEXT = 'Order Placed';

    public function init()
    {
        $this->_resourceClass = "Sales_Model_Resource_Status";
        $this->_collectionClass = "Sales_Model_Resource_Collection_Status";
        $this->_modelClass = "sales/status";
    }

}
