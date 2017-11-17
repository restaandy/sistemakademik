<?php
namespace GroceryCrud\Core\State;

use GroceryCrud\Core\GroceryCrud as GCrud;
use GroceryCrud\Core\Render\RenderAbstract;
use GroceryCrud\Core\Model;
use \PHPExcel as PHPExcel;
use \PHPExcel_IOFactory as PHPExcel_IOFactory;

class PrintState extends StateAbstract {

    const MAX_AMOUNT_OF_PRINT = 1000;

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
        if ($stateParameters->search_field !== null && $stateParameters->search_text !== null) {
            $this->setFilters($stateParameters->search_field, $stateParameters->search_text);
        }

        $this->setModel();
        $model = $this->gCrud->getModel();

        if ($this->gCrud->getWhere() !== null) {
            $model->setWhere($this->gCrud->getWhere());
        }

        $model->setRelations1ToN($this->getRelations1ToN());
    }

    public function render()
    {
        $stateParameters = $this->getStateParameters();

        $this->initialize($stateParameters);
        $this->setInitialData();

        $model = $this->gCrud->getModel();

        $model->setColumns($this->getColumns(StateAbstract::WITH_PRIMARY_KEY));

        if ($stateParameters->order_by !== null) {
            $model->setOrderBy($stateParameters->order_by);

            if ($stateParameters->sorting !== null) {
                $model->setSorting($stateParameters->sorting);
            }
        }

        $model->setLimit(PrintState::MAX_AMOUNT_OF_PRINT);

        if (!empty($this->filtersAnd)) {
            $model->setAndFilters($this->filtersAnd);
        }

        if (!empty($this->filtersOr)) {
            $model->setOrFilters($this->filtersOr);
        }

        $results = $model->getList();

        $primaryKeyName = $this->getPrimaryKeyName();

        $results = $this->stripTags($this->enhanceColumnResults($results));


        foreach ($results as &$result) {
            $result['grocery_crud_extras'] = (object) array(
                'primaryKeyValue' => $result[$primaryKeyName]
            );
        }

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