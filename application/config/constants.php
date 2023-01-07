<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

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
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

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
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


//******************************* Self Defined COnstants Start *************************************//
define('CV_PLATFORM_DB_NAME','platform_admin_db');
define('CV_REQUEST_SCHEME','https://');
define('CV_PLATFORM_COMPANY_BASE_URL',$_SERVER['ADMIN_PORTAL_BASE_URL']);//'http://compben.awtech.in/admin-portal/');
define('CV_EMAIL_FROM',$_SERVER['EMAIL_FROM']);//'noreply@compben.awtech.in');
define('CV_CONCATENATE_SYNTAX','~~~');// It's used for concatination of 2 values in code
define('CV_DEFAULT_FILE_NAME','Manual');// It's used as defaul file name when admin add staff
define('CV_STATUS_RULE_DELETED', '8');// It's denotes that the rule (Salary/Bonus/LTI/R&r) has been deleted
define('CV_STATUS_RULE_RELEASED', '9');// It's denotes that the rule (Salary/Bonus/LTI) has been deleted
define('CV_STATUS_ACTIVE', 1);
define('CV_RELEASED_LETTER_STATUS', 2);//Finally released letter to emps & updated Increment dtl into login_user tbl
define('CV_CAPTCHA_SITE_KEY', '6Lch180UAAAAAN5IHUpMiCjr_ncrV8I8fst6FooR');//'6LerjW0UAAAAAPrkGma8iPqvUl0uaqdP2G4sADa9'); // Used for google recaptcha
define('CV_CAPTCHA_SECRET_KEY', '6Lch180UAAAAALwSda1xCQcjS3xz1u_-sWiR1-kp');//'6LerjW0UAAAAAGuqbA0k6rDftEV9lEk_P1JZr9q7'); // Used for google recaptcha
define('CV_RESTRICTED_SPECIAL_CHARACTERS', "#^!$*?><'");
define('CV_SALARY_HIKE_ROUND_OFF', 8);
define('CV_DEFAULT_MAX_TENURE', 35);//It is using to show tenure range upto define value
define('CV_HTTP_UNAUTHORIZED', 401);//It will use on Ajax request to check user is logged Out or Not

define('CV_LIGHT_GREEN_BG_COLOR', '#C4FFC4'); // Manager :: Those employee records color which are approved by a level below and submitted to me
define('CV_LIGHT_YELLOW_BG_COLOR', '#FFFFC6'); // Manager :: Those employee records color which are not my direct reportee and not yet approved by respective manager

define('CV_VIEW_RIGHT_NAME','view');
define('CV_INSERT_RIGHT_NAME','insert');
define('CV_UPDATE_RIGHT_NAME','update');
define('CV_DELETE_RIGHT_NAME','delete');

/**************** Start :: User Roles Related constants ***************/
define('CV_ROLE_ADMIN_USER',1); //Admin User's Role
define('CV_ROLE_BUSINESS_UNIT_HEAD',7); //Business Unit Head's Role
/**************** End :: User Roles Related constants ***************/

define('CV_MANAGERS_HIERARCHY_BY_MANUAL', 1);// Manager Hierarchy Build by Manual
define('CV_MANAGERS_HIERARCHY_BY_1ST_MANAGER', 2);// Manager Hierarchy Build by Using 1st Approver
define('CV_MANAGERS_HIERARCHY_BY_INTEGRATION', 3);// Manager Hierarchy Build by API Integration

define('CV_MKT_ELEMENT_ID_FOR_SINGLE_BM', 116);//Default Market Element for Single Benchmark
define('CV_MKT_ELEMENT_ID_FOR_MULTIPLE_BM', 86);//Default Market Element for Multiple Benchmark
define ("CV_BUSINESS_REQUIRED_ACTIVE_INACTIVE_ARRAY", json_encode(array ("2", "3", "35")));
define('CV_BONUS_LABEL_NAME', "Bonus/Incentive");// It is using for name of Bonus rules
define('CV_BONUS_SIP_LABEL_NAME', "Sales Incentive");// It is using for name of Sales Incentive rules

