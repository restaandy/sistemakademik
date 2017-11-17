<?php
namespace GroceryCrud\Core\State;

use GroceryCrud\Core\Exceptions\Exception;
use GroceryCrud\Core\GroceryCrud as GCrud;
use GroceryCrud\Core\Render\RenderAbstract;
use GroceryCrud\Core\Error\ErrorMessage;

class UploadMultipleState extends StateAbstract {

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

    protected function upload($fieldName, $uploadPath)
    {
        $storage = new \Upload\Storage\FileSystem($uploadPath);
        $file = new \Upload\File($fieldName, $storage);

        // Optionally you can rename the file on upload
        $new_filename = uniqid();
        $file->setName($new_filename);

        // Validate file upload
        $file->addValidations(array(
            new \Upload\Validation\Extension(
                ['gif', 'jpeg', 'jpg', 'png', 'tiff', 'doc', 'docx', 'txt', 'odt', 'xls', 'xlsx', 'pdf', 'ppt', 'pptx', 'pps', 'ppsx', 'mp3', 'm4a', 'ogg', 'wav', 'mp4', 'm4v', 'mov', 'wmv', 'flv', 'avi', 'mpg', 'ogv', '3gp', '3g2']
            ),

            // Ensure file is no larger than 5M (use "B", "K", M", or "G")
            new \Upload\Validation\Size('20M')
        ));

        // Access data about the file that has been uploaded
        $data = array(
            'name'       => $file->getNameWithExtension(),
            'extension'  => $file->getExtension(),
            'mime'       => $file->getMimetype(),
            'size'       => $file->getSize(),
            'md5'        => $file->getMd5(),
            'dimensions' => $file->getDimensions()
        );

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