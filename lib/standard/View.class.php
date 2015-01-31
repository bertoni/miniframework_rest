<?php
/**
 * File that brings the standard view of the system
 *
 * PHP Version 5.3
 *
 * @category View
 * @package  Standard
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
namespace standard;
/**
 * Standard view of the system
 *
 * @category View
 * @package  Standard
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
abstract class View
{
    /**
     * Type vision XML
     * 
     * @var    string
     * @access public
     */
    CONST XML = 'xml';
    /**
     * Type vision HTML
     * 
     * @var    string
     * @access public
     */
    CONST HTML = 'html';
    /**
     * Type vision JSON
     * 
     * @var    string
     * @access public
     */
    CONST JSON = 'json';

    /**
     * Shows a content formated
     *
     * @param array  $content  {Content to be showed}
     * @param string $template {Template file to be used}
     *
     * @return void
     * @access public
     */
    public abstract function show(array $content, $template = null);

    /**
     * Return a specific view for a visualization type
     *
     * @param string $type {Visualization type used}
     *
     * @return View
     * @access public
     */
    public final static function getViewer($type)
    {
        switch ($type) {
        case self::HTML:
            return new \standard\ViewHtml();
            break;
        case self::XML:
            return new \standard\ViewXml();
            break;
        case self::JSON:
        default:
            return new \standard\ViewJson();
            break;
        }
    }
}