//*** Start - Business Attribute ba_name Basis, Also used in login_user tabl Columns  ***//
define('CV_BA_NAME_EMP_FULL_NAME', 'name');
define('CV_BA_NAME_EMP_EMAIL', 'email');
define('CV_BA_NAME_COUNTRY', 'country');
define('CV_BA_NAME_CITY', 'city');
define('CV_BA_NAME_BUSINESS_LEVEL_1', 'business_level_1');
define('CV_BA_NAME_BUSINESS_LEVEL_2', 'business_level_2');
define('CV_BA_NAME_BUSINESS_LEVEL_3', 'business_level_3');
define('CV_BA_NAME_FUNCTION', 'function');
define('CV_BA_NAME_SUBFUNCTION', 'subfunction');
define('CV_BA_NAME_DESIGNATION', 'designation');
define('CV_BA_NAME_GRADE', 'grade');
define('CV_BA_NAME_LEVEL', 'level');
define('CV_BA_NAME_EDUCATION', 'education');
define('CV_BA_NAME_CRITICAL_TALENT', 'critical_talent');
define('CV_BA_NAME_CRITICAL_POSITION', 'critical_position');
define('CV_BA_NAME_SPECIAL_CATEGORY', 'special_category');
define('CV_BA_NAME_COMPANY_JOINING_DATE', 'company_joining_date');
define('CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE', 'increment_purpose_joining_date');
define('CV_BA_NAME_START_DATE_FOR_ROLE', 'start_date_for_role');
define('CV_BA_NAME_END_DATE_FOR_ROLE', 'end_date_for_role');
define('CV_BA_NAME_BONUS_INCENTIVE_APPLICABLE', 'bonus_incentive_applicable');
define('CV_BA_NAME_RECENTLY_PROMOTED', 'recently_promoted');
define('CV_BA_NAME_RATING_FOR_LAST_YEAR', 'rating_for_last_year');
define('CV_BA_NAME_RATING_FOR_CURRENT_YEAR', 'rating_for_current_year');
define('CV_BA_NAME_SALARY_AFTER_LAST_INCREASE', 'salary_after_last_increase');
define('CV_BA_NAME_EFFECTIVE_DATE_OF_LAST_SALARY_INCREASE', 'effective_date_of_last_salary_increase');
define('CV_BA_NAME_SALARY_AFTER_2ND_LAST_INCREASE', 'salary_after_2nd_last_increase');
define('CV_BA_NAME_EFFECTIVE_DATE_OF_2ND_LAST_SALARY_INCREASE', 'effective_date_of_2nd_last_salary_increase');
define('CV_BA_NAME_SALARY_AFTER_3RD_LAST_INCREASE', 'salary_after_3rd_last_increase');
define('CV_BA_NAME_EFFECTIVE_DATE_OF_3RD_LAST_SALARY_INCREASE', 'effective_date_of_3rd_last_salary_increase');
define('CV_BA_NAME_SALARY_AFTER_4TH_LAST_INCREASE', 'salary_after_4th_last_increase');
define('CV_BA_NAME_EFFECTIVE_DATE_OF_4TH_LAST_SALARY_INCREASE', 'effective_date_of_4th_last_salary_increase');
define('CV_BA_NAME_SALARY_AFTER_5TH_LAST_INCREASE', 'salary_after_5th_last_increase');
define('CV_BA_NAME_EFFECTIVE_DATE_OF_5TH_LAST_SALARY_INCREASE', 'effective_date_of_5th_last_salary_increase');
define('CV_BA_NAME_CURRENCY', 'currency');
define('CV_BA_NAME_CURRENT_BASE_SALARY', 'current_base_salary');
define('CV_BA_NAME_CURRENT_TARGET_BONUS', 'current_target_bonus');
define('CV_BA_NAME_ALLOWANCE_1', 'allowance_1');
define('CV_BA_NAME_ALLOWANCE_2', 'allowance_2');
define('CV_BA_NAME_ALLOWANCE_3', 'allowance_3');
define('CV_BA_NAME_ALLOWANCE_4', 'allowance_4');
define('CV_BA_NAME_ALLOWANCE_5', 'allowance_5');
define('CV_BA_NAME_ALLOWANCE_6', 'allowance_6');
define('CV_BA_NAME_ALLOWANCE_7', 'allowance_7');
define('CV_BA_NAME_ALLOWANCE_8', 'allowance_8');
define('CV_BA_NAME_ALLOWANCE_9', 'allowance_9');
define('CV_BA_NAME_ALLOWANCE_10', 'allowance_10');
define('CV_BA_NAME_TOTAL_COMPENSATION', 'total_compensation');
define('CV_BA_NAME_INCREMENT_APPLIED_ON', 'increment_applied_on');
define('CV_BA_NAME_JOB_CODE', 'job_code');
define('CV_BA_NAME_JOB_NAME', 'job_name');
define('CV_BA_NAME_JOB_LEVEL', 'job_level');
define('CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_MIN', 'market_target_salary_level_min');
define('CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_MIN', 'market_total_salary_level_min');
define('CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_MIN', 'market_base_salary_level_min');
define('CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_1', 'market_target_salary_level_1');
define('CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_1', 'market_total_salary_level_1');
define('CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_1', 'market_base_salary_level_1');
define('CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_2', 'market_target_salary_level_2');
define('CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_2', 'market_total_salary_level_2');
define('CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_2', 'market_base_salary_level_2');
define('CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_3', 'market_target_salary_level_3');
define('CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_3', 'market_total_salary_level_3');
define('CV_BA_NAME_APPROVER_1', 'approver_1');
define('CV_BA_NAME_APPROVER_2', 'approver_2');
define('CV_BA_NAME_APPROVER_3', 'approver_3');
define('CV_BA_NAME_APPROVER_4', 'approver_4');
define('CV_BA_NAME_MANAGER_NAME', 'manager_name');
define('CV_BA_NAME_AUTHORISED_SIGNATORY_FOR_LETTER', 'authorised_signatory_for_letter');
define('CV_BA_NAME_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER', 'authorised_signatorys_title_for_letter');
define('CV_BA_NAME_HR_AUTHORISED_SIGNATORY_FOR_LETTER', 'hr_authorised_signatory_for_letter');
define('CV_BA_NAME_HR_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER', 'hr_authorised_signatorys_title_for_letter');
define('CV_BA_NAME_COMPANY_NAME', 'company_name');
define('CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_3', 'market_base_salary_level_3');
define('CV_BA_NAME_COMPANY_1_BASE_SALARY_MIN', 'company_1_base_salary_min');
define('CV_BA_NAME_COMPANY_1_BASE_SALARY_MAX', 'company_1_base_salary_max');
define('CV_BA_NAME_COMPANY_1_BASE_SALARY_AVERAGE', 'company_1_base_salary_average');
define('CV_BA_NAME_COMPANY_2_BASE_SALARY_MIN', 'company_2_base_salary_min');
define('CV_BA_NAME_COMPANY_2_BASE_SALARY_MAX', 'company_2_base_salary_max');
define('CV_BA_NAME_COMPANY_2_BASE_SALARY_AVERAGE', 'company_2_base_salary_average');
define('CV_BA_NAME_COMPANY_3_BASE_SALARY_MIN', 'company_3_base_salary_min');
define('CV_BA_NAME_COMPANY_3_BASE_SALARY_MAX', 'company_3_base_salary_max');
define('CV_BA_NAME_COMPANY_3_BASE_SALARY_AVERAGE', 'company_3_base_salary_average');
define('CV_BA_NAME_AVERAGE_BASE_SALARY_MIN', 'average_base_salary_min');
define('CV_BA_NAME_AVERAGE_BASE_SALARY_MAX', 'average_base_salary_max');
define('CV_BA_NAME_AVERAGE_BASE_SALARY_AVERAGE', 'average_base_salary_average');
define('CV_BA_NAME_COMPANY_1_TARGET_SALARY_MIN', 'company_1_target_salary_min');
define('CV_BA_NAME_COMPANY_1_TARGET_SALARY_MAX', 'company_1_target_salary_max');
define('CV_BA_NAME_COMPANY_1_TARGET_SALARY_AVERAGE', 'company_1_target_salary_average');
define('CV_BA_NAME_COMPANY_2_TARGET_SALARY_MIN', 'company_2_target_salary_min');
define('CV_BA_NAME_COMPANY_2_TARGET_SALARY_MAX', 'company_2_target_salary_max');
define('CV_BA_NAME_COMPANY_2_TARGET_SALARY_AVERAGE', 'company_2_target_salary_average');
define('CV_BA_NAME_COMPANY_3_TARGET_SALARY_MIN', 'company_3_target_salary_min');
define('CV_BA_NAME_COMPANY_3_TARGET_SALARY_MAX', 'company_3_target_salary_max');
define('CV_BA_NAME_COMPANY_3_TARGET_SALARY_AVERAGE', 'company_3_target_salary_average');
define('CV_BA_NAME_AVERAGE_TARGET_SALARY_MIN', 'average_target_salary_min');
define('CV_BA_NAME_AVERAGE_TARGET_SALARY_MAX', 'average_target_salary_max');
define('CV_BA_NAME_AVERAGE_TARGET_SALARY_AVERAGE', 'average_target_salary_average');
define('CV_BA_NAME_COMPANY_1_TOTAL_SALARY_MIN', 'company_1_total_salary_min');
define('CV_BA_NAME_COMPANY_1_TOTAL_SALARY_MAX', 'company_1_total_salary_max');
define('CV_BA_NAME_COMPANY_1_TOTAL_SALARY_AVERAGE', 'company_1_total_salary_average');
define('CV_BA_NAME_COMPANY_2_TOTAL_SALARY_MIN', 'company_2_total_salary_min');
define('CV_BA_NAME_COMPANY_2_SOTAL_SALARY_MAX', 'company_2_sotal_salary_max');
define('CV_BA_NAME_COMPANY_2_TOTAL_SALARY_AVERAGE', 'company_2_total_salary_average');
define('CV_BA_NAME_COMPANY_3_TOTAL_SALARY_MIN', 'company_3_total_salary_min');
define('CV_BA_NAME_COMPANY_3_TOTAL_SALARY_MAX', 'company_3_total_salary_max');
define('CV_BA_NAME_COMPANY_3_TOTAL_SALARY_AVERAGE', 'company_3_total_salary_average');
define('CV_BA_NAME_AVERAGE_TOTAL_SALARY_MIN', 'average_total_salary_min');
define('CV_BA_NAME_AVERAGE_TOTAL_SALARY_MAX', 'average_total_salary_max');
define('CV_BA_NAME_AVERAGE_TOTAL_SALARY_AVERAGE', 'average_total_salary_average');
define('CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_4', 'market_target_salary_level_4');
define('CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_4', 'market_total_salary_level_4');
define('CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_4', 'market_base_salary_level_4');
define('CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_5', 'market_target_salary_level_5');
define('CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_5', 'market_total_salary_level_5');
define('CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_5', 'market_base_salary_level_5');
define('CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_6', 'market_target_salary_level_6');
define('CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_6', 'market_total_salary_level_6');
define('CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_6', 'market_base_salary_level_6');
define('CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_7', 'market_target_salary_level_7');
define('CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_7', 'market_total_salary_level_7');
define('CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_7', 'market_base_salary_level_7');
define('CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_8', 'market_target_salary_level_8');
define('CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_8', 'market_total_salary_level_8');
define('CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_8', 'market_base_salary_level_8');
define('CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_9', 'market_target_salary_level_9');
define('CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_9', 'market_total_salary_level_9');
define('CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_9', 'market_base_salary_level_9');
/*define('CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_10', 'market_target_salary_level_10');
define('CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_10', 'market_total_salary_level_10');
define('CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_10', 'market_base_salary_level_10');
define('CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_11', 'market_target_salary_level_11');
define('CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_11', 'market_total_salary_level_11');
define('CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_11', 'market_base_salary_level_11');*/
define('CV_BA_NAME_MARKET_TARGET_SALARY_SEVEL_MAX', 'market_target_salary_sevel_max');
define('CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_MAX', 'market_total_salary_level_max');
define('CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_MAX', 'market_base_salary_level_max');


