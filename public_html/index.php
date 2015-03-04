<?php
/**
 * Initial file of all application
 *
 * PHP Version 5.3
 *
 * @category Files
 * @package  Public
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
require_once dirname(__FILE__) . '/../config/default.inc.php';

 // CodeSniffer
if (DEV && APP_IN_USE == 'codesniffer') {
    include dirname(__FILE__) . '/../test/codesniffer/index.php';
    exit;
}

$RequestHTTP    = helper\RequestHTTP::getInstance();
$url_request    = explode('?', $_SERVER['REQUEST_URI'], 2);
$url            = $url_request[0];
$parameters_get = (isset($url_request[1]) && !empty($url_request[1])
                  ? $url_request[1] : null);

// Checks if exists some route to this URL
if (helper\Slug::decodeUrl(APP_IN_USE, $url, $RequestHTTP->getHttpMethod())) {
    try {
        $Controller = APP_IN_USE . '\\controller\\'
                      . helper\Slug::$parameters['controller'];
        $Controller::request(
            helper\Slug::$parameters['action'],
            helper\Slug::$parameters
        );
        exit;
    } catch (\Exception $e) {
        if (DEV) {
            echo 'exceção: ', $e->getMessage(), "\n";exit;
        }
        http_response_code(404);exit;
    }
    // Case does not exists route, try load a static file with name of the URL
} else if (stream_resolve_include_path(
    PATH_APP . '/' . APP_IN_USE . '/view/static' . $url
    . (preg_match('/(.)+\.(html|php)$/', $url) ? null : '.php')
) !== false) {
    // Redirect the URL for that does not get with the file extension
    if (preg_match('/(.)+\.(html|php)$/', $url) === 1) {
        header(
            "Location: " . preg_replace('/(.+)\.(html|php)$/', '$1', $url)
            . (!is_null($parameters_get) ? '?' . $parameters_get : null),
            true,
            301
        );
        exit;
    }
    include PATH_APP . '/' . APP_IN_USE . '/view/static' . $url
            . (preg_match('/(.)+\.(html|php)$/', $url) ? null : '.php');
    exit;
} else {
    if (http_response_code() == 200) {
        http_response_code(404);
    }
    exit;
}