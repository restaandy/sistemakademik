<?php
namespace GroceryCrud\Core;

use Zend\Db\Adapter\Profiler\ProfilerInterface;
use GroceryCrud\Core\Profiler\FileProfiler;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Predicate;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Metadata\Metadata;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\PredicateSet;
use GroceryCrud\Core\Model\ModelInterface;
use GroceryCrud\Core\Helpers\ArrayHelper;
use GroceryCrud\Core\Model\ModelFieldType;

use Zend\Db\Sql\Where;

class Model implements ModelInterface
{
    protected $tableName = '';
    protected $primaryKeys = [];

    /**
     * @var Adapter
     */
    protected $adapter;

    protected $orderBy;
    protected $sorting;
    protected $_profiler;
    protected $limit = 10;
    protected $page  = 1;
    protected $_filters;
    protected $_filters_or;
    protected $_relation_1_n = [];
    protected $_relation_n_n = [];
    protected $_columns = [];
    protected $_relation_n_n_columns = [];
    protected $_fieldTypes = [];
    protected $_columnNames = [];

    /**
     * @var string|array|null
     */
    protected $_where;

    function __construct($databaseConfig) {
        $this->setDatabaseConnection($databaseConfig);
    }

    /**
     * @param string|array $where
     * @return $this
     */
    public function setWhere($where)
    {
        $this->_where = $where;

        return $this;
    }

    public function setDefaultProfiler()
    {
        $this->setProfiler(new FileProfiler());

        return $this;
    }

    public function setProfiler(ProfilerInterface $profiler)
    {
        $this->_profiler = $profiler;
        $this->adapter->setProfiler($this->_profiler);

        return $this;
    }

    public function getProfiler()
    {
        return $this->_profiler;
    }


    public function setDatabaseConnection($databaseConfig) {
        $this->adapter = new Adapter($databaseConfig['adapter']);
    }

    public function getDatabaseName() {
        return $this->adapter->getDriver()->getConnection()->getCurrentSchema();
    }

    public function getDriverName() {
        return $this->adapter->getDriver()->getDatabasePlatformName();
    }

    public function getDbUniqueId() {
        $dbName = $this->getDatabaseName();
        $dbDriver = $this->getDriverName();

        return $dbDriver . '+' . $dbName;
    }

    public function setTableName($tableName) {
        $this->tableName = $tableName;

        return $this;
    }

    public function setAndFilters($filters) {
        $this->_filters = $filters;
    }

    public function setOrFilters($filters) {
        $this->_filters_or = $filters;
    }

    /**
     * @param string $orderBy
     * @param string $sortingBy
     * @return $this
     */
    public function setDefaultOrderBy($orderBy, $sortingBy = 'asc')
    {
        $this->setOrderBy($orderBy);
        $this->setSorting($sortingBy);

        return $this;
    }