/*define('CV_BA_NAME_MARKET_TCC_BW_LEVEL_MIN', 'market_tcc_bw_level_min');
define('CV_BA_NAME_MARKET_TCC_BW_LEVEL_1', 'market_tcc_bw_level_1');
define('CV_BA_NAME_MARKET_TCC_BW_LEVEL_2', 'market_tcc_bw_level_2');
define('CV_BA_NAME_MARKET_TCC_BW_LEVEL_3', 'market_tcc_bw_level_3');
define('CV_BA_NAME_MARKET_TCC_BW_LEVEL_4', 'market_tcc_bw_level_4');
define('CV_BA_NAME_MARKET_TCC_BW_LEVEL_5', 'market_tcc_bw_level_5');
define('CV_BA_NAME_MARKET_TCC_BW_LEVEL_6', 'market_tcc_bw_level_6');
define('CV_BA_NAME_MARKET_TCC_BW_LEVEL_7', 'market_tcc_bw_level_7');
define('CV_BA_NAME_MARKET_TCC_BW_LEVEL_8', 'market_tcc_bw_level_8');
define('CV_BA_NAME_MARKET_TCC_BW_LEVEL_9', 'market_tcc_bw_level_9');
define('CV_BA_NAME_MARKET_TCC_BW_LEVEL_10', 'market_tcc_bw_level_10');
define('CV_BA_NAME_MARKET_TCC_BW_LEVEL_11', 'market_tcc_bw_level_11');
define('CV_BA_NAME_MARKET_TCC_BW_LEVEL_MAX', 'market_tcc_bw_level_max');*/



