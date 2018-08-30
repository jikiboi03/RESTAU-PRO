<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'Login_controller/index';
$route['404_override'] = '';
// $route['error500'] = 'error_controller';
$route['error500'] = 'login_controller/index';
$route['translate_uri_dashes'] = TRUE;


// $route['log-user'] = 'login_controller/login_validation';


$route['dashboard'] = 'Dashboard_controller/index';
$route['user-logout'] = 'login_controller/logout';

$route['showlist-sold-today'] = 'Dashboard_controller/ajax_list';


//************************************ READING ROUTES ****************************************************************
//******************************************************************************************************************

$route['print-s-reading'] = 'Dashboard_controller/set_s_reading';
$route['print-x-reading'] = 'Dashboard_controller/set_x_reading';

//======================================== API SECTION =================================================================

$route['showlist-pos-api'] = 'Dashboard_controller/ajax_api_pos_list';


//************************************ ITEMS ROUTES ****************************************************************
//******************************************************************************************************************

$route['items-page'] = 'Items/Items_controller';

$route['showlist-items'] = 'Items/Items_controller/ajax_list';

$route['add-item'] = 'Items/Items_controller/ajax_add';

$route['edit-item/(:num)'] = 'Items/Items_controller/ajax_edit/$1';

$route['update-item'] = 'Items/Items_controller/ajax_update';

$route['delete-item/(:num)'] = 'Items/Items_controller/ajax_delete/$1';

//======================================== API SECTION =================================================================

$route['showlist-items-api'] = 'Items/Items_controller/ajax_api_list';


//************************************ PRODUCTS ROUTES ****************************************************************
//******************************************************************************************************************

$route['products-page'] = 'Products/Products_controller';

$route['showlist-products'] = 'Products/Products_controller/ajax_list';

$route['add-product'] = 'Products/Products_controller/ajax_add';

$route['edit-product/(:num)'] = 'Products/Products_controller/ajax_edit/$1';

$route['update-product'] = 'Products/Products_controller/ajax_update';

$route['delete-product/(:num)'] = 'Products/Products_controller/ajax_delete/$1';

//======================================== API SECTION =================================================================

$route['showlist-products-api'] = 'Products/Products_controller/ajax_api_list';


//************************************ PACKAGES ROUTES ****************************************************************
//******************************************************************************************************************

$route['packages-page'] = 'Packages/Packages_controller';

$route['showlist-packages'] = 'Packages/Packages_controller/ajax_list';

$route['add-package'] = 'Packages/Packages_controller/ajax_add';

$route['edit-package/(:num)'] = 'Packages/Packages_controller/ajax_edit/$1';

$route['update-package'] = 'Packages/Packages_controller/ajax_update';

$route['delete-package/(:num)'] = 'Packages/Packages_controller/ajax_delete/$1';

//======================================== API SECTION =================================================================

$route['showlist-packages-api'] = 'Packages/Packages_controller/ajax_api_list';


//************************************ CATEGORIES ROUTES ***************************************************************
//******************************************************************************************************************

$route['categories-page'] = 'Categories/Categories_controller';

$route['showlist-categories'] = 'Categories/Categories_controller/ajax_list';

$route['add-category'] = 'Categories/Categories_controller/ajax_add';

$route['edit-category/(:num)'] = 'Categories/Categories_controller/ajax_edit/$1';

$route['update-category'] = 'Categories/Categories_controller/ajax_update';

$route['delete-category/(:num)'] = 'Categories/Categories_controller/ajax_delete/$1';

//======================================== API SECTION =================================================================

$route['showlist-categories-api'] = 'Categories/Categories_controller/ajax_api_list';


//************************************ TABLES ROUTES ***************************************************************
//******************************************************************************************************************

$route['tables-page'] = 'Tables/Tables_controller';

$route['showlist-tables'] = 'Tables/Tables_controller/ajax_list';

$route['add-table'] = 'Tables/Tables_controller/ajax_add';

$route['edit-table/(:num)'] = 'Tables/Tables_controller/ajax_edit/$1';

$route['update-table'] = 'Tables/Tables_controller/ajax_update';

