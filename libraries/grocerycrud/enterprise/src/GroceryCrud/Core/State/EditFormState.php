<?php
namespace GroceryCrud\Core\State;

use GroceryCrud\Core\GroceryCrud as GCrud;
use GroceryCrud\Core\Render\RenderAbstract;
use GroceryCrud\Core\Exceptions\Exception as GCrudException;

class EditFormState extends StateAbstract {

    /**
     * MainState constructor.
     * @param GCrud $gCrud
     */
    function __construct(GCrud $gCrud)
    {
        $this->gCrud = $gCrud;
    }

    public function getStateParameters()
    {
        return (object)array(
            'primary_key_value' => !empty($_GET['pk_value']) ? $_GET['pk_value'] : null
        );
    }

    public function initialize($stateParameters)
    {
        $this->setModel();
        $model = $this->gCrud->getModel();

        if ($this->gCrud->getDbTableName() !== null) {
            $model->setTableName($this->gCrud->getDbTableName());
        }

        if ($this->gCrud->getWhere() !== null) {
            $model->setWhere($this->gCrud->getWhere());
        }

        $model->setPrimaryKey($this->getPrimaryKeyName());
        $model->setRelations1ToN($this->getRelations1ToN());
    }

    public function render()
    {
        if (!$this->gCrud->getLoadEdit()) {
            throw new \Exception('Permission denied. You are not allowed to use this operation');
        }

        $stateParameters = $this->getStateParameters();

        $this->initialize($stateParameters);

        $model = $this->gCrud->getModel();

        $output = (object)[];

        try {
            if (!$model->validateOne($stateParameters->primary_key_value)) {
                throw new GCrudException(
                    "Either the user doesn't have access to this row, either the row doesn't exist."
                );
            }

            $result = $model->getOne($stateParameters->primary_key_value);

            $relationNtoN = $this->gCrud->getRelationNtoN();

            foreach ($relationNtoN as $field) {
                $result[$field->fieldName] = $model->getRelationNtoNData($field, $stateParameters->primary_key_value);
            }

            $editFormCallback = $this->gCrud->getCallbackEditForm();

            if ($editFormCallback !== null) {
                $result = $editFormCallback($result);
            }

            $output = $this->setResponseStatusAndMessage($output, $result);

            if ($output->status === 'success') {
                $output->data = $result;
            }

        } catch (GCrudException $e) {
            $output->message = $e->getMessage();
            $output->status = 'failure';
        }

        $render = new RenderAbstract();

        $render->output = json_encode($output);
        $render->outputAsObject = $output;
        $render->isJSONResponse = true;

        return $render;

    }

    public function showList($results)
    {
        $data = $this->_getCommonData();
        $columns = $this->gCrud->getColumns();

        if (!empty($columns)) {
            $data->columns = $columns;
        } else {
            $data->columns = array_keys((array)$results[0]);
        }

        return $this->gCrud->getLayout()->theme_view('list_template.php', $data, true);
    }

    public function _getCommonData()
    {
        $data = (object)array();

        $data->subject 				= $this->gCrud->getSubject();
        $data->subject_plural 		= $this->gCrud->getSubjectPlural();

        return $data;
    }
}