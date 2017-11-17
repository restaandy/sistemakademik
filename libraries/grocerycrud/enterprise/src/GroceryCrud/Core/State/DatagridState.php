<?php
namespace GroceryCrud\Core\State;

use GroceryCrud\Core\GroceryCrud as GCrud;
use GroceryCrud\Core\Render\RenderAbstract;
use GroceryCrud\Core\Model;
use GroceryCrud\Core\Helpers\ArrayHelper;

class DatagridState extends StateAbstract {

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
            'search_field' => !empty($_GET['search_field']) ? $_GET['search_field'] : null,
            'search_text' => !empty($_GET['search_text']) ? $_GET['search_text'] : null,
            'page' => !empty($_GET['page']) ? $_GET['page'] : null,
            'per_page' => !empty($_GET['per_page']) ? $_GET['per_page'] : null,
            'sorting' => !empty($_GET['sorting']) ? $_GET['sorting'] : null,
            'order_by' => !empty($_GET['order_by']) ? $_GET['order_by'] : null
        );
    }

    public function initialize($stateParameters)
    {
        if ($stateParameters->search_text !== null) {
            $this->setFilters($stateParameters->search_field, $stateParameters->search_text);
        }
    }

    protected function _getRelationalColumns($columns) {
        $relational_fields = array_keys($this->gCrud->getRelationNtoN());

        $relational_columns = [];
        foreach ($columns as $rowNum => $columnName) {
            if (in_array($columnName, $relational_fields)) {
                $relational_columns[] = $columns[$rowNum];
            }
        }

        return $relational_columns;
    }

    public function render()
    {
        $stateParameters = $this->getStateParameters();
        $config = $this->getConfigParameters();

        $this->setInitialData();
        $this->initialize($stateParameters);

        $model = $this->gCrud->getModel();

        $allColumns = $this->getColumns(StateAbstract::WITH_PRIMARY_KEY);

        $this->setColumns();

        $model->setPrimaryKey($this->getPrimaryKeyName());

        $defaultOrderBy = $this->gCrud->getDefaultOrderBy();

        if ($defaultOrderBy !== null && $stateParameters->order_by === null) {
            $model->setDefaultOrderBy($defaultOrderBy->ordering, $defaultOrderBy->sorting);
        }

        if ($stateParameters->order_by !== null) {
            $model->setOrderBy($stateParameters->order_by);

            if ($stateParameters->sorting !== null) {
                $model->setSorting($stateParameters->sorting);
            }
        }

        if ($stateParameters->per_page !== null) {
            $model->setLimit($stateParameters->per_page);
        } else {
            $model->setLimit($config['default_per_page']);
        }

        if ($stateParameters->page !== null) {
            $model->setPage($stateParameters->page);
        }

        if (!empty($this->filtersAnd)) {
            $model->setAndFilters($this->filtersAnd);
        }

        if (!empty($this->filtersOr)) {
            $model->setOrFilters($this->filtersOr);
        }

        if ($this->gCrud->getWhere() !== null) {
            $model->setWhere($this->gCrud->getWhere());
        }

        $model->setRelationalColumns($this->_getRelationalColumns($allColumns));

        $relations1toN = $this->getRelations1ToN();
        foreach ($relations1toN as &$relation) {
            if (strstr($relation->titleField, '{')) {
                $relation->titleField = $this->getFieldsArray($relation->titleField);
            }
        }

        $model->setRelations1ToN($this->getRelations1ToN());
        $model->setRelationNToN($this->getRelationsNToN());

        $model = $this->gCrud->getModel();

        $results = $model->getList();

        $results = $this->enhanceColumnResults($results);

        $output = (object)array();
        $output->filtered_total = $model->getTotalItems();
        $output->data = $results;

        $render = new RenderAbstract();

        $render->output = json_encode($output);
        $render->outputAsObject = $results;
        $render->isJSONResponse = true;

        return $render;

    }

    public function _getCommonData()
    {
        $data = (object)array();

        $data->subject 				= $this->gCrud->getSubject();
        $data->subject_plural 		= $this->gCrud->getSubjectPlural();

        return $data;
    }
}