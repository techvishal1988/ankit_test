<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
$route['default_controller'] = 'home';
$route['404_override'] = 'mycustom404ctrl';
$route['translate_uri_dashes'] = FALSE;

//require_once 'aop_routes.php';// AOP Routes

$route['no-rights'] = 'dashboard/no_rights';
$route['logout'] = 'home/logout';
$route['login'] = 'home/index';
$route['verify-account/(:any)/(:any)'] = 'home/verify_account/$1/$2';
$route['forgot-password'] = 'home/forgot_password';
$route['reset-password'] = 'home/reset_password';
$route['change-password'] = 'dashboard/change_password';
$route['sso-process-login/(:any)/(:any)/(:any)'] = 'home/sso_process_login/$1/$2/$3';

//************************* Route for unblock blocked account *************//
$route['unblock/(:any)/(:any)'] = 'home/account_unblock/$1/$2';
$route['reset-token/(:any)'] = 'home/send_resendemail/$1';
//************************ Manager routes Goes Here Start ***************** //
//$route['manager/dashboard'] = 'manager/dashboard';
$route['manager/profile'] = 'manager/dashboard/profile';
$route['manager/view-manager-employees'] = 'manager/dashboard/view_manager_emps';
$route['manager/myteam'] = 'manager/dashboard/myteam';
//$route['manager/team-graph'] = 'manager/dashboard/empgraph';
$route['manager/team-graph'] = 'manager/dashboard/manager_team_view';
$route['manager/staff-detail/(:num)'] = 'manager/dashboard/view_emplyoee_details/$1';
$route['manager/managers-list-to-recommend-salary/(:num)/?(:num)?']='manager/dashboard/managers_list_to_recommend_salary/$1/$2';
$route['manager/view-increments-list/(:num)'] = 'manager/dashboard/view_increments_list/$1';
$route['manager/view-increments-bonus-list/(:num)'] = 'manager/dashboard/view_increments_bonus_list/$1';
$route['manager/send-bonus-for-next-level/(:num)']='manager/dashboard/send_bonus_for_next_level/$1';
$route['manager/view-employee-increments/(:num)/(:num)'] = 'manager/dashboard/view_employee_increments/$1/$2';
$route['manager/team-graph/(:num)/(:num)/(:num)'] = 'manager/dashboard/view_employee_increments_team_graph/$1/$2/$3';
$route['manager/view-employee-bonus-increments/(:num)/(:num)'] = 'manager/dashboard/view_emp_bonus_increment_dtls/$1/$2';
$route['manager/view-employee-bonus-increments-released/(:num)/(:num)'] = 'manager/dashboard/view_emp_bonus_increment_dtls_released/$1/$2';
$route['manager/send-for-next-level/(:num)']='manager/dashboard/send_for_next_level/$1';
$route['manager/update-promotions/(:num)'] = 'manager/dashboard/update_emp_promotions_dtls/$1';

$route['hr/update-promotions/(:num)'] = 'increments/update_emp_promotions_dtls/$1';

$route['manager/view-emp-list-for-rnr'] = 'manager/dashboard/view_emp_list_for_rnr';
$route['manager/propose-for-rnr/(:num)'] = 'manager/dashboard/propose_for_rnr/$1';

// $route['manager/view-emp-list-for-lti/(:num)'] = 'manager/dashboard/view_emp_list_for_lti/$1'; CB:Ravi-20-11-2018
$route['manager/view-employee-lti-dtls/(:num)/(:num)'] = 'manager/dashboard/view_emp_lti_dtls/$1/$2';
$route['manager/view-employee-lti-dtls-released/(:num)/(:num)'] = 'manager/dashboard/view_emp_lti_dtls_released/$1/$2';
$route['manager/send-lti-for-next-level/(:num)'] = 'manager/dashboard/send_lti_for_next_level/$1';
$route['manager/download-rule-emp-list/(:num)'] = 'manager/dashboard/download_rule_emp_list/$1';

// routes by omkar
$route['manager/comingsoon-report'] = 'manager/dashboard/comingsoonreport';
$route['manager/comingsoon-lti'] = 'manager/dashboard/comingsoonlti';
$route['manager/comingsoon-randr'] = 'manager/dashboard/comingsoonrandr';
$route['manager/self'] = 'manager/dashboard/self_view';
//************************ Manager routes Goes Here Start ***************** //