$route['delete-table/(:num)'] = 'Tables/Tables_controller/ajax_delete/$1';

//======================================== API SECTION =================================================================

$route['showlist-tables-api'] = 'Tables/Tables_controller/ajax_api_list';


//************************************ TRANSACTIONS ROUTES ***************************************************************
//******************************************************************************************************************

$route['transactions-page'] = 'Transactions/Transactions_controller';

$route['transactions-page-cleared'] = 'Transactions/Transactions_controller/index_cleared';

$route['transactions-page-cancelled'] = 'Transactions/Transactions_controller/index_cancelled';

$route['transactions-page-refunded'] = 'Transactions/Transactions_controller/index_refunded';

$route['showlist-transactions/(:num)'] = 'Transactions/Transactions_controller/ajax_list/$1';

$route['add-transaction'] = 'Transactions/Transactions_controller/ajax_add';

$route['edit-transaction/(:num)'] = 'Transactions/Transactions_controller/ajax_edit/$1';

$route['get-transaction-by-receipt/(:num)'] = 'Transactions/Transactions_controller/ajax_get_by_receipt/$1';

$route['get-last-receipt-trans'] = 'Transactions/Transactions_controller/ajax_get_last_receipt_no_trans';

$route['update-transaction'] = 'Transactions/Transactions_controller/ajax_update';

$route['delete-transaction/(:num)'] = 'Transactions/Transactions_controller/ajax_delete/$1';

//======================================== API SECTION =================================================================

$route['showlist-transactions-api'] = 'Transactions/Transactions_controller/ajax_api_list';

$route['add-transactions-api'] = 'Transactions/Transactions_controller/ajax_api_add_trans';

$route['add-transactions-refund-api'] = 'Transactions/Transactions_controller/ajax_api_add_refund_trans';

$route['reset-transactions-api/(:num)'] = 'Transactions/Transactions_controller/ajax_api_reset_trans/$1';


//************************************ DISCOUNTS ROUTES ***************************************************************
//******************************************************************************************************************

$route['discounts-page'] = 'Discounts/Discounts_controller';

$route['showlist-discounts'] = 'Discounts/Discounts_controller/ajax_list';

$route['add-discount'] = 'Discounts/Discounts_controller/ajax_add';

$route['edit-discount/(:num)'] = 'Discounts/Discounts_controller/ajax_edit/$1';

$route['update-discount'] = 'Discounts/Discounts_controller/ajax_update';

$route['delete-discount/(:num)'] = 'Discounts/Discounts_controller/ajax_delete/$1';

//======================================== API SECTION =================================================================

$route['showlist-discounts-api'] = 'Discounts/Discounts_controller/ajax_api_list';

$route['add-discounts-api'] = 'Discounts/Discounts_controller/ajax_api_add_trans';



//************************************ STORE CONFIG ROUTES *************************************************************
//******************************************************************************************************************

$route['store-config-page'] = 'Store_config/Store_config_controller';

$route['edit-store-config/(:num)'] = 'Store_config/Store_config_controller/ajax_edit/$1';

$route['update-store-config'] = 'Store_config/Store_config_controller/ajax_update';

$route['back-up-db'] = 'Store_config/Store_config_controller/backup_db';

// $route['back-up-db'] = 'myphp-backup.php';

//======================================== API SECTION =================================================================

$route['showlist-store-config-api'] = 'Store_config/Store_config_controller/ajax_api_list';


//************************************ PRODUCT DISCOUNT ROUTES ***************************************************************
//******************************************************************************************************************

$route['prod-discounts-page'] = 'Prod_discounts/Prod_discounts_controller';

$route['showlist-prod-discounts'] = 'Prod_discounts/Prod_discounts_controller/ajax_list';

$route['add-prod-discount'] = 'Prod_discounts/Prod_discounts_controller/ajax_add';

$route['edit-prod-discount/(:num)'] = 'Prod_discounts/Prod_discounts_controller/ajax_edit/$1';

$route['update-prod-discount'] = 'Prod_discounts/Prod_discounts_controller/ajax_update';

