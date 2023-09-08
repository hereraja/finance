<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['group'] = 'master/group';
$route['group/entry'] = 'master/group_add';
$route['group/edit'] = 'master/group_edit';
$route['subgroup'] = 'master/sub_group';
$route['subgroup/entry'] = 'master/sub_group_add';
$route['achead'] = 'master/ac_head';
$route['Master/fetch_my_achead/(:any)'] = 'Master/fetch_my_achead';
$route['achead/entry'] = 'master/ac_head_add';

$route['godown'] = 'Rent_calculation/godown_list';
$route['godown/entry'] = 'Rent_calculation/godown_add';
$route['godown/edit/(:num)'] = 'Rent_calculation/godown_edit/$1';

$route['customer'] = 'Rent_calculation/customer_list';
$route['customer/entry'] = 'Rent_calculation/customer_add';
$route['customer/edit/(:num)'] = 'Rent_calculation/customer_edit/$1';

$route['godownrent/entry'] = 'Rent_calculation/godown_rent_add';
$route['godownrent'] = 'Rent_calculation/godown_rent';
$route['godownrent/edit/(:num)'] = 'Rent_calculation/godown_rent_edit/$1';

$route['rent_collection/entry']='Rent_calculation/rent_collection';
$route['rent_collection']='Rent_calculation/rent_collection_list';
$route['rent_collection/fetch_product']='Rent_calculation/fetch_product'; 
$route['rent_collection/fetch_amount']='Rent_calculation/fetch_amount'; 
$route['rent_collection/edit/(:num)'] = 'Rent_calculation/rent_collection_edit/$1';
$route['rent_collection/fetch_godown'] = 'Rent_calculation/fetch_godown';
$route['rent_collection/fetch_gst'] = 'Rent_calculation/fetch_gst';
$route['collectRent'] = 'Rent_calculation/collectRent';
$route['collectRent/edit/(:num)'] = 'Rent_calculation/collectRentEdit/$1';

$route['rent_report']='Rent_calculation/rent_report';
$route['rentb2c_invoice']='Rent_calculation/rentb2c_rep';

$route['purchasevu'] = 'transaction/purchase_appview';
$route['crnvu'] = 'transaction/crn_appview';
$route['advvu'] = 'transaction/adv_appview';
$route['cashVoucher'] = 'transaction/index';
$route['cashVoucherlst'] = 'transaction/approvedCashvoucher';
$route['bankVoucherlst'] = 'transaction/approvedbankvoucher';
$route['journallst'] = 'transaction/approvedjournal';
$route['ledgcodedtl'] = 'report/ledgercodedtl';
$route['cashVoucher/entry'] = 'transaction/entry';
$route['bankVoucher'] = 'transaction/bank_view';
$route['bankVoucher/entry'] = 'transaction/bank_add';
$route['jurnalVoucher'] = 'transaction/jurnal_view';
$route['jurnalVoucher/entry'] = 'transaction/jurnal_entry';
$route['cheqdtl']   = 'transaction/cheqdtl';
$route['cheqdtladd']   = 'transaction/cheqdtladd';
$route['cheqdtl']   = 'transaction/cheqdtl';
///   ***** Start code for report 
$route['advjrnlr'] = 'report/advjrnl';
$route['trailbal'] = 'report/trailbal';
$route['balsh'] = 'report/balsh';
$route['pl'] = 'report/pl';
$route['consolidated-trailbal'] = 'report/consolidated_trailbal';
$route['consolidated-trailbal-subgroup'] = 'report/consolidated_trailbal_subgroup';
$route['consolidated-trailbal-group'] = 'report/consolidated_trailbal_group';
$route['trailbalsubgroup'] = 'report/trailbalsubgroup';
$route['daybook']  = 'report/daybook';
$route['cashbook']  = 'report/cashbook';
$route['gl']       = 'report/gl';
$route['ac_detail']       = 'report/ac_detail';
$route['trailbal_group'] = 'report/trailbal_group';
$route['crnjrnlr'] = 'report/crnjrnl';
$route['saljrnlr'] = 'report/salejrnl';
$route['purjrnlr'] = 'report/purjrnl';
$route['bankbook']  = 'report/bankbook';
///   ***** End code for report
$route['mnthend'] = 'transaction/month_end';
// $route['user'] = 'admins';
// $route['user_add'] = 'admins/user_add';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//handling $ trandport charges
$route['handling-trandport-charges/customar_entry']='HTransportC/customar_entry';
$route['handling-trandport-charges/customar']='HTransportC';
$route['handling-trandport-charges/customar-edit/(:num)']='HTransportC/customar_edit/$1';


$route['handling-trandport-charges/customar_htc_entry']='HTransportC/customar_htc_entry';
$route['handling-trandport-charges/htc_list']='HTransportC/htc_list';
$route['handling-trandport-charges/htc_edit/(:num)']='HTransportC/htc_edit/$1';


$route['handling-trandport-charges/htc_raise_invoice']='HTransportC/customar_raise_invoice';
$route['handling-trandport-charges/htc_raise_invoice_list']='HTransportC/customar_raise_invoice_list';
$route['handling-trandport-charges/htc_collection_edit/(:any)']='HTransportC/htc_collection_edit/$1';
$route['handling-trandport-charges/rentb2c_rep']='HTransportC/rentb2c_rep';
$route['handling-trandport-charges/rent_report']='HTransportC/rent_report';




$route['user'] = 'admins';
$route['user_add'] = 'admins/user_add';
$route['userlist_admin']='admins/userlist_admin';


// ===================notification======================
$route['notification/send']='Notification/send_notification_ho';
$route['notification']='Notification/notification';
$route['notification/delete/(:num)']='Notification/delete/$1';
$route['notification/edit/(:num)']='Notification/edit/$1';

$route['notification/(:num)']='Notification/branch_notification_view/$1';
$route['notification/view/(:num)']='Notification/notification_view/$1';
$route['notification/count']='Notification/count_notification';
$route['notification/sow10']='Notification/notification_list_10';
$route['notification/my-notification']='Notification/my_notification';
// ===================end notification======================
