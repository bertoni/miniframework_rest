<?php
/**
 * File that brings the standard interface of the controllers
 * 
 * PHP Version 5.3
 *
 * @category Interface
 * @package  Standard
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
namespace standard;
/**
 * Standard interface of the controllers
 *
 * @category Interface
 * @package  Standard
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
interface IController
{
    /**
     * Function that makes a request
     *
     * @param string      $action      {Action to be executed}
     * @param RequestHTTP $RequestHTTP {RequestHTTP of the request}
     * @param array       $parameters  {Request parameters}
     *
     * @return string
     * @access public
     */
    public static function request(
        $action,
        \helper\RequestHTTP $RequestHTTP,
        array $parameters
    );
}