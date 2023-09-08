<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define("GROUP_TYPE", serialize(array(
    "1" => "Liabilites",
    "2" => "Asset",
    "3" => "Revenue",
    "4" => "Expense"
)));

// ACCOUNTING YEAR CALCULATION SUBHAM

define('END_ACC_DM', '0331');
$current_year = date('Y') - 1;
$previous_year = date('Y') - 2;
$next_year = date('Y');
if (date('Ymd') > date('Y') . END_ACC_DM) {
    $current_year += 1;
    $previous_year += 1;
    $next_year += 1;
}
define('CURRENT_YEAR', $current_year);
define('PREVIOUS_YEAR', $previous_year);
define('NEXT_YEAR', $next_year);

if(date('m') >= 4) 
	{
		$d = date('Y-m-d', strtotime('+1 years'));
		$session_year =  date('Y') .'-'.date('y', strtotime($d));
		$start_fyear = date('Y').'-04-01';
		$end_fyear   = date('Y', strtotime($d)).'-03-31';
						
	}else {
		
		$d = date('Y-m-d', strtotime('-1 years'));
		$session_year = date('Y', strtotime($d)).'-'.date('y');
		$start_fyear= date('Y', strtotime($d)).'-04-01';
		$end_fyear  = date('Y').'-03-31';
	} 
defined('SESSION_YEAR')  OR define('SESSION_YEAR', $session_year); // SESSION YEAR
defined('START_SESSION_YEAR')  OR define('START_SESSION_YEAR', $start_fyear); // START SESSION YEAR	
defined('END_SESSION_YEAR')  OR define('END_SESSION_YEAR', $end_fyear); // END SESSION YEAR 


// define('SALLERGSTIN', '29AAFCD5862R000');
define('SALLERGSTIN', '19AABAT0010H2ZY');
// define('SALLERPIN', '560007');
define('SALLERPIN', '700107');
// define('SALLERSTCD', '29');
define('SALLERSTCD', '19');
define('SALLERPH', '9000000000');
define('SALLEREM', 'abc@gmail.com');
define('CURRDT', date('d/m/Y'));
// define('AUTHKOKEN', '1.d88fc2d8-64eb-40a2-96f0-16f6e7cdd286_8d583da35687c440a8ebb2f67591923df276a8b9df462fc6eb0b033c51fbe385');
define('AUTHKOKEN', '1.249874fd-e3cd-402c-a503-b0a47cb0711f_3d64af076bfe30480c2e74d59d4d5017d2fd57d429bc3364908b5f0ae91a7a51');
// define('OWNERID', '0411ffd4-270a-4a78-96ef-738504f31327');
//define('OWNERID', 'd5c19ef6-b179-45a9-b661-f15c507a1aa9');//FOR SANDBOX TESTING
  define('OWNERID', 'fded77f8-4880-4dc6-8b6c-9d23f3374517');//FOR PRODUCTION SERVER
define('PRODUCT', 'EInvoice');

define('LG_LNM', 'The West Bengal State Co-operative Marketing Federation Ltd.');
define('TRQ_NM', 'BENFED');

define('TAX_SCH', 'GST');
define('SupTyp', 'B2B');
define('Typ', 'INV');
define('Version', '1.1');