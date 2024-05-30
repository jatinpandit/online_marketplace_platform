<?php

class Core_Block_Form_Radio extends Core_Block_Template{
    protected function _toHtml()
    {
        $html = '';
        if ($options = $this->getData('options')) {
            foreach ($options as $optionValue => $optionLabel) {
                $html .= '<input type="radio" value="' . $optionValue . '"';
                if ($this->getData('value') == $optionValue) {
                    $html .= ' checked';
                }
                foreach ($this->getData() as $key => $value) {
                    if ($key != 'options') {
                        $html .= ' ' . $key . '="' . $value . '"';
                    }
                }
                $html .= '>' . $optionLabel . '<br>';
            }
        }
        return $html;
    }
}

// Example
// $radioOptions = [
//     'male' => 'Male',
//     'female' => 'Female'
// ];
// $radio = getRenderer('radio', ['name' => 'gender', 'options' => $radioOptions, 'value' => 'male']);