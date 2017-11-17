<?php

namespace GroceryCrud\Core\State;

use GroceryCrud\Core\Exceptions\Exception;
use GroceryCrud\Core\GroceryCrud as GCrud;
use GroceryCrud\Core\Helpers\ArrayHelper;
use GroceryCrud\Core\Model;
use GroceryCrud\Core\Error\ErrorMessageInteface;

class StateAbstract
{
    const EXTRAS_FIELD_NAME = 'grocery_crud_extras';
    const WITH_PRIMARY_KEY = 1;
    const WITH_TABLE_NAME = 1;

    public $config;

    /**
     * @var \GroceryCrud\Core\GroceryCrud
     */
    public $gCrud;

    public $filtersAnd = [];
    public $filtersOr = [];

    function __construct(GCrud $gCrud)
    {
        $this->gCrud = $gCrud;
        $this->config = $this->getConfigParameters();
    }

    /**
     * @overide
     * @return object
     */
    public function getStateParameters()
    {
        return (object)array();
    }

    public function getConfigParameters()
    {
        return $this->gCrud->getConfig();
    }

    public function filterData($data) {
        $config = $this->getConfigParameters();

        if ($config['xss_clean']) {
            foreach ($data as $data_name => $data_value) {
                if (is_string($data_value)) {
                    $data[$data_name] = strip_tags($data_value);
                }
            }
        }

        return $data;
    }

    public function setInitialData()
    {
        $this->setModel();

        $model = $this->gCrud->getModel();

        if ($this->gCrud->getDbTableName() !== null) {
            $model->setTableName($this->gCrud->getDbTableName());
        }

        $primaryKeys = $this->gCrud->getPrimaryKeys();
        if (!empty($primaryKeys)) {
               foreach ($primaryKeys as $tableName => $primaryKey) {
                   $model->setPrimaryKey($primaryKey, $tableName);
               }
        }
    }

    public function setColumns()
    {
        $allColumns = $this->getColumns(StateAbstract::WITH_PRIMARY_KEY);
        $this->gCrud->getModel()->setColumns($this->removeRelationalColumns($allColumns));
    }

    public function removeRelationalColumns($columns)
    {
        $relational_fields = array_keys($this->gCrud->getRelationNtoN());

        foreach ($columns as $rowNum => $columnName) {
            if (in_array($columnName, $relational_fields)) {
                unset($columns[$rowNum]);
            }
        }

        return $columns;
    }

    /**
     * Usually we don't use "clever" functions. However here as the callback names are hardcoded for now, we
     * did create dynamic names as getters
     *
     * @param $inputStateParameters
     * @param $callbackTitle
     * @param $operationCallback
     * @return {Object}
     */
    public function stateOperationWithCallbacks($inputStateParameters, $callbackTitle, $operationCallback)
    {
        $callbackBeforeString = "getCallbackBefore" . $callbackTitle;
        $callbackBefore = $this->gCrud->$callbackBeforeString();
        $callbackOperationString = "getCallback" . $callbackTitle;
        $callbackOperation = $this->gCrud->$callbackOperationString();
        $callbackAfterString = "getCallbackAfter" . $callbackTitle;
        $callbackAfter = $this->gCrud->$callbackAfterString();

        $inputStateParameters = $this->beforeStateOperation($callbackBefore, $inputStateParameters);
        // If the callback will return false then do not continue
        if ($inputStateParameters === false || $inputStateParameters instanceof ErrorMessageInteface) {
            return $inputStateParameters;
        }

        $inputStateParameters = $this->stateOperation($callbackOperation, $inputStateParameters, $operationCallback);
        if ($inputStateParameters === false || $inputStateParameters instanceof ErrorMessageInteface) {
            return $inputStateParameters;
        }

        $inputStateParameters = $this->afterStateOperation($callbackAfter, $inputStateParameters);
        if ($inputStateParameters === false || $inputStateParameters instanceof ErrorMessageInteface) {
            return $inputStateParameters;
        }

        return $inputStateParameters;
    }

    public function setResponseStatusAndMessage($output, $callbackResult) {

        if ($callbackResult instanceof ErrorMessageInteface) {
            $output->message = $callbackResult->getMessage();
            $output->status  = 'failure';
        } else {
            $output->message = $callbackResult === false ? 'Unknown error' : 'Success';
            $output->status = $callbackResult === false ? 'failure' : 'success';
        }

        return $output;
    }