//************************ Admin routes Goes Here Start ***************** //
$route['staff'] = 'admin/admin_dashboard';
$route['add-staff'] = 'admin/admin_dashboard/add_staff';
$route['add-hr/?(:num)?'] = 'admin/admin_dashboard/add_hr/$1';
$route['delete-role/(:num)/(:num)'] = 'admin/admin_dashboard/delete_role/$1/$2';
$route['staff-detail/(:num)'] = 'admin/admin_dashboard/view_emplyoee_details/$1';
$route['view-emoloye/(:num)'] = 'admin/admin_dashboard/view_emoloye/$1';
$route['view-employee/(:num)'] = 'admin/admin_dashboard/view_emoloye/$1';
$route['change-employee-status/(:num)/(:num)/(:any)'] = 'admin/admin_dashboard/change_employee_status/$1/$2/$3';
$route['edit-employee/(:num)'] = 'admin/admin_dashboard/edit_employee/$1';
$route['delete-employee/(:num)/(:any)'] = 'admin/admin_dashboard/delete_employee/$1/$2';
$route['hr-list'] = 'admin/user_management/view_user_right_details';//'admin/admin_dashboard/hr_list';
$route['country'] = 'admin/admin_dashboard/country_list';
$route['country/(:num)'] = 'admin/admin_dashboard/country_list/$1';
$route['business-attributes'] = 'admin/business_attributes/business_attributes_list';
$route['update-business-attributes'] = 'admin/business_attributes/update_attributes_status';
//$route['add-business-attributes'] = 'admin/business_attributes/add_business_attributes';
//$route['edit-business-attributes/(:num)'] = 'admin/business_attributes/add_business_attributes/$1';
//$route['change-business-attributes-status/(:num)/(:num)'] = 'admin/business_attributes/change_business_attributes_status/$1/$2';
//$route['change-business-attributes-required/(:num)/(:num)'] = 'admin/business_attributes/change_business_attributes_required/$1/$2';
$route['export-business-attributes'] = 'admin/business_attributes/export_business_attributes';
$route['designation'] = 'admin/admin_dashboard/designation_list';
$route['designation/(:num)'] = 'admin/admin_dashboard/designation_list/$1';
$route['manage-grade'] = 'admin/admin_dashboard/manage_grade';
$route['manage-grade/(:num)'] = 'admin/admin_dashboard/manage_grade/$1';
$route['manage-level'] = 'admin/admin_dashboard/manage_level';
$route['manage-level/(:num)'] = 'admin/admin_dashboard/manage_level/$1';
$route['manage-city'] = 'admin/admin_dashboard/manage_city';
$route['manage-city/(:num)'] = 'admin/admin_dashboard/manage_city/$1';

$route['upload-city-data'] = 'admin/admin_dashboard/upload_city_data';
$route['download-city-sample-file'] = 'admin/admin_dashboard/download_city_sample_file';

$route['manage-business-level-1'] = 'admin/admin_dashboard/manage_business_level1';
$route['manage-business-level-1/(:num)'] = 'admin/admin_dashboard/manage_business_level1/$1';
$route['manage-business-level-2'] = 'admin/admin_dashboard/manage_business_level2';
$route['manage-business-level-2/(:num)'] = 'admin/admin_dashboard/manage_business_level2/$1';
$route['manage-business-level-3'] = 'admin/admin_dashboard/manage_business_level3';
$route['manage-business-level-3/(:num)'] = 'admin/admin_dashboard/manage_business_level3/$1';
$route['manage-functions'] = 'admin/admin_dashboard/manage_functions';
$route['manage-functions/(:num)'] = 'admin/admin_dashboard/manage_functions/$1';
$route['manage-sub-functions'] = 'admin/admin_dashboard/manage_sub_functions';
$route['manage-sub-functions/(:num)'] = 'admin/admin_dashboard/manage_sub_functions/$1';
$route['manage-sub-subfunctions/?(:num)?'] = 'admin/admin_dashboard/manage_sub_subfunctions/$1';
$route['manage-ratings/?(:num)?'] = 'admin/admin_dashboard/manage_ratings/$1';
$route['manage-currency/?(:num)?'] = 'admin/admin_dashboard/manage_currency/$1';
$route['currency-rates'] = 'admin/admin_dashboard/currency_rates';
$route['edit-company-info'] = 'admin/admin_dashboard/edit_company_info';
/*************************** User Rights Start *******************************/
$route['set-user-rights/(:num)'] = 'admin/user_management/set_user_rights/$1';
//$route['rights-approval/(:num)'] = 'admin/user_management/rights_approval/$1';
$route['view-user-right-details/(:num)'] = 'admin/user_management/view_user_right_details/$1';
$route['view-user-right-details'] = 'admin/user_management/view_user_right_details';
$route['employee-not-in-hr-criteria/(:num)'] = 'admin/user_management/employee_not_in_hr_criteria/$1';
$route['view-role-permissions/(:num)'] = 'admin/user_management/view_role_permissions/$1';
$route['view-roles'] = 'admin/user_management/view_roles';
/*************************** User Rights Start *******************************/

