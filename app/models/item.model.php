<?php
namespace XWork\Models;

use XWork\Model as Model;

/**
 * Description of fecha
 *
 * @author mrojas
 */
class ItemModel extends Model {
          
          public function getAllCities() {
                    $this->_database->_autocommit(false);
                    $this->_database->_selectDB();
                    $this->_database->_query('SELECT * FROM  `city`');
                    $this->_database->_commit();
                    return $this->_database->_fetchObject();
          }
          
}
