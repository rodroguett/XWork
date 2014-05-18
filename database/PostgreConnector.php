<?php

namespace XWork\Database;

if (!defined('XWORK'))
          exit('ERROR: No se puede lanzar Directamente');

use \mysqli as mysqli;
use \XWork\Excepciones\DatabaseException as DatabaseException;
use \XWork\Errors as Errors;
use \Exception as Exception;

/**
  @package Database
 * 
 * Motor de Conexion a Mysql a travez de Mysqli
 *
 * @category   database
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    1.3
 * 
 */
final class PostgreConnector extends DatabaseConfig implements database {

          /**
           * Variables for database interaction
           */
          private static $_singleInstance;
          private $_sqlLink;
          private $_sqlExec;
          private $_sqlArray        = array();
          private $_sqlAffectedRows = array();
          private $_sqlRows         = array();
          private $_lastID;

          /**
           * Create the single instance of class
           * 
           * @param none
           * @return Object self::$_singleInstance Instance
           */
          public static function _getInstance($host,$user,$pass,$name,$port) {
                    if (!self::$_singleInstance instanceof self) {
                              self::$_singleInstance = new self($host,$user,$pass,$name,$port);
                    }
                    return self::$_singleInstance;
          }

          /**
           * Constructor to create initial configuration of Oracle
           * 
           * @param none
           * @return none
           */
          private function __construct($host,$user,$pass,$name,$port){
                    $this->_initializeConfiguration($host,$user,$pass,$name,$port);
                    $this->_connect();
          }

          /**
           * Open a connection to Postgre server
           * 
           * @param none
           * @return Object $this
           */
          public function _connect() {
                    $this->_sqlLink = pg_connect('host = ' . $this->_sqlHost . ' port=' . $this->_sqlPort . '  dbname = ' . $this->_sqlDB . ' user = ' . $this->_sqlUser . ' password = ' . $this->_sqlPass);
                    return $this;
          }

          /**
           * Select a Oracle database.
           * 
           * @param none
           * @return Object $this 
           */
          public function _selectDB() {
                    // Nothing to do here
          }

          /**
           * Execute the SQL
           * 
           * @param String $_query
           * @return Object $this 
           */
          public function _query($_query) {
                    $this->_sqlExec = pg_execute($this->_sqlLink, $_query);
                    return $this;
          }

          /**
           * Starts a transaction
           * 
           * @param none
           * @return Object $this Current object
           */
          public function _begin() {
                    pg_execute($this->_sqlLink, "BEGIN");
                    return $this;
          }

          /**
           * Commit the changes
           * 
           * @param none
           * @return Object $this Current object
           */
          public function _commit() {
                    pg_execute($this->_sqlLink, "COMMIT");
                    return $this;
          }

          /**
           * Rollback the changes
           * 
           * @param none
           * @return Object $this Current object
           */
          public function _rollback() {
                    pg_execute($this->_sqlLink, "ROLLBACK");
                    return $this;
          }

          /**
           * Fetch a result row as an associative array
           * 
           * @param none
           * @return Object $this
           */
          public function _fetchAssoc() {
                    $_sqlStoreValues = array();
                    while ($this->_sqlRows  = pg_fetch_assoc($this->_sqlExec)) {
                              $_sqlStoreValues[] = $this->_sqlRows;
                    }
                    $this->_freeResult();
                    return $_sqlStoreValues;
          }

          /**
           * Fetch a result row as an associative array and as an enumerated array
           * 
           * @param none
           * @return Array $this->_sqlStoreValues
           */
          public function _fetchArray() {
                    $_sqlStoreValues = array();
                    while ($this->_sqlRows  = pg_fetch_array($this->_sqlExec, OCI_BOTH)) {
                              $_sqlStoreValues[] = $this->_sqlRows;
                    }
                    $this->_freeResult();
                    return $_sqlStoreValues;
          }

          /**
           * Fetch a result row as an object
           * 
           * @param none
           * @return Array $this->_sqlStoreValues
           */
          public function _fetchObject() {
                    $_sqlStoreValues = array();
                    while ($this->_sqlRows  = pg_fetch_object($this->_sqlExec, OCI_BOTH)) {
                              $_sqlStoreValues[] = $this->_sqlRows;
                    }
                    $this->_freeResult();
                    return $_sqlStoreValues;
          }

          /**
           * Fetch number of affected rows in previous Oracle operation
           * 
           * @param none
           * @return Object $this
           */
          public function _affectedRows() {
                    return pg_affected_rows();
          }

          /**
           * Method to return the id of last affected row
           * 
           * @param none
           * @return Int $this->_lastID Last id
           */
          public function _lastID($_tableName = '', $_fieldName = '') {
                    $_pgSql = "SELECT $_fieldName FROM $_tableName ORDER BY $_fieldName DESC LIMIT 1";

                    $this->_executeSql($_pgSql);
                    return $this->_sqlRows[$_fieldName];
          }

          /**
           * Method to return id of last multiple insert statements executed
           *  
           * @param Int $_size Count of statements
           * @return array
           */
          public function _multipleID($_size, $_tableName = '', $_fieldName = '') {
                    $_lastID = $this->_lastID($_tableName, $_fieldName);

                    for ($i = $_lastID; $i < ($_lastID + $_size); $i++) {
                              $_lastIDs[] = $i;
                    }
                    return $_lastIDs;
          }

          /**
           * Method to free the results from memory
           * 
           * @param none
           * @return none
           */
          public function _freeResult() {
                    pg_free_result($this->_sqlExec);
          }

          /**
           * Method to stop the cloning of object
           * 
           * @param none
           * @return none
           */
          private function __clone() {
                    throw new Exception("Cloning is disabled.");
          }

          /**
           * Destroy Oracle connection
           * 
           * @param none
           * @return none
           */
          public function __destruct() {
                    pg_close($this->_sqlLink);
          }

          /**
           * Limpia Inyecciones SQL
           * 
           * @param none
           * @return none
           */
          public function _sanitize($var) {
                    return htmlentities($var);
          }

}
