<?php

class Admin_Controller_Import extends Core_Controller_Admin_Action
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
        $importForm = $layout->createBlock('import/admin_form');
        $child->addChild('form', $importForm);
        $layout->toHtml();
    }

    public function listAction()
    {
        $layout = $this->getLayout();
        $this->getCss();
        $child = $layout->getChild('content');
        $importList = $layout->createBlock('import/admin_list');
        $child->addChild('list', $importList);
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
        $tableName = $this->getRequest()->getParams('table_name');
        $file = $_FILES['csv_file'];
        $fName = $_FILES["csv_file"]["name"];

        if ($file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = Mage::getBaseDir('media/csv/');
            $filename = $uploadDir . basename($file['name']);

            if (move_uploaded_file($file['tmp_name'], $filename)) {

                Mage::getModel('import/importCsv')
                    ->addData('csv_file', $fName)
                    ->addData('table_name', $tableName)
                    ->save();

            } else {
                echo "Error moving uploaded file.";
            }
        } else {
            echo "Error uploading file.";
        }
        $this->redirect('admin/import/list');
    }


    public function readAction()
    {
        $csvId = $this->getRequest()->getParams('csvId');
        $fileName = Mage::getBaseDir('media/csv/') . Mage::getModel('import/importCsv')->load($csvId)->getCsvFile();

        $db = Mage::getSingleton('core/dB_adapter')->connect();
        $values = [];
        $handle = fopen($fileName, "r");
        if ($handle !== FALSE) {
            $header = fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== FALSE) {
                $rowData = array_combine($header, $data);
                $json = json_encode($rowData, JSON_UNESCAPED_UNICODE);
                $values[] = "('" . $csvId . "', '" . addslashes($json) . "')";

                if (count($values) >= 1000) {
                    $valuesStr = implode(", ", $values);
                    $sql = "INSERT INTO import (csv_id, json_data) VALUES {$valuesStr}";
                    $db->query($sql);
                    $values = [];
                }
            }

            if (!empty ($values)) {
                $valuesStr = implode(", ", $values);
                $sql = "INSERT INTO import (csv_id, json_data) VALUES {$valuesStr}";
                $db->query($sql);
            }

            fclose($handle);
            return true;
        }
        return false;
    }


    public function exportAction()
    {
        $csvId = $this->getRequest()->getParams('csvId');
        $data = Mage::getModel('import/import')->getCollection()
            ->addFieldToFilter('csv_id', $csvId)
            ->getData();

        $csvContent = "Column 1,Column 2,Column 3\n";
        foreach ($data as $_data) {
            $rowData = json_decode($_data->getJsonData(), true);
            $csvContent .= implode(',', $rowData) . "\n";
        }

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="export.csv"');

        echo $csvContent;
        exit;
    }


    public function importAction(){
        $csvId = $this->getRequest()->getParams('csvId');
        $importData = Mage::getModel('import/import')->getCollection()
            ->addFieldToFilter('csv_id', $csvId)
            ->addFieldToFilter('status',0)
            ->getData();

        echo count($importData);
    }

    public function importDataAction(){
        $csvId = $this->getRequest()->getParams('csvId');
        
        $importValue = Mage::getModel('import/import')->getCollection()
            ->addFieldToFilter('csv_id', $csvId)
            ->addFieldToFilter('status', 0) 
            ->getFirstItem();
    
        if ($importValue->getId()) { 
            try {
                $jsonData = $importValue->getJsonData();
                $filterData = json_decode($jsonData, true); 
                if ($filterData) { 
                    Mage::getModel('catalog/product')->setData($filterData)->save();
                    $importValue->addData('status', 1)->save(); 
                } else {
                    throw new Exception("Failed to decode JSON data.");
                }
            } catch (Exception $e) {
                $importValue->addData('status', 2)->save();
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Import record not found for CSV ID: " . $csvId;
        }
    }
    

}





