<?php

class Wishlist_Controller_Index extends Core_Controller_Front_Action
{

    protected $_allowedAction = [];

    public function init(){
        $action = $this->getRequest()->getActionName();
        if(!in_array($action, $this->_allowedAction) &&
                !Mage::getSingleton('core/session')->get('logged_in_customer_id')
        ){
            $this->getRequest()->redirect('customer/account/login');
        }
    }

    public function getCss()
    {
        $layout = $this->getLayout();
        $layout->getChild('head')
            ->addCss('header.css')
            ->addCss('footer.css')
            ->addCss('1columnMain.css')
            ->addCss('wishlist/view.css');
    }

    public function viewAction()
    {
        $layout = $this->getLayout();
        $this->getCss();
        $child = $layout->getChild('content');
        $wishlistView = $layout->createBlock('wishlist/view');
        $child->addChild('wishlistView', $wishlistView);
        $layout->toHtml();
    }

    public function saveAction(){

        $data = $this->getRequest()->getParams('wishlist');
        $wishlistModel = Mage::getModel('wishlist/wishlist')
            ->setData($data)
            ->addData('customer_id', Mage::getSingleton('core/session')->get('logged_in_customer_id'))
            ->save();
        $this->getRequest()->redirect('wishlist/index/view');
    }

    public function formWishlistAction(){
        $layout = $this->getLayout();
        $this->getCss();
        $child = $layout->getChild('content');
        $wishlistForm = $layout->createBlock('wishlist/form');
        $child->addChild('wishlistForm', $wishlistForm);
        $layout->toHtml();
    }
   

}

