<?php

class Sales_Controller_Quote extends Core_Controller_Front_Action
{
  public function getCss()
  {
    $layout = $this->getLayout();
    $layout->getChild('head')
      ->addCss('header.css')
      ->addCss('footer.css')
      ->addCss('1columnMain.css');
  }


  public function addAction()
  {
    $data = $this->getRequest()->getParams();
    Mage::getSingleton('sales/quote')->addProduct($data);
    $this->redirect('cart/checkout/view');
  }

  public function saveAction()
  {
    $addressData = $this->getRequest()->getParams('sales_quote_customer');
    Mage::getSingleton('sales/quote')->addAddress($addressData);

    $paymentData = $this->getRequest()->getParams('sales_quote_payment');
    Mage::getSingleton('sales/quote')->addPayment($paymentData);

    $shippingData = $this->getRequest()->getParams('sales_quote_shipping');
    Mage::getSingleton('sales/quote')->addShipping($shippingData);

    Mage::getSingleton('sales/quote')->convert();
    Mage::getSingleton('core/session')->remove('quote_id');
    $this->redirect('cart/checkout/placeorder');
  }


  public function deleteAction()
  {
    $deleteId = $this->getRequest()->getParams('id');
    Mage::getSingleton('sales/quote')->removeProduct($deleteId);
    $this->redirect('cart/checkout/view');
  }

  public function updateAction()
  {
    $updateData = $this->getRequest()->getParams();
    Mage::getSingleton('sales/quote')->updateProduct($updateData);
    $this->redirect('cart/checkout/view');
  }
}
