<?php
class Core_Block_Form_Checkbox extends Core_Block_Template{
    protected function _toHtml()
    {
        $html = '<input type="checkbox"';
        foreach ($this->getData() as $key => $value) {
            $html .= ' ' . $key . '="' . $value . '"';
        }
        $html .= ' />';
        return $html;
    }
}


// $checkbox = getRenderer('checkbox', ['name' => 'agree', 'value' => 'yes']);