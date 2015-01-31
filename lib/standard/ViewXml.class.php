<?php
/**
 * File that brings the XML view of the system
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
 * XML view of the system
 *
 * @category View
 * @package  Standard
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
class ViewXml extends \standard\View
{
    /**
     * Shows a content formated
     *
     * @param array  $content  {Content to be showed}
     * @param string $template {Template file to be used}
     *
     * @return void
     * @access public
     */
    public function show(array $content, $template = null)
    {
        header('Content-Type: application/xml;charset=UTF-8');
        $xml = new \SimpleXMLElement('<?xml version="1.0"?><root></root>');
        $this->_arrayToXml($content, $xml);
        echo $xml->asXML();
    }

    /**
     * Transforms a array in a recursive XML, keeping key and value
     *
     * @param array            $data_array {Array of the model to be followed}
     * @param SimpleXMLElement $xml        {XML object to be filled}
     *
     * @return void
     * @access private
     */
    private function _arrayToXml(array $data_array, \SimpleXMLElement &$xml)
    {
        foreach ($data_array as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xml->addChild("$key");
                } else {
                    $subnode = $xml->addChild("item$key");
                }
                $this->_arrayToXml($value, $subnode);
            } else {
                $xml->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }
}