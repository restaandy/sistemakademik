<?php
namespace GroceryCrud\Core\State;

use GroceryCrud\Core\Exceptions\Exception;
use GroceryCrud\Core\GroceryCrud as GCrud;
use GroceryCrud\Core\Render\RenderAbstract;
use GroceryCrud\Core\Error\ErrorMessage;
use GroceryCrud\Core\Upload\Transliteration;

class UploadState extends StateAbstract {

    public function getStateParameters()
    {
        return (object)[
            'field_name' => array_keys($_FILES)[0]
        ];
    }

    public function render()
    {
        $stateParameters = $this->getStateParameters();

        $this->setModel();
        $model = $this->gCrud->getModel();

        if ($this->gCrud->getDbTableName() !== null) {
            $model->setTableName($this->gCrud->getDbTableName());
        }

        $response = $this->stateOperationWithCallbacks($stateParameters, 'Upload', function ($stateParameters) {
            $field_name = $stateParameters->field_name;
            $field_types = $this->getFieldTypes();

            if (isset($field_types[$field_name]) && $field_types[$field_name]->dataType === 'upload') {
                $response = $this->upload($field_name, $field_types[$field_name]->options->uploadPath);

                $response->filePath = $field_types[$field_name]->options->publicPath . '/' . $response->filename;
            } else {
                $response = (new ErrorMessage())->setMessage('This operation is not allowed');
            }

            return $response;
        });

        $output = (object)array();
        $output = $this->setResponseStatusAndMessage($output, $response);

        if (!$this->hasErrorResponse($response)) {
            $output->uploadResult = $response;
        }

        $render = new RenderAbstract();


        $render->output = json_encode($output);
        $render->outputAsObject = $output;
        $render->isJSONResponse = true;

        return $render;

    }

    protected function removeExtension($filename) {
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
    }

    protected function transformRawFilename($filename) {
        // Filter any non existance characters. Filter XSS vulnerability
        // Also trim multiple whitespaces in a row
        $filename = trim(filter_var($filename));

        // Covert Translite characters
        $filename = Transliteration::convertFilename($filename);

        // Replace dot and empty space with dash
        $filename = str_replace(['.', ' '], '-', $filename);

        // Completely remove any illegal characters
        $filename = preg_replace("/([^a-zA-Z0-9\-\_ ]+?){1}/i", '', $filename);

        return $filename;
    }

    protected function upload($fieldName, $uploadPath)
    {
        $storage = new \Upload\Storage\FileSystem($uploadPath);
        $file = new \Upload\File($fieldName, $storage);

        $filename = isset($_FILES[$fieldName]) ? $_FILES[$fieldName]['name'] : null;

        if ($filename === null) {
            return false;
        }

        $filename = $this->removeExtension($filename);
        $filename = $this->transformRawFilename($filename);

        if (file_exists($uploadPath . '/' . $filename . '.' . $file->getExtension())) {
            $filename = $filename . '-' .substr(uniqid(), -5);
        }

        $file->setName($filename);

        // Validate file upload
        $file->addValidations(array(
            new \Upload\Validation\Extension(
                ['gif', 'jpeg', 'jpg', 'png', 'tiff', 'doc', 'docx', 'txt', 'odt', 'xls', 'xlsx', 'pdf', 'ppt', 'pptx', 'pps', 'ppsx', 'mp3', 'm4a', 'ogg', 'wav', 'mp4', 'm4v', 'mov', 'wmv', 'flv', 'avi', 'mpg', 'ogv', '3gp', '3g2']
            ),

            // Ensure file is no larger than 5M (use "B", "K", M", or "G")
            new \Upload\Validation\Size('20M')
        ));

        // Access data about the file that has been uploaded
        $data = [
            'name'       => $file->getNameWithExtension(),
            'extension'  => $file->getExtension(),
            'mime'       => $file->getMimetype(),
            'size'       => $file->getSize(),
            'md5'        => $file->getMd5(),
            'dimensions' => $file->getDimensions()
        ];

        // Try to upload file
        try {
            // Success!
            $file->upload();
        } catch (\Exception $e) {
            throw $e;
            // Fail!
            $errors = $file->getErrors();
        }

        return (object)[
            'filename' => $file->getNameWithExtension()
        ];
    }
}