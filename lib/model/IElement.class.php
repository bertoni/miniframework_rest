<?php
/**
 * File that brings the interface of elements
 *
 * PHP Version 5.3
 *
 * @category Interface
 * @package  Lib\model
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
namespace model;
/**
 * Interface of elements
 *
 * @category Interface
 * @package  Lib\model
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
interface IElement
{
    /**
     * Function that recover the value of a element
     *
     * @param string $attribute {Attribute owner of the value}
     *
     * @return string
     * @access public
     */
    public function getAttr($attribute);
    /**
     * Function that inserts a value in a element
     *
     * @param string $attribute {Attribute owner of the value}
     * @param string $value     {Value to be inserted}
     *
     * @return IElement
     * @access public
     */
    public function setAttr($attribute, $value);
    /**
     * Function that cleans the value of a element
     *
     * @param string $attribute {Attribute to be cleaned}
     *
     * @return IElement
     * @access public
     */
    public function cleanAttr($attribute);
    /**
     * Function that checks if a object exists
     *
     * @return booleam
     * @access public
     */
    public function exists();
    /**
     * Function that saves the object data
     *
     * @return booleam
     * @access public
     */
    public function save();
}