$route['delete-prod-discount/(:num)'] = 'Prod_discounts/Prod_discounts_controller/ajax_delete/$1';

//======================================== API SECTION =================================================================

// $route['showlist-discounts-api'] = 'Discounts/Discounts_controller/ajax_api_list';

// $route['add-discounts-api'] = 'Discounts/Discounts_controller/ajax_api_add_trans';


//************************************ PRODUCT DISCOUNT ROUTES ***************************************************************
//******************************************************************************************************************

$route['pack-discounts-page'] = 'Pack_discounts/Pack_discounts_controller';

$route['showlist-pack-discounts'] = 'Pack_discounts/Pack_discounts_controller/ajax_list';

$route['add-pack-discount'] = 'Pack_discounts/Pack_discounts_controller/ajax_add';

$route['edit-pack-discount/(:num)'] = 'Pack_discounts/Pack_discounts_controller/ajax_edit/$1';

$route['update-pack-discount'] = 'Pack_discounts/Pack_discounts_controller/ajax_update';

$route['delete-pack-discount/(:num)'] = 'Pack_discounts/Pack_discounts_controller/ajax_delete/$1';

//======================================== API SECTION =================================================================

// $route['showlist-discounts-api'] = 'Discounts/Discounts_controller/ajax_api_list';

// $route['add-discounts-api'] = 'Discounts/Discounts_controller/ajax_api_add_trans';




//************************************ PROD DETAIL ROUTES **************************************************************
//******************************************************************************************************************

$route['prod-details-page/(:num)'] = 'Prod_details/Prod_details_controller/index/$1';

$route['showlist-prod-details/(:num)'] = 'Prod_details/Prod_details_controller/ajax_list/$1';

$route['add-prod-detail'] = 'Prod_details/Prod_details_controller/ajax_add';

$route['edit-prod-detail/(:num)/(:num)'] = 'Prod_details/Prod_details_controller/ajax_edit/$1/$2';

$route['update-prod-detail'] = 'Prod_details/Prod_details_controller/ajax_update';

$route['delete-prod-detail/(:num)/(:num)'] = 'Prod_details/Prod_details_controller/ajax_delete/$1/$2';

//======================================== API SECTION =================================================================

$route['showlist-prod-details-api/(:num)'] = 'Prod_details/Prod_details_controller/ajax_api_list/$1';


//************************************ PACK DETAIL ROUTES **************************************************************
//******************************************************************************************************************

$route['pack-details-page/(:num)'] = 'Pack_details/Pack_details_controller/index/$1';

$route['showlist-pack-details/(:num)'] = 'Pack_details/Pack_details_controller/ajax_list/$1';

$route['add-pack-detail'] = 'Pack_details/Pack_details_controller/ajax_add';

$route['edit-pack-detail/(:num)/(:num)'] = 'Pack_details/Pack_details_controller/ajax_edit/$1/$2';

$route['update-pack-detail'] = 'Pack_details/Pack_details_controller/ajax_update';

$route['delete-pack-detail/(:num)/(:num)'] = 'Pack_details/Pack_details_controller/ajax_delete/$1/$2';

//======================================== API SECTION =================================================================

$route['showlist-pack-details-api/(:num)'] = 'Pack_details/Pack_details_controller/ajax_api_list/$1';


//************************************ TRANS DETAIL ROUTES **************************************************************
//******************************************************************************************************************

$route['trans-details-page/(:num)'] = 'Trans_details/Trans_details_controller/index/$1';

$route['trans-details-refund-page/(:num)'] = 'Trans_details/Trans_details_controller/index_refund/$1';

$route['showlist-trans-details/(:num)'] = 'Trans_details/Trans_details_controller/ajax_list/$1';

$route['showlist-trans-details-refund/(:num)'] = 'Trans_details/Trans_details_controller/ajax_list_refund/$1';

$route['set-payment'] = 'Trans_details/Trans_details_controller/ajax_set_payment';

$route['set-discount'] = 'Trans_details/Trans_details_controller/ajax_set_discount';

$route['set-cancel/(:num)'] = 'Trans_details/Trans_details_controller/ajax_set_cancel/$1';