define('CV_BA_NAME_GENDER', 'gender');
define('CV_BA_NAME_SUB_SUBFUNCTION', 'sub_subfunction');
define('CV_BA_NAME_PERFORMANCE_ACHIEVEMENT', 'performance_achievement');
define('CV_BA_NAME_ALLOWANCE_11', 'allowance_11');
define('CV_BA_NAME_ALLOWANCE_12', 'allowance_12');
define('CV_BA_NAME_ALLOWANCE_13', 'allowance_13');
define('CV_BA_NAME_ALLOWANCE_14', 'allowance_14');
define('CV_BA_NAME_ALLOWANCE_15', 'allowance_15');
define('CV_BA_NAME_ALLOWANCE_16', 'allowance_16');
define('CV_BA_NAME_ALLOWANCE_17', 'allowance_17');
define('CV_BA_NAME_ALLOWANCE_18', 'allowance_18');
define('CV_BA_NAME_ALLOWANCE_19', 'allowance_19');
define('CV_BA_NAME_ALLOWANCE_20', 'allowance_20');
define('CV_BA_NAME_TEETH_TAIL_RATIO', 'teeth_tail_ratio');
define('CV_BA_NAME_PREVIOUS_TALENT_RATING', 'previous_talent_rating');
define('CV_BA_NAME_PROMOTED_IN_2_YRS', 'promoted_in_2_yrs');
define('CV_BA_NAME_ENGAGEMENT_LEVEL', 'engagement_level');
define('CV_BA_NAME_SUCCESSOR_IDENTIFIED', 'successor_identified');
define('CV_BA_NAME_READYNESS_LEVEL', 'readyness_level');
define('CV_BA_NAME_URBAN_RURAL_CLASSIFICATION', 'urban_rural_classification');
define('CV_BA_NAME_EMPLOYEE_MOVEMENT_INTO_BONUS_PLAN', 'employee_movement_into_bonus_plan');
define('CV_BA_NAME_OTHER_DATA_9', 'other_data_9');
define('CV_BA_NAME_OTHER_DATA_10', 'other_data_10');
define('CV_BA_NAME_OTHER_DATA_11', 'other_data_11');
define('CV_BA_NAME_OTHER_DATA_12', 'other_data_12');
define('CV_BA_NAME_OTHER_DATA_13', 'other_data_13');
define('CV_BA_NAME_OTHER_DATA_14', 'other_data_14');
define('CV_BA_NAME_OTHER_DATA_15', 'other_data_15');
define('CV_BA_NAME_OTHER_DATA_16', 'other_data_16');
define('CV_BA_NAME_OTHER_DATA_17', 'Other_data_17');
define('CV_BA_NAME_OTHER_DATA_18', 'other_data_18');
define('CV_BA_NAME_OTHER_DATA_19', 'other_data_19');
define('CV_BA_NAME_OTHER_DATA_20', 'other_data_20');
define('CV_BA_NAME_EMP_FIRST_NAME', 'first_name');
define('CV_BA_NAME_ALLOWANCE_21', 'allowance_21');
define('CV_BA_NAME_ALLOWANCE_22', 'allowance_22');
define('CV_BA_NAME_ALLOWANCE_23', 'allowance_23');
define('CV_BA_NAME_ALLOWANCE_24', 'allowance_24');
define('CV_BA_NAME_ALLOWANCE_25', 'allowance_25');
define('CV_BA_NAME_ALLOWANCE_26', 'allowance_26');
define('CV_BA_NAME_ALLOWANCE_27', 'allowance_27');
define('CV_BA_NAME_ALLOWANCE_28', 'allowance_28');
define('CV_BA_NAME_ALLOWANCE_29', 'allowance_29');
define('CV_BA_NAME_ALLOWANCE_30', 'allowance_30');
define('CV_BA_NAME_ALLOWANCE_31', 'allowance_31');
define('CV_BA_NAME_ALLOWANCE_32', 'allowance_32');
define('CV_BA_NAME_ALLOWANCE_33', 'allowance_33');
define('CV_BA_NAME_ALLOWANCE_34', 'allowance_34');
define('CV_BA_NAME_ALLOWANCE_35', 'allowance_35');
define('CV_BA_NAME_ALLOWANCE_36', 'allowance_36');
define('CV_BA_NAME_ALLOWANCE_37', 'allowance_37');
define('CV_BA_NAME_ALLOWANCE_38', 'allowance_38');
define('CV_BA_NAME_ALLOWANCE_39', 'allowance_39');
define('CV_BA_NAME_ALLOWANCE_40', 'allowance_40');

