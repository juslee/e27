<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "startuplist";
$route['404_override'] = 'startuplist/page_not_found';
$route['company/(:any)'] = "startuplist/company/$1";
$route['investment_org/(:any)'] = "startuplist/investment_org/$1";
$route['person/(:any)'] = "startuplist/person/$1";
//temporarily use the search to sort country
$route['country/(:any)'] = "search/all/country:$1";
//$route['country/(:any)'] = "startuplist/country/$1";
$route['c/(:any)'] = "startuplist/setcountry/$1";
$route['l'] = "startuplist/l";
$route['companylist'] = "startuplist/companylist";
$route['companylist'] = "startuplist/companylist";
$route['personlist'] = "startuplist/personlist";
$route['investment_orglist'] = "startuplist/investment_orglist";

$route['searchcountry/(:any)'] = "search/all/country:$1";

$route['category/(:any)/(:any)'] = "search/all/category:$1/$2";
$route['category/(:any)'] = "search/all/category:$1";
$route['login'] = "main";
$route['backend'] = "main";
$route['admin'] = "main";
$route['newlyadded'] = "startuplist/index/newlyadded";
$route['newlyupdated'] = "startuplist/index/newlyupdated";
$route['account'] = "startuplist/account";
$route['account/(:any)'] = "startuplist/account/$1";
$route['editcompany/(:any)'] = "startuplist/editcompany/$1";
$route['addcompany/(:any)'] = "startuplist/addcompany/$1";
$route['editperson/(:any)'] = "startuplist/editperson/$1";
$route['addperson/(:any)'] = "startuplist/addperson/$1";
$route['editinvestment_org/(:any)'] = "startuplist/editinvestment_org/$1";
$route['addinvestment_org/(:any)'] = "startuplist/addinvestment_org/$1";
$route['register'] = "startuplist/register";
$route['userlogin'] = "startuplist/userlogin";
$route['userlogout'] = "startuplist/userlogout";
$route['forgotpass'] = "startuplist/forgotpass";
$route['changepass'] = "startuplist/changepass";
$route['changepass/(:any)'] = "startuplist/changepass/$1";
$route['editaccount'] = "startuplist/editaccount";


/* End of file routes.php */
/* Location: ./application/config/routes.php */