//By Rahul
$route['download-salary-structure/(:num)/(:num)'] = 'admin/admin_dashboard/download_salary_structure/$1/$2';
$route['download-salary-structure/(:num)/(:num)/(:num)'] = 'admin/admin_dashboard/download_salary_structure/$1/$2/$3';
$route['admin/template/delete-template/(:num)'] = 'admin/template/delete_template/$1';
$route['email-filter/?(:num)?'] = 'upload/email_filter/$1';
$route['get-email-template'] = 'upload/getEmailTemplate';
$route['download-flexi-data/(:num)/(:num)/?(:num)?'] = 'admin/admin_dashboard/download_flexi_data/$1/$2/$3';

// $route['download-salary-structure/(:num)/(:num)'] = 'admin/admin_dashboard/download_salary_structure/$1/$2';
// $route['download-salary-structure/(:num)/(:num)/(:num)'] = 'admin/admin_dashboard/download_salary_structure/$1/$2/$3';
//By Omkar
$route['staffexport'] = 'admin/admin_dashboard/staffexport';
$route['ajaxemplist'] = 'admin/admin_dashboard/ajaxemplist';
// routes by omkar
$route['admin/comingsoon-lti'] = 'admin/admin_dashboard/comingsoonlti';
$route['admin/comingsoon-randr'] = 'admin/admin_dashboard/comingsoonrandr';
$route['admin/comingsoon-report'] = 'admin/admin_dashboard/comingsoonreport';

$route['configure-promotion-upgrade-data'] = 'admin/admin_dashboard/configure_promotion_upgrade_data';
$route['download-promotion-upgrade-data']='admin/admin_dashboard/download_promotion_upgrade_data_format_file';
$route['download-promotion-upgrade-error-file']='admin/admin_dashboard/download_promotion_upgrade_error_file';
//************************ Admin routes Goes Here End ***************** //


$route['view-profile'] = 'dashboard/profile';
$route['set-proxy'] = 'dashboard/set_proxy';
$route['reset-proxy'] = 'dashboard/reset_proxy';
$route['performance-cycle/?(:num)?/?(:num)?'] = 'performance_cycle/index/$1/$2';
$route['salary-rule-list/(:num)'] = 'performance_cycle/salary_rule_list/$1';
$route['salary-rule-comparisons/(:any)/(:any)'] = 'rules/salary_rule_comparisons/$1/$2';
$route['bonus-rule-list/(:num)'] = 'performance_cycle/bonus_rule_list/$1';
$route['sent_email_approvers/(:num)'] = 'performance_cycle/sentEmailToApprovers/$1';
$route['sentEmailBonusToApprove/(:num)'] = 'performance_cycle/sentEmailBonusToApprove/$1';
$route['reminderEmailBonusToApprovers/(:num)'] = 'performance_cycle/reminderEmailBonusToApprovers/$1';
$route['reminder_email_approvers/(:num)'] = 'performance_cycle/reminderEmailToApprovers/$1';
$route['sentEmailLtiToApprove/(:num)'] = 'performance_cycle/sentEmailLtiToApprove/$1';
$route['reminderEmailLtiToApprovers/(:num)'] = 'performance_cycle/reminderEmailLtiToApprovers/$1';
$route['sentEmailrnrToApprove/(:num)'] = 'performance_cycle/sentEmailrnrToApprove/$1';
$route['reminderEmailrnrToApprovers/(:num)'] = 'performance_cycle/reminderEmailrnrToApprovers/$1';

