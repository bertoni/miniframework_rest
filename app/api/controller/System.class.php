<?php
/**
 * File that brings the controller of the API system
 * 
 * PHP Version 5.3
 *
 * @category Controller
 * @package  Api\controller
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
namespace api\controller;
/**
 * Controller of the API system
 *
 * @category Controller
 * @package  Api\controller
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
abstract class System implements \standard\IController
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
        array $parameters = null
    ) {
        $action = '_' . $action;
        if (method_exists(__CLASS__, $action)) {
            self::$action($RequestHTTP, $parameters);
        } else {
            throw new \Exception(
                'Not exists the ' . $action
                . ' action in the ' . __CLASS__ . ' class'
            );
        }
    }

    /**
     * Shows the API utilization guide
     *
     * @param RequestHTTP $RequestHTTP {RequestHTTP of the request}
     * @param array       $parameters  {Request parameters}
     *
     * @return string
     * @access private
     */
    private static function _userGuide(
        \helper\RequestHTTP $RequestHTTP,
        array $parameters = null
    ) {
        // Checks the methods supported
        if (!$RequestHTTP->isGet()) {
            http_response_code(405);
            header('Allow: GET');
            exit;
            
        }
        http_response_code(200);
        
        // Defines the response type
        $accept            = '*';
        $Registry          = \helper\Registry::getInstance();
        $supported_formats = $Registry->get('supported_formats');
        foreach ($RequestHTTP->accept as $acc) {
            if (isset($supported_formats[$acc])) {
                $accept = $supported_formats[$acc];
                break;
            }
        }
        
        // Generates the response content
        $doc   = array();
        $doc['/user']['GET'] = array(
            'needs'         => 'Header access_token',
            'views'         => array('json', 'xml'),
            'functionality' => 'lista os usuários'
        );
        
        // Show the response
        $View = \standard\View::getViewer($accept);
        $View->show($doc);
    }
}