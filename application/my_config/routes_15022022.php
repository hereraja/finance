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
$route['achead/entry'] = 'master/ac_head_add';
$route['purchasevu'] = 'transaction/purchase_appview';
$route['crnvu'] = 'transaction/crn_appview';
$route['advvu'] = 'transaction/adv_appview';
$route['cashVoucher'] = 'transaction/index';
$route['cashVoucher/entry'] = 'transaction/entry';
$route['bankVoucher'] = 'transaction/bank_view';
$route['bankVoucher/entry'] = 'transaction/bank_add';
$route['jurnalVoucher'] = 'transaction/jurnal_view';
$route['jurnalVoucher/entry'] = 'transaction/jurnal_entry';
$route['advjrnlr'] = 'report/advjrnl';
$route['trailbal'] = 'report/trailbal';
$route['gl']       = 'report/gl';
$route['trailbal_group'] = 'report/trailbal_group';
$route['crnjrnlr'] = 'report/crnjrnl';
$route['saljrnlr'] = 'report/salejrnl';
$route['purjrnlr'] = 'report/purjrnl';
$route['mnthend'] = 'transaction/month_end';
$route['user'] = 'admins';
$route['user_add'] = 'admins/user_add';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