$route['edit-trans-detail/(:num)/(:num)'] = 'Trans_details/Trans_details_controller/ajax_edit/$1/$2';

$route['update-trans-detail'] = 'Trans_details/Trans_details_controller/ajax_update';

$route['delete-trans-detail-prod/(:num)/(:num)'] = 'Trans_details/Trans_details_controller/ajax_delete_prod/$1/$2';
$route['delete-trans-detail-pack/(:num)/(:num)'] = 'Trans_details/Trans_details_controller/ajax_delete_pack/$1/$2';

// receipt routes

$route['print-billout-receipt/(:num)'] = 'Trans_details/Trans_details_controller/set_transaction_receipt/$1/billout/0'; // print billout-type receipt

$route['reprint-last-trans-receipt/(:num)/(:num)'] = 'Trans_details/Trans_details_controller/set_transaction_receipt/$1/payment/$2'; // reprint payment-type receipt

//======================================== API SECTION =================================================================

$route['set-payment-api'] = 'Trans_details/Trans_details_controller/ajax_set_payment_api';

$route['showlist-trans-details-api/(:num)'] = 'Trans_details/Trans_details_controller/ajax_api_list/$1';

$route['showlist-trans-details-by-receipt-no-api/(:num)'] = 'Trans_details/Trans_details_controller/ajax_api_list_by_receipt_no/$1';








//************************************** NOTIFICATIONS ROUTES
//**************************************

$route['notifications-page/notifications-monthly-page'] = 'notifications/notifications_controller/index/monthly';

$route['notifications-page/notifications-quarterly-page'] = 'notifications/notifications_controller/index/quarterly';

$route['notifications-page/notifications-deworming-page'] = 'notifications/notifications_controller/index/deworming';

$route['notifications-page/notifications-severe-page'] = 'notifications/notifications_controller/index/severe';





//************************************** LOGS ROUTES
//**************************************

// system
$route['logs-page'] = 'Logs/Logs_controller';

$route['showlist-logs'] = 'Logs/Logs_controller/ajax_list';

// trans
$route['trans-logs-page'] = 'Logs/Trans_logs_controller';

$route['showlist-trans-logs'] = 'Logs/Trans_logs_controller/ajax_list';

//======================================== API SECTION =================================================================

$route['add-trans-logs'] = 'Logs/Trans_logs_controller/ajax_add_api';


//************************************** SCHEDULES ROUTES
//**************************************

$route['schedules-page'] = 'Schedules/Schedules_controller';

$route['showlist-schedules'] = 'Schedules/Schedules_controller/ajax_list';



//************************************** STATISTICS ROUTES
//**************************************


$route['statistics-page'] = 'Statistics/Statistics_controller/index';



//************************************** REPORTS (TCPDF) ROUTES
//**************************************

$route['reports-page'] = 'Reports/Reports_controller';

$route['dashboard-report'] = 'Pdf_reports/Pdf_dashboard_report_controller/index';

// menu items -----------------------------------------
$route['products-report'] = 'Pdf_reports/Pdf_products_report_controller/index';

$route['packages-report'] = 'Pdf_reports/Pdf_packages_report_controller/index';

$route['menu-top-selling-report'] = 'Pdf_reports/Pdf_products_report_controller/index_bs';


$route['products-report-annual/(:any)'] = 'Pdf_reports/Pdf_products_report_controller/index_annual/$1';

$route['packages-report-annual/(:any)'] = 'Pdf_reports/Pdf_packages_report_controller/index_annual/$1';

$route['menu-top-selling-report-annual/(:any)'] = 'Pdf_reports/Pdf_products_report_controller/index_annual_bs/$1';


$route['products-report-monthly/(:any)/(:any)'] = 'Pdf_reports/Pdf_products_report_controller/index_monthly/$1/$2';

$route['packages-report-monthly/(:any)/(:any)'] = 'Pdf_reports/Pdf_packages_report_controller/index_monthly/$1/$2';

$route['menu-top-selling-report-monthly/(:any)/(:any)'] = 'Pdf_reports/Pdf_products_report_controller/index_monthly_bs/$1/$2';