//$route['download-sample'] = 'upload/download_sample';
$route['download-sample/(:any)'] = 'upload/download_sample/$1';
//$route['upload-data'] = 'upload';
$route['upload-data'] = 'upload/index/bulk_upload';
$route['bulk-delete'] = 'upload/index/bulk_delete';
$route['bulk-active'] = 'upload/index/bulk_active';
$route['bulk-inactive'] = 'upload/index/bulk_inactive';
$route['bulk-upload'] = 'upload/index/bulk_upload';

$route['sent_email_new_employee/(:num)/(:num)'] = 'upload/sentEmailNewEmployee/$1/$2';
$route['mapping-head/(:num)'] = 'upload/mapping_headers/$1';
$route['saved-salary-mappings/(:num)'] = 'upload/savedMappings/$1';
//$route['show-uploaded-data/(:num)'] = 'upload/show_uploaded_data/$1';
$route['update-approvel/(:num)'] = 'approvel/update_approvel_req/$1';

$route['salary-rule-filters/(:num)/?(:num)?'] = 'rules/salary_rule_filters/$1/$2';
$route['create-salary-rules/(:num)'] = 'rules/create_rules/$1';
$route['emp-list-not-in-cycle/(:num)/(:num)'] = 'rules/emp_not_any_cycle/$1/$2';
$route['view-salary-rule-details/(:num)'] = 'rules/view_salary_rule_details/$1';
$route['view-rule-budget/(:num)'] = 'rules/view_rule_budget/$1';
$route['send-rule-for-approval/(:num)/?(:num)?/(:num)'] = 'rules/send_rule_approval_request/$1/$2/$3';
$route['view-increments/(:num)'] = 'increments/view_increments/$1';

/*************** Start :: Dummy urls for testing **************/
$route['view-increments-ravij/(:num)'] = 'increments/view_increments_ravij/$1';
$route['manager/managers-list-to-recommend-salary-ravij/(:num)/?(:num)?']='manager/dashboard/managers_list_to_recommend_salary_ravij/$1/$2';
/*************** End :: Dummy urls for testing **************/

$route['view-employee-increments/(:num)/(:num)'] = 'increments/view_employee_increment_dtls/$1/$2';
$route['delete-salary-rule/(:num)'] = 'rules/delete_salary_rule/$1';
$route['salary-rule-approval-request-list'] = 'approvel/salary_rule_approval_request_list';
$route['update-salary-rule-approvel/(:num)'] = 'approvel/update_salary_rule_approvel_req/$1';
$route['reject-salary-rule-approval-request/(:num)'] = 'approvel/reject_salary_rule_approvel_req/$1';
$route['reopen-salary-rule/(:num)'] = 'rules/refresh_status_change_to_reopen_salary_rule/$1';

$route['bonus-rule-filters/(:num)/?(:num)?'] = 'Bonus/bonus_rule_filters/$1/$2';
$route['create-bonus-rule/(:num)'] = 'Bonus/createBonusRules/$1';
$route['save-bonus/(:num)/(:num)'] = 'Bonus/saveBonusRules/$1/$2';
$route['view-bonus-rule-budget/(:num)'] = 'Bonus/view_bonus_budget/$1';
$route['view-bonus-rule-details/(:num)'] = 'Bonus/view_bonus_rule_details/$1';
$route['send-bonus-rule-for-approval/(:num)/?(:num)?'] = 'Bonus/send_bonus_rule_approval_request/$1/$2';
$route['view-bonus-increments/(:num)'] = 'increments/view_bonus_increments/$1';
$route['view-employee-bonus-increments/(:num)/(:num)'] = 'increments/view_employee_bonus_increment_dtls/$1/$2';
$route['delete-bonus-rule/(:num)'] = 'Bonus/delete_bonus_rule/$1';
$route['update-bonus-rule-approvel/(:num)'] = 'approvel/update_bonus_rule_approvel_req/$1';
$route['reject-bonus-rule-approval-request/(:num)'] = 'approvel/reject_bonus_rule_approvel_req/$1';

