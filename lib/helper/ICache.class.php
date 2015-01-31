<?php
/**
 * File that brings the cache interface
 *
 * PHP Version 5.3
 *
 * @category Interface
 * @package  Lib\helper
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
namespace helper;
/**
 * Cache interface
 *
 * @category Interface
 * @package  Lib\helper
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
Interface ICache
{
    /**
     * Function that checks if this cached
     *
     * @return boolean
     * @access public
     */
    public function isCached();
    /**
     * Function that returns the content's cache
     *
     * @return string
     * @access public
     */
    public function getCache();
    /**
     * Function that saves a cache
     * 
     * @param string $content {Conteúdo a ser salvo}
     *
     * @return boolean
     * @access public
     */
    public function save($content);
    /**
     * Function that ignore the cache's buffer without change it
     *
     * @return void
     * @access public
     */
    public function ignore();
    /**
     * Function that returns a cache object
     *
     * @param string  $id        {Cache identification}
     * @param integer $exp_time  {Cache duration time, in seconds}
     * @param string  $host      {Host's name used in the cache identification}
     * @param string  $url       {URL to be used in the cache identification}
     * @param string  $user      {Logged user used in the cache identification}
     * @param integer $comp_time {Time of comparison cache, in seconds}
     *
     * @return ICache
     * @access public
     */
    public static function cache($id, $exp_time, $host, $url, $user, $comp_time);
    /**
     * Function that removes a cache
     *
     * @param string $id   {Cache identification}
     * @param string $host {Cache duration time, in seconds}
     * @param string $url  {URL to be used in the cache identification}
     * @param string $user {Logged user used in the cache identification}
     *
     * @return boolean
     * @access public
     */
    public static function remove($id, $host, $url, $user);
}