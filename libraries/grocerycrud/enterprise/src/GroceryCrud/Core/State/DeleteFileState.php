<?php
namespace GroceryCrud\Core\State;

use GroceryCrud\Core\Exceptions\Exception;
use GroceryCrud\Core\GroceryCrud as GCrud;
use GroceryCrud\Core\Render\RenderAbstract;
use GroceryCrud\Core\Model;

class DeleteFileState extends StateAbstract {

    public function getStateParameters()
    {
        return (object)array(
            'filename' => $_POST['filename'],
            'fieldName' => $_POST['fieldName']
        );
    }

    public function render()
    {
        $stateParameters = $this->getStateParameters();

        $this->setModel();
        $model = $this->gCrud->getModel();

        if ($this->gCrud->getDbTableName() !== null) {
            $model->setTableName($this->gCrud->getDbTableName());
        }

        $field_types = $this->getFieldTypes();

        if (isset($field_types[$stateParameters->fieldName]) && $field_types[$stateParameters->fieldName]->dataType === 'upload') {
            $response = $this->deleteFile($stateParameters->filename, $field_types[$stateParameters->fieldName]->options->uploadPath);
        } else {
            throw new Exception('This operation is not allowed');
        }

        $output = (object)array();
        $output->status = $response ? 'success' : 'failure';

        $render = new RenderAbstract();


        $render->output = json_encode($output);
        $render->outputAsObject = $output;
        $render->isJSONResponse = true;

        return $render;

    }

    public function deleteFile($filename, $path) {
        return unlink($path . '/' . $filename);
    }
}