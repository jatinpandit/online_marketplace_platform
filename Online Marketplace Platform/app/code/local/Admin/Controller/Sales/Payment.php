<?php

class Admin_Controller_Sales_Payment extends Core_Controller_Admin_Action
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
        $paymentForm = $layout->createBlock('sales/admin_payment_form');
        $child->addChild('form', $paymentForm);
        $layout->toHtml();
    }

    public function listAction()
    {
        $layout = $this->getLayout();
        $this->getCss();
        $child = $layout->getChild('content');
        $paymentList = $layout->createBlock('sales/admin_payment_list');
        $child->addChild('list', $paymentList);
        $layout->toHtml();

    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getParams('id');
        $payment = Mage::getModel('sales/payment')->load($id)
            ->delete();
        $this->getRequest()->redirect('admin/sales_payment/list');
    }

    public function saveAction()
    {
        $data = $this->getRequest()->getParams('payment_method');
        $paymentModel = Mage::getModel('sales/payment')
            ->setData($data)
            ->save();
        $this->getRequest()->redirect('admin/sales_payment/list');
    }

}