// related to SIP
$route['sip-rule-list/(:num)'] = 'performance_cycle/sip_rule_list/$1';
$route['sip-rule-filters/(:num)/?(:num)?'] = 'Sip/sip_rule_filters/$1/$2';
$route['create-sip-rule/(:num)'] = 'Sip/createSipRules/$1';
$route['save-sip/(:num)/(:num)'] = 'Sip/saveSipRules/$1/$2';
$route['view-sip-rule-budget/(:num)'] = 'Sip/view_sip_budget/$1';
$route['view-sip-rule-details/(:num)'] = 'Sip/view_sip_rule_details/$1';
$route['send-sip-rule-for-approval/(:num)/?(:num)?'] = 'Sip/send_sip_rule_approval_request/$1/$2';
$route['view-sip-increments/(:num)'] = 'increments/view_sip_increments/$1';
$route['view-employee-sip-dtls/(:num)/(:num)'] = 'increments/view_employee_sip_dtls/$1/$2';
$route['manager/view-employee-sip-dtls/(:num)/(:num)'] = 'manager/dashboard/view_employee_sip_dtls/$1/$2';

$route['delete-sip-rule/(:num)'] = 'Sip/delete_sip_rule/$1';
$route['update-sip-rule-approvel/(:num)'] = 'approvel/update_sip_rule_approvel_req/$1';
$route['reject-sip-rule-approval-request/(:num)'] = 'approvel/reject_sip_rule_approvel_req/$1';

//************************ Employee routes Goes Here Start ***************** //
$route['employee/dashboard'] = 'employee/dashboard';
$route['employee/recomend-salary-increase'] = 'employee/dashboard/view_employee_salary_increments';
// routes by omkar
$route['employee/comingsoon-lti'] = 'employee/dashboard/comingsoonlti';
$route['employee/comingsoon-randr'] = 'employee/dashboard/comingsoonrandr';
$route['employee/view-emp-lti-dtls'] = 'employee/dashboard/view_emp_lti_dtls';
$route['employee/view-emp-rnr-dtls'] = 'employee/dashboard/view_emp_rnr_dtls';
$route['employee/view-letter/(:any)/?(:any)?'] = 'admin/template/view_letter/$1/$2';
$route['employee/view-bonus-letter/(:num)/(:num)'] = 'admin/template/view_letter_bonus/$1/$2';
$route['employee/dashboard/total-rewards-statment'] = 'employee/dashboard/donutgraph';
$route['employee/view-profile'] = 'employee/dashboard/view_profile';
//************************ Employee routes Goes Here End ***************** //


$route['lti-rule-list/(:num)'] = 'performance_cycle/lti_rule_list/$1';
$route['lti-rule-filters/(:num)/?(:num)?'] = 'lti_rule/lti_rule_filters/$1/$2';
$route['create-lti-rules/(:num)'] = 'lti_rule/create_lti_rules/$1';
$route['lti-emp-list-not-in-cycle/(:num)/(:num)'] = 'lti_rule/emp_not_any_cycle/$1/$2';
$route['save-lti-rule/(:num)/(:num)'] = 'lti_rule/save_lti_rule/$1/$2';
$route['view-lti-rule-budget/(:num)'] = 'lti_rule/view_lti_rule_budget/$1';
$route['send-lti-rule-for-approval/(:num)/?(:num)?'] = 'lti_rule/send_lti_rule_approval_request/$1/$2';
$route['view-lti-rule-details/(:num)'] = 'lti_rule/view_lti_rule_details/$1';
$route['delete-lti-rule/(:num)'] = 'lti_rule/delete_lti_rule/$1';
$route['update-lti-rule-approvel/(:num)'] = 'approvel/update_lti_rule_approvel_req/$1';
$route['reject-lti-rule-approval-request/(:num)'] = 'approvel/reject_lti_rule_approvel_req/$1';
$route['view-lti-incentive-list/(:num)'] = 'increments/view_lti_incentive_list/$1';
$route['view-employee-lti-dtls/(:num)/(:num)'] = 'increments/view_emp_lti_dtls/$1/$2';
$route['edit-lti-stock-values/(:num)'] = 'lti_rule/edit_lti_stock_value_of_vestings/$1';

