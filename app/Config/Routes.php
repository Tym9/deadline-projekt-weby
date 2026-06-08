<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Main::index');
$routes->get('autori', 'Main::authors');
$routes->get('autori/detail/(:num)/(:segment)', 'Main::authorDetail/$1/$2');
$routes->get('recept/detail/(:num)/(:segment)', 'Main::detail/$1/$2');
