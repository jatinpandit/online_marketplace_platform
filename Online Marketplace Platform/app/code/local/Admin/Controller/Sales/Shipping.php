<?php

class Admin_Controller_Sales_Shipping extends Core_Controller_Admin_Action
{

    protected $_allowedAction = [];

    public function getCss()
    {
        $layout = $this->getLayout();
        $layout->getChild('head')
            ->addCss('admin/header.css')
            ->addCss('product/form.css')
            ->addCss('product/list.css')
            ->addCss('adminMain.css');
    }
    public function formAction()
    {
        $layout = $this->getLayout();
        $this->getCss();
        $child = $layout->getChild('content');
        $shippingForm = $layout->createBlock('sales/admin_shipping_form');
        $child->addChild('form', $shippingForm);
        $layout->toHtml();
    }

    public function listAction()
    {
        $layout = $this->getLayout();
        $this->getCss();
        $child = $layout->getChild('content');
        $shippingList = $layout->createBlock('sales/admin_shipping_list');
        $child->addChild('list', $shippingList);
        $layout->toHtml();

    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getParams('id');
        $shipping = Mage::getModel('sales/shipping')->load($id)
            ->delete();
        $this->getRequest()->redirect('admin/sales_shipping/list');
    }

    public function saveAction()
    {
        $data = $this->getRequest()->getParams('shipping_method');
        $shippingModel = Mage::getModel('sales/shipping')
            ->setData($data)
            ->save();
        $this->getRequest()->redirect('admin/sales_shipping/list');
    }

}