    public function hasErrorResponse($response) {
        return $response === false || $response instanceof ErrorMessageInteface;
    }

    public function stripTags($results)
    {
        foreach ($results as &$result) {
            foreach ($result as $columnName => &$columnValue) {
                if (is_array($columnValue) || is_object($columnValue)) {
                    continue;
                }

                $columnValue = strip_tags($columnValue);
            }
        }

        return $results;
    }

    public function enhanceColumnResults($results)
    {
        $primaryKeyName = $this->getPrimaryKeyName();

        $callbackColumns = $this->gCrud->getCallbackColumn();
        $actionButtons = $this->gCrud->getActionButtons();

        $config = $this->getConfigParameters();

        $char_limiter = $config['column_character_limiter'];

        foreach ($results as &$result) {
            foreach ($result as $columnName => &$columnValue) {
                if (is_array($columnValue)) {
                    continue;
                }

                $columnValue = strip_tags($columnValue);
                $columnValue = $char_limiter > 0 && (strlen($columnValue) > $char_limiter) ? substr($columnValue, 0 , $char_limiter - 1) . '...' : $columnValue;

                if (isset($callbackColumns[$columnName])) {
                    $columnValue = $callbackColumns[$columnName]($columnValue, $result);
                }
            }

            $result[StateAbstract::EXTRAS_FIELD_NAME] = (object) array(
                'primaryKeyValue' => $result[$primaryKeyName]
            );

            foreach ($actionButtons as $actionButton) {
                if (!isset($result[StateAbstract::EXTRAS_FIELD_NAME]->actionButtons)) {
                    $result[StateAbstract::EXTRAS_FIELD_NAME]->actionButtons = [];
                }
                $callback = $actionButton->urlCallback;

                $result[StateAbstract::EXTRAS_FIELD_NAME]->actionButtons[] = (object)array(
                    'label' => $actionButton->label,
                    'iconCssClass' => $actionButton->iconCssClass,
                    'url' => $callback($result),
                    'newTab' => $actionButton->newTab
                );
            }
        }

        return $results;
    }

    public function getColumns($extra = null) {
        $columns = $this->gCrud->getColumns();
        $unsetColumns = $this->gCrud->getUnsetColumns();

        if (empty($columns)) {
            $columns = $this->getColumnNames();
        }

        foreach ($unsetColumns as $columnName) {
            $columns = ArrayHelper::array_reject($columns, function ($value) use ($columnName) {
                return $value === $columnName;
            });
        }

        if ($extra === StateAbstract::WITH_PRIMARY_KEY) {
            $primaryKey = $this->getPrimaryKeyName();
            if (!in_array($primaryKey, $columns)) {
                array_unshift($columns, $primaryKey);
            }
        }

        return $columns;
    }

    public function getRelations1ToN()
    {
        $relations1ToN = $this->gCrud->getDbRelations1ToN();

        foreach ($relations1ToN as &$relation) {
            $relation->relationPrimaryKey = $this->getPrimaryKeyName($relation->tableName);
        }

        return $relations1ToN;
    }

    public function getRelationsNToN()
    {
        $relationsNToN = $this->gCrud->getDbRelationsNToN();

        foreach ($relationsNToN as &$relation) {
            $relation->referrerPrimaryKeyField = $this->getPrimaryKeyName($relation->referrerTable);
        }

        return $relationsNToN;
    }

    public function beforeStateOperation($stateCallback, $stateParameters) {
        if ($stateCallback === null) {
            return $stateParameters;
        }
        return $stateCallback($stateParameters);
    }

    public function stateOperation($stateCallback, $stateParameters, $operationCallback) {
        if ($stateCallback === null) {
            return $operationCallback($stateParameters);
        }

        return $stateCallback($stateParameters);
    }

    public function afterStateOperation($stateCallback, $stateParameters) {
        if ($stateCallback === null) {
            return $stateParameters;
        }
        return $stateCallback($stateParameters);
    }

