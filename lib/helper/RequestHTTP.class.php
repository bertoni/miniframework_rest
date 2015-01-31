<?php
/**
 * File that brings the class of HTTP request
 *
 * PHP Version 5.3
 *
 * @category Class
 * @package  Helper
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
namespace helper;
/**
 * Class of HTTP request
 *
 * @category Class
 * @package  Helper
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
class RequestHTTP
{
    /**
     * Variables received by GET
     * 
     * @var    array
     * @access public
     */
    public $get = array();
    /**
     * Variables received by POST
     * 
     * @var    array
     * @access public
     */
    public $post = array();
    /**
     * Variables received by PUT
     * 
     * @var    array
     * @access public
     */
    public $put = array();
    /**
     * Variables received by DELETE
     * 
     * @var    array
     * @access public
     */
    public $delete = array();
    /**
     * Variables received by HEADER
     * 
     * @var    array
     * @access public
     */
    public $header = array();
    /**
     * Data type accept in the response
     * 
     * @var    array
     * @access public
     */
    public $accept = array();
    /**
     * RequestHTTP's instance
     * 
     * @var    RequestHTTP
     * @access private
     */
    private static $_instance;

    /**
     * Recover the RequestHTTP instance single
     *
     * @return RequestHTTP
     * @access public
     */
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new RequestHTTP();
        }
        return self::$_instance;
    }

    /**
     * Return if the request method was by GET
     *
     * @return boolean
     * @access public
     */
    public function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    /**
     * Return if the request method was by POST
     *
     * @return boolean
     * @access public
     */
    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    /**
     * Return if the request method was by PUT
     *
     * @return boolean
     * @access public
     */
    public function isPut()
    {
        return $_SERVER['REQUEST_METHOD'] == 'PUT';
    }

    /**
     * Return if the request method was by DELETE
     *
     * @return boolean
     * @access public
     */
    public function isDelete()
    {
        return $_SERVER['REQUEST_METHOD'] == 'DELETE';
    }

    /**
     * Function that construct the RequestHTTP object
     *
     * @return void
     * @access private
     */
    private function __construct()
    {
        $this->_parseGet();
        $this->_parsePost();
        $this->_parsePutDelete();
        $this->_parseHeader();
    }

    /**
     * Function that recover the request by GET
     *
     * @return void
     * @access private
     */
    private function _parseGet()
    {
        $this->get = $_GET;
    }

    /**
     * Function that recover the request by POST
     *
     * @return void
     * @access private
     */
    private function _parsePost()
    {
        $this->post = $_POST;
    }

    /**
     * Function that recover the request by PUT/DELETE
     *
     * @return void
     * @access private
     */
    private function _parsePutDelete()
    {
        if ($this->isPut() || $this->isDelete()) {
            $var = array();
            parse_str(file_get_contents('php://input'), $var);
            if (count($var)) {
                $this->{($this->isPut() ? 'put' : 'delete')} = $var;
            }
        }
    }

    /**
     * Function that recover the request by HEADER
     *
     * @return void
     * @access private
     */
    private function _parseHeader()
    {
        $this->header = $_SERVER;
        $arh          = apache_request_headers();
        if (is_array($arh) && count($arh)) {
            foreach ($arh as $k=>$v) {
                $this->header[strtoupper($k)] = $v;
            }
        }
        $accept = explode(',', $this->header['HTTP_ACCEPT']);
        foreach ($accept as $v) {
            $v = explode(';', $v);
            $v = array_shift($v);
            $v = explode('/', $v);
            $this->accept[] = $v[1];
        }
    }

    /**
     * Function that prevents the cloning of the class by magic method
     *
     * @return void
     * @access private
     */
    private function __clone()
    {
    }

}