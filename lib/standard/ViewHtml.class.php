<?php
/**
 * File that brings the HTML view of the system
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
 * HTML view of the system
 *
 * @category View
 * @package  Standard
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
class ViewHtml extends \standard\View
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
        header('Content-Type: text/html;charset=UTF-8');
        echo '<pre>';print_r($content);
    }
}