$route['rnr-rule-list/(:num)'] = 'performance_cycle/rnr_rule_list/$1';
$route['rnr-rule-filters/(:num)/?(:num)?'] = 'rnr_rule/rnr_rule_filters/$1/$2';
$route['create-rnr-rules/(:num)'] = 'rnr_rule/create_rnr_rules/$1';
$route['save-rnr-rule/(:num)'] = 'rnr_rule/save_rnr_rule/$1';
$route['view-rnr-rule-details/(:num)'] = 'rnr_rule/view_rnr_rule_details/$1';
$route['delete-rnr-rule/(:num)'] = 'rnr_rule/delete_rnr_rule/$1';
$route['reject-rnr-rule-approval-request/(:num)'] = 'approvel/reject_rnr_rule_approvel_req/$1';
$route['update-rnr-rule-approvel/(:num)'] = 'approvel/update_rnr_rule_approvel_req/$1';
$route['employee-not-in-any-rule/(:num)'] = 'performance_cycle/notinrule/$1';
$route['bonus/emp-list-not-in-cycle/(:num)/(:num)'] = 'bonus/emp_not_any_cycle/$1/$2';
$route['bonus/employee-not-in-any-rule/(:num)'] = 'performance_cycle/bonusnotinrule/$1';


$route['propose-for-recognized-rnr'] = 'dashboard/propose_rnr_to_anyone';

//******* Xoxoday Url *************//
$route['xoxoday'] = 'xoxoday';
$route['xoxoday/voucher-booking'] = 'xoxoday/VoucherBooking';

//******* Survey Url *************//
$route['survey/dashboard-analytics/?(:any)?/?(:num)?'] = 'survey/dashboard_analytics/$1/$2';
$route['ready-to-launch-survey'] = 'survey/ready_to_launch_survey';
$route['survey/get-category-survey'] = 'survey/get_category_info';
$route['survey/show-admin-survey'] = 'survey/show_admin_survey';
$route['survey/show-company-survey'] = 'survey/show_company_survey';
$route['survey/copy-admin-exists-survey'] = 'survey/copy_admin_exists_survey';
$route['survey/copy-company-exists-survey'] = 'survey/copy_company_exists_survey';
$route['survey/get-exists-category-survey'] = 'survey/get_exists_category_info';
$route['survey/7-rs'] = 'survey/sevenrs';
$route['survey/aim-zone'] = 'survey/aimzone';
$route['survey/aim-zone-details/?(:any)?/?(:num)?'] = 'survey/aimzone_details/$1/$2';
$route['survey/create/?(:any)?/?(:num)?'] = 'survey/create/$1/$2';
$route['survey/get-users-for-aim'] = 'survey/get_users_for_aim';
$route['survey/aim-zone-delete'] = 'survey/aimzone_delete';
//******* Survey User Url *************//
$route['survey/userend'] = 'survey/survey_user_end';
$route['survey/users'] = 'survey/getUsers';
$route['survey/user-survey-questions/?(:num)?'] = 'survey/user_survey_questions/$1';

$route['survey/welcome/(:num)'] = 'survey/survey_welcome_message/$1';

//******* Print Url *************//
$route['print-preview-salary/(:num)/?(:num)?'] = 'printview/printpreview_salary/$1/$2';
$route['printpreview-bonus/(:num)'] = 'printview/printpreview_bonus/$1';
$route['print-preview-lti/(:num)'] = 'printview/printpreview_lti/$1';

//******* Print Url *************//

//*********** Tenure Classification *********//
$route['tenure-classification'] = 'admin/admin_dashboard/tenure_classification';
$route['send-email'] = 'admin/admin_dashboard/tenure_classification';
$route['tenure-classification/(:num)'] = 'admin/admin_dashboard/tenure_classification/$1';


//*********** Key Cross Cell *********//
$route['key-cross-cell-bonus'] = 'admin/admin_dashboard/key_cross_cell_bonus';

$route['term-conditions'] = 'home/term_conditions';


//**************** Tire Master *********//
$route['tier'] = 'admin/admin_dashboard/tier';
$route['tier/(:num)'] = 'admin/admin_dashboard/tier/$1';


//************ Target for Adjustement *****************//
$route['target-for-adjustment'] = 'admin/admin_dashboard/target_for_adjustment';


//************ minimum pay and capping *****************//
$route['min-pay-capp/(:num)'] = 'admin/admin_dashboard/min_pay_capp/$1';
$route['download-min-pay-capp-sample-file'] = 'admin/admin_dashboard/download_min_pay_capp_sample_file';
$route['upload-min-pay-capp-data/(:num)'] = 'admin/admin_dashboard/upload_min_pay_capp_data/$1';

//*********** Set Rules For Manager *******************//

$route['set-rules-for-manager'] = 'cron/set_rules_for_manager';