    public function getColumnNames() {
        $config = $this->getConfigParameters();
        $model = $this->gCrud->getModel();

        $cachedString = $this->getUniqueCacheName(self::WITH_TABLE_NAME) .'+columnNames';
        if ($config['backend_cache'] && $this->isInCache($cachedString)) {
            $columnNames = json_decode($this->getCacheItem($cachedString));
        } else {
            $columnNames = $model->getColumnNames();

            if ($config['backend_cache']) {
                $this->gCrud->getCache()->setItem($cachedString, json_encode($columnNames));
            }
        }

        foreach ($this->gCrud->getRelationNtoN() as $fieldName => $fieldInfo) {
            $columnNames[] = $fieldName;
        }

        return $columnNames;

    }

    public function setFilters($search_field_array, $search_text_array)
    {
        if (!is_array($search_text_array)) {
            $columns = $this->gCrud->getModel()->getColumnNames();

            foreach ($columns as $column_name) {
                $this->filtersOr[$column_name] = $search_text_array;
            }

        } else {
            foreach ($search_field_array as $num_row => $field_name) {
                $this->filtersAnd[$field_name] = $search_text_array[$num_row];
            }
        }
    }

    public function getPrimaryKeyName($dbTableNameRaw = null)
    {
        $config = $this->getConfigParameters();
        $primaryKeyName = null;

        $dbTableName = $dbTableNameRaw !== null ? $dbTableNameRaw : $this->gCrud->getDbTableName();
        $cacheUniqueId = $this->getUniqueCacheName() . '+' . $dbTableName;

        if (!$config['backend_cache'] || $this->gCrud->getCache()->getItem($cacheUniqueId . '+primaryKeyField') === null) {
            $primaryKeyName = $this->gCrud->getModel()->getPrimaryKeyField($dbTableName);

            if ($config['backend_cache']) {
                $this->gCrud->getCache()->setItem($cacheUniqueId . '+primaryKeyField', $primaryKeyName);
            }
        } else {
            $primaryKeyName = $this->gCrud->getCache()->getItem($cacheUniqueId . '+primaryKeyField');
        }

        return $primaryKeyName;
    }

    public function removePrimaryKeyFromList($fieldList)
    {
        if(($key = array_search($this->getPrimaryKeyName(), $fieldList)) !== false) {
            unset($fieldList[$key]);
        }

        return $fieldList;
    }

    public function getUniqueCacheName($extraInfo = null)
    {
        $model = $this->gCrud->getModel();

        $finalString = $model->getDbUniqueId();

        if ($extraInfo === self::WITH_TABLE_NAME) {
            $finalString .= '+' . $this->gCrud->getDbTableName();
        }

        return $finalString;
    }

    /**
     * @param string $stringWithFields
     * @return array
     */
    public function getFieldsArray($stringWithFields) {

        preg_match_all("{([^{}]+)}", $stringWithFields, $matches);

        $fields = [];
        foreach ($matches[0] as $match) {
            if (strstr($stringWithFields, '{' . $match . '}')) {
                $fields[] = $match;
            }
        }

        return $fields;
    }

    /**
     * @param string $stringWithFields
     * @return array
     */
    public function getMatchesAsArray($stringWithFields) {

        preg_match_all("{([^{}]+)}", $stringWithFields, $matches);

        return $matches[0];
    }

    public function transformDataWithMultipleFields($data, $stringWithFields) {
        $matches = $this->getMatchesAsArray($stringWithFields);

        $finalData = [];

        foreach ($data as $row) {
            $tmp = (object)[];
            $tmp->id = $row->id;
            $tmp->title = '';

            foreach ($matches as $match) {
                if (isset($row->title[$match])) {
                    $tmp->title .= $row->title[$match];
                } else {
                    $tmp->title .= $match;
                }
            }

            $finalData[] = $tmp;
        }

        return $finalData;
    }

