<?php

namespace GroceryCrud\Core\Model;

use GroceryCrud\Core\Model;
use Zend\Db\Sql\Where;

class DynamicModel extends Model
{
    /**
     * @var string|array|null
     */
    protected $_where;

    /**
     * @param string|array $where
     * @return $this
     */
    public function setWhere($where)
    {
        $this->_where = $where;

        return $this;
    }

    /**
     * @param string $orderBy
     * @param string $sotringBy
     * @return $this
     */
    public function setDefaultOrderBy($orderBy, $sotringBy = 'asc')
    {
        $this->setOrderBy($orderBy);
        $this->setSorting($sotringBy);

        return $this;
    }

    /**
     * @param \Zend\Db\Sql\Select $select
     * @return \Zend\Db\Sql\Select
     */
    public function extraWhereStatements($select)
    {
        if ($this->_where !== null) {
            if (is_array($this->_where)) {
                $where = new Where();

                foreach ($this->_where as $columnName => $columnValue) {
                    $where->literal($columnName . ' = ?', $columnValue);
                }

                $select->where($where);
            } else {
                $select->where($this->_where);
            }
        }

        return $select;
    }
}