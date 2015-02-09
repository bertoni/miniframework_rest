<?php
/**
 * File of application constants
 *
 * PHP Version 5.3
 *
 * @category Configuration
 * @package  Config
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */

if (!defined('SYSTEM_NAME')) {
    define('SYSTEM_NAME', 'TransportManager');
}
if (!defined('PATH_SITE')) {
    define(
        'PATH_SITE',
        (DEV ? 'transportmanagerv2' : '//www.transportmanager.com.br')
    );
}
if (!defined('PATH_LIB')) {
    define(
        'PATH_LIB',
        substr(dirname(__FILE__), 0, strrpos(dirname(__FILE__), '/')) . '/lib'
    );
}
if (!defined('PATH_APP')) {
    define(
        'PATH_APP',
        substr(dirname(__FILE__), 0, strrpos(dirname(__FILE__), '/')) . '/app'
    );
}
if (!defined('PATH_CACHE')) {
    define(
        'PATH_CACHE',
        substr(dirname(__FILE__), 0, strrpos(dirname(__FILE__), '/')) . '/cache'
    );
}
if (!defined('SALT')) {
    define('SALT', SYSTEM_NAME . 'tr4nsp0rtm4n4g3r');
}
if (!defined('SEND_EMAIL')) {
    define('SEND_EMAIL', (DEV ? false : true));
}
if (!defined('EMAIL_TO_SEND')) {
    define('EMAIL_TO_SEND', 'dev@transportmanager.com.br');
}
if (!defined('DO_DISK_CACHE')) {
    define('DO_DISK_CACHE', (!DEV ? false : true));
}
if (!defined('CACHE_ROUTE')) {
    define('CACHE_ROUTE', 'routes');
}
if (!defined('BROWSER')) {
    $USERAGENT = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('|MSIE ([0-9].[0-9]{1,2})|', $USERAGENT, $matched)) {
        $browser_version = $matched[1];
        $browser         = 'IE';
    } elseif (preg_match('|Opera/([0-9].[0-9]{1,2})|', $USERAGENT, $matched)) {
        $browser_version = $matched[1];
        $browser         = 'OPERA';
    } elseif (preg_match('|Firefox/([0-9\.]+)|', $USERAGENT, $matched)) {
        $browser_version = $matched[1];
        $browser         = 'FIREFOX';
    } elseif (preg_match('|Chrome/([0-9\.]+)|', $USERAGENT, $matched)) {
        $browser_version = $matched[1];
        $browser         = 'CHROME';
    } elseif (preg_match('|Safari/([0-9\.]+)|', $USERAGENT, $matched)) {
        $browser_version = $matched[1];
        $browser         = 'SAFARI';
    } else {
        $browser_version = 0;
        $browser         = 'OTHER';
    }
    define('BROWSER',         $browser);
    define('BROWSER_VERSION', $browser_version);
    unset($USERAGENT, $matched, $browser, $browser_version);
}
if (!defined('APP_IN_USE')) {
    $app = explode(
        '.',
        str_replace(array('https://', 'http://', '/'), null, $_SERVER['HTTP_HOST'])
    );
    $app = array_shift($app);
    define('APP_IN_USE', $app);
    unset($app);
}
if (!defined('DB_CONN')) {
    define('DB_CONN', (DEV ? 'mysql:host=localhost;port=3306;dbname=transportmanagerv2' : 'mysql:host=localhost;port=3306;dbname=transpor_prod'));
    define('DB_USER', (DEV ? 'root' : 'transpor_app'));
    define('DB_PASS', (DEV ? 'root' : 'TzTi51SRV$J4'));
}