//// *********** employee_graph_create ***********//
$route['employee-graph-update/(:num)']='admin/admin_dashboard/employee_graph_update/$1';

$route['market-data-upload'] = 'admin/admin_dashboard/upload_market_data';
$route['download-market-data-sample-format-file'] = 'admin/admin_dashboard/download_market_data_sample_format_file';
$route['market-data-export'] = 'admin/admin_dashboard/market_data_export';

$route['final-salary-structure/?(:num)?'] = 'admin/admin_dashboard/final_salary_structure/$1';


$route['salary-rules-upgrade-promotion/(:num)/?(:num)?/?(:num)?'] = 'rules/salary_rules_upgrade_promotion/$1/$2/$3';

$route['download-upgrade-promotion-sample-file/(:num)'] = 'rules/download_upgrade_promotion_sample_file/$1';


$route['manager/update-salary-rule-comments/(:num)/(:num)'] = 'manager/dashboard/update_salary_rule_comments/$1/$2';

$route['manager/update-promotion-comments/(:num)/(:num)'] = 'manager/dashboard/update_promotion_comments/$1/$2';


$route['update-salary-rule-comments/(:num)/(:num)'] = 'increments/update_salary_rule_comments/$1/$2';
$route['update-promotion-comments/(:num)/(:num)'] = 'increments/update_promotion_comments/$1/$2';


$route['flexi-plan'] = 'admin/admin_dashboard/flexi_plan';


 $route['flexi-plan-filters/?(:num)?'] = 'admin/admin_dashboard/flexi_plan_filters/$1';

 $route['flexi-plan-launched/'] = 'admin/admin_dashboard/flexi_plan_launched/';
$route['flexi-plan-copy/?(:num)?'] = 'admin/admin_dashboard/flexi_plan_copy/$1';
$route['flexi-plan-delete/(:num)'] = 'admin/admin_dashboard/flexi_plan_delete/$1';



########## Table settings Routes ######

 $route['updateSettings'] = 'admin/table_settings/updateSettings';

 ########## Profit revenue cost Routes added by nibha ######
 $route['enter-prc'] = 'admin/admin_dashboard/enter_prc';
 $route['enter-prc/(:num)'] = 'admin/admin_dashboard/enter_prc/$1';

 $route['ssops'] = 'home/peoplestrongSSO';


 ################## Offer Letter Route #################
$route['objective-settings'] = 'candidate_proposal/objective_settings';
$route['objective-settings-output'] = 'candidate_proposal/objective_settings_output';
$route['candidate-offer'] = 'candidate_proposal/candidate_offer_proposal';
$route['candidate-offer-rule-setting'] = 'candidate_proposal/candidate_offer_rule_setting';
$route['candidate-offer-rule-setting/(:num)'] = 'candidate_proposal/candidate_offer_rule_setting/$1';
// routes for analytics
$route['report/performance-rating'] = 'report/performance_rating';
$route['report/promotion-report'] = 'report/promotion_report';
$route['report/identified-report'] = 'report/identified_report';
$route['report/successor-readyness-report'] = 'report/successor_readyness_report';
$route['report/promoted-successor-report'] = 'report/promoted_successor_report';
$route['report/salary-increase-budget'] = 'report/salary_increase_budget';
$route['report/salary-increase-budget/(:num)/(:num)'] = 'report/salary_increase_budget/$1/$2';
$route['report/salary-increase'] = 'report/employee_salary_increase';
$route['report/salary-increase/(:num)/(:num)'] = 'report/employee_salary_increase/$1/$2';
$route['report/grade-cost-summary/(:num)'] = 'report/get_cost_summary_by_grade/$1';
$route['report/performance-rating-cost-summary/(:num)'] = 'report/get_cost_summary_by_performance_rating/$1';
$route['report/promotion-summary/(:num)'] = 'report/get_promotion_summary/$1';
$route['report/range-pene-and-avg-increase-summary/(:num)'] = 'report/get_range_pene_and_avg_increase_summary/$1';
$route['report/miscellaneous-summary/(:num)'] = 'report/get_miscellaneous_summary/$1';
$route['report/compposition-rule-wise'] = 'report/get_compposition_rule_wise';
$route['report/compposition-rule-wise/(:num)/(:num)'] = 'report/get_compposition_rule_wise/$1/$2';
$route['report/potential-rating'] = 'report/potential_rating';