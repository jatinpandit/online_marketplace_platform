<?php

class Sales_Model_Quote extends Core_Model_Abstract
{

    public function init()
    {
        $this->_resourceClass = "Sales_Model_Resource_Quote";
        $this->_collectionClass = "Sales_Model_Resource_Collection_Quote";
        $this->_modelClass = "sales/quote";
    }

    public function initQuote()
    {
        $customerId = Mage::getSingleton('core/session')->get('logged_in_customer_id');
        $quoteId = Mage::getSingleton('core/session')->get('quote_id');
        if (!empty ($quoteId)) {
            $this->load($quoteId);
            if (empty ($this->getCustomerId())) {
                $this->addData('customer_id', $customerId)
                    ->save();
            }
            if (count($this->countQuote($customerId)) > 1) {
                $this->mergeQuote($customerId);
            }
        }
        if (!$this->getId()) {

            $quoteData = $this->loadQuoteByCustomer($customerId);
            if ($customerId && $quoteData && empty ($quoteData->getOrderId())) {
                $this->load($quoteData->getQuoteId());
                if ($this->getId()) {
                    $quoteId = $this->getId();
                    Mage::getSingleton('core/session')->set('quote_id', $quoteId);
                }
            } else {
                $quote = Mage::getModel('sales/quote')
                    ->setData(["tax_percent" => 8, "grand_total" => 0]);
                if ($customerId) {
                    $quote->addData('customer_id', $customerId);
                }
                $quote->save();
                Mage::getSingleton('core/session')->set('quote_id', $quote->getId());
                $quoteId = $quote->getId();
                $this->load($quoteId);
            }
        }
        return $this;
    }

    public function loadQuoteByCustomer($customerId)
    {

        return $this->getCollection()
            ->addFieldToFilter('customer_id', $customerId)
            ->addFieldToFilter('order_id', null)
            ->getFirstItem();
    }


    public function countQuote($customerId)
    {
        return $this->getCollection()
            ->addFieldToFilter('customer_id', $customerId)
            ->addFieldToFilter('order_id', null)
            ->getData();
    }

    public function mergeQuote($customerId)
    {
        $mainQuote = $this->loadQuoteByCustomer($customerId);
        $mainQuoteId = $mainQuote->getId();

        $mergeQuoteData = $this->countQuote($customerId);
        $mergeQuoteId = $mergeQuoteData[1]->getQuoteId();

        $mergeQuote = $this->load($mergeQuoteId);

        foreach ($mergeQuote->getItemCollection()->getData() as $itemData) {
            Mage::getModel('sales/quote_item')
                ->addItem($mainQuote, $itemData->getProductId(), $itemData->getQty());
        }
        $mainQuote->save();
        $mergeQuote->delete();
        Mage::getSingleton('core/session')->set('quote_id', $mainQuoteId);
    }


    public function getItemCollection()
    {
        // $this->initQuote();
        return Mage::getModel('sales/quote_item')->getCollection()
            ->addFieldToFilter('quote_id', $this->getId());
    }

    public function getCustomerCollection()
    {
        return Mage::getModel('sales/quote_customer')->getCollection()
            ->addFieldToFilter('customer_id', Mage::getSingleton('core/session')->get('logged_in_customer_id'))
            ->getFirstItem();
    }

    public function getPaymentCollection()
    {
        // $this->initQuote();
        return Mage::getModel('sales/quote_payment')
            ->getCollection()
            ->addFieldToFilter('quote_id', $this->getId())
            ->getFirstItem();
    }

    public function getShippingCollection()
    {
        // $this->initQuote();
        return Mage::getModel('sales/quote_shipping')
            ->getCollection()
            ->addFieldToFilter('quote_id', $this->getId())
            ->getFirstItem();
    }

    protected function _beforeSave()
    {
        $grandTotal = 0;
        foreach ($this->getItemCollection()->getData() as $_item) {
            $grandTotal += $_item->getRowTotal();
        }
        if ($this->getTaxPercent()) {
            $tax = round($grandTotal / $this->getTaxPercent(), 2);
            $grandTotal = $grandTotal + $tax;
        }
        $this->addData('grand_total', $grandTotal);
    }

    public function addProduct($request)
    {
        $this->initQuote();
        if ($this->getId()) {
            Mage::getModel('sales/quote_item')->addItem($this, $request['product_id'], $request['quantity']);
        }
        $this->save();
    }

    public function removeProduct($itemId)
    {
        $this->initQuote();

        if ($this->getId()) {
            $itemModel = Mage::getModel('sales/quote_item')->load($itemId);
            if ($this->getId() == $itemModel->getQuoteId()) {
                $itemModel->delete();
                $this->save();
            }
        }
    }

    public function updateProduct($updateData)
    {
        $this->initQuote();
        if ($this->getId()) {
            $itemData = Mage::getModel('sales/quote_item')->load($updateData['item_id']);
            if ($this->getId() == $itemData->getQuoteId()) {
                $itemData->addData('qty', $updateData['new_qty']);
                $itemData->save();
                $this->save();
            }
        }
    }

    public function convert()
    {
        $this->initQuote();
        if ($this->getId()) {
            $order = Mage::getModel('sales/order')->addOrder($this);
            foreach ($this->getItemCollection()->getData() as $_item) {
                Mage::getModel('sales/order_item')->addItem($_item->getData(), $order->getId());
            }

            Mage::getModel('sales/order_customer')
                ->addCustomer($this->getCustomerCollection(), $order->getId());
            Mage::getModel('sales/order_payment')
                ->addPayment($this->getPaymentCollection(), $order->getId());
            Mage::getModel('sales/order_shipping')
                ->addShipping($this->getShippingCollection(), $order->getId());

            $this->addData('order_id', $order->getId());
            $this->save();
            Mage::getModel('catalog/product')->inventoryConvert($order->getId());
        }
    }


    public function addAddress($data)
    {
        $this->initQuote();
        Mage::getModel('sales/quote_customer')->setData($data)
            ->addData('quote_id', $this->getId())
            ->addData('customer_id', Mage::getSingleton('core/session')->get('logged_in_customer_id'))
            ->save();

        Mage::getModel('customer/address')->addAddress($data);

        return $this;
    }

    public function addPayment($data)
    {
        $this->initQuote();
        if ($this->getId()) {
            $payment = Mage::getModel('sales/quote_payment')
                ->setData($data)
                ->addData('quote_id', $this->getId())
                ->save();
            $this->addData('payment_id', $payment->getId());
        }
        $this->save();
    }

    public function addShipping($data)
    {
        $this->initQuote();
        if ($this->getId()) {
            $shipping = Mage::getSingleton('sales/quote_shipping')
                ->setData($data)
                ->addData('quote_id', $this->getId())
                ->save();
            $this->addData('shipping_id', $shipping->getId());
        }
        $this->save();
    }

}
