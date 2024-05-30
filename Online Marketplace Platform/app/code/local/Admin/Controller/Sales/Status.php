<?php

class Admin_Controller_Sales_Status extends Core_Controller_Admin_Action
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
        $status = $layout->createBlock('sales/admin_status_form');
        $child->addChild('form', $status);
        $layout->toHtml();
    }

    public function listAction()
    {
        $layout = $this->getLayout();
        $this->getCss();
        $child = $layout->getChild('content');
        $statusList = $layout->createBlock('sales/admin_status_list');
        $child->addChild('list', $statusList);
        $layout->toHtml();

    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getParams('id');
        $status = Mage::getModel('sales/status')->load($id)
            ->delete();
        $this->getRequest()->redirect('admin/sales_status/list');
    }

    public function saveAction()
    {
        $data = $this->getRequest()->getParams('status');
        $statusModel = Mage::getModel('sales/status')
            ->setData($data)
            ->save();
        $this->getRequest()->redirect('admin/sales_status/list');
    }

}