    public function setOrderBy($orderBy) {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function setSorting($sorting) {
        $this->sorting = $sorting;
        return $this;
    }

    /**
     * @param integer $limit
     * @return $this
     */
    public function setLimit($limit) {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param integer $page
     * @return $this
     */
    public function setPage($page) {
        $this->page = $page;
        return $this;
    }

    public function getColumnNames ($tableName = null) {
        if ($tableName === null) {
            $tableName = $this->tableName;
        }

        if (isset($this->_columnNames[$tableName])) {
            return $this->_columnNames[$tableName];
        }

        $fieldTypes = $this->getFieldTypes($tableName);

        $columnNames = [];
        foreach ($fieldTypes as $fieldName => $fieldType) {
            $columnNames[] = $fieldName;
        }

        $this->_columnNames[$tableName] = $columnNames;

        return $columnNames;
    }

    public function getRelationData($tableName, $titleField, $where = null, $orderBy = null) {
        $primaryKeyField = $this->getPrimaryKeyField($tableName);

        $titleFieldIsArray = is_array($titleField);

        $sql = new Sql($this->adapter);
        $select = $sql->select();

        if ($orderBy !== null) {
            $select->order($orderBy);
        } else {
            if ($titleFieldIsArray) {
                $select->order($titleField[0]);
            } else {
                $select->order($titleField);
            }
        }
        $select->from($tableName);

        if ($where !== null) {
            $select->where($where);
        }

        $select = $this->extraJoinRelationalData($tableName, $select);
        $select = $this->extraWhereRelationalData($tableName, $select);

        $selectString = $sql->buildSqlString($select);
        $result = $this->adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);

        $resultSet = new ResultSet;
        $resultSet->initialize($result);

        $relationData = [];
        foreach ($resultSet as $row) {
            if ($titleFieldIsArray) {
                $title = [];
                foreach ($titleField as $subtitle) {
                    $title[$subtitle] = $row[$subtitle];
                }
            } else {
                $title = $row[$titleField];
            }

            $relationData[] = (object)array(
                'id' => $row[$primaryKeyField],
                'title' => $title
            );
        }

        return $relationData;
    }

    public function getPrimaryKeyField ($tableName = null) {
        if ($tableName === null) {
            $tableName = $this->tableName;
        }

        // Is it already setted?
        if (!empty($this->primaryKeys[$tableName])) {
            return $this->primaryKeys[$tableName];
        }

        return $this->_getPrimaryKey($tableName);
    }

    public function setPrimaryKey($primaryKey, $tableName = null)
    {
       if ($tableName === null) {
            $tableName = $this->tableName;
       }

        $this->primaryKeys[$tableName] = $primaryKey;

        return $this;
    }

    private function _getPrimaryKey($tableName) {
        $driverName = $this->adapter->getDriver()->getDatabasePlatformName();

        // There is a much faster way for Mysql to retreive the primary key
        if ($driverName === 'Mysql') {
            $statement = $this->adapter->createStatement('SHOW KEYS FROM `' . $tableName . '` WHERE Key_name = \'PRIMARY\'');

            $result = $statement->execute();

            $primaryKeyData = $result->current();

            $this->primaryKeys[$tableName] = $primaryKeyData['Column_name'];

            return $this->primaryKeys[$tableName];
        }

        $tableGateway = new Metadata($this->adapter);

        $constraints = $tableGateway->getTable($tableName)->getConstraints();

        foreach ($constraints AS $constraint) {
            if ($constraint->isPrimaryKey()) {
                $this->primaryKeys[$tableName] = $constraint->getColumns()[0];
                return $this->primaryKeys[$tableName];
            }
        }

        return null;
    }

    /**
     * @param Select $select
     * @return Select
     */
    public function filtering(Select $select, $filterType = PredicateSet::OP_AND)
    {
        $where = new Where();
        $whereArray = [];

        $filters = $filterType === PredicateSet::OP_AND ? $this->_filters : $this->_filters_or;

        foreach ($filters as $filter_name => $filter_value) {

            if ($this->isFieldWithRelationNtoN($filter_name)) {
                // If the filter is relationNtoN we will filter than within a second query later
                continue;
            } else {
                $filter_name =  '`' . $this->tableName. '`.`' . $filter_name . '`';
            }

            if (preg_match('/^<=/', $filter_value)) {
                $whereArray[] = [$filter_name . ' <= ?', preg_replace('/^<=/', '', $filter_value)];
            } else if (preg_match('/^</', $filter_value)) {
                $whereArray[] = [$filter_name . ' < ?', preg_replace('/^</', '', $filter_value)];
            } else if (preg_match('/^>=/', $filter_value)) {
                $whereArray[] = [$filter_name . ' >= ?', preg_replace('/^>=/', '', $filter_value)];
            } else if (preg_match('/^>/', $filter_value)) {
                $whereArray[] = [$filter_name . ' > ?', preg_replace('/^>/', '', $filter_value)];
            } else if (preg_match('/^=/', $filter_value)) {
                $whereArray[] = [$filter_name . ' = ?', preg_replace('/^=/', '', $filter_value)];
            } else {
                $whereArray[] = [$filter_name . ' LIKE ?', '%' . $filter_value . '%'];
            }
        }

        if ($filterType === PredicateSet::OP_AND) {
            foreach ($whereArray as $whereQuery) {
                $where->literal($whereQuery[0], $whereQuery[1]);
            }

            $select->where($where);
        } else {
            $predictateSetArray = [];

            foreach ($whereArray as $whereQuery) {
                $predictateSetArray[] = new Predicate\Expression($whereQuery[0], $whereQuery[1]);
            }

            $select->where(new Predicate\PredicateSet($predictateSetArray, $filterType));
        }


        return $select;
    }

    public function insert($data, $tableName = null) {

        if ($tableName === null) {
            $tableName = $this->tableName;
        }

        $sql = new Sql($this->adapter);
        $insert = $sql->insert($tableName);
        $insert->values($data);

        $statement = $sql->prepareStatementForSqlObject($insert);
        return $statement->execute();
    }

    public function update($primaryKeyValue, $data) {
        if (empty($primaryKeyValue)) {
            throw new \Exception("The primaryKeyValue can't be empty or 0");
        }

        $primaryKeyField = $this->getPrimaryKeyField();

        // First a validation check that we can
        $sql = new Sql($this->adapter);
        $select = $sql->select()
            ->columns([$primaryKeyField])
            ->from($this->tableName);

        $select = $this->joinStatements($select);

        $select->where([
            $primaryKeyField . ' = ?' => $primaryKeyValue
        ]);
        if ($this->_where !== null) {
            $select->where($this->_where);
        }

        $row = $this->getRowFromSelect($select, $sql);

        if ($row === null) {
            return false;
        }

        $sql = new Sql($this->adapter);
        $update = $sql->update($this->tableName);
        $update->where([
            $primaryKeyField . ' = ?' => $primaryKeyValue
        ]);

        $update->set($data);

        $statement = $sql->prepareStatementForSqlObject($update);
        return $statement->execute();
    }

    public function removeOne($id) {
        if (empty($id)) {
            throw new \Exception("The remove id can't be empty or 0");
        }

        $sql = new Sql($this->adapter);
        $remove = $sql->delete($this->tableName);
        $remove->where([
            $this->getPrimaryKeyField() . ' = ?' => $id
        ]);
        if ($this->_where !== null) {
            $remove->where($this->_where);
        }

        $statement = $sql->prepareStatementForSqlObject($remove);
        return $statement->execute();
    }

    public function removeMultiple($ids)
    {
        if (empty($ids)) {
            throw new \Exception("The remove ids can't be empty");
        }

        $sql = new Sql($this->adapter);
        $remove = $sql->delete($this->tableName);
        $where = new Where();
        $where->in($this->getPrimaryKeyField(), $ids);
        $remove->where($where);

        if ($this->_where !== null) {
            $remove->where($this->_where);
        }

        $statement = $sql->prepareStatementForSqlObject($remove);
        return $statement->execute();
    }

    public function getTotalItems()
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select()
            ->columns(array('num' => new Expression('COUNT(*)')))
            ->from($this->tableName);

        if (!empty($this->_filters)) {
            $select = $this->filtering($select, PredicateSet::OP_AND);
        }

        if (!empty($this->_filters_or)) {
            $select = $this->filtering($select, PredicateSet::OP_OR);
        }

        if (!empty($this->_filters) || !empty($this->_filters_or)) {
            $select = $this->joinStatements($select);
        }
        $select = $this->extraJoinStatements($select);

        $select = $this->whereStatements($select);
        $select = $this->extraWhereStatements($select);

        $selectString = $sql->buildSqlString($select);

        $result = $this->adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);

