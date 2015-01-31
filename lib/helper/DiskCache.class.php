<?php
/**
 * File that brings the class of disk cache
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
 * Class of disk cache
 *
 * @category Class
 * @package  Lib\helper
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
class DiskCache implements \helper\ICache
{
    /**
     * Path of the file
     * 
     * @var    string
     * @access protected
     */
    protected $file_path = null;
    /**
     * Cache content
     * 
     * @var    string
     * @access protected
     */
    protected $cache = null;
    /**
     * Defines if the cache is valid
     * 
     * @var    boolean
     * @access protected
     */
    protected $is_cached = true;
    /**
     * Cache directory
     * 
     * @var    string
     * @access protected
     */
    protected static $path = PATH_CACHE;
    /**
     * Standard value of the cache expiration time
     * 
     * @var    integer
     * @access public
     */
    CONST EXPIRE = 3600;

    /**
     * Function that constructs the cache
     *
     * @param string $id   {Cache identification}
     * @param string $host {Host name to be used in the cache identification}
     * @param string $url  {URL to be used in the cache identification}
     * @param string $user {Logged user to be used in the cache identification}
     *
     * @return void
     * @access public
     */
    protected function __construct($id, $host = null, $url = null, $user = null)
    {
        $this->file_path = self::solvePath($id, $host, $url, $user);
        $this->cache     = self::read($this->file_path);
    }

    /**
     * Function that checks if this cached
     *
     * @return boolean
     * @access public
     */
    public function isCached()
    {
        return $this->is_cached;
    }

    /**
     * Function that returns the content's cache
     *
     * @return string
     * @access public
     */
    public function getCache()
    {
        if ($this->isCached()) {
            return $this->cache;
        }
        return null;
    }

    /**
     * Function that saves a cache
     * 
     * @param string $content {Content to be save}
     *
     * @return boolean
     * @access public
     */
    public function save($content = null)
    {
        $buffer = $this->stop();
        if (!is_null($content)) {
            $buffer = $content;
        }
        if ($this->write($buffer)) {
            $this->cache     = $buffer;
            $this->is_cached = true;
            return true;
        }
        return false;
    }

    /**
     * Function that ignore the cache's buffer without change it
     *
     * @return void
     * @access public
     */
    public function ignore()
    {
        $this->stop();
        $this->cache = self::read($this->file_path);
        return true;
    }

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
     * @return DiskCache
     * @access public
     */
    public static function cache(
        $id,
        $exp_time  = self::EXPIRE,
        $host      = null,
        $url       = null,
        $user      = null,
        $comp_time = null
    ) {
        $Cache = new self($id, $host, $url, $user);
        $file  = $Cache->file_path;
        if (!self::valid($file, $exp_time, $comp_time)) {
            self::touch($file);
            self::start();
            $Cache->is_cached = false;
        }
        return $Cache;
    }

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
    public static function remove($id, $host = null, $url = null, $user = null)
    {
        $file = self::solvePath($id, $host, $url, $user);
        if (!file_exists($file)) {
            return false;
        }
        @unlink($file);
        return true;
    }

    /**
     * Function that returns the a file path
     *
     * @param string $id   {Cache identification}
     * @param string $host {Cache duration time, in seconds}
     * @param string $url  {URL to be used in the cache identification}
     * @param string $user {Logged user used in the cache identification}
     *
     * @return string
     * @access protected
     */
    protected static function solvePath($id, $host = null, $url = null, $user = null)
    {
        return realpath(self::$path) . '/' . strtolower($id)
               . (!is_null($host) ? '.' : null)
               . $host . (!is_null($url) ? '.' : null) . $url
               . (!is_null($user) ? '.' : null) . $user . '.cache';
    }

    /**
     * Function that returns if a cache file exists
     *
     * @param string  $file      {Cache file}
     * @param integer $exp_time  {Cache duration time, in seconds}
     * @param integer $comp_time {Time of comparison cache, in seconds}
     *
     * @return boolean
     * @access protected
     */
    protected static function valid($file, $exp_time, $comp_time = null)
    {
        if (!file_exists($file)) {
            return false;
        }
        $exp_time = (int)$exp_time;
        // Returns valid, case does not exist expiration time
        if ($exp_time === 0) {
            return true;
        }
        // Defines the standard expiration time if this is less than zero
        if ($exp_time < 0) {
            $exp_time = self::EXPIRE;
        }
        if (is_null($comp_time)) {
            $comp_time = time();
        }
        if (($comp_time - filemtime($file)) > $exp_time) {
            return false;
        }
        return true;
    }

    /**
     * Function that updates the date and hour of the cache file
     *
     * @param string $file {Cache file}
     *
     * @return boolean
     * @access protected
     */
    protected static function touch($file)
    {
        if (!file_exists($file)) {
            return false;
        }
        if (DO_DISK_CACHE) {
            @touch($file);
            @chmod($file, 0777);
        }
        return true;
    }

    /**
     * Function that initializes the cache buffer
     *
     * @return void
     * @access protected
     */
    protected static function start()
    {
        ob_start();
    }

    /**
     * Function that returns the content of a cache file
     *
     * @param string $file {Cache file}
     *
     * @return string
     * @access protected
     */
    protected static function read($file)
    {
        if (!file_exists($file)) {
            return null;
        }
        return file_get_contents($file);
    }

    /**
     * Function that returns the cache buffer
     *
     * @return string
     * @access protected
     */
    protected function stop()
    {
        return ob_get_clean();
    }

    /**
     * Function that writes in a cache's file with a content
     *
     * @param string $content {Content to be write in the cache}
     *
     * @return boolean
     * @access protected
     */
    protected function write($content)
    {
        $r = true;
        if (DO_DISK_CACHE) {
            $file = $this->file_path;
            $r    = file_put_contents($file, $content);
            @chmod($file, 0777);
        }
        return $r;
    }

}