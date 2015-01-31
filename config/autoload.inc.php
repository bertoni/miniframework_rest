<?php
/**
 * File that brings the autoload of the application
 *
 * PHP Version 5.3
 *
 * @category Config
 * @package  Configuration
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */

/**
 * Autoload of the libraries
 *
 * @param string $classname {Name of the class to be include}
 *
 * @return void
 * @access public
 */
function autoloadLib($classname)
{
    $classname = PATH_LIB . '/'
    . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.class.php';
    if (stream_resolve_include_path($classname) !== false) {
        include $classname;
    }
}
spl_autoload_register('autoloadLib');

/**
 * Autoload of the applications
 *
 * @param string $classname {Name of the class to be include}
 *
 * @return void
 * @access public
 */
function autoloadApp($classname)
{
    $classname = PATH_APP . '/'
    . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.class.php';
    if (stream_resolve_include_path($classname) !== false) {
        include $classname;
    }
}
spl_autoload_register('autoloadApp');