define('CV_BA_NAME_TOTAL_SALARY_AFTER_LAST_INCREASE', 'total_salary_after_last_increase');
define('CV_BA_NAME_TOTAL_SALARY_AFTER_2ND_LAST_INCREASE', 'total_salary_after_2nd_last_increase');
define('CV_BA_NAME_TOTAL_SALARY_AFTER_3RD_LAST_INCREASE', 'total_salary_after_3rd_last_increase');
define('CV_BA_NAME_TOTAL_SALARY_AFTER_4TH_LAST_INCREASE', 'total_salary_after_4th_last_increase');
define('CV_BA_NAME_TOTAL_SALARY_AFTER_5TH_LAST_INCREASE', 'total_salary_after_5th_last_increase');
define('CV_BA_NAME_TARGET_SALARY_AFTER_LAST_INCREASE', 'target_salary_after_last_increase');
define('CV_BA_NAME_TARGET_SALARY_AFTER_2ND_LAST_INCREASE', 'target_salary_after_2nd_last_increase');
define('CV_BA_NAME_TARGET_SALARY_AFTER_3RD_LAST_INCREASE', 'target_salary_after_3rd_last_increase');
define('CV_BA_NAME_TARGET_SALARY_AFTER_4TH_LAST_INCREASE', 'target_salary_after_4th_last_increase');
define('CV_BA_NAME_TARGET_SALARY_AFTER_5TH_LAST_INCREASE', 'target_salary_after_5th_last_increase');
define('CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR', 'rating_for_2nd_last_year');
define('CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR', 'rating_for_3rd_last_year');
define('CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR', 'rating_for_4th_last_year');
define('CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR', 'rating_for_5th_last_year');
define('CV_BA_NAME_EMP_CODE', 'employee_code');

define('CV_BA_NAME_COST_CENTER', 'cost_center');
define('CV_BA_NAME_EMPLOYEE_TYPE', 'employee_type');
define('CV_BA_NAME_EMPLOYEE_ROLE', 'employee_role');
//**** END - Business Attribute ba_name Basis, Also used in login_user tabl Columns  ***//


//*********** Page Ids To Manage User Permissions Start ******************//
define('CV_DASHBOARD_ID', 1);
define('CV_PERFORMANCE_CYCLE_ID', 2);
define('CV_UPLOAD_FILES_ID', 3);
define('CV_MAPPING_HEADERS_ID', 4);
define('CV_SALARY_RULES_ID', 54);//2);//5);
define('CV_BONUS_RULES_ID', 55);//2);//6);
define('CV_LTI_RULES_ID', 56);//2);//25);
define('CV_RNR_RULES_ID', 57);//2);//26);
define('CV_STAFF_ID', 9);
define('CV_HR_RIGHTS_ID', 10);
define('CV_INCREMENTS_ID', 11);
define('CV_GENERAL_SETTINGS_ID', 12);
define('CV_REPORTS_ID', 13);

// ID pages by om 23/11/17 start
define('CV_LEVEL_LIST', 72);
define('CV_DESIGNATION_LIST', 14);
define('CV_MANAGE_GRADE', 15);
define('CV_COUNTRY_ID', 16);
define('CV_CITY_ID', 17);
define('CV_MANAGE_BUSINESS_LEVEL_1', 18);
define('CV_MANAGE_BUSINESS_LEVEL_2', 19);
define('CV_MANAGE_BUSINESS_LEVEL_3', 20);
define('CV_MANAGE_FUNCTIONS', 21);
define('CV_MANAGE_SUB_FUNCTIONS', 22);
define('CV_MANAGE_SUB_SUB_FUNCTIONS', 68);
define('CV_ROLE_PERMISSION', 23);
define('CV_BUSINESS_ATTRIBUTES', 24);
// ID pages by om 23/11/17 end
// ID pages by om 12/12/17 start
define('CV_LTI', 25);
define('CV_RANDR', 26);
define('CV_REPORTS', 27);
define('CV_SALARY_REVIEW', 28);
define('CV_BONUS_REVIEW', 29);
define('CV_LTI_REVIEW', 42);
define('CV_RANDR_REVIEW', 43);

define('CV_APPROVE_SALARY', 30);
define('CV_APPROVE_BONUS', 31);
define('CV_APPROVE_LTI', 32);
define('CV_APPROVE_RNR', 33);

define('CV_SALARY_MOVEMENT_CHART', 38);
define('CV_CURRENT_MARKET_POSITIONING_CHART', 39);
define('CV_COMPARISON_WITHPEERS_CHART', 40);
define('CV_COMPARISON_WITH_TEAM_CHART', 41);

define('CV_SURVEY', 44);
define('CV_TOOLTIP', 45);
define('CV_CREATE_TEMPLATE', 46);
define('CV_TREND', 47);
define('CV_CBNETWORK', 48);
define('CV_WORKSHOP', 49);
define('CV_GLOSSARY', 50);
define('CV_FAQ', 51);
define('CV_INTERNAL_CB_NETWORK', 52);
define('CV_CB_POLOCIES', 53);
// ID pages by om 12/12/17 end
// ID pages by om 28/06/2018
define('CV_COMP_SALARY', 54);
define('CV_COMP_BONUS', 55);
define('CV_COMP_LTI', 56);
define('CV_COMP_RNR', 57);

define('CV_PAY_RANGE_ANALYSIS', 58);
define('CV_ALLOCATED_BUDGET', 59);
define('CV_SALAERY_INCREASE_ANALYSIS', 60);
define('CV_SALARY_ANALYSIS_REPORT',61);
define('CV_PAYMIX_REPORT', 62);
define('CV_HEADCOUNT_REPORT', 63);
define('CV_COMPPISITING_REPORT', 64);
define('CV_DB_REPORT', 65);
define('CV_MANAGE_CURRENCY', 66);
define('CV_CURRENCY_RATES', 67);
define('CV_PG_TOTAL_REWARDS_STATEMENT_ID', 71);
//*********** Page Ids To Manage User Permissions End ******************//