    public function getFieldTypes()
    {
        $config = $this->getConfigParameters();
        $model = $this->gCrud->getModel();

        $dbTableName = $this->gCrud->getDbTableName();
        $cacheUniqueId = $this->getUniqueCacheName(self::WITH_TABLE_NAME);

        // Not in the cache? Then create it!
        if (!$config['backend_cache'] || $this->gCrud->getCache()->getItem($cacheUniqueId . '+fieldTypes') === null) {
            $fieldTypes = $model->getFieldTypes($dbTableName);

            if ($config['backend_cache']) {
                $this->gCrud->getCache()->setItem($cacheUniqueId . '+fieldTypes', json_encode($fieldTypes));
            }
        } else {
            $fieldTypes = (array)json_decode($this->gCrud->getCache()->getItem($cacheUniqueId . '+fieldTypes'));
        }

        $relations = $this->gCrud->getRelations1toMany();
        $requiredFields = $this->gCrud->getRequiredFields();

        foreach ($fieldTypes as $fieldName => $fieldType) {
            if (isset($relations[$fieldName])) {
                // In case we have already cached the primary key for the relational data
                $model->setPrimaryKey($this->getPrimaryKeyName($relations[$fieldName]->tableName), $relations[$fieldName]->tableName);

                $hasMultipleFields = strstr($relations[$fieldName]->titleField, "{");

                $columns = $hasMultipleFields
                    ? $this->getFieldsArray($relations[$fieldName]->titleField)
                    : $relations[$fieldName]->titleField;

                if ($relations[$fieldName]->orderBy !== null) {
                    $orderBy = $relations[$fieldName]->orderBy;
                } else {
                    $orderBy = is_array($columns) ? $columns[0] : $columns;
                }

                $relationalData = $this->gCrud->getModel()->getRelationData(
                    $relations[$fieldName]->tableName,
                    $columns,
                    $relations[$fieldName]->where,
                    $orderBy
                );

                $fieldTypes[$fieldName]->permittedValues = $relationalData;

                if ($hasMultipleFields) {
                    $fieldTypes[$fieldName]->permittedValues =
                        $this->transformDataWithMultipleFields($relationalData, $relations[$fieldName]->titleField);
                }

                $fieldTypes[$fieldName]->dataType = 'relational';
            }

            $fieldTypes[$fieldName]->isRequired = in_array($fieldName, $requiredFields);
        }

        foreach ($this->gCrud->getRelationNtoN() as $fieldName => $fieldInfo) {
            // In case we have already cached the primary key for the relational data
            $model->setPrimaryKey($this->getPrimaryKeyName($fieldInfo->referrerTable), $fieldInfo->referrerTable);

            $fieldTypes[$fieldName] = (object)array(
                'dataType' => 'relational_n_n',
                'isNullable' => false,
                'permittedValues' => $this->gCrud->getModel()->getRelationData(
                    $fieldInfo->referrerTable,
                    $fieldInfo->referrerTitleField
                )
            );
        }

        $fieldTypesFromUser = $this->gCrud->getFieldTypes();
        foreach ($fieldTypesFromUser as $fieldName => $filedTypeInfo) {
            if (isset($fieldTypes[$fieldName])) {
                $fieldTypes[$fieldName]->dataType = $filedTypeInfo->dataType;

                if ($filedTypeInfo->permittedValues !== null) {
                    $fieldTypes[$fieldName]->permittedValues = $filedTypeInfo->permittedValues;
                }

                $fieldTypes[$fieldName]->options = $filedTypeInfo->options;

                if (is_array($fieldTypes[$fieldName]->options) && isset($fieldTypes[$fieldName]->options['defaultValue'])) {
                    $fieldTypes[$fieldName]->defaultValue = $fieldTypes[$fieldName]->options['defaultValue'];
                }
            }
        }

        $texteditorFields = $this->gCrud->getTextEditorFields();
        foreach ($texteditorFields as $fieldName => $fieldValue) {
            if (isset($fieldTypes[$fieldName])) {
                $fieldTypes[$fieldName]->dataType = 'texteditor';
            }
        }

        $readOnlyFields = $this->gCrud->getReadOnlyFields();

        foreach ($readOnlyFields as $fieldName) {
            if (isset($fieldTypes[$fieldName])) {
                $fieldTypes[$fieldName]->isReadOnly = true;
            }
        }

        foreach ($fieldTypes as $fieldName => &$field) {
            $field->isReadOnly = property_exists($field, 'isReadOnly') ? $field->isReadOnly : false;
        }

        return $fieldTypes;
    }

    public function setModel()
    {
        $model = $this->gCrud->getModel();
        if ($model === null) {
            $config = $this->gCrud->getDatabaseConfig();
            if ($config === null) {
                throw new Exception('You need to add a configuration file first');
            }
            $model = new Model($config);
            $this->gCrud->setModel($model);
        }
    }

