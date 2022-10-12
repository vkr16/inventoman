<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.



/**
 * Dashboard
 */
$routes->get('/admin', 'Admin::index');

/**
 * Employee Management
 */
$routes->get('/admin/employees', 'Admin::employees');
$routes->post('/admin/employees/add', 'Admin::employeesAdd');
$routes->post('/admin/employees/list', 'Admin::employeesList');
$routes->post('/admin/employees/detail', 'Admin::employeesDetail');
$routes->post('/admin/employees/update', 'Admin::employeesUpdate');
$routes->post('/admin/employees/delete', 'Admin::employeesDelete');

/**
 * Administrator Management
 */
$routes->get('/admin/administrators', 'Admin::administrators');
$routes->post('/admin/administrators/validation/employee', 'Admin::administratorsEmployeeValidation');
$routes->post('/admin/administrators/validation/username', 'Admin::administratorsUsernameValidation');
$routes->post('/admin/administrators/add', 'Admin::administratorsAdd');
$routes->post('/admin/administrators/list', 'Admin::administratorsList');
$routes->post('/admin/administrators/delete', 'Admin::administratorsDelete');
$routes->post('/admin/administrators/reset', 'Admin::administratorsReset');

/**
 * Invoice Management
 */
$routes->get('/admin/invoices', 'Admin::invoices');
$routes->post('/admin/invoices/add', 'Admin::invoicesAdd');
$routes->post('/admin/invoices/list', 'Admin::invoicesList');
$routes->post('/admin/invoices/delete', 'Admin::invoicesDelete');
$routes->post('/admin/invoices/itemlist', 'Admin::invoicesItemList');
$routes->post('/admin/invoices/editableitemlist', 'Admin::invoicesEditableItemList');
$routes->get('/admin/invoices/detail', 'Admin::invoicesDetail');
$routes->post('/admin/invoices/get', 'Admin::invoicesGet');
$routes->post('/admin/invoices/update', 'Admin::invoicesUpdate');

/**
 * Asset Management
 */
$routes->get('/admin/assets', 'Admin::assets');
$routes->post('/admin/assets/add', 'Admin::assetsAdd');
$routes->post('/admin/assets/delete', 'Admin::assetsDelete');
$routes->post('/admin/assets/update', 'Admin::assetsUpdate');
$routes->post('/admin/assets/list', 'Admin::assetsList');

/**
 * Handover Management
 */
$routes->get('/admin/handovers', 'Admin::handovers');
$routes->post('/admin/handovers/list', 'Admin::handoversList');
$routes->post('/admin/handovers/add', 'Admin::handoversAdd');




/**
 * Authentication & Authorization
 */
$routes->get('/', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->post('/auth', 'Auth::auth');


/**
 * API Endpoints
 */
$routes->post('/api/admin/add', 'Api::adminAdd');



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
