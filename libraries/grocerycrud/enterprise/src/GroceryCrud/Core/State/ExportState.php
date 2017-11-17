<?php
namespace GroceryCrud\Core\State;

use GroceryCrud\Core\GroceryCrud as GCrud;
use GroceryCrud\Core\Render\RenderAbstract;
use GroceryCrud\Core\Model;
use \PHPExcel as PHPExcel;
use \PHPExcel_IOFactory as PHPExcel_IOFactory;

class ExportState extends StateAbstract {

    const MAX_AMOUNT_OF_EXPORT = 1000;

    protected $filters = [];

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

    public function filterByColumns($results)
    {
        $columnNames = $this->getColumns();
        $finalResults = [];

        foreach ($results as $row) {
            $tmpRow = [];
            foreach ($row as $fieldName => $fieldValue) {
                if (in_array($fieldName, $columnNames)) {
                    $tmpRow[$fieldName] = $fieldValue;
                }
            }
            $finalResults[] = $tmpRow;
        }

        return $finalResults;

    }

    public function render()
    {
        $stateParameters = $this->getStateParameters();

        $this->setInitialData();
        $this->initialize($stateParameters);

        $model = $this->gCrud->getModel();

        $model->setColumns($this->getColumns(StateAbstract::WITH_PRIMARY_KEY));

        if ($stateParameters->order_by !== null) {
            $model->setOrderBy($stateParameters->order_by);

            if ($stateParameters->sorting !== null) {
                $model->setSorting($stateParameters->sorting);
            }
        }

        $model->setLimit(ExportState::MAX_AMOUNT_OF_EXPORT);

        if (!empty($this->filtersAnd)) {
            $model->setAndFilters($this->filtersAnd);
        }

        if (!empty($this->filtersOr)) {
            $model->setOrFilters($this->filtersOr);
        }

        $results = $model->getList();

        $results = $this->stripTags($this->enhanceColumnResults($results));
        $results = $this->filterByColumns($results);

        $columns = $this->transformFieldsList($this->gCrud->getColumns(), $this->gCrud->getUnsetColumns());

        $this->exportToExcel($results, $columns);
    }

    public function exportToExcel($data, $columns)
    {
        // Create new PHPExcel object
        $objPHPExcel = new \PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        $columnsToExport = [];

        foreach ($columns as $column) {
            $columnsToExport[$column->name] = $column->displayAs;
        }

        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        if (!empty($data)) {
            $column = 'A';
            foreach ($data[0] as $field_name => $field_value) {
                if ($field_name === StateAbstract::EXTRAS_FIELD_NAME) {
                    continue;
                }

                if (!isset($columnsToExport[$field_name])) {
                    continue;
                }

                $activeSheet->setCellValue($column . '1', $columnsToExport[$field_name]);
                $column = ++$column;
            }

            $row_number = 2;
            foreach ($data as $row) {
                $column = 'A';
                foreach ($row as $field_name => $field_value) {
                    if ($field_name === StateAbstract::EXTRAS_FIELD_NAME) {
                        continue;
                    }
                    if (!isset($columnsToExport[$field_name])) {
                        continue;
                    }

                    $activeSheet->setCellValue($column . $row_number, $field_value);
                    $column = ++$column;
                }
                $row_number += 1;
            }
        }

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Simple');

        $subjectPlural = $this->gCrud->getSubjectPlural();

        $filename = !empty($subjectPlural) ? $subjectPlural : 'Spreadsheet';

        $filename .= '_' . date('Y-m-d');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public function _getCommonData()
    {
        $data = (object)array();

        $data->subject 				= $this->gCrud->getSubject();
        $data->subject_plural 		= $this->gCrud->getSubjectPlural();

        return $data;
    }
}