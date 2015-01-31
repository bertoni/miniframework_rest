<?php
/**
 * File that brings the application routes
 *
 * PHP Version 5.3
 *
 * @category Configuration
 * @package  Config
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */

$Cache = helper\DiskCache::cache(
    CACHE_ROUTE, 1, null, null, null, filemtime(__FILE__)
);
if (helper\Slug::isNeedToAddRoutes($Cache)) {
    // REGRAS PARA PÁGINAS DE LANDING PAGES
    helper\Slug::add(
        'api',
        'user-guide',
        '/',
        array('controller' => 'System', 'action' => 'userGuide')
    );
    helper\Slug::saveRoutes($Cache);
}