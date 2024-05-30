<?php

class Cart_Controller_Checkout extends Core_Controller_Front_Action
{


    protected $_allowedAction = ['view'];

    public function init()
    {
        $action = $this->getRequest()->getActionName();
        if (
            !in_array($action, $this->_allowedAction) &&
            !Mage::getSingleton('core/session')->get('logged_in_customer_id')
        ) {
            $this->getRequest()->redirect('customer/account/login');
        }
    }

    public function getCss()
    {
        $layout = $this->getLayout();
        $layout->getChild('head')
            ->addCss('header.css')
            ->addCss('footer.css')
            ->addCss('cart/view.css')
            ->addCss('cart/checkout.css')
            ->addCss('cart/orderdone.css')
            ->addCss('1columnMain.css');
    }


    public function viewAction()
    {
        $layout = $this->getLayout();
        $this->getCss();

        $child = $layout->getChild('content');
        $viewCart = $layout->createBlock('cart/cartview');
        $child->addChild('viewCart', $viewCart);

        $layout->toHtml();
    }

    public function checkoutAction()
    {
        $quote = Mage::getSingleton('sales/quote');
        $items = $quote->initQuote()
            ->getItemCollection()
            ->getData();
        $insufficientItems = array();
        if ($items) {
            foreach ($items as $item) {
                $product = $item->getProduct();
                $productId = $product->getId();
                $qtyInCart = $item->getQty();

                $inventory = $product->getInventory();

                if ($inventory < $qtyInCart) {
                    $insufficientItems[] = $item;
                }
            }
        }
        if (!empty ($insufficientItems)) {

            foreach ($insufficientItems as $insufficientItem) {
                $product = $insufficientItem->getProduct();
                $inventory = $product->getInventory();
                if ($inventory == 0) {
                    $customerId = Mage::getSingleton('core/session')->get('logged_in_customer_id');
                    $wishlistData = Mage::getModel('wishlist/wishlist')->getCollection()
                        ->addFieldToFilter('customer_id', $customerId)
                        ->getFirstItem();

                    if ($wishlistData == null) {
                        $wishlist = Mage::getModel('wishlist/wishlist');
                        $wishlist->setData([
                            "customer_id" => $customerId,
                            "name" => 'my wishlist'
                        ])->save();

                        $wishlistId = $wishlist->getId();
                    } else {
                        $wishlistId = $wishlistData->getId();
                    }

                    Mage::getModel('wishlist/item')->setData([
                        'wishlist_id' => $wishlistId,
                        'product_id' => $insufficientItem->getProductId()
                    ])->save();
                    $insufficientItem->delete();
                } else {
                    $insufficientItem->addData('qty', $inventory)
                        ->save();
                }
            }
            $quote->save();
            $message = "Some items(qty's) have been removed from your cart due to insufficient inventory.";
            Mage::getSingleton('core/session')->set('error_message', $message);
            $this->redirect('cart/checkout/view');
            return;
        }
        $layout = $this->getLayout();
        $this->getCss();

        $child = $layout->getChild('content');
        $checkout = $layout->createBlock('cart/checkout');
        $child->addChild('checkout', $checkout);
        $layout->toHtml();
    }

    public function placeorderAction()
    {
        $layout = $this->getLayout();
        $this->getCss();

        $child = $layout->getChild('content');
        $order = $layout->createBlock('cart/order');
        $child->addChild('order', $order);
        $layout->toHtml();
    }

}