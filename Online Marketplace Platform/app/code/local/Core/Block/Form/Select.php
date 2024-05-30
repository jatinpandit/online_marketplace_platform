<?php

class Core_Block_Form_Select extends Core_Block_Template {
    protected function _toHtml() {
        $html = '<select';
        foreach ($this->getData() as $key => $value) {
            if ($key === 'options') {
                continue; 
            }
            $html .= ' ' . $key . '="' . $value . '"';
        }
        $html .= '>';
        if ($this->getData('options') && is_array($this->getData('options'))) {
            foreach ($this->getData('options') as $optionValue => $optionLabel) {
                $html .= '<option value="' . $optionValue . '">' . $optionLabel . '</option>';
            }
        }
        
        $html .= '</select>';
        echo $html;
        return $html;
    }
}

// $selectOptions = [
//     '1' => 'Option 1',
//     '2' => 'Option 2',
//     '3' => 'Option 3'
// ];
// $select = getRenderer('select', ['name' => 'dropdown', 'options' => $selectOptions]);