    public function getEditFields()
    {
        return $this->transformFieldsList($this->gCrud->getEditFields(), $this->gCrud->getUnsetEditFields());
    }

    public function getAddFields()
    {
        return $this->transformFieldsList($this->gCrud->getAddFields(), $this->gCrud->getUnsetAddFields());
    }

    public function getFilteredData($fields, $data)
    {
        $finalData = [];

        $relationNtoNfields = $this->gCrud->getRelationNtoN();
        $fieldTypes = $this->getFieldTypes();

        foreach ($fields as $field) {
            if (array_key_exists($field->name, $data)) {
                if (!isset($relationNtoNfields[$field->name])) {
                    $finalData[$field->name] = $this->filterValue($fieldTypes, $field->name, $data[$field->name]);
                }
            }
        }

        return $finalData;
    }

    public function filterValue($fieldTypes, $fieldName, $fieldValue) {
        if( isset($fieldTypes[$fieldName]) &&
            $fieldTypes[$fieldName]->isNullable === true &&
            $fieldValue === ''
        ) {
            return null;
        }

        return $fieldValue;
    }

    public function getRelationNtoNData($fields, $data)
    {
        $relationNtoNData = [];

        $relationNtoNfields = $this->gCrud->getRelationNtoN();

        foreach ($fields as $field) {
            if (array_key_exists($field->name, $data)) {
                if (isset($relationNtoNfields[$field->name])) {
                    $relationNtoNData[$field->name] = $data[$field->name];
                }
            }
        }

        return $relationNtoNData;
    }

    public function transformFieldsList($simpleList, $unsetFields) {
        $transformedList = [];
        $displayAs = $this->gCrud->getDisplayAs();

        if (empty($simpleList)) {
            $simpleList = $this->removePrimaryKeyFromList($this->getColumnNames());
        }

        if (!empty($unsetFields)) {
            foreach ($unsetFields as $unsetFieldName) {
                $simpleList = ArrayHelper::array_reject($simpleList, function ($value) use ($unsetFieldName) {
                    return $unsetFieldName === $value;
                });
            }
        }

        foreach ($simpleList as $fieldName) {
            $transformedList[] = (object)array(
                'name' => $fieldName,
                'displayAs' => !empty($displayAs[$fieldName]) ? $displayAs[$fieldName] : ucfirst(str_replace('_',' ', $fieldName))
            );
        }

        return $transformedList;
    }

    public function isInCache($itemAsString) {
        return $this->gCrud->getCache()->getItem($itemAsString) !== null;
    }

    public function getCacheItem($itemAsString) {
        return $this->gCrud->getCache()->getItem($itemAsString);
    }

    public function getUniqueId() {
        return $this->gCrud->getLayout()->getUniqueId();
    }

    public function getValidationRules()
    {
        $validator = $this->gCrud->getValidator();
        $validationRules = $this->gCrud->getValidationRules();
        foreach ($validationRules as $rule) {
            $validator->set_rule($rule['fieldName'], $rule['rule'], $rule['parameters']);
        }

        $displayAs = $this->gCrud->getDisplayAs();
        $uniqueFields = $this->gCrud->getUniqueFields();

        if (!empty($uniqueFields)) {
            $this->gCrud->getModel()->setPrimaryKey($this->getPrimaryKeyName());
            $uniqueCallback = function ($field, $value) {
                $stateParameters = $this->getStateParameters();
                $primaryKeyValue = !empty($stateParameters->primaryKeyValue) ? $stateParameters->primaryKeyValue : null;
                return $this->gCrud->getModel()->isUnique($field, $value, $primaryKeyValue);
            };
            $uniqueCallback = \Closure::bind($uniqueCallback, $this);
            $validator->setUniqueCallback($uniqueCallback);
        }

        foreach ($displayAs as $fieldName => $display) {
            $validator->set_label($fieldName, $display);
        }

        $requiredFields = $this->gCrud->getRequiredFields();
        foreach ($requiredFields as $fieldName) {
            $validator->set_rule($fieldName, 'required');
        }

        foreach ($uniqueFields as $fieldName) {
            $validator->set_rule($fieldName, 'unique');
        }

        $validator->set_data($this->getStateParameters()->data);

        return $validator;
    }
}