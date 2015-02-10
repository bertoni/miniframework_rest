<?php
/**
 * File that brings the interface of repositories
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
 * Interface of repositories
 *
 * @category Interface
 * @package  Lib\model
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
interface IRepository
{
    /**
     * Function that adds the state of a element
     *
     * @param IElement $Element {Object to be saved}
     *
     * @return boolean
     * @access public
     */
    public function add(\model\IElement $Element);
    /**
     * Function that changes the state of a element
     *
     * @param IElement $Element {Object to be changed}
     *
     * @return boolean
     * @access public
     */
    public function change(\model\IElement $Element);
    /**
     * Function that lists elements
     *
     * @param array $options {Array of options}
     *
     * @return ArrayObject[IElement]
     * @access public
     */
    public function getAll(array $options = null);
    /**
     * Function that returns one object by a identification
     *
     * @param string $id {Object Identification}
     *
     * @return array
     * @access public
     */
    public function getById($id);
    /**
     * Function that removes a element
     *
     * @param IElement $Element {Object to be removed}
     *
     * @return boolean
     * @access public
     */
    public function remove(\model\IElement $Element);
}