//**************** Business Attribute Module Basis Start *****************//
define('CV_CURRENCY', 'currency');
define('CV_EMAIL_MODULE_NAME', 'email');
define('CV_EMPLOYEE_FULL_NAME', 'employee_full_name');
define('CV_COUNTRY', 'country');
define('CV_CITY', 'city');
define('CV_BUSINESS_LEVEL_1', 'business_level_1');
define('CV_BUSINESS_LEVEL_2', 'business_level_2');
define('CV_BUSINESS_LEVEL_3', 'business_level_3');
define('CV_FUNCTION', 'function');
define('CV_SUB_FUNCTION', 'subfunction');
define('CV_SUB_SUB_FUNCTION', 'sub_subfunction');
define('CV_DESIGNATION', 'designation');
define('CV_GRADE', 'grade');
define('CV_LEVEL', 'level');

define('CV_EDUCATION', 'education');
define('CV_CRITICAL_TALENT', 'critical_talent');
define('CV_CRITICAL_POSITION', 'critical_position');
define('CV_SPECIAL_CATEGORY', 'special_category');
define('CV_COMPANY_JOINING_DATE', 'company_joining_date');
define('CV_INCREMENT_PURPOSE_JOINING_DATE', 'increment_purpose_joining_date');


define('CV_RECENTLY_PROMOTED', 'recently_promoted');
define('CV_FIRST_APPROVER', 'first_approver');
define('CV_SECOND_APPROVER', 'second_approver');
define('CV_THIRD_APPROVER', 'third_approver');
define('CV_FOURTH_APPROVER', 'fourth_approver');
define('CV_RATING_ELEMENT', 'rating');
define('CV_INCREMENT_APPLIED_ON','increment_applied_on');
define('CV_SALARY_ELEMENT','salary');
define('CV_MARKET_SALARY_ELEMENT','market_salary');//Market Data For Base Salary
define('CV_MARKET_SALARY_CTC_ELEMENT','market_salary_ctc');//Market Data For CTC
define('CV_PREVIOUS_INCREMENTS','previous_increments');

//define('CV_BUSINESS_LEVELS','business_level');
define('CV_BONUS_APPLIED_ON','bonus_applied_on');
//**************** Business Attribute Module Basis END *****************//

//**************** Business Attribute Id Basis Start *****************//
define('CV_BA_ID_COUNTRY', 3);
define('CV_BA_ID_CITY', 4);
define('CV_BA_ID_EDUCATION', 13);
define('CV_BA_ID_CRITICAL_TALENT', 14);
define('CV_BA_ID_CRITICAL_POSITION', 15);
define('CV_BA_ID_SPECIAL_CATEGORY', 16);
define('CV_BA_ID_COMPANY_JOINING_DATE', 17);

define('CV_BA_ID_RATING_FOR_2ND_LAST_YEAR', 200);
define('CV_BA_ID_RATING_FOR_3RD_LAST_YEAR', 201);
define('CV_BA_ID_RATING_FOR_4TH_LAST_YEAR', 202);
define('CV_BA_ID_RATING_FOR_5TH_LAST_YEAR', 203);

define('CV_EMP_NAME_ID', 1);
define('CV_EMAIL_ID', 2);
//define('CV_BUSINESS_LEVEL_3_ID', 7);
define('CV_BONUS_APPLIED_ON_ID', 37);
define('CV_ALLOWANCE_1_ID', 38);
define('CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID', 18);
define('CV_PERFORMANCE_RATING_FOR_LAST_YEAR_ID', 23);
define('CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID', 24);
define('CV_CURRENCY_ID', 35);
define('CV_FIRST_APPROVER_ID', 64);
define('CV_SECOND_APPROVER_ID', 65);
define('CV_THIRD_APPROVER_ID', 66);
define('CV_FOURTH_APPROVER_ID', 67);

define('CV_BUSINESS_LEVEL_ID_1', 5);
define('CV_BUSINESS_LEVEL_ID_2', 6);
define('CV_BUSINESS_LEVEL_ID_3', 7);
define('CV_FUNCTION_ID', 8);
define('CV_SUB_FUNCTION_ID', 9);
define('CV_SUB_SUB_FUNCTION_ID', 136);
define('CV_PERFOMANCE_ACHIEVEMENT_ID', '137');

define('CV_DESIGNATION_ID', 10);
define('CV_GRADE_ID', 11); 
define('CV_LEVEL_ID', 12);
define('CV_EDUCATION_ID', 13);
define('CV_SALARY_AFTER_LAST_INCREASE_ID', 25);
define('CV_EFFECTIVE_DATE_OF_LAST_SALARY_INCREASE_ID', 26);
define('CV_BA_ID_EFFECTIVE_DATE_OF_2ND_LAST_SALARY_INCREASE', 28);
define('CV_BA_ID_EFFECTIVE_DATE_OF_3RD_LAST_SALARY_INCREASE', 30);
define('CV_BA_ID_EFFECTIVE_DATE_OF_4TH_LAST_SALARY_INCREASE', 32);
define('CV_EFFECTIVE_DATE_OF_5TH_LAST_SALARY_INCREASE_ID', 34);
define('CV_CURRENT_BASE_SALARY_ID', 36);
define('CV_BA_ID_EMPLOYEE_MOVEMENT_INTO_BONUS_PLAN', 155);
define('CV_BA_ID_PROMOTED_IN_2_YRS', 150);

define('CV_BA_ID_START_DATE_FOR_ROLE', 19);
define('CV_BA_ID_END_DATE_FOR_ROLE', 20);

define('CV_BA_ID_COST_CENTER', 204);
define('CV_BA_ID_EMPLOYEE_TYPE', 205);
define('CV_BA_ID_EMPLOYEE_ROLE', 206);
//**************** Business Attribute Id Basis END *****************//

