<?php

if (!defined('XWORK'))
          exit('ERROR: No se puede lanzar Directamente');

/**
 * Controles especificos para las bases de datos
 * 
 * @category   configuraciones
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    0.8
 */

/**
 *        Define el nombre del esquema de la Base de Datos
 */define('DB_NAME', 'DEMO');

/**
 *        Define el nombre del usuario de la Base de Datos
 */
define('DB_USER', 'test');

/**
 *        Define la Contraseña del usuario de la Base de Datos
 */
define('DB_PASS', 'test');

/**
 *        Define el Host donde se encuentra la Base de Datos
 */
define('DB_HOST', '10.0.0.4');// '10.0.0.4');// 'localhost');//10.0.0.4');

/**
 *        Define el Driver a Utilizar como Conector Estandard
 *        Posee Varias Opciones:
 *              -   MySql: Conecta a una base de Datos MySQL
 *              -   MySqli: Conecta a una base de Datos MySQL mediante el motor MySQLi
 *              -   Oracle: Conecta a una base de Datos Oracle
 *              -   PgSQL: Conecta a una base de Datos Postgre
 *              -   Sqlite: Conecta a una base de  Datos sqlite
 *              -   Mssql: Conecta a una base de  Datos de Microsoft SQL.
 *        No sensible a mayusculas ni minusculas
 */
define('DB_DRVR', 'MYSQLI');

/**
 *        Define el Puerto donde se encuentra la Base de Datos
 */
define('DB_PORT', 3306);

/**
 *        Define un prefijo para las tablas, en el caso de que existiera
 */
define('DB_PRFX', 'base_');