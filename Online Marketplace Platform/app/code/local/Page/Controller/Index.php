<?php


class Page_Controller_Index extends Core_Controller_Front_Action
{

    public function getCss()
    {
        $layout = $this->getLayout();

        $layout->getChild('head')->addCss('header.css');
        $layout->getChild('head')->addCss('footer.css');
        $layout->getChild('head')->addCss('1columnMain.css');
        $layout->getChild('head')->addCss('banner/banner.css');
        $layout->getChild('head')->addCss('banner/homeProduct.css');
    }

    public function indexAction()
    {
        $layout = $this->getLayout();
        $this->getCss();
        $banner = $layout->createBlock('banner/banner');
        $homeProduct = $layout->createBlock('banner/homeProduct');
        $content = $layout->getChild('content')
            ->addChild('banner', $banner)
            ->addChild('homeProduct', $homeProduct);
        $layout->toHtml();
    }

    public function searchAction() {
        $q = $this->getRequest()->getParamS('q');
    
        $productCollection = Mage::getModel('catalog/product')->getCollection()
            ->addFieldToFilter('name', array('like' => '%' . $q . '%'))
            ->getData();

        $hint = '';
        foreach ($productCollection as $name) {
            $hint .= "<div><a href='".$name->getLink()."'>" . $name->getName() . "</a></div>";
        }
    
        echo $hint !== '' ? $hint : 'No suggestions';
    }
    

}