define('CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID', 1);
define('CV_PERFORMANCE_CYCLE_BONUS_TYPE_ID', 2);
define('CV_PERFORMANCE_CYCLE_LTI_TYPE_ID', 3);
define('CV_PERFORMANCE_CYCLE_R_AND_R_TYPE_ID', 4);
define('CV_PERFORMANCE_CYCLE_SALES_ID', 5);

//******************************* Self Defined COnstants End *************************************//

// constent for information pages
define('SALARY_RULE_FILTER', 1);
define('BONUS_RULE', 2);
define('SALARY_RULE', 3);
define('BONUS_RULE_FILTER', 4);

define('CV_MANAGER_CAN_EXCEED_BUDGET', 1);//Used to check manager can exceed Budget, Ranges & Max Hike For Salary Increments
define('CV_MANAGER_CAN_GO_IN_NEGATIVE_BUDGET', 3);//Used to check manager can go into Negative Budget but within range/descritions and as well he can submit his records for next level
define('CV_MANAGER_CAN_EXCEED_BUDGET_AND_SUBMIT', 4);//Used to check manager can go into Negative Budget and can submit his records for next level

//**************** Constents For LTI Page Start *****************//
define('CV_LTI_LINK_WITH_STOCK', 'Stock Value');
define('CV_LTI_LINK_WITH_CASH', 'Cash');
//**************** Constents For LTI Page End *****************//

//**************** Start :: Constents For Salary Rule for Type of Hikes *****************//
define ("CV_SALARY_TOTAL_HIKE", 1);
define ("CV_SALARY_MERIT_HIKE", 2);
define ("CV_SALARY_MARKET_HIKE", 3);
define ("CV_SALARY_PROMOTION_HIKE", 4);
//**************** End :: Constents For Salary Rule for Type of Hikes *****************//

//**************** Constents For Adhoc Start *****************//
define('CV_ADHOC_FULL_TIME', 1);//Means its for full time without any limitations
define('CV_ADHOC_ANNIVERSARY_TIME', 2);//Means its for the anniversary time without any limitations
//**************** Constents For Adhoc End *****************//

//**************** Constent For Tooltip parent drop down start *****//
define ("CV_TOOLTIP_MASTER_ARRAY",
    json_encode(
        array (
            CV_COMP_BONUS,
            "69",
            CV_STAFF_ID,
            "70",
            CV_COMP_LTI,
            "2",
            CV_REPORTS_ID,
            CV_COMP_RNR,
            "23",
            CV_SURVEY,
            CV_COMP_SALARY,
            CV_UPLOAD_FILES_ID
        )
    )
);
//**************** Constent For Tooltip parent drop down end ******//
define('CV_CONFIRMATION_MESSAGE','Are you sure ?');
define('CV_CONFIRMATION_DELETE_MESSAGE','Are you sure, You want to delete ?');
define('CV_CONFIRMATION_REJECT_MESSAGE','Are you sure, You want to reject this request ?');
define('CV_CONFIRMATION_APRROVED_MESSAGE','Are you sure, You want to approve request ?');
define('CV_CONFIRMATION_RELEASED_MESSAGE','Are you sure, You want to release request ?');
//**************** Constent For confirom message *****************//

//**************** Constent For view roles start ******//

define ("CV_VIEW_ROLE_ARRAY", json_encode(array ("3", "4", "5","7","9")));

//**************** Constent For view roles end ******//

//**************** Constent For Xoxoday start ******//

define ("CV_XOXODAY_URL", "http://corp.xoxoday.com/index.php");

//**************** Constent For Xoxoday end ******//

// *************** Constent for survey frequency *****//
define ("CV_FRQ_SURVEY_ARRAY", json_encode(array ("1" => "Survey Start Date", "2" => "Date of Joining")));
define ("CV_SURVEY_TYPE_ONETIME", 1);
define ("CV_SURVEY_TYPE_PERIODIC", 2);
define ("CV_SURVEY_PUBLISHED_TRUE" , 1);


define ("CV_SURVEY_PUBLISHED_TERMS_0" , "Draft");
define ("CV_SURVEY_PUBLISHED_TERMS_1" , "Launch");
define ("CV_SURVEY_PUBLISHED_TERMS_2" , "Freeze");
define ("CV_SURVEY_PUBLISHED_TERMS_3" , "Completed");
//for 3 Dimensional Question
define ("CV_SURVEY_3D_IMPORTANCE" , "-importance");//3 Dimensional Question Option
define ("CV_SURVEY_3D_SATISFACTION" , "-satisfaction");//3 Dimensional Question Option

// Aop component constant
define ("CV_AOP_WAGE_COMPONENT_FIXED_SALARY", 1);
define ("CV_AOP_WAGE_COMPONENT_TOTAL_SALARY", 2);
define ("CV_AOP_WAGE_COMPONENT_FIXED_AMOUNT", 3);
define ("CV_AOP_WAGE_COMPONENT_TOTAL_AMOUNT_ORG", 4);
define ("CV_AOP_WAGE_COMPONENT_LEAVES", 5);

define ("CV_AOP_WAGE_COMPONENT_FIXED_SALARY_NAME", '% age of fixed salary');
define ("CV_AOP_WAGE_COMPONENT_TOTAL_SALARY_NAME", '% age of total salary');
define ("CV_AOP_WAGE_COMPONENT_FIXED_AMOUNT_NAME", 'Fixed Amounts');
define ("CV_AOP_WAGE_COMPONENT_TOTAL_AMOUNT_ORG_NAME", 'Total amount for organization');
define ("CV_AOP_WAGE_COMPONENT_LEAVES_NAME", 'No. of days for leaves');

