<?php
/**
 * File that brings the registries class
 *
 * PHP Version 5.3
 *
 * @category Class
 * @package  Lib\helper
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
namespace helper;
/**
 * Registries class
 *
 * @category Class
 * @package  Lib\helper
 * @author   Arnaldo Bertoni Jr <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://br.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213/
 */
class Registry
{
    /**
     * Register's instance
     * 
     * @var    Registry
     * @access private
     */
    private static $_instance;
    /**
     * Stored data
     * 
     * @var    ArrayObject
     * @access private
     */
    private $_storage;
    
    /**
     * Function that constructs the class
     *
     * @return void
     * @access private
     */
    private function __construct()
    {
        $this->_storage = new \ArrayObject();
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
    
    /**
     * Recover the registry instance single
     *
     * @return Registry
     * @access public
     */
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new Registry();
        }
        return self::$_instance;
    }
    
    /**
     * Function that adds data
     *
     * @param string $key   {Name to be stored}
     * @param string $value {Object or value to be stored}
     *
     * @return Registry
     * @access public
     */
    public function register($key , $value)
    {
        if (!$this->_storage->offsetExists($key)) {
            $this->_storage->offsetSet($key, $value);
            return $this;
        }
        throw new LogicException(
            sprintf('There is already a record for the key "%s".', $key)
        );
    }
    
    /**
     * Função que busca dados
     * Function that searchs data
     *
     * @param string $key {Name to be sought}
     *
     * @return string
     * @access public
     */
    public function get($key)
    {
        if ($this->_storage->offsetExists($key)) {
            return $this->_storage->offsetGet($key);
        }
        throw new RuntimeException(
            sprintf('There is no a record for the key "%s".', $key)
        );
    }
    
    /**
     * Function that checks if exists a valid key
     *
     * @param string $key {Name to be sought}
     *
     * @return boolean
     * @access public
     */
    public function exists($key)
    {
        return $this->_storage->offsetExists($key);
    }
    
    /**
     * Function that remove values with determined name
     *
     * @param string $key {Name to be sought}
     *
     * @return Registry
     * @access public
     */
    public function unregister($key)
    {
        if ($this->_storage->offsetExists($key)) {
            $this->_storage->offsetUnset($key);
            return $this;
        }
        throw new RuntimeException(
            sprintf('There is no a record for the key "%s".', $key)
        );
    }
}