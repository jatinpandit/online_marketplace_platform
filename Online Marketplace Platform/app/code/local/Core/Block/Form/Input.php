<?php

class Core_Block_Form_Input extends Core_Block_Template{
    protected function _toHtml()
    {
        $html = '<input ';
        foreach ($this->getData() as $key => $value) {
            $html .= ' ' . $key . '="' . $value . '"';
        }
        $html .= ' />';
        return $html;
    }
}


// $textInput = getRenderer('input', ["type" => "text" ,'name' => 'username', 'placeholder' => 'Enter your username']);