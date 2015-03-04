<?php
/**
 * File that brings the Slug class
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
 * Slug class
 *
 * @category Class
 * @package  Lib\helper
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
abstract class Slug
{
    /**
     * Parameters received in the request
     * 
     * @var    array
     * @access public
     */
    public static $parameters = array();
    /**
     * Application routes
     * 
     * @var    array
     * @access public
     */
    protected static $route = array();

    /**
     * Function that adds a route
     *
     * @param string $application {Route's application}
     * @param string $label       {Route's nick}
     * @param string $url         {Route's URL}
     * @param array  $methods     {Available HTTP methods for the URL}
     * @param array  $args        {Route's variables}
     * @param array  $validators  {Special validators of the route}
     *
     * @access public
     * @return void
     */
    public static function add(
        $application,
        $label,
        $url,
        array $methods,
        array $args       = array(),
        array $validators = array()
    ) {
        // if the URL type is STATIC
        if (!preg_match('/\*/', $url)
            && !preg_match('/(\:[0-9a-zA-Z_]){1,}/', $url)
        ) {
            self::_setRoute(
                $application,
                'static',
                $label,
                $url,
                $methods,
                $url,
                $args,
                $validators
            );
        } else {
            $pattern = preg_replace('/\//', '\/', $url);
            // transforms the dynamic urls variables
            if (preg_match('/(\:[0-9a-zA-Z_]){1,}/', $url)) {
                // check if there are specific rules
                if (count($validators)) {
                    foreach ($validators as $name=>$expression) {
                        $pattern = preg_replace(
                            '/\:(' . $name . ')/',
                            '(?P<$1>' . $expression . ')',
                            $pattern,
                            1
                        );
                    }
                }
                $pattern = preg_replace(
                    '/:([a-zA-Z0-9_]{1,})/', '(?P<$1>[a-zA-Z0-9-]{1,})', $pattern
                );
            }
            // if the URL type is DYNAMIC
            if (!preg_match('/\*/', $url)) {
                self::_setRoute(
                    $application,
                    'dynamic',
                    $label,
                    $url,
                    $methods,
                    $pattern,
                    $args,
                    $validators
                );
            } else {
                // MAGIC URL
                $pattern = preg_replace(
                    '/(\x5c\/\*)/',
                    '(?P<_arg>(?:(\/(?:[a-zA-Z0-9-]+)\/(?:[a-zA-Z0-9-]+))+)?)',
                    $pattern
                );
                self::_setRoute(
                    $application,
                    'magic',
                    $label,
                    $url,
                    $methods,
                    $pattern,
                    $args,
                    $validators
                );
            }
        }
    }

    /**
     * Function that returns a URL
     *
     * @param string $application {Route's application}
     * @param string $name        {Route's nick}
     * @param string $method      {Route's HTTP method}
     * @param array  $args        {Route's variables}
     *
     * @access public
     * @return string
     */
    public static function getUrl(
        $application,
        $name,
        $method,
        array $args = array()
    ) {
        if (isset(self::$route[$application])) {
            if (isset(self::$route[$application]['static'])) {
                foreach (self::$route[$application]['static'] as $label=>$data) {
                    if ($name === $label) {
                        if (!self::_checksHttpMethodInRoute(
                            $application, 'static', $label, $method
                        )) {
                            return '';
                        }
                        return $data['url'];
                    }
                }
            }
            if (isset(self::$route[$application]['dynamic'])) {
                foreach (self::$route[$application]['dynamic'] as $label=>$data) {
                    if ($name === $label) {
                        if (!self::_checksHttpMethodInRoute(
                            $application, 'dynamic', $label, $method
                        )) {
                            return '';
                        }
                        preg_match_all(
                            '/\:([0-9a-zA-Z_]{1,})/', $data['url'], $variables
                        );
                        $correct_param = true;
                        foreach ($variables[1] as $var) {
                            $correct_param = $correct_param
                                 && array_key_exists($var, $args)
                                 && preg_match(
                                     (isset($data['validators'][$method][$var])
                                         ? '/^'
                                            . $data['validators'][$method][$var]
                                            . '$/'
                                         : '/^[a-zA-Z0-9-]{1,}$/'),
                                     $args[$var]
                                 );
                        }
                        if ($correct_param) {
                            foreach ($variables[1] as $var) {
                                $data['url'] = preg_replace(
                                    '/\:' . $var . '/', $args[$var], $data['url']
                                );
                            }
                            return $data['url'];
                        }
                    }
                }
            }
            if (isset(self::$route[$application]['magic'])) {
                foreach (self::$route[$application]['magic'] as $label=>$data) {
                    if ($name === $label) {
                        if (!self::_checksHttpMethodInRoute(
                            $application, 'magic', $label, $method
                        )) {
                            return '';
                        }
                        preg_match_all(
                            '/\:([0-9a-zA-Z_]{1,})/', $data['url'], $variables
                        );
                        $correct_param = true;
                        foreach ($variables[1] as $var) {
                            $correct_param = $correct_param
                            && array_key_exists($var, $args)
                            && preg_match(
                                (isset($data['validators'][$method][$var]) 
                                    ? '/^' . $data['validators'][$method][$var]
                                        . '$/'
                                    : '/^[a-zA-Z0-9-]{1,}$/'),
                                $args[$var]
                            );
                        }
                        if ($correct_param) {
                            foreach ($variables[1] as $var) {
                                $data['url'] = preg_replace(
                                    '/\:' . $var . '/', $args[$var], $data['url']
                                );
                                $args[$var]  = null;
                                unset($args[$var]);
                            }
                            $magic_values = '';
                            foreach ($args as $k=>$v) {
                                $magic_values .= (empty($magic_values) ? null : '/')
                                              . (strlen($k) && strlen($v)
                                                      ? $k . '/' . $v
                                                      : null);
                            }
                            $data['url'] = preg_replace(
                                '/' . (empty($magic_values) ? '\/' : null)
                                . '\*$/', $magic_values, $data['url']
                            );
                            return $data['url'];
                        }
                    }
                }
            }
        }
        return '';
    }

    /**
     * Função que trata a url solicitada
     * Function that handles the requested URL
     *
     * @param string $application {Route's application}
     * @param string $url         {URL to be decoded}
     * @param string $method      {Route's HTTP method}
     *
     * @access public
     * @return boolean
     */
    public static function decodeUrl($application, $url, $method)
    {
        if (isset(self::$route[$application])) {
            if (isset(self::$route[$application]['static'])) {
                foreach (self::$route[$application]['static'] as $label=>$data) {
                    if ($url === $data['pattern']) {
                        if (!self::_checksHttpMethodInRoute(
                            $application, 'static', $label, $method
                        )) {
                            http_response_code(405);
                            header(
                                'Allow: ' . implode(
                                    ', ',
                                    self::$route[$application]['static']
                                    [$label]['methods']
                                )
                            );
                            return false;
                        }
                        if (isset($data['args'][$method])) {
                            self::$parameters = $data['args'][$method];
                        }
                        return true;
                    }
                }
            }
            if (isset(self::$route[$application]['dynamic'])) {
                foreach (self::$route[$application]['dynamic'] as $label=>$data) {
                    if (preg_match('/^' . $data['pattern'] . '$/', $url, $matchs)) {
                        if (!self::_checksHttpMethodInRoute(
                            $application, 'dynamic', $label, $method
                        )) {
                            http_response_code(405);
                            header(
                                'Allow: ' . implode(
                                    ', ',
                                    self::$route[$application]['dynamic']
                                    [$label]['methods']
                                )
                            );
                            return false;
                        }
                        self::$parameters = array_merge(
                            (isset($data['args'][$method])
                                ? $data['args'][$method]
                                : array()),
                            $matchs
                        );
                        return true;
                    }
                }
            }
            if (isset(self::$route[$application]['magic'])) {
                foreach (self::$route[$application]['magic'] as $label=>$data) {
                    if (preg_match('/^' . $data['pattern'] . '$/', $url, $matchs)) {
                        if (!self::_checksHttpMethodInRoute(
                            $application, 'magic', $label, $method
                        )) {
                            http_response_code(405);
                            header(
                                'Allow: ' . implode(
                                    ', ',
                                    self::$route[$application]['magic']
                                    [$label]['methods']
                                )
                            );
                            return false;
                        }
                        $args = explode('/', $matchs['_arg']);
                        array_shift($args);
                        $max = count($args);
                        if ($max && isset($data['args'][$method])) {
                            for ($i=0; $i<$max; $i++) {
                                $data['args'][$method][$args[$i]] = $args[++$i];
                            }
                        }
                        $matchs['_arg'] = null;
                        unset($matchs['_arg']);
                        self::$parameters = array_merge(
                            (isset($data['args'][$method])
                                ? $data['args'][$method]
                                : array()),
                            $matchs
                        );
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Function that checks the necessity of generates routes
     * 
     * @param ICache $Cache {Object to be used for check the cache}
     *
     * @access public
     * @return boolean
     */
    public static function isNeedToAddRoutes(\helper\ICache $Cache)
    {
        // Checks if the cache is able
        if ($Cache->isCached()) {
            self::$route = unserialize($Cache->getCache());
            return false;
        }
        return true;
    }

    /**
     * Function that saves the routes
     * 
     * @param ICache $Cache {Object to be used for saves the cache}
     *
     * @access public
     * @return boolean
     */
    public static function saveRoutes(\helper\ICache $Cache)
    {
        $content = serialize(self::$route);
        return $Cache->save($content);
    }

    /**
     * Function that sets a route
     *
     * @param string $application {Route's application}
     * @param string $type        {Route's type}
     * @param string $label       {Route's nick}
     * @param string $url         {Route's URL}
     * @param array  $methods     {Available HTTP methods for the URL}
     * @param string $pattern     {Route's regular expression}
     * @param array  $args        {Route's variables}
     * @param array  $validators  {Special validators of the route}
     *
     * @access private
     * @return void
     */
    private static function _setRoute(
        $application,
        $type,
        $label,
        $url,
        array $methods,
        $pattern,
        array $args       = array(),
        array $validators = array()
    ) {
        self::$route[$application][$type][$label] = array(
            'url'        => $url,
            'pattern'    => $pattern,
            'methods'    => $methods,
            'args'       => $args,
            'validators' => $validators
        );
    }

    /**
     * Function that checks if the route supports a specific HTTP method
     *
     * @param string $application {Route's application}
     * @param string $type        {Route's type}
     * @param string $label       {Route's nick}
     * @param string $method      {HTTP method to be validated}
     *
     * @access public
     * @return boolean
     */
    private static function _checksHttpMethodInRoute(
        $application, $type, $label, $method
    ) {
        return in_array(
            $method, self::$route[$application][$type][$label]['methods']
        );
    }


}