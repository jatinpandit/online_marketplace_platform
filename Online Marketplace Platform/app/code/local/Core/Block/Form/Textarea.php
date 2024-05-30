<?php

class Core_Block_Form_Textarea extends Core_Block_Template{
    protected function _toHtml()
    {
        $html = '<textarea';
        foreach ($this->getData() as $key => $value) {
            $html .= ' ' . $key . '="' . $value . '"';
        }
        $html .= '>';
        $html .= $this->getData('value'); 
        $html .= '</textarea>';
        return $html;
    }
}

// $textarea = getRenderer('textarea', ['name' => 'message', 'rows' => '4', 'cols' => '50']);