define ("CV_AOP_WAGE_COMPONENT", json_encode(array (CV_AOP_WAGE_COMPONENT_FIXED_SALARY => CV_AOP_WAGE_COMPONENT_FIXED_SALARY_NAME, CV_AOP_WAGE_COMPONENT_FIXED_AMOUNT => CV_AOP_WAGE_COMPONENT_FIXED_AMOUNT_NAME, CV_AOP_WAGE_COMPONENT_TOTAL_AMOUNT_ORG => CV_AOP_WAGE_COMPONENT_TOTAL_AMOUNT_ORG_NAME, CV_AOP_WAGE_COMPONENT_LEAVES => CV_AOP_WAGE_COMPONENT_LEAVES_NAME)));

define ("CV_AOP_BASE_LEAVE_BASE", 1);
define ("CV_AOP_BASE_LEAVE_TARGET", 2);
define ("CV_AOP_BASE_LEAVE_TOTAL", 3);
define ("CV_AOP_BASED_LEAVE", json_encode(array(CV_AOP_BASE_LEAVE_BASE => 'Base', CV_AOP_BASE_LEAVE_TARGET => 'Target', CV_AOP_BASE_LEAVE_TOTAL => 'Total')));


define ("CV_AIM_ACTION_STATUS_TERMS_1" , "Exceeded Impact");
define ("CV_AIM_ACTION_STATUS_TERMS_2" , "Achieved Impact");
define ("CV_AIM_ACTION_STATUS_TERMS_3" , "partially Achieved Impact");
define ("CV_AIM_ACTION_STATUS_TERMS_4" , "Impact not Achieved");

define ("CV_TAKE_AVERAGE_SALARY_OF", json_encode(array('1' => 'Active Employee', '2' => 'Active+Employees serving notice period.')));

define ("CV_HEAD_COUNT_TYPE_NUMBER", 1);
define ("CV_HEAD_COUNT_TYPE_COST", 2);
define ("CV_AOP_WORKING_DAYS", 28);

define ("CV_WAGE_FREQUENCY_YEAR", 1);
define ("CV_WAGE_FREQUENCY_MONTH", 2);
define ("CV_WAGE_FREQUENCY",json_encode(array(CV_WAGE_FREQUENCY_YEAR => 'Annual', CV_WAGE_FREQUENCY_MONTH => 'Monthly')));
define("CV_Max_Tenure_Value", 1000);

/////Template table name////

define("CV_TEMPLATE_TABLE_COMPENSATION", "compensation_table");
define("CV_TEMPLATE_TABLE_INCREMENT_BREAKUP", "increment_breakup_table");
define("CV_TEMPLATE_TABLE_INCENTIVE", "incentive_table");
define("CV_TEMPLATE_TABLE_BASIC_INFO", "basic_info_table");

define("CV_TEMPLATE_TABLE_RATING_CONTENT", "rating_content");
define("CV_TEMPLATE_TOTAL_INCENTIVE_EARNED", "total_incentive_earned");
define("CV_TEMPLATE_TABLE_FINAL_SALARY_WITH_PREVIOUS_YEAR", "final_salary_table_with_previous_year");
define("CV_TEMPLATE_TABLE_FINAL_SALARY_ONLY_CURRENT_YEAR", "final_salary_table_only_current_year");

########### Define Key For Email Template (Define By Kingjuliean) ##########

define("SALARY_RULE_APPROVE","salaryRuleApprove");
define("NEW_EMPLOYEEE","newEmployee");
define("SALARY_RULE_APPROVE_REMINDER","salaryRuleApproveReminder");
define("SALARY_RULE_NEXT_LEVEL_APPROVER","salaryRuleNextLevelApprove");
define("NEW_SALARY_RULE_RELESED_EMPLOYEE","newSalaryRuleRelesedEmployee");
define("NEW_SALARY_RULE_RELESED_MANAGER","newSalaryRuleRelesedManager");

############################################################################

############################################ define default smtp details for send email##################################################
define('SMTP_HOST', 'smtp.sendgrid.net');
define('SMTP_PORT', 587);
define('SMTP_USER', 'apikey');
define('SMTP_PASSWORD', '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');
define('SMTP_CONNECTION', 'TLS');
define('FROM_EMAIL', 'info@compport.com');
define('FROM_NAME', 'Compport');
define('BLANK_TEXT_FIELD_LETTER','---');
define('BLANK_DATE_FIELD_LETTER','---');
define('COMPANY_ADDRESS_FOR_LETTER','<p style="text-align:center">Designed and Developed by Compport IT Solutions, UAE  All Rights Reserved.</p>
<p style="text-align:center">Designed and Developed by Compport IT Solutions, UAE  All Rights Reserved.</p>
<p style="text-align:center">Designed and Developed by Compport IT Solutions, UAE  All Rights Reserved.</p>');
############################################################



define('CV_SURVEY_COMPANY_ID', 56);//Defined only for running a survey for a particular company
//Defined constant CV_PROMOTION_RELATED_COLUMNS_ARRAY to hold column names related to promotion for increment list 
define ("CV_PROMOTION_RELATED_COLUMNS_ARRAY", "'position_pay_range_after_promotion', 'promotion_recommandetion', 'sp_increased_salary', 'sp_manager_discretions', 'promotion_comment', 'market_salary_after_promotion', 'new_grade', 'new_designation', 'new_level'");

// ******* Start :: RSU Related Constants ******* 
define ("CV_RSU_ENABLED_FOR_DOMAINS_ARRAY", "freshworks.com,freshworks.test");
define('CV_RSU_DIVISION_VALUE', 133.02);
define('CV_RSU_ROUND_OFF', -2);
// ******* End :: RSU Related Constants ******* 

