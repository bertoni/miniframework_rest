<?php
/**
 * File of application standard configuration
 *
 * PHP Version 5.3
 *
 * @category Configuration
 * @package  Config
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */

/**
 * Define the environment
 */
if (!isset($_SERVER['SERVER_ADDR'])
    || $_SERVER['SERVER_ADDR'] == '127.0.0.1'
    || $_SERVER['SERVER_ADDR'] == '127.0.1.1'
) {
    define('DEV', true);
} else {
    define('DEV', false);
}

/**
 * Set if the PHP should show erros
 */
if (DEV) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
} else {
    error_reporting(null);
    ini_set('display_errors', 'Off');
}

/**
 * Define the PHP charset
 */
ini_set('default_charset', 'UTF-8');

/**
 * Define the default zone
 */
date_default_timezone_set("America/Sao_Paulo");
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");

require 'constant.inc.php';

/**
 * Begin the session
 */
session_set_cookie_params(0);
session_name(
    sha1(
        SALT
        . (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '')
        . SALT
        . (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '')
        . SALT
    )
);
session_start();

require_once 'autoload.inc.php';
require_once 'library.inc.php';
require_once 'collection.inc.php';
require_once 'route.inc.php';

/**
 * Gravo a conexão com o banco de dados da aplicação
 */
$REGISTRY = \helper\Registry::getInstance();
if (!$REGISTRY->exists('dbmysql')) {
    $options = array(
        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        \PDO::ATTR_PERSISTENT         => true,
        \PDO::ATTR_CASE               => \PDO::CASE_LOWER
    );
    $REGISTRY->register(
        'dbmysql',
        new \helper\ConnectionDB(DB_CONN, DB_USER, DB_PASS, $options)
    );
    unset($options);
}