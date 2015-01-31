<?php
/**
 * File of application collections
 *
 * PHP Version 5.3
 *
 * @category Configuration
 * @package  Config
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */

$Registry = \helper\Registry::getInstance();

if (!$Registry->exists('supported_formats')) {
    $Registry->register(
        'supported_formats',
        array(
            'html'      => 'html',
            'xhtml+xml' => 'html',
            'xml'       => 'xml',
            'json'      => 'json',
            '*'         => 'json'
        )
    );
}