        $resultSet = new ResultSet;
        $resultSet->initialize($result);

        foreach ($resultSet as $row) {
            return (int)$row->num;
        }

        return 0;
    }

    public function validateOne($id) {
        $sql = new Sql($this->adapter);
        $select = $sql->select();

        $primaryKeyField = $this->getPrimaryKeyField();

        $select->columns([
            $primaryKeyField
        ]);
        $select->from($this->tableName);
        $select->where([
            $primaryKeyField => $id
        ]);

        if ($this->_where !== null) {
            $select->where($this->_where);
        }

        $this->joinStatements($select);

        $selectString = $sql->buildSqlString($select);
        $result = $this->adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);

        $resultSet = new ResultSet;
        $resultSet->initialize($result);

        return ($resultSet->count() === 1);
    }

    public function validateMultiple($ids) {
        $sql = new Sql($this->adapter);
        $select = $sql->select();

        $select->from($this->tableName);

        $primaryKeyField = $this->getPrimaryKeyField();
        $where = new Where();
        $where->in($primaryKeyField, $ids);
        $select->where($where);

        if ($this->_where !== null) {
            $select->where($this->_where);
        }

        $this->joinStatements($select);

        $selectString = $sql->buildSqlString($select);
        $result = $this->adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);

        $resultSet = new ResultSet;
        $resultSet->initialize($result);

        return ($resultSet->count() === count($ids));
    }

    public function getOne($id)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();

        //TODO: throw exception when there is no tableName
        $select->from($this->tableName);

        $primaryKeyField = $this->getPrimaryKeyField();

        $select->where([$primaryKeyField => $id]);

        if ($this->_where !== null) {
            $select->where($this->_where);
        }

        $selectString = $sql->buildSqlString($select);
        $result = $this->adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);

        $resultSet = new ResultSet;
        $resultSet->initialize($result);

        foreach ($resultSet as $row) {
            return $row;
        }

        return null;
    }

    public function getFieldTypes($tableName)
    {
        if (isset($this->_fieldTypes[$tableName])) {
            return $this->_fieldTypes[$tableName];
        }

        $driverName = $this->adapter->getDriver()->getDatabasePlatformName();

        // There is a much faster way for Mysql to retreive the field types
        if ($driverName === 'Mysql') {
            $statement = $this->adapter->createStatement('SHOW FIELDS FROM `' . $tableName . '`');

            $results = iterator_to_array($statement->execute());

            $fieldTypes = [];
            foreach ($results as $column) {

                $tmpColumn = new ModelFieldType();
                $tmpColumn->isNullable = $column['Null'] == 'YES';
                list($tmpColumn->dataType) = explode('(', $column['Type']);
                $tmpColumn->defaultValue = $column['Default'];
                $tmpColumn->permittedValues = null;

                if ($tmpColumn->dataType === 'enum') {

                    $tmpColumn->permittedValues = explode("','", str_replace(['enum(\'', '\')'], '', $column['Type']));
                }

                $fieldTypes[$column['Field']] = $tmpColumn;
            }

            $this->_fieldTypes[$tableName] = $fieldTypes;

            return $fieldTypes;
        }

        $tableGateway = new Metadata($this->adapter);

        $columns = $tableGateway->getTable($this->tableName)->getColumns();

        $fieldTypes = [];
        foreach ($columns as $column) {
            $tmpColumn = new ModelFieldType();
            $tmpColumn->isNullable = $column->getIsNullable();
            $tmpColumn->dataType = $column->getDataType();
            $tmpColumn->defaultValue = $column->getColumnDefault();
            $tmpColumn->permittedValues = $column->getErrata('permitted_values');
            $fieldTypes[$column->getName()] = $tmpColumn;
        }

        $this->_fieldTypes[$tableName] = $fieldTypes;

        return $fieldTypes;
    }

    public function setRelations1ToN($dbRelations)
    {
        $this->_relation_1_n = $dbRelations;
    }

    public function setRelationNToN($dbRelations)
    {
        $this->_relation_n_n = $dbRelations;
    }

    public function isFieldWithRelation($fieldName)
    {
        foreach ($this->_relation_1_n as $relation) {
            if ($relation->fieldName === $fieldName) {
                return true;
            }
        }

        return false;
    }

    public function isFieldWithRelationNtoN($fieldName)
    {
        foreach ($this->_relation_n_n_columns as $column) {
            if ($column === $fieldName) {
                return true;
            }
        }

        return false;
    }

    public function defaultOrdering($select)
    {
        return $select;
    }

    public function setRelationalColumns($columns)
    {
        $this->_relation_n_n_columns = $columns;
    }

    /**
     * @param \Zend\Db\Sql\Select $select
     * @return mixed
     */
    public function joinStatements($select)
    {
        foreach ($this->_relation_1_n as $relation) {
            // For optimizing reasons we are joining the tables ONLY for two scenarios:
            // 1. When we have an order by the field
            // 2. The relation has a where statement
            if ($this->orderBy === $relation->fieldName || $relation->where !== null) {
                $select->join(
                    $relation->tableName,
                    $this->tableName . '.' . $relation->fieldName . ' = ' . $relation->tableName . '.' . $relation->relationPrimaryKey,
                    [],
                    Select::JOIN_LEFT
                );

                if ($relation->where !== null) {
                    $select->where($relation->where);
                }
            }
        }

        return $select;
    }

    /**
     * @param \Zend\Db\Sql\Select $select
     * @return \Zend\Db\Sql\Select
     */
    public function extraJoinStatements($select)
    {
        return $select;
    }

    /**
     * @param \Zend\Db\Sql\Select $select
     * @return \Zend\Db\Sql\Select
     */
    public function extraWhereStatements($select)
    {
        return $select;
    }

    /**
     * @param string $tableName
     * @param \Zend\Db\Sql\Select $select
     * @return \Zend\Db\Sql\Select
     */
    protected function extraJoinRelationalData($tableName, $select) {
        return $select;
    }

    /**
     * @param string $tableName
     * @param \Zend\Db\Sql\Select $select
     * @return \Zend\Db\Sql\Select
     */
    protected function extraWhereRelationalData($tableName, $select) {
        return $select;
    }

    /**
     * @param \Zend\Db\Sql\Select $select
     * @return \Zend\Db\Sql\Select
     */
    public function whereStatements($select)
    {
        if ($this->_filters) {
            foreach ($this->_filters as $filterName => $filter) {
                if ($this->isFieldWithRelationNtoN($filterName)) {
                    $rel = $this->_relation_n_n[$filterName];
                    $select->join($rel->junctionTable,
                        $rel->junctionTable . '.' . $rel->primaryKeyJunctionToCurrent . '=' .
                        $this->tableName . '.' . $this->getPrimaryKeyField($this->tableName). ''
                    );
                    $select->where([$rel->junctionTable . '.' . $rel->primaryKeyToReferrerTable => $filter]);
                }
            }
        }

        if ($this->_where !== null) {
            $select->where($this->_where);
        }

        return $select;
    }

    public function setColumns($columns) {
        $this->_columns = $columns;
    }

    public function getRowFromSelect($select, $sql) {
        $selectString = $sql->buildSqlString($select);

        $result = $this->adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);

        $resultSet = new ResultSet;
        $resultSet->initialize($result);

        if ($resultSet->count() === 0) {
            return null;
        }

        $row = $resultSet->current();

        return $row;
    }

    /**
     * @param \Zend\Db\Sql\Select $select
     * @param $sql
     * @return array
     */
    public function getResultsFromSelect($select, $sql) {
        $selectString = $sql->buildSqlString($select);

        $result = $this->adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);

        $resultSet = new ResultSet;
        $resultSet->initialize($result);



        $resultsArray = array();
        foreach ($resultSet as $row) {
            $resultsArray[]  = $row;
        }

        return $resultsArray;
    }

    public function isUnique($fieldName, $fieldValue, $primaryKeyValue)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();

        $select->columns(array('num' => new Expression('COUNT(*)')));

        if ($primaryKeyValue !== null) {
            $primaryKeyName = $this->getPrimaryKeyField();
            $where = new Where();
            $where->literal($fieldName . ' = ?', $fieldValue);
            $where->literal($primaryKeyName . ' != ?', $primaryKeyValue);
            $select->where($where);
        } else {
            $select->where([$fieldName => $fieldValue]);
        }

        $select->from($this->tableName);

        $row = $this->getRowFromSelect($select, $sql);

        return ((int)$row['num'] === 0);
    }

    function insertRelationManytoMany($fieldInfo, $data , $primaryKey)
    {
        foreach($data as $dataPrimaryKey) {
            $this->insert(array(
                $fieldInfo->primaryKeyJunctionToCurrent => $primaryKey,
                $fieldInfo->primaryKeyToReferrerTable => $dataPrimaryKey,
            ), $fieldInfo->junctionTable);
        }

        return true;
    }

    function updateRelationManytoMany($fieldInfo, $data , $primaryKey)
    {
        $sql = new Sql($this->adapter);
        $remove = $sql->delete($fieldInfo->junctionTable);
        $whereDelete = new Where();

        $whereDelete->equalTo($fieldInfo->primaryKeyJunctionToCurrent, $primaryKey);

        if (!empty($data)) {
            $whereDelete->notIn($fieldInfo->primaryKeyToReferrerTable, $data);
        }
        $remove->where($whereDelete);

        $statement = $sql->prepareStatementForSqlObject($remove);

        $statement->execute();

        $dataToInsert = $data;

        $select = $sql->select();
        $select->columns([$fieldInfo->primaryKeyToReferrerTable]);

        $where = new Where();

        $where->equalTo($fieldInfo->primaryKeyJunctionToCurrent, $primaryKey);

        if (!empty($data)) {
            $where->in($fieldInfo->primaryKeyToReferrerTable, $data);
        }

        $select->where($where);
        $select->from($fieldInfo->junctionTable);

        $results = $this->getResultsFromSelect($select, $sql);

        foreach ($results as $field) {
            if (in_array($field->{$fieldInfo->primaryKeyToReferrerTable}, $data)) {
                $dataToInsert = ArrayHelper::array_reject_value($dataToInsert, $field->{$fieldInfo->primaryKeyToReferrerTable});
            }
        }

        foreach($dataToInsert as $dataPrimaryKey) {
            $this->insert(array(
                $fieldInfo->primaryKeyJunctionToCurrent => $primaryKey,
                $fieldInfo->primaryKeyToReferrerTable => $dataPrimaryKey,
            ), $fieldInfo->junctionTable);
        }

        return true;
    }

    public function getRelationNtoNData($fieldInfo, $primaryKeyValue)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->columns([$fieldInfo->primaryKeyToReferrerTable]);
        $select->where([
            $fieldInfo->primaryKeyJunctionToCurrent . ' = ?' => $primaryKeyValue
        ]);
        $select->from($fieldInfo->junctionTable);

        $results = $this->getResultsFromSelect($select, $sql);

        $relationIds = [];
        foreach ($results as $row) {
            $relationIds[] = $row->{$fieldInfo->primaryKeyToReferrerTable};
        }

        return $relationIds;
    }

    protected function _getOnlyPrimaryKeyValues($results) {
        $primaryKeyField = $this->getPrimaryKeyField();

        $primaryKeyValues = [];
        foreach ($results as $result) {
            $primaryKeyValues[] = $result->$primaryKeyField;
        }

        return $primaryKeyValues;
    }

    public function concatRelationalData($results, $primaryKeyValues)
    {
        if (empty($primaryKeyValues)) {
            // Nothing to concat! The results is empty
            return [];
        }

        $primaryKey = $this->getPrimaryKeyField();

        foreach ($this->_relation_n_n as $relation) {

            if (in_array($relation->fieldName, $this->_relation_n_n_columns)) {
                $sql = new Sql($this->adapter);
                $select = $sql->select();
                $select->columns([$relation->primaryKeyJunctionToCurrent, $relation->primaryKeyToReferrerTable]);
                $select->from($relation->junctionTable);

                $where = new Where();
                $where->in($relation->primaryKeyJunctionToCurrent, $primaryKeyValues);
                $select->where($where);

                $relationResults = $this->getResultsFromSelect($select, $sql);

                $groupByCurrentId = [];
                foreach ($relationResults as $row) {
                    if (!isset($groupByCurrentId[$row[$relation->primaryKeyJunctionToCurrent]])) {
                        $groupByCurrentId[$row[$relation->primaryKeyJunctionToCurrent]] = [
                            $row[$relation->primaryKeyToReferrerTable]
                        ];
                    } else {
                        $groupByCurrentId[$row[$relation->primaryKeyJunctionToCurrent]][]
                            = $row[$relation->primaryKeyToReferrerTable];
                    }
                }

                foreach ($results as &$result) {
                    $result[$relation->fieldName] = isset($groupByCurrentId[$result[$primaryKey]])
                        ? $groupByCurrentId[$result[$primaryKey]]
                        : '';
                }
            }
        }

        return $results;
    }

    public function getList()
	{
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->columns($this->_columns);
        $select->limit($this->limit);
        $select->offset(($this->limit * ($this->page - 1)));

        $select->from($this->tableName);

        $order_by = $this->orderBy;
        $sorting = $this->sorting;

        if ($order_by !== null) {
            $sortingString = ($sorting === null) ? '' : ' ' . $sorting;

            // For optimizing reasons we are joining the tables ONLY when we have an order by the field
            if ($this->isFieldWithRelation($order_by)) {
                $relationField = $this->_relation_1_n[$order_by];

                if ($relationField->orderBy !== null) {
                    $select->order($relationField->orderBy . $sortingString);
                } else if (is_array($relationField->titleField)) {
                    $orderingFields = [];
                    foreach ($relationField->titleField as $titleField) {
                        $orderingFields[] = $relationField->tableName . '.' . $titleField . $sortingString;
                    }
                    $select->order($orderingFields);
                } else {
                    $order_by = $relationField->tableName . '.' . $relationField->titleField;
                    $select->order($order_by . $sortingString);
                }
            } else {
                $select->order($order_by . $sortingString);
            }

        } else {
            $select = $this->defaultOrdering($select);
        }

        if (!empty($this->_filters)) {
            $select = $this->filtering($select, PredicateSet::OP_AND);
        }

        if (!empty($this->_filters_or)) {
            $select = $this->filtering($select, PredicateSet::OP_OR);
        }

        $select = $this->joinStatements($select);
        $select = $this->extraJoinStatements($select);

        $select = $this->whereStatements($select);
        $select = $this->extraWhereStatements($select);

        $results = $this->getResultsFromSelect($select, $sql);

        $resultsIds = $this->_getOnlyPrimaryKeyValues($results);

        $results = $this->concatRelationalData($results, $resultsIds);

        return $results;
	}
}
