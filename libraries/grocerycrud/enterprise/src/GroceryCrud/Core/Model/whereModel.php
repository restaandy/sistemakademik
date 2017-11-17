<?php 
namespace GroceryCrud\Core\Model;
use GroceryCrud\Core\Model;

class whereModel extends Model {
    
    public function __construct($databaseConfig,$query = "1 = 1"){
        $this->where_query = $query;
        $this->setDatabaseConnection($databaseConfig);
    }
    
    public function extraWhereStatements($select)
    {
        $select->where($this->where_query);
        return $select;
    }
    
}