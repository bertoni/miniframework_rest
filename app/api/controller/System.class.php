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
     * @param string $action     {Action to be executed}
     * @param array  $parameters {Request parameters}
     *
     * @return string
     * @access public
     */
    public static function request($action, array $parameters = null)
    {
        $action = '_' . $action;
        if (method_exists(__CLASS__, $action)) {
            // Defines the response type
            $accept            = '*';
            $RequestHTTP       = \helper\RequestHTTP::getInstance();
            $Registry          = \helper\Registry::getInstance();
            $supported_formats = $Registry->get('supported_formats');
            foreach ($RequestHTTP->accept as $acc) {
                if (isset($supported_formats[$acc])) {
                    $accept = $supported_formats[$acc];
                    break;
                }
            }
            $View = \standard\View::getViewer($accept);
            self::$action($View, $parameters);
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
     * @param View  $View       {View should be used in the request}
     * @param array $parameters {Request parameters}
     *
     * @return string
     * @access private
     */
    private static function _userGuide(
        \standard\View $View,
        array $parameters = null
    ) {
        http_response_code(200);
        
        // Generates the response content
        $doc   = array();
        $doc['/']['GET'] = array(
            'needs'         => 'nothing',
            'profile'       => 'all',
            'views'         => array('json', 'xml'),
            'functionality' => 'Exibe o guia do usuário da API'
        );
        $doc['/profile']['GET'] = array(
            'needs'         => 'nothing',
            'profile'       => 'all',
            'views'         => array('json', 'xml'),
            'functionality' => 'Listagem dos perfis do sistema'
        );
        
        // Show the response
        $View->show($doc);
    }
}