$route['products-report-custom/(:any)/(:any)'] = 'Pdf_reports/Pdf_products_report_controller/index_custom/$1/$2';

$route['packages-report-custom/(:any)/(:any)'] = 'Pdf_reports/Pdf_packages_report_controller/index_custom/$1/$2';

$route['menu-top-selling-report-custom/(:any)/(:any)'] = 'Pdf_reports/Pdf_products_report_controller/index_custom_bs/$1/$2';



// users ----------------------------------------------
$route['users-report-type/(:any)'] = 'Pdf_reports/Pdf_users_report_controller/index/$1';

$route['users-report-type-annual/(:any)/(:any)'] = 'Pdf_reports/Pdf_users_report_controller/index_annual/$1/$2';

$route['users-report-type-monthly/(:any)/(:any)/(:any)'] = 'Pdf_reports/Pdf_users_report_controller/index_monthly/$1/$2/$3';

$route['users-report-type-custom/(:any)/(:any)/(:any)'] = 'Pdf_reports/Pdf_users_report_controller/index_custom/$1/$2/$3';



// trans ----------------------------------------------
$route['transactions-report/(:any)'] = 'Pdf_reports/Pdf_transactions_report_controller/index/$1';

$route['transactions-report-annual/(:any)/(:any)'] = 'Pdf_reports/Pdf_transactions_report_controller/index_annual/$1/$2';

$route['transactions-report-monthly/(:any)/(:any)/(:any)'] = 'Pdf_reports/Pdf_transactions_report_controller/index_monthly/$1/$2/$3';

$route['transactions-report-custom/(:any)/(:any)/(:any)'] = 'Pdf_reports/Pdf_transactions_report_controller/index_custom/$1/$2/$3';


//************************************** HVI ROUTES
//**************************************

$route['profiles-page/dec-tree-page/(:num)'] = 'dec_tree/dec_tree_controller/index/$1';



//************************************** USERS
//**************************************

$route['users-page'] = 'Users/Users_controller/index';

$route['showlist-users'] = 'Users/Users_controller/ajax_list';

$route['showlist-users-api'] = 'Users/Users_controller/ajax_api_list';

$route['edit-user/(:num)'] = 'Users/Users_controller/ajax_edit/$1';

$route['add-user'] = 'Users/Users_controller/ajax_add';

$route['update-user/(:num)'] = 'Users/Users_controller/ajax_update/$1';

$route['edit-privileges/(:num)'] = 'Users/Users_controller/ajax_edit/$1';

$route['update-privileges/(:num)'] = 'Users/Users_controller/ajax_privileges_update/$1';

$route['delete-user/(:num)'] = 'Users/Users_controller/ajax_delete/$1';




//************************************** REPORT
//**************************************
			//** SALES **//
// $route['report/sales-report'] = 'sales_report/sales_report_controller';

// $route['report/sales-report/print-report/(:any)/(:any)'] = 'sales_report/sales_report_controller/ajax_set_report/$1/$2';


			//** INVENTORY **//
// $route['report/inventory-report'] = 'inventory_report/inventory_report_controller';

// $route['report/inventory-report/print-report'] = 'inventory_report/inventory_report_controller/ajax_set_report';

// $route['report/inventory-report/print-report-damaged'] = 'inventory_report/inventory_report_controller/ajax_set_report_damaged';

// $route['report/inventory-report/print-report-borrow'] = 'inventory_report/inventory_report_controller/ajax_set_report_borrow';

// data = [{
//     y: percent_active,
//     color: colors[0],
//     drilldown: {
//         name: 'Active genders',
//         categories: ['Male', 'Female'],
//         data: [((children_active_male / total_children_count) * 100), ((children_active_female / total_children_count) * 100)],
//         color: colors[0]
//     }
// }, {
//     y: percent_graduated,
//     color: colors[1],
//     drilldown: {
//         name: 'Graduated genders',
//         categories: ['Male', 'Female'],
//         data: [((children_graduated_male / total_children_count) * 100), ((children_graduated_female / total_children_count) * 100)],
//         color: colors[1]
//     }
// }],