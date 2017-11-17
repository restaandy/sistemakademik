<?php 
namespace GroceryCrud\Core\Model;
use GroceryCrud\Core\Model;

class bytahunModel extends Model {
    
    public function __construct($databaseConfig,$parameters = array()){
        $this->parameter = $parameters;
        $this->setDatabaseConnection($databaseConfig);
    }
    
    public function extraWhereStatements($select)
    {
        $select->where("temuan_tahun = ".$this->parameter['tahun']);
        return $select;
    }
    
}