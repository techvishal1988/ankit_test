-- ****************************** Dated On : 13-10-2019 ******************************

-- ---------New tables for SIP Module
DROP TABLE IF EXISTS `sip_employee_details`;
CREATE TABLE IF NOT EXISTS `sip_employee_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `target_sip` decimal(10,2) NOT NULL,
  `emp_final_bdgt` decimal(10,2) NOT NULL COMMENT 'Calculated budget emp wise for manager',
  `final_sip` decimal(10,2) NOT NULL COMMENT 'Rule creation time sip or after modify by manager',
  `final_sip_per` decimal(10,2) NOT NULL COMMENT 'Final sip %',
  `actual_sip` decimal(10,2) NOT NULL COMMENT 'Rule creation time sip',
  `actual_sip_per` decimal(10,2) NOT NULL COMMENT 'Actual sip %',
  `emp_weightage_achievement_dtls` varchar(2000) NOT NULL,
  `manager_discretionary_increase` decimal(10,2) NOT NULL,
  `manager_discretionary_decrease` decimal(10,2) NOT NULL COMMENT 'no of per to inc/dec sip after or before modify by manager',
  `last_action_by` varchar(150) NOT NULL COMMENT 'Last Manger Email',
  `manager_emailid` varchar(150) NOT NULL COMMENT 'sip req is on this manager',
  `country` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `business_level_1` varchar(200) NOT NULL,
  `business_level_2` varchar(200) NOT NULL,
  `business_level_3` varchar(200) NOT NULL,
  `designation` varchar(200) NOT NULL,
  `function` varchar(200) NOT NULL,
  `sub_function` varchar(200) NOT NULL,
  `sub_sub_function` varchar(200) NOT NULL,
  `grade` varchar(200) NOT NULL,
  `level` varchar(200) NOT NULL,
  `education` varchar(200) NOT NULL,
  `critical_talent` varchar(200) NOT NULL,
  `critical_position` varchar(200) NOT NULL,
  `special_category` varchar(200) NOT NULL,
  `tenure_company` int(3) NOT NULL COMMENT 'value of login_user tbl',
  `tenure_role` int(3) NOT NULL COMMENT 'value of login_user tbl',
  `company_name` varchar(200) NOT NULL,
  `emp_name` varchar(50) NOT NULL,
  `emp_first_name` varchar(50) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `recently_promoted` varchar(5) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `current_base_salary` decimal(10,2) NOT NULL,
  `sip_incentive_applicable` varchar(200) NOT NULL,
  `current_target_sip` decimal(10,2) NOT NULL,
  `total_compensation` varchar(50) NOT NULL,
  `joining_date_for_increment_purposes` varchar(50) NOT NULL,
  `joining_date_the_company` varchar(50) NOT NULL,
  `start_date_for_role` varchar(50) NOT NULL,
  `end_date_the_role` varchar(50) NOT NULL,
  `approver_1` varchar(50) NOT NULL,
  `approver_2` varchar(50) NOT NULL,
  `approver_3` varchar(50) NOT NULL,
  `approver_4` varchar(50) NOT NULL,
  `manager_name` varchar(50) NOT NULL,
  `authorised_signatory_for_letter` varchar(100) NOT NULL,
  `authorised_signatory_title_for_letter` varchar(200) NOT NULL,
  `hr_authorised_signatory_for_letter` varchar(100) NOT NULL,
  `hr_authorised_signatory_title_for_letter` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=1st App Req, 2=2nd App Req, 3rd App Req, 4th App Req, 5=Approved By All Managers',
  `updatedby` int(11) NOT NULL COMMENT 'Manager''s Id who had modified the sip',
  `updatedon` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby_proxy` int(11) NOT NULL COMMENT 'Who is created it as a Proxy',
  `updatedby_proxy` int(11) NOT NULL COMMENT 'Who is updated it as a Proxy',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `sip_hr_parameter`;
CREATE TABLE IF NOT EXISTS `sip_hr_parameter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sip_rule_name` varchar(100) NOT NULL,
  `recurring_plan` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=NO,1=YES',
  `frequency_of_plan` tinyint(1) DEFAULT NULL COMMENT '1=Monthly, 2=Quarterly, 3=Annually',
  `recurr_plan_start_dt` date DEFAULT NULL,
  `recurr_plan_end_dt` date DEFAULT NULL,
  `prorated_increase` varchar(3) NOT NULL DEFAULT 'no' COMMENT 'yes, no, fix',
  `fix_per_range_doj` text,
  `sip_applied_on_elements` varchar(500) NOT NULL COMMENT 'salary type attribute comma separated ids',
  `target_sip` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Sum of Salary Element based, 2=Fixed Given Amount, 3=As per value of BA name ''Target Incentive''',
  `target_sip_on` varchar(15) NOT NULL COMMENT 'Designation/Grade/Level',
  `performance_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=Rating Wise, 2=Achievement percentage wise',
  `performance_achievements_multiplier_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=Single Multiplier, 2=Decelerated or Accelerated Multiplier',
  `multiplier_dtls` varchar(1000) NOT NULL,
  `performance_achievement_rangs` text NOT NULL,
  `actual_achievement_file_path` varchar(150) NOT NULL,
  `individual_performance_below_check` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=No, 2=Yes',
  `min_payout` decimal(10,2) NOT NULL,
  `max_payout` decimal(10,2) NOT NULL,
  `overall_budget` varchar(100) NOT NULL,
  `manual_budget_dtls` text NOT NULL,
  `performance_cycle_id` int(11) NOT NULL,
  `country` text NOT NULL,
  `city` text NOT NULL,
  `business_level1` text NOT NULL,
  `business_level2` text NOT NULL,
  `business_level3` text NOT NULL,
  `functions` text NOT NULL,
  `sub_functions` text NOT NULL,
  `sub_subfunctions` text NOT NULL,
  `designations` text NOT NULL,
  `grades` text NOT NULL,
  `levels` text NOT NULL,
  `educations` text NOT NULL,
  `critical_talents` text NOT NULL,
  `critical_positions` text NOT NULL,
  `special_category` text NOT NULL,
  `tenure_company` text NOT NULL,
  `tenure_roles` text NOT NULL,
  `cutoff_date` date NOT NULL,
  `manager_discretionary_increase` decimal(10,2) NOT NULL,
  `manager_discretionary_decrease` decimal(10,2) NOT NULL,
  `to_currency_id` int(11) NOT NULL COMMENT 'PK of manage_currency tbl, need to show currency in it',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=Filter Created, 2=Step2, 3=Review the Plan, 4=Sent For Approval, 5=Approval Rejected, 6=Approved, 7=Sent to managers before rule Release, 8=Deleted, 9=Released',
  `template_id` int(11) NOT NULL COMMENT 'PK of template tbl to link template with Emp Letter',
  `createdby` int(11) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` int(11) NOT NULL,
  `updatedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby_proxy` int(11) NOT NULL COMMENT 'Who is created it as a Proxy',
  `updatedby_proxy` int(11) NOT NULL COMMENT 'Who is updated it as a Proxy',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `sip_rule_users_dtls`;
CREATE TABLE IF NOT EXISTS `sip_rule_users_dtls` (
  `rule_id` int(11) NOT NULL COMMENT 'PK of sip_hr_parameter tbl',
  `user_id` int(11) NOT NULL COMMENT 'PK of login_user tbl',
  `actual_achievements` varchar(1500) NOT NULL COMMENT 'Actual Achievements as per selected SIP Parameters'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `sip_weightage_parameters`;
CREATE TABLE IF NOT EXISTS `sip_weightage_parameters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) DEFAULT NULL,
  `value` decimal(10,2) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=Business Attribute, 2=custom, 3=individual, 4=Target Sales Incentive %',
  `target_based_on_id` int(11) DEFAULT NULL COMMENT 'ids for designation, grade, level',
  `ba_id` int(11) DEFAULT NULL COMMENT 'references to PK of business_attribute, NULL in case of custom, individual, Target Sales Incentive % and Target Sales Amount',
  `sip_hr_parameter_id` int(11) NOT NULL COMMENT 'PK of sip_hr_parameter',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- ****************************** Dated On : 06-11-2019 ******************************

-- ---------Added new column as effective_dt
ALTER TABLE `hr_parameter` ADD `effective_dt` DATE NOT NULL COMMENT 'Reviewed salary effective from this date' AFTER `sp_manager_discretionary_decrease`;


-- ****************************** Dated On : 19-11-2019 ******************************

-- ---------Changed few columns text
UPDATE `table_attribute` SET `display_name` = 'Total Salary Increment Amount', `desciption` = 'Total Salary Increment Amount' WHERE `table_attribute`.`id` = 15; 
UPDATE `table_attribute` SET `display_name` = 'Total Salary increase recommended', `desciption` = 'Total Salary increase recommended by manager' WHERE `table_attribute`.`id` = 16;

-- ---------Inserted new records into table as table_attribute
INSERT INTO `table_attribute` (`id`, `attribute_name`, `table_name`, `created_by`, `display_name`, `desciption`, `module_name`, `col_attributes_order`, `status`, `is_lock`, `updatedon`, `createdon`) VALUES ('26', 'merit_increase_amount', '', '1', 'Merit Increase Amount', 'Merit Increase Amount', 'hr_screen', '20', '1', '0', '0000-00-00 00:00:00', '2019-11-19 15:44:24'), ('27', 'merit_increase_percentage', '', '1', 'Merit Increase Percentage', 'Merit Increase Percentage', 'hr_screen', '21', '1', '0', '0000-00-00 00:00:00', '2019-11-19 15:44:24'), ('28', 'market_correction_amount', '', '1', 'Market Correction Amount', 'Market Correction Amount', 'hr_screen', '22', '1', '0', '0000-00-00 00:00:00', '2019-11-19 15:44:24'), ('29', 'market_correction_percentage', '', '1', 'Market Correction Percentage', 'Market Correction Percentage', 'hr_screen', '23', '1', '0', '0000-00-00 00:00:00', '2019-11-19 15:44:24');


-- ****************************** Dated On : 25-11-2019 ******************************

-- ---------Created new tables for Ready To Use Model as well insert default records for it
DROP TABLE IF EXISTS `quick_modules`;
CREATE TABLE IF NOT EXISTS `quick_modules` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `plan_name` VARCHAR(100) NOT NULL,
  `plan_definition` VARCHAR(1500) NOT NULL,
  `pro` VARCHAR(1500) NOT NULL,
  `cons` VARCHAR(1500) NOT NULL,
  `hike_calculation_multiplier` DECIMAL(10,2) NOT NULL,
  `crr_calculation_multiplier` VARCHAR(100) NOT NULL,
  `prorated_increase` VARCHAR(20) NOT NULL DEFAULT 'no',
  `include_inactive` VARCHAR(3) NOT NULL DEFAULT 'no',
  `manager_can_change_rating` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1=Yes, 2=No',
  `performance_based_hike` VARCHAR(3) NOT NULL DEFAULT 'yes',
  `market_comparison_after_applying_performance_hike` VARCHAR(3) NOT NULL DEFAULT 'yes' COMMENT 'Calculate market comparison after applying performance based increase',
  `salary_position_based_on` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1=Distance Based, 2=Quartile Based',
  `default_market_benchmark` VARCHAR(100) NOT NULL DEFAULT '116~~~market_base_salary_level_5',
  `comparative_ratio_range` VARCHAR(1000) NOT NULL DEFAULT '{"range1":{"min":0,"max":"75"},"range2":{"min":"75","max":"100"}}',
  `manager_discretionary_increase` DECIMAL(10,2) NOT NULL,
  `manager_discretionary_decrease` DECIMAL(10,2) NOT NULL,
  `standard_promotion_increase` DECIMAL(10,2) NOT NULL,
  `budget_accumulation` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1=Yes, 2=No',
  `include_promotion_budget` TINYINT(1) NOT NULL DEFAULT '2' COMMENT '1=Yes, 2=No',
  `manager_can_exceed_budget` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1=Yes, 2=No',
  `overall_budget` VARCHAR(50) NOT NULL DEFAULT 'Automated locked',
  `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive, 3=Deleted',
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;


INSERT INTO `quick_modules` (`id`, `plan_name`, `plan_definition`, `pro`, `cons`, `hike_calculation_multiplier`, `crr_calculation_multiplier`, `prorated_increase`, `include_inactive`, `manager_can_change_rating`, `performance_based_hike`, `market_comparison_after_applying_performance_hike`, `salary_position_based_on`, `default_market_benchmark`, `comparative_ratio_range`, `manager_discretionary_increase`, `manager_discretionary_decrease`, `standard_promotion_increase`, `budget_accumulation`, `include_promotion_budget`, `manager_can_exceed_budget`, `overall_budget`, `status`) VALUES
(1, 'High Performance Differentiation', 'This plan is suitable for organisations, which are either struggling to create a strong performance driven culture or would like to increase focus on High Performance culture.', 'Rewards high contributors substantially and impacts the low performers severely.', 'Require high budgets in case there are too many high performers in the company in the performance rating distribution.', '2.00', '0,0', 'no', 'no', 1, 'yes', 'yes', 1, '116~~~market_base_salary_level_5', '{\"range1\":{\"min\":0,\"max\":\"100\"}}', '0.00', '0.00', '0.00', 1, 2, 1, 'Automated locked', 1),
(2, 'Moderate Performance Differentiation', 'This plan is suitable for organisations, which are in their journey to create a performance driven culture or would like to increase focus on Performance culture.', 'Creates moderate differentiation to Rewards high contributors and impacts the low performers', 'Require moderate budgets in case there are too many high performers in the company in the performance rating distribution.', '1.50', '0,0', 'no', 'no', 1, 'yes', 'yes', 1, '116~~~market_base_salary_level_5', '{\"range1\":{\"min\":0,\"max\":\"100\"}}', '0.00', '0.00', '0.00', 1, 2, 1, 'Automated locked', 1),
(3, 'Low Performance Differentiation', 'This plan is suitable for organisations, which are either struggling to create a strong performance driven culture or would like to increase focus on High Performance culture.', 'Rewards high contributors substantially and impacts the low performers severely', 'Require high budgets in case there are too many high performers in the company in the performance rating distribution.', '1.25', '0,0', 'no', 'no', 1, 'yes', 'yes', 1, '116~~~market_base_salary_level_5', '{\"range1\":{\"min\":0,\"max\":\"100\"}}', '0.00', '0.00', '0.00', 1, 2, 1, 'Automated locked', 1),
(4, 'High Performance & Market Correction Differentiation', 'This plan is suitable for organisations, which are either struggling to create a strong performance driven culture or would like to increase focus on High Performance culture.', 'Rewards high contributors substatially and impacts the low performers severely. Rewards high performers substantially who are far from their target positions. Ensures fairness and narrow pay differences between same performers in the same jobs.', 'Require high budgets in case employee\'s compensation are far from market, esp high performers, or there are too many high performers or both the conditions are applicable. Creates challenge in managing employees who are in the same position for long time and above the pay range, hence, has to be supported by a strong Talent Development plan so that employees do not get stuck with the same position for ever.', '2.00', '1,0.5,0', 'no', 'no', 1, 'yes', 'yes', 1, '116~~~market_base_salary_level_5', '{\"range1\":{\"min\":0,\"max\":\"75\"},\"range2\":{\"min\":\"75\",\"max\":\"100\"}}', '0.00', '0.00', '0.00', 1, 2, 1, 'Automated locked', 1),
(5, 'Moderate Performance & Market Correction Differentiation', 'This plan is suitable for organisations, which are in their journey to create a performance driven culture but would like to go slowly over a period of 2-3 years.', 'Rewards high contributors and impacts the low performers . Rewards high performers who are far from their target positions. Ensures reasonable fairness and starts narrowing down pay differences between same performers in the same jobs.', 'Require reasonable budgets in case employee\'s compensation are far from market, esp high performers, or there are too many high performers or both the conditions are applicable. Creates a little bit of challenge in managing employees who are in the same position for long time and above the pay range.', '1.50', '1,0.5,0', 'no', 'no', 1, 'yes', 'yes', 1, '116~~~market_base_salary_level_5', '{\"range1\":{\"min\":0,\"max\":\"75\"},\"range2\":{\"min\":\"75\",\"max\":\"100\"}}', '0.00', '0.00', '0.00', 1, 2, 1, 'Automated locked', 1),
(6, 'Low Performance & Market Correction Differentiation', 'This plan is suitable for organisations, which are just beginning their journey to create a performance driven culture and want to take first baby step in incorporating a structure comp plan reflecting this strategy.', 'Starts reflecting differentiation between high, average and low performers and also starts giving some bit of push to cases which are far from their target comp positioning.', 'Require average budgets \r\nRequires extensive communication to all managers to explain the methodology as it is launched first time.', '1.25', '1,0.5,0', 'no', 'no', 1, 'yes', 'yes', 1, '116~~~market_base_salary_level_5', '{\"range1\":{\"min\":0,\"max\":\"75\"},\"range2\":{\"min\":\"75\",\"max\":\"100\"}}', '0.00', '0.00', '0.00', 1, 2, 1, 'Automated locked', 1),
(7, 'Same increment for all', 'This plan is suitable for organisations, which are either struggling to create a strong performance driven culture or would like to increase focus on High Performance culture.', 'Rewards high contributors substantially and impacts the low performers severely.', 'Require high budgets in case there are too many high performers in the company in the performance rating distribution.', '1.00', '0,0', 'no', 'no', 1, 'yes', 'yes', 1, '116~~~market_base_salary_level_5', '{\"range1\":{\"min\":0,\"max\":\"100\"}}', '0.00', '0.00', '0.00', 1, 2, 1, 'Automated locked', 1),
(8, 'Market based differentiation, with standard merit increase', 'This plan is suitable for organisations, which are either struggling to create a strong performance driven culture or would like to increase focus on High Performance culture.', 'Rewards high contributors substantially and impacts the low performers severely.\r\nRewards high performers substantially who are far from their target positions.\r\nEnsures fairness and narrow pay differences between same performers in the same jobs.', 'Require high budgets in case employee\'s compensation are far from market, esp high performers, or there are too many high performers or both the conditions are applicable.\r\nCreates challenge in managing employees who are in the same position for long time and above the pay range, hence, has to be supported by a strong Talent Development plan so that employees do not get stuck with the same position for ever.', '1.00', '1,0.5,0', 'no', 'no', 1, 'yes', 'yes', 1, '116~~~market_base_salary_level_5', '{\"range1\":{\"min\":0,\"max\":\"75\"},\"range2\":{\"min\":\"75\",\"max\":\"100\"}}', '0.00', '0.00', '0.00', 1, 2, 1, 'Automated locked', 1);


-- ****************************** Dated On : 13-12-2019 ******************************

-- ---------Added new column as file_type
ALTER TABLE `data_upload` ADD `file_type` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1=Inserted, 2=Deleted, 3=Active, 4=In-Active' AFTER `uploaded_by_user_id`;


-- ****************************** Dated On : 17-12-2019 ******************************

-- ---------Added new column as level, education, hike_multiplier_basis_on and hike_multiplier_dtls
ALTER TABLE `tbl_market_data` ADD `level` VARCHAR(100) NOT NULL AFTER `grade`;
ALTER TABLE `tbl_market_data` ADD `education` VARCHAR(100) NOT NULL AFTER `designation`;

ALTER TABLE `hr_parameter` ADD `hike_multiplier_basis_on` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1=Country, 2=Grade, 3=Level' AFTER `if_recently_promoted`, ADD `hike_multiplier_dtls` TEXT NOT NULL AFTER `hike_multiplier_basis_on`;

-- ---------Query to migrate data for column as hike_multiplier_dtls
-- UPDATE hr_parameter SET hr_parameter.hike_multiplier_dtls = (SELECT CONCAT("{", GROUP_CONCAT('"',manage_country.id,'":', '"100"'), "}") FROM manage_country where FIND_IN_SET (manage_country.id, hr_parameter.country)) where hr_parameter.hike_multiplier_dtls = '';

UPDATE hr_parameter SET hr_parameter.hike_multiplier_basis_on = 0;


-- ****************************** Dated On : 26-12-2019 ******************************

-- ---------Added 2 new columns as type_of_hike_can_edit and promotion_type_element_dtls
ALTER TABLE `hr_parameter` ADD `type_of_hike_can_edit` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1=Total, 2=Both, 3=Merit, 4=Market Correction' AFTER `promotion_basis_on`, ADD `promotion_type_element_dtls` VARCHAR(3000) NOT NULL COMMENT 'Details of promotion %age basis on Designation/Grade/Level' AFTER `type_of_hike_can_edit`;

-- ---------Query to migrate data for column as promotion_type_element_dtls
UPDATE hr_parameter 
SET hr_parameter.promotion_type_element_dtls = 
CASE
    WHEN hr_parameter.promotion_basis_on = 2 THEN ((SELECT CONCAT("{", GROUP_CONCAT('"',manage_grade.id,'":', '"',hr_parameter.standard_promotion_increase,'"'), "}") FROM manage_grade WHERE FIND_IN_SET (manage_grade.id, hr_parameter.grades)))
    WHEN hr_parameter.promotion_basis_on = 3 THEN ((SELECT CONCAT("{", GROUP_CONCAT('"',manage_level.id,'":', '"',hr_parameter.standard_promotion_increase,'"'), "}") FROM manage_level WHERE FIND_IN_SET (manage_level.id, hr_parameter.levels)))
    ELSE ((SELECT CONCAT("{", GROUP_CONCAT('"',manage_designation.id,'":', '"',hr_parameter.standard_promotion_increase,'"'), "}") FROM manage_designation WHERE FIND_IN_SET (manage_designation.id, hr_parameter.designations)))
END
WHERE hr_parameter.promotion_type_element_dtls = '';


-- ****************************** Dated On : 28-12-2019 ******************************

-- ---------added new column multiplier_wise_per_dtls into tbl hr_parameter and new record in pages tbl
ALTER TABLE `hr_parameter` ADD `multiplier_wise_per_dtls` TEXT NOT NULL AFTER `hike_multiplier_dtls`;
INSERT INTO `pages` (`id`, `name`, `uri_segment`, `status`) VALUES ('72', 'Manage Level', 'manage-level', '1');


-- ****************************** Dated On : 30-12-2019 ******************************

-- ---------added new columns into tbl employee_salary_details tbl
ALTER TABLE `employee_salary_details` ADD `market_salary_column` VARCHAR(100) NOT NULL COMMENT 'market salary type BA name' AFTER `market_salary`;

ALTER TABLE `employee_salary_details` ADD `mkt_salary_after_promotion` DECIMAL(10,2) NOT NULL COMMENT 'Market Salary as per new Grade/Designation/Level after Promotion' AFTER `market_salary_column`, ADD `crr_after_promotion` DECIMAL(10,2) NOT NULL COMMENT 'crr as per new salary & new market salary after promotion' AFTER `mkt_salary_after_promotion`, ADD `final_merit_hike` DECIMAL(10,2) NOT NULL AFTER `crr_after_promotion`, ADD `final_market_hike` DECIMAL(10,2) NOT NULL AFTER `final_merit_hike`;

-- ---------Query to migrate data in columns as mkt_salary_after_promotion, crr_after_promotion, final_merit_hike, final_market_hike
UPDATE `employee_salary_details` SET mkt_salary_after_promotion = market_salary, crr_after_promotion =crr_val, final_merit_hike = performnace_based_increment, final_market_hike = crr_based_increment;

-- ---------Query to migrate standard promotion increase per into manager_discretions (or total per) column
UPDATE employee_salary_details esd, hr_parameter hp SET esd.manager_discretions = esd.manager_discretions + esd.sp_manager_discretions WHERE esd.rule_id = hp.id AND hp.include_promotion_budget = 1 AND esd.sp_manager_discretions > 0;


-- ****************************** Dated On : 04-01-2020 ******************************
-- ---------Inserted new records into table as table_attribute
INSERT INTO `table_attribute` (`id`, `attribute_name`, `table_name`, `created_by`, `display_name`, `desciption`, `module_name`, `col_attributes_order`, `status`, `is_lock`, `updatedon`, `createdon`) VALUES (NULL, 'position_pay_range_after_promotion', '', '1', 'Positioning after Merit & Promotion Increase', 'Positioning after Merit & Promotion Increase', 'hr_screen', '51', '1', '0', '2020-01-04 15:15:00', '2020-01-04 15:15:00');

-- ---------added new columns into tbl hr_parameter for Performace Period
ALTER TABLE `hr_parameter` ADD `pp_start_dt` DATE NOT NULL COMMENT 'Performance Period Start Date' AFTER `cutoff_date`, ADD `pp_end_dt` DATE NOT NULL COMMENT 'Performance Period End Date' AFTER `pp_start_dt`;

-- ---------Query to migrate for Performace Period columns
UPDATE hr_parameter hp SET hp.pp_start_dt = hp.start_dt, hp.pp_end_dt=hp.end_dt;


-- ****************************** Dated On : 06-01-2020 ******************************

-- ---------added new column into tbl employee_salary_details tbl
ALTER TABLE `employee_salary_details` ADD `quartile_range_name_after_promotion` VARCHAR(200) NOT NULL AFTER `crr_after_promotion`;

-- ---------Query to migrate data in column as quartile_range_name_after_promotion
UPDATE `employee_salary_details` SET quartile_range_name_after_promotion = pre_quartile_range_name;

ALTER TABLE `employee_salary_details` ADD `min_salary_for_penetration` DECIMAL(10,2) NOT NULL COMMENT 'Market salary as per min crr range for penetration' AFTER `promotion_comment`, ADD `max_salary_for_penetration` DECIMAL(10,2) NOT NULL COMMENT 'Market salary as per max crr range for penetration' AFTER `min_salary_for_penetration`;


-- ****************************** Dated On : 09-01-2020 ******************************

-- ---------Just changed data type of the column type_of_hike_can_edit into tbl hr_parameter tbl
ALTER TABLE `hr_parameter` CHANGE `type_of_hike_can_edit` `type_of_hike_can_edit` VARCHAR(20) NOT NULL DEFAULT '1' COMMENT '1=Total, 2=Merit, 3=Market Correction, 4=Promotion';

-- ---------Inserted new records into table_attribute tbl
INSERT INTO `table_attribute` (`id`, `attribute_name`, `table_name`, `created_by`, `display_name`, `desciption`, `module_name`, `col_attributes_order`, `status`, `is_lock`, `updatedon`, `createdon`) VALUES 
('30', 'current_monthly_salary_being_reviewed', '', '1', 'Current Monthly Salary Being Reviewed', 'Current Monthly Salary Being Reviewed', 'hr_screen', '52', '1', '0', '2020-01-09 17:31:00', '2020-01-09 17:31:00'),
('31', 'final_new_monthly_salary', '', '1', 'Final New Monthly Salary', 'Final New Monthly Salary', 'hr_screen', '53', '1', '0', '2020-01-09 17:31:00', '2020-01-09 17:31:00'),
('32', 'market_salary', '', '1', 'Salary Compared To', 'Salary Compared To', 'hr_screen', '54', '1', '0', '2020-01-09 17:31:00', '2020-01-09 17:31:00'),
('33', 'market_salary_after_promotion', '', '1', 'Salary Compared To After Increase', 'Salary Compared To After Increase', 'hr_screen', '55', '1', '0', '2020-01-09 17:31:00', '2020-01-09 17:31:00'),
('34', 'rating_last_year', '', '1', 'Performance Rating for previous year', 'Performance Rating for previous year', 'hr_screen', '56', '1', '0', '2020-01-09 17:31:00', '2020-01-09 17:31:00'),
('35', 'rating_2nd_last_year', '', '1', 'Performance Rating for 2nd last year', 'Performance Rating for 2nd last year', 'hr_screen', '57', '1', '0', '2020-01-09 17:31:00', '2020-01-09 17:31:00'),
('36', 'rating_3rd_last_year', '', '1', 'Performance Rating for 3rd last year', 'Performance Rating for 3rd last year', 'hr_screen', '58', '1', '0', '2020-01-09 17:31:00', '2020-01-09 17:31:00'),
('37', 'rating_4th_last_year', '', '1', 'Performance Rating for 4th last year', 'Performance Rating for 4th last year', 'hr_screen', '59', '1', '0', '2020-01-09 17:31:00', '2020-01-09 17:31:00'),
('38', 'rating_5th_last_year', '', '1', 'Performance Rating for 5th last year', 'Performance Rating for 5th last year', 'hr_screen', '60', '1', '0', '2020-01-09 17:31:00', '2020-01-09 17:31:00');

-- ---------Added new columns into employee_salary_details tbl
ALTER TABLE `employee_salary_details` ADD `rating_last_year` VARCHAR(100) NOT NULL AFTER `end_date_the_role`, ADD `rating_2nd_last_year` VARCHAR(100) NOT NULL AFTER `rating_last_year`, ADD `rating_3rd_last_year` VARCHAR(100) NOT NULL AFTER `rating_2nd_last_year`, ADD `rating_4th_last_year` VARCHAR(100) NOT NULL AFTER `rating_3rd_last_year`, ADD `rating_5th_last_year` VARCHAR(100) NOT NULL AFTER `rating_4th_last_year`;


-- ****************************** Dated On : 17-01-2020 ******************************

-- ---------Created a new tbl
CREATE TABLE IF NOT EXISTS `hr_candidate_offer_parameter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `offer_rule_name` varchar(150) NOT NULL COMMENT 'Offer rule name',
  `offer_applied_on_elements` varchar(256) NOT NULL COMMENT 'Offer type attribute comma separated ids',
  `pay_range_basis_on` int(11) NOT NULL COMMENT 'Have pay range ID',
  `position` varchar(128) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT 'if 1 then Active and 0 for Inactive',
  `effective_dt` date NOT NULL COMMENT 'Offer effective from this date',
  `cutoff_date` date NOT NULL COMMENT 'Offer effective till this date',
  `updatedby` int(11) NOT NULL,
  `updatedon` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby_proxy` int(11) NOT NULL,
  `updatedby_proxy` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Have Candidate offer rules data';


-- ****************************** Dated On : 21-01-2020 ******************************

-- ---------Alter tbl_temp_bulk_upload_emp_increments tbl
ALTER TABLE `tbl_temp_bulk_upload_emp_increments` ADD `merit_hike` DECIMAL(10,2) NOT NULL AFTER `performance_rating`, ADD `market_hike` DECIMAL(10,2) NOT NULL AFTER `merit_hike`, ADD `total_hike` DECIMAL(10,2) NOT NULL AFTER `market_hike`;
ALTER TABLE `tbl_temp_bulk_upload_emp_increments` CHANGE `promotion_percentage` `promotion_percentage` DECIMAL(10,2) NOT NULL;
ALTER TABLE `tbl_temp_bulk_upload_emp_increments` ADD `promotion_recommendation` VARCHAR(3) NOT NULL COMMENT 'Yes/No' AFTER `promotion_basis_on`;
ALTER TABLE `tbl_temp_bulk_upload_emp_increments` DROP `salary_increment_percentage`, DROP `salary_comment`, DROP `promotion_basis_on`, DROP `promotion_comment`;


-- ****************************** Dated On : 27-01-2020 ******************************

-- ---------Alter salary_rule_users_dtls tbl
ALTER TABLE `salary_rule_users_dtls`
ADD `email` VARCHAR(80) NOT NULL  AFTER `user_id`,
ADD `name` VARCHAR(50) NOT NULL  AFTER `email`,
ADD `country` VARCHAR(100) NOT NULL  AFTER `name`,  
ADD `city` VARCHAR(100) NOT NULL  AFTER `country`,
ADD `function` VARCHAR(100) NOT NULL  AFTER `city`,
ADD `subfunction` VARCHAR(100) NOT NULL  AFTER `function`,
ADD `sub_subfunction` VARCHAR(100) NOT NULL  AFTER `subfunction`,
ADD `business_level_1` VARCHAR(100) NOT NULL  AFTER `sub_subfunction`,
ADD `business_level_2` VARCHAR(100) NOT NULL  AFTER `business_level_1`,
ADD `business_level_3` VARCHAR(100) NOT NULL  AFTER `business_level_2`,
ADD `designation` VARCHAR(100) NOT NULL  AFTER `business_level_3`,
ADD `grade` VARCHAR(100) NOT NULL  AFTER `designation`,
ADD `level` VARCHAR(100) NOT NULL  AFTER `grade`,
ADD `education` VARCHAR(100) NOT NULL  AFTER `level`,
ADD `critical_talent` VARCHAR(100) NOT NULL  AFTER `education`,
ADD `critical_position` VARCHAR(100) NOT NULL  AFTER `critical_talent`,
ADD `special_category` VARCHAR(100) NOT NULL  AFTER `critical_position`,
ADD `tenure_company` int(5) NOT NULL  AFTER `special_category`,
ADD `tenure_role` int(5) NOT NULL  AFTER `tenure_company`,
ADD `currency` VARCHAR(15) NOT NULL  AFTER `tenure_role`,
ADD `recently_promoted` ENUM('Yes','No') NOT NULL DEFAULT 'No'  AFTER `currency`,  
ADD `company_joining_date` DATE NOT NULL  AFTER `recently_promoted`,
ADD `increment_purpose_joining_date` DATE NOT NULL  AFTER `company_joining_date`,
ADD `start_date_for_role` DATE NOT NULL  AFTER `increment_purpose_joining_date`,
ADD `end_date_for_role` DATE NOT NULL  AFTER `start_date_for_role`,
ADD `bonus_incentive_applicable` VARCHAR(50) NOT NULL  AFTER `end_date_for_role`,
ADD `rating_for_last_year` VARCHAR(100) NOT NULL  AFTER `bonus_incentive_applicable`,
ADD `rating_for_2nd_last_year` VARCHAR(100) NOT NULL  AFTER `rating_for_last_year`,
ADD `rating_for_3rd_last_year` VARCHAR(100) NOT NULL  AFTER `rating_for_2nd_last_year`,
ADD `rating_for_4th_last_year` VARCHAR(100) NOT NULL  AFTER `rating_for_3rd_last_year`,
ADD `rating_for_5th_last_year` VARCHAR(100) NOT NULL  AFTER `rating_for_4th_last_year`,
ADD `rating_for_current_year` VARCHAR(100) NOT NULL  AFTER `rating_for_5th_last_year`,
ADD `effective_date_of_last_salary_increase` DATE NOT NULL  AFTER `rating_for_current_year`,
ADD `effective_date_of_2nd_last_salary_increase` DATE NOT NULL  AFTER `effective_date_of_last_salary_increase`,
ADD `effective_date_of_3rd_last_salary_increase` DATE NOT NULL  AFTER `effective_date_of_2nd_last_salary_increase`,
ADD `effective_date_of_4th_last_salary_increase` DATE NOT NULL  AFTER `effective_date_of_3rd_last_salary_increase`,
ADD `effective_date_of_5th_last_salary_increase` DATE NOT NULL  AFTER `effective_date_of_4th_last_salary_increase`,
ADD `salary_after_last_increase` DECIMAL(10,2) NOT NULL  AFTER `effective_date_of_5th_last_salary_increase`,  ADD `salary_after_2nd_last_increase` DECIMAL(10,2) NOT NULL  AFTER `salary_after_last_increase`,  ADD `salary_after_3rd_last_increase` DECIMAL(10,2) NOT NULL  AFTER `salary_after_2nd_last_increase`,  ADD `salary_after_4th_last_increase` DECIMAL(10,2) NOT NULL  AFTER `salary_after_3rd_last_increase`,  ADD `salary_after_5th_last_increase` DECIMAL(10,2) NOT NULL  AFTER `salary_after_4th_last_increase`,  ADD `total_salary_after_last_increase` DECIMAL(10,2) NOT NULL  AFTER `salary_after_5th_last_increase`,  ADD `total_salary_after_2nd_last_increase` DECIMAL(10,2) NOT NULL  AFTER `total_salary_after_last_increase`,  ADD `total_salary_after_3rd_last_increase` DECIMAL(10,2) NOT NULL  AFTER `total_salary_after_2nd_last_increase`,  ADD `total_salary_after_4th_last_increase` DECIMAL(10,2) NOT NULL  AFTER `total_salary_after_3rd_last_increase`,  ADD `total_salary_after_5th_last_increase` DECIMAL(10,2) NOT NULL  AFTER `total_salary_after_4th_last_increase`,  ADD `target_salary_after_last_increase` DECIMAL(10,2) NOT NULL  AFTER `total_salary_after_5th_last_increase`,  ADD `target_salary_after_2nd_last_increase` DECIMAL(10,2) NOT NULL  AFTER `target_salary_after_last_increase`,  ADD `target_salary_after_3rd_last_increase` DECIMAL(10,2) NOT NULL  AFTER `target_salary_after_2nd_last_increase`,  ADD `target_salary_after_4th_last_increase` DECIMAL(10,2) NOT NULL  AFTER `target_salary_after_3rd_last_increase`,  ADD `target_salary_after_5th_last_increase` DECIMAL(10,2) NOT NULL  AFTER `target_salary_after_4th_last_increase`, 
ADD `current_base_salary` DECIMAL(10,2) NOT NULL  AFTER `target_salary_after_5th_last_increase`,
ADD `current_target_bonus` DECIMAL(10,2) NOT NULL  AFTER `current_base_salary`,
ADD `allowance_1` DECIMAL(10,2) NOT NULL  AFTER `current_target_bonus`,
ADD `allowance_2` DECIMAL(10,2) NOT NULL  AFTER `allowance_1`,
ADD `allowance_3` DECIMAL(10,2) NOT NULL  AFTER `allowance_2`,
ADD `allowance_4` DECIMAL(10,2) NOT NULL  AFTER `allowance_3`,
ADD `allowance_5` DECIMAL(10,2) NOT NULL  AFTER `allowance_4`,
ADD `allowance_6` DECIMAL(10,2) NOT NULL  AFTER `allowance_5`,
ADD `allowance_7` DECIMAL(10,2) NOT NULL  AFTER `allowance_6`,
ADD `allowance_8` DECIMAL(10,2) NOT NULL  AFTER `allowance_7`,
ADD `allowance_9` DECIMAL(10,2) NOT NULL  AFTER `allowance_8`,
ADD `allowance_10` DECIMAL(10,2) NOT NULL  AFTER `allowance_9`,
ADD `allowance_11` DECIMAL(10,2) NOT NULL  AFTER `allowance_10`,
ADD `allowance_12` DECIMAL(10,2) NOT NULL  AFTER `allowance_11`,
ADD `allowance_13` DECIMAL(10,2) NOT NULL  AFTER `allowance_12`,
ADD `allowance_14` DECIMAL(10,2) NOT NULL  AFTER `allowance_13`,
ADD `allowance_15` DECIMAL(10,2) NOT NULL  AFTER `allowance_14`,
ADD `allowance_16` DECIMAL(10,2) NOT NULL  AFTER `allowance_15`,
ADD `allowance_17` DECIMAL(10,2) NOT NULL  AFTER `allowance_16`,
ADD `allowance_18` DECIMAL(10,2) NOT NULL  AFTER `allowance_17`,
ADD `allowance_19` DECIMAL(10,2) NOT NULL  AFTER `allowance_18`,
ADD `allowance_20` DECIMAL(10,2) NOT NULL  AFTER `allowance_19`,
ADD `allowance_21` DECIMAL(10,2) NOT NULL  AFTER `allowance_20`,
ADD `allowance_22` DECIMAL(10,2) NOT NULL  AFTER `allowance_21`,
ADD `allowance_23` DECIMAL(10,2) NOT NULL  AFTER `allowance_22`,
ADD `allowance_24` DECIMAL(10,2) NOT NULL  AFTER `allowance_23`,
ADD `allowance_25` DECIMAL(10,2) NOT NULL  AFTER `allowance_24`,
ADD `allowance_26` DECIMAL(10,2) NOT NULL  AFTER `allowance_25`,
ADD `allowance_27` DECIMAL(10,2) NOT NULL  AFTER `allowance_26`,
ADD `allowance_28` DECIMAL(10,2) NOT NULL  AFTER `allowance_27`,
ADD `allowance_29` DECIMAL(10,2) NOT NULL  AFTER `allowance_28`,
ADD `allowance_30` DECIMAL(10,2) NOT NULL  AFTER `allowance_29`,
ADD `allowance_31` DECIMAL(10,2) NOT NULL  AFTER `allowance_30`,
ADD `allowance_32` DECIMAL(10,2) NOT NULL  AFTER `allowance_31`,
ADD `allowance_33` DECIMAL(10,2) NOT NULL  AFTER `allowance_32`,
ADD `allowance_34` DECIMAL(10,2) NOT NULL  AFTER `allowance_33`,
ADD `allowance_35` DECIMAL(10,2) NOT NULL  AFTER `allowance_34`,
ADD `allowance_36` DECIMAL(10,2) NOT NULL  AFTER `allowance_35`,
ADD `allowance_37` DECIMAL(10,2) NOT NULL  AFTER `allowance_36`,
ADD `allowance_38` DECIMAL(10,2) NOT NULL  AFTER `allowance_37`,
ADD `allowance_39` DECIMAL(10,2) NOT NULL  AFTER `allowance_38`,
ADD `allowance_40` DECIMAL(10,2) NOT NULL  AFTER `allowance_39`,
ADD `total_compensation` DECIMAL(10,2) NOT NULL  AFTER `allowance_40`,
ADD `increment_applied_on` DECIMAL(10,2) NOT NULL  AFTER `total_compensation`,
ADD `job_code` VARCHAR(100) NOT NULL  AFTER `increment_applied_on`,
ADD `job_name` VARCHAR(100) NOT NULL  AFTER `job_code`,
ADD `job_level` VARCHAR(100) NOT NULL  AFTER `job_name`,
ADD `market_target_salary_level_min` DECIMAL(10,2) NOT NULL  AFTER `job_level`,
ADD `market_total_salary_level_min` DECIMAL(10,2) NOT NULL  AFTER `market_target_salary_level_min`,
ADD `market_base_salary_level_min` DECIMAL(10,2) NOT NULL  AFTER `market_total_salary_level_min`,
ADD `market_target_salary_level_1` DECIMAL(10,2) NOT NULL  AFTER `market_base_salary_level_min`,
ADD `market_total_salary_level_1` DECIMAL(10,2) NOT NULL  AFTER `market_target_salary_level_1`,
ADD `market_base_salary_level_1` DECIMAL(10,2) NOT NULL  AFTER `market_total_salary_level_1`,
ADD `market_target_salary_level_2` DECIMAL(10,2) NOT NULL  AFTER `market_base_salary_level_1`,
ADD `market_total_salary_level_2` DECIMAL(10,2) NOT NULL  AFTER `market_target_salary_level_2`,
ADD `market_base_salary_level_2` DECIMAL(10,2) NOT NULL  AFTER `market_total_salary_level_2`,
ADD `market_target_salary_level_3` DECIMAL(10,2) NOT NULL  AFTER `market_base_salary_level_2`,
ADD `market_total_salary_level_3` DECIMAL(10,2) NOT NULL  AFTER `market_target_salary_level_3`,
ADD `market_base_salary_level_3` DECIMAL(10,2) NOT NULL  AFTER `market_total_salary_level_3`,
ADD `market_target_salary_level_4` DECIMAL(10,2) NOT NULL  AFTER `market_base_salary_level_3`,
ADD `market_total_salary_level_4` DECIMAL(10,2) NOT NULL  AFTER `market_target_salary_level_4`,
ADD `market_base_salary_level_4` DECIMAL(10,2) NOT NULL  AFTER `market_total_salary_level_4`,
ADD `market_target_salary_level_5` DECIMAL(10,2) NOT NULL  AFTER `market_base_salary_level_4`,
ADD `market_total_salary_level_5` DECIMAL(10,2) NOT NULL  AFTER `market_target_salary_level_5`,
ADD `market_base_salary_level_5` DECIMAL(10,2) NOT NULL  AFTER `market_total_salary_level_5`,
ADD `market_target_salary_level_6` DECIMAL(10,2) NOT NULL  AFTER `market_base_salary_level_5`,
ADD `market_total_salary_level_6` DECIMAL(10,2) NOT NULL  AFTER `market_target_salary_level_6`,
ADD `market_base_salary_level_6` DECIMAL(10,2) NOT NULL  AFTER `market_total_salary_level_6`,
ADD `market_target_salary_level_7` DECIMAL(10,2) NOT NULL  AFTER `market_base_salary_level_6`,
ADD `market_total_salary_level_7` DECIMAL(10,2) NOT NULL  AFTER `market_target_salary_level_7`,
ADD `market_base_salary_level_7` DECIMAL(10,2) NOT NULL  AFTER `market_total_salary_level_7`,
ADD `market_target_salary_level_8` DECIMAL(10,2) NOT NULL  AFTER `market_base_salary_level_7`,
ADD `market_total_salary_level_8` DECIMAL(10,2) NOT NULL  AFTER `market_target_salary_level_8`,
ADD `market_base_salary_level_8` DECIMAL(10,2) NOT NULL  AFTER `market_total_salary_level_8`,
ADD `market_target_salary_level_9` DECIMAL(10,2) NOT NULL  AFTER `market_base_salary_level_8`,
ADD `market_total_salary_level_9` DECIMAL(10,2) NOT NULL  AFTER `market_target_salary_level_9`,
ADD `market_base_salary_level_9` DECIMAL(10,2) NOT NULL  AFTER `market_total_salary_level_9`,
ADD `market_target_salary_sevel_max` DECIMAL(10,2) NOT NULL  AFTER `market_base_salary_level_9`,
ADD `market_total_salary_level_max` DECIMAL(10,2) NOT NULL  AFTER `market_target_salary_sevel_max`,
ADD `market_base_salary_level_max` DECIMAL(10,2) NOT NULL  AFTER `market_total_salary_level_max`,
ADD `company_1_base_salary_min` DECIMAL(10,2) NOT NULL  AFTER `market_base_salary_level_max`,
ADD `company_1_base_salary_max` DECIMAL(10,2) NOT NULL  AFTER `company_1_base_salary_min`,
ADD `company_1_base_salary_average` DECIMAL(10,2) NOT NULL  AFTER `company_1_base_salary_max`,
ADD `company_2_base_salary_min` DECIMAL(10,2) NOT NULL  AFTER `company_1_base_salary_average`,
ADD `company_2_base_salary_max` DECIMAL(10,2) NOT NULL  AFTER `company_2_base_salary_min`,
ADD `company_2_base_salary_average` DECIMAL(10,2) NOT NULL  AFTER `company_2_base_salary_max`,
ADD `company_3_base_salary_min` DECIMAL(10,2) NOT NULL  AFTER `company_2_base_salary_average`,
ADD `company_3_base_salary_max` DECIMAL(10,2) NOT NULL  AFTER `company_3_base_salary_min`,
ADD `company_3_base_salary_average` DECIMAL(10,2) NOT NULL  AFTER `company_3_base_salary_max`,
ADD `average_base_salary_min` DECIMAL(10,2) NOT NULL  AFTER `company_3_base_salary_average`,
ADD `average_base_salary_max` DECIMAL(10,2) NOT NULL  AFTER `average_base_salary_min`,
ADD `average_base_salary_average` DECIMAL(10,2) NOT NULL  AFTER `average_base_salary_max`,
ADD `company_1_target_salary_min` DECIMAL(10,2) NOT NULL  AFTER `average_base_salary_average`,
ADD `company_1_target_salary_max` DECIMAL(10,2) NOT NULL  AFTER `company_1_target_salary_min`,
ADD `company_1_target_salary_average` DECIMAL(10,2) NOT NULL  AFTER `company_1_target_salary_max`,
ADD `company_2_target_salary_min` DECIMAL(10,2) NOT NULL  AFTER `company_1_target_salary_average`,
ADD `company_2_target_salary_max` DECIMAL(10,2) NOT NULL  AFTER `company_2_target_salary_min`,
ADD `company_2_target_salary_average` DECIMAL(10,2) NOT NULL  AFTER `company_2_target_salary_max`,
ADD `company_3_target_salary_min` DECIMAL(10,2) NOT NULL  AFTER `company_2_target_salary_average`,
ADD `company_3_target_salary_max` DECIMAL(10,2) NOT NULL  AFTER `company_3_target_salary_min`,
ADD `company_3_target_salary_average` DECIMAL(10,2) NOT NULL  AFTER `company_3_target_salary_max`,
ADD `average_target_salary_min` DECIMAL(10,2) NOT NULL  AFTER `company_3_target_salary_average`,
ADD `average_target_salary_max` DECIMAL(10,2) NOT NULL  AFTER `average_target_salary_min`,
ADD `average_target_salary_average` DECIMAL(10,2) NOT NULL  AFTER `average_target_salary_max`,
ADD `company_1_total_salary_min` DECIMAL(10,2) NOT NULL  AFTER `average_target_salary_average`,
ADD `company_1_total_salary_max` DECIMAL(10,2) NOT NULL  AFTER `company_1_total_salary_min`,
ADD `company_1_total_salary_average` DECIMAL(10,2) NOT NULL  AFTER `company_1_total_salary_max`,
ADD `company_2_total_salary_min` DECIMAL(10,2) NOT NULL  AFTER `company_1_total_salary_average`,
ADD `company_2_sotal_salary_max` DECIMAL(10,2) NOT NULL  AFTER `company_2_total_salary_min`,
ADD `company_2_total_salary_average` DECIMAL(10,2) NOT NULL  AFTER `company_2_sotal_salary_max`,
ADD `company_3_total_salary_min` DECIMAL(10,2) NOT NULL  AFTER `company_2_total_salary_average`,
ADD `company_3_total_salary_max` DECIMAL(10,2) NOT NULL  AFTER `company_3_total_salary_min`,
ADD `company_3_total_salary_average` DECIMAL(10,2) NOT NULL  AFTER `company_3_total_salary_max`,
ADD `average_total_salary_min` DECIMAL(10,2) NOT NULL  AFTER `company_3_total_salary_average`,
ADD `average_total_salary_max` DECIMAL(10,2) NOT NULL  AFTER `average_total_salary_min`,
ADD `average_total_salary_average` DECIMAL(10,2) NOT NULL  AFTER `average_total_salary_max`,
ADD `approver_1` VARCHAR(80) NOT NULL  AFTER `average_total_salary_average`,
ADD `approver_2` VARCHAR(80) NOT NULL  AFTER `approver_1`,
ADD `approver_3` VARCHAR(80) NOT NULL  AFTER `approver_2`,
ADD `approver_4` VARCHAR(80) NOT NULL  AFTER `approver_3`,
ADD `manager_name` VARCHAR(50) NOT NULL  AFTER `approver_4`,
ADD `authorised_signatory_for_letter` VARCHAR(80) NOT NULL  AFTER `manager_name`,
ADD `authorised_signatorys_title_for_letter` VARCHAR(100) NOT NULL  AFTER `authorised_signatory_for_letter`,
ADD `hr_authorised_signatory_for_letter` VARCHAR(80) NOT NULL  AFTER `authorised_signatorys_title_for_letter`,
ADD `hr_authorised_signatorys_title_for_letter` VARCHAR(100) NOT NULL  AFTER `hr_authorised_signatory_for_letter`,
ADD `company_name` VARCHAR(100) NOT NULL  AFTER `hr_authorised_signatorys_title_for_letter`,
ADD `gender` VARCHAR(10) NOT NULL  AFTER `company_name`,
ADD `first_name` VARCHAR(50) NOT NULL  AFTER `gender`,
ADD `employee_code` VARCHAR(100) NOT NULL  AFTER `first_name`,
ADD `performance_achievement` DECIMAL(10,2) NOT NULL  AFTER `employee_code`,  
ADD `teeth_tail_ratio` VARCHAR(100) NOT NULL  AFTER `performance_achievement`,  
ADD `previous_talent_rating` VARCHAR(100) NOT NULL  AFTER `teeth_tail_ratio`,  ADD `promoted_in_2_yrs` DATE NOT NULL  AFTER `previous_talent_rating`,  ADD `engagement_level` VARCHAR(100) NOT NULL  AFTER `promoted_in_2_yrs`,  ADD `successor_identified` VARCHAR(100) NOT NULL  AFTER `engagement_level`,  ADD `readyness_level` VARCHAR(100) NOT NULL  AFTER `successor_identified`,  ADD `urban_rural_classification` VARCHAR(100) NOT NULL  AFTER `readyness_level`,  ADD `employee_movement_into_bonus_plan` DATE NOT NULL  AFTER `urban_rural_classification`,  ADD `other_data_9` VARCHAR(100) NOT NULL  AFTER `employee_movement_into_bonus_plan`,  ADD `other_data_10` VARCHAR(100) NOT NULL  AFTER `other_data_9`,  ADD `other_data_11` VARCHAR(100) NOT NULL  AFTER `other_data_10`,  ADD `other_data_12` VARCHAR(100) NOT NULL  AFTER `other_data_11`,  ADD `other_data_13` VARCHAR(100) NOT NULL  AFTER `other_data_12`,  ADD `other_data_14` VARCHAR(100) NOT NULL  AFTER `other_data_13`,  ADD `other_data_15` VARCHAR(100) NOT NULL  AFTER `other_data_14`,  ADD `other_data_16` VARCHAR(100) NOT NULL  AFTER `other_data_15`,  ADD `other_data_17` VARCHAR(100) NOT NULL  AFTER `other_data_16`,  ADD `other_data_18` VARCHAR(100) NOT NULL  AFTER `other_data_17`,  ADD `other_data_19` VARCHAR(100) NOT NULL  AFTER `other_data_18`,  ADD `other_data_20` VARCHAR(100) NOT NULL  AFTER `other_data_19`;
-- Need to create a Data Migrate Script to insert data into salary_rule_users_dtls tbl for newly columns

-- Inserted new data into table_attribute tbl
INSERT INTO `table_attribute` (`id`, `attribute_name`, `table_name`, `created_by`, `display_name`, `desciption`, `module_name`, `col_attributes_order`, `status`, `is_lock`, `updatedon`, `createdon`) VALUES 
('39', 'salary_after_last_increase', '', '1', 'Base Salary after last increase', 'Base Salary after last increase', 'hr_screen', '61', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'), 
('44', 'target_salary_after_last_increase', '', '1', 'Target Salary after last increase', 'Target Salary after last increase', 'hr_screen', '62', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('74', 'total_salary_after_last_increase', '', '1', 'Total Salary after last increase', 'Total Salary after last increase', 'hr_screen', '63', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('49', 'recently_promoted', '', '1', 'Recently Promoted (Yes/No)', 'Recently Promoted (Yes/No)', 'hr_screen', '64', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('50', 'performance_achievement', '', '1', 'Performance Achievement', 'Performance Achievement', 'hr_screen', '65', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('75', 'previous_talent_rating', '', '1', 'Previous Talent Rating', 'Previous Talent Rating', 'hr_screen', '66', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('76', 'promoted_in_2_yrs', '', '1', 'Promoted in 2 year', 'Promoted in 2 year', 'hr_screen', '67', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('77', 'successor_identified', '', '1', 'Successor Identified', 'Successor Identified', 'hr_screen', '68', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('78', 'readyness_level', '', '1', 'Readyness level', 'Readyness level', 'hr_screen', '69', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('79', 'urban_rural_classification', '', '1', 'Urban/Rural classification', 'Urban/Rural classification', 'hr_screen', '70', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('80', 'other_data_9', '', '1', 'Other Data-9', 'Other Data-9', 'hr_screen', '71', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('81', 'other_data_10', '', '1', 'Other Data-10', 'Other Data-10', 'hr_screen', '72', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('82', 'other_data_11', '', '1', 'Other Data-11', 'Other Data-11', 'hr_screen', '73', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('83', 'other_data_12', '', '1', 'Other Data-12', 'Other Data-12', 'hr_screen', '74', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('48', 'other_data_13', '', '1', 'Other Data-13', 'Other Data-13', 'hr_screen', '75', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('85', 'other_data_14', '', '1', 'Other Data-14', 'Other Data-14', 'hr_screen', '76', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('86', 'other_data_15', '', '1', 'Other Data-15', 'Other Data-15', 'hr_screen', '77', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('87', 'other_data_16', '', '1', 'Other Data-16', 'Other Data-16', 'hr_screen', '78', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('88', 'other_data_17', '', '1', 'Other Data-17', 'Other Data-17', 'hr_screen', '79', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('89', 'other_data_18', '', '1', 'Other Data-18', 'Other Data-18', 'hr_screen', '80', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('90', 'other_data_19', '', '1', 'Other Data-19', 'Other Data-19', 'hr_screen', '81', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('91', 'other_data_20', '', '1', 'Other Data-20', 'Other Data-20', 'hr_screen', '82', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('92', 'tenure_in_company', '', '1', 'Tenure in the company', 'Tenure in the company', 'hr_screen', '83', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01'),
('93', 'tenure_in_role', '', '1', 'Tenure in the role', 'Tenure in the role', 'hr_screen', '84', '1', '0', '2020-01-27 15:01:01', '2020-01-27 15:01:01');

ALTER TABLE `login_user` CHANGE `promoted_in_2_yrs` `promoted_in_2_yrs` DATE NULL DEFAULT NULL;
ALTER TABLE `login_user_history` CHANGE `promoted_in_2_yrs` `promoted_in_2_yrs` DATE NULL DEFAULT NULL;

-- Note :: Need to create data migration script for above added all columns into salary_rule_users_dtls tbl


-- ****************************** Dated On : 03-02-2020 ******************************

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` bigint(20) NOT NULL DEFAULT 0,
  `data` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `user_logged_dtls` ADD COLUMN `status` TINYINT(1) DEFAULT 1 NULL COMMENT '1=Entry By Correct Login, 2=Entry By Invalid Attempt' AFTER `ip_address`;


-- ****************************** Dated On : 06-02-2020 ******************************

INSERT INTO `business_attribute` (`id`, `ba_name`, `ba_name_cw`, `display_name`, `desciption`, `data_type_code`, `module_name`, `ba_grouping`, `ba_groups_order`, `ba_attributes_order`, `status`, `is_required`, `updatedon`, `createdon`) VALUES
(204, 'cost_center', 'Cost Center', 'Cost Center', '', 'VARCHAR', 'cost_center', 'Business', 2, 529, 1, 0, '2020-02-06 11:28:00', '2020-02-06 11:28:00'),
(205, 'employee_type', 'Employee Type', 'Employee Type', '', 'VARCHAR', 'employee_type', 'Business', 2, 530, 1, 0, '2020-02-06 11:28:00', '2020-02-06 11:28:00'),
(206, 'employee_role', 'Employee Role', 'Employee Role', '', 'VARCHAR', 'employee_role', 'Business', 2, 531, 1, 0, '2020-02-06 11:28:00', '2020-02-06 11:28:00'),
(207, 'other_data_21', 'Other Data-21', 'Gobal HRBP', '', 'VARCHAR', 'N/A', 'Other', 8, 531, 1, 0, '2020-02-06 11:28:00', '2020-02-06 11:28:00'),
(208, 'other_data_22', 'Other Data-22', 'Functional HRBP', '', 'VARCHAR', 'N/A', 'Other', 8, 532, 1, 0, '2020-02-06 11:28:00', '2020-02-06 11:28:00'),
(209, 'other_data_23', 'Other Data-23', 'HR Partner-1', '', 'VARCHAR', 'N/A', 'Other', 8, 533, 1, 0, '2020-02-06 11:28:00', '2020-02-06 11:28:00'),
(210, 'other_data_24', 'Other Data-24', 'HR Partner-2', '', 'VARCHAR', 'N/A', 'Other', 8, 534, 1, 0, '2020-02-06 11:28:00', '2020-02-06 11:28:00');

ALTER TABLE `login_user` ADD `cost_center` INT NOT NULL COMMENT 'PK of manage_cost_center tbl' AFTER `employee_code`, ADD `employee_type` INT NOT NULL COMMENT 'PK of manage_employee_type tbl' AFTER `cost_center`, ADD `employee_role` INT NOT NULL COMMENT 'PK of manage_employee_role tbl' AFTER `employee_type`, ADD `other_data_21` VARCHAR(100) NOT NULL AFTER `employee_role`, ADD `other_data_22` VARCHAR(100) NOT NULL AFTER `other_data_21`, ADD `other_data_23` VARCHAR(100) NOT NULL AFTER `other_data_22`, ADD `other_data_24` VARCHAR(100) NOT NULL AFTER `other_data_23`;

ALTER TABLE `login_user_history` ADD `cost_center` INT NOT NULL COMMENT 'PK of manage_cost_center tbl' AFTER `employee_code`, ADD `employee_type` INT NOT NULL COMMENT 'PK of manage_employee_type tbl' AFTER `cost_center`, ADD `employee_role` INT NOT NULL COMMENT 'PK of manage_employee_role tbl' AFTER `employee_type`, ADD `other_data_21` VARCHAR(100) NOT NULL AFTER `employee_role`, ADD `other_data_22` VARCHAR(100) NOT NULL AFTER `other_data_21`, ADD `other_data_23` VARCHAR(100) NOT NULL AFTER `other_data_22`, ADD `other_data_24` VARCHAR(100) NOT NULL AFTER `other_data_23`;

CREATE TABLE IF NOT EXISTS `manage_cost_center` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `order_no` smallint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Un-Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `manage_employee_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `order_no` smallint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Un-Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `manage_employee_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `order_no` smallint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Un-Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dropped few column from hr_parameter tbl which are not in use as of now
ALTER TABLE `hr_parameter` DROP `budget_amount`, DROP `budget_percent`, DROP `standard_promotion_increase`, DROP `sp_manager_discretionary_increase`, DROP `sp_manager_discretionary_decrease`;

-- Changed Data Type of few column which are not needed extra size
ALTER TABLE `hr_parameter` CHANGE `overall_budget` `overall_budget` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, CHANGE `comparative_ratio` `comparative_ratio` VARCHAR(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, CHANGE `Manager_discretionary_increase` `Manager_discretionary_increase` DECIMAL(10,2) NOT NULL, CHANGE `Manager_discretionary_decrease` `Manager_discretionary_decrease` DECIMAL(10,2) NOT NULL;

-- Added 3 new columns into hr_parameter tbl
ALTER TABLE `hr_parameter` ADD `cost_centers` TEXT NOT NULL AFTER `special_category`, ADD `employee_types` TEXT NOT NULL AFTER `cost_centers`, ADD `employee_roles` TEXT NOT NULL AFTER `employee_types`;

-- Added 7 new columns into salary_rule_users_dtls tbl
ALTER TABLE `salary_rule_users_dtls` ADD `cost_center` VARCHAR(100) NOT NULL AFTER `other_data_20`, ADD `employee_type` VARCHAR(100) NOT NULL AFTER `cost_center`, ADD `employee_role` VARCHAR(100) NOT NULL AFTER `employee_type`, ADD `other_data_21` VARCHAR(100) NOT NULL AFTER `employee_role`, ADD `other_data_22` VARCHAR(100) NOT NULL AFTER `other_data_21`, ADD `other_data_23` VARCHAR(100) NOT NULL AFTER `other_data_22`, ADD `other_data_24` VARCHAR(100) NOT NULL AFTER `other_data_23`;


-- ****************************** Dated On : 08-02-2020 ******************************
-- Changed ordering of the Business Attributes 
UPDATE business_attribute SET ba_attributes_order = 1 WHERE id = 73;
UPDATE business_attribute SET ba_attributes_order = 2 WHERE id = 204;
UPDATE business_attribute SET ba_attributes_order = 3 WHERE id = 205;
UPDATE business_attribute SET ba_attributes_order = 4 WHERE id = 169;
UPDATE business_attribute SET ba_attributes_order = 5 WHERE id = 1;
UPDATE business_attribute SET ba_attributes_order = 6 WHERE id = 168;
UPDATE business_attribute SET ba_attributes_order = 7 WHERE id = 2;
UPDATE business_attribute SET ba_attributes_order = 8 WHERE id = 135;
UPDATE business_attribute SET ba_attributes_order = 9 WHERE id = 3;
UPDATE business_attribute SET ba_attributes_order = 10 WHERE id = 4;
UPDATE business_attribute SET ba_attributes_order = 11 WHERE id = 5;
UPDATE business_attribute SET ba_attributes_order = 12 WHERE id = 6;
UPDATE business_attribute SET ba_attributes_order = 13 WHERE id = 7;
UPDATE business_attribute SET ba_attributes_order = 14 WHERE id = 8;
UPDATE business_attribute SET ba_attributes_order = 15 WHERE id = 9;
UPDATE business_attribute SET ba_attributes_order = 16 WHERE id = 136;
UPDATE business_attribute SET ba_attributes_order = 17 WHERE id = 10;
UPDATE business_attribute SET ba_attributes_order = 18 WHERE id = 11;
UPDATE business_attribute SET ba_attributes_order = 19 WHERE id = 12;
UPDATE business_attribute SET ba_attributes_order = 20 WHERE id = 206;
UPDATE business_attribute SET ba_attributes_order = 21 WHERE id = 154;
UPDATE business_attribute SET ba_attributes_order = 22 WHERE id = 13;
UPDATE business_attribute SET ba_attributes_order = 23 WHERE id = 14;
UPDATE business_attribute SET ba_attributes_order = 24 WHERE id = 15;
UPDATE business_attribute SET ba_attributes_order = 25 WHERE id = 16;
UPDATE business_attribute SET ba_attributes_order = 26 WHERE id = 17;
UPDATE business_attribute SET ba_attributes_order = 27 WHERE id = 18;
UPDATE business_attribute SET ba_attributes_order = 28 WHERE id = 19;
UPDATE business_attribute SET ba_attributes_order = 29 WHERE id = 20;
UPDATE business_attribute SET ba_attributes_order = 30 WHERE id = 21;
UPDATE business_attribute SET ba_attributes_order = 31 WHERE id = 155;
UPDATE business_attribute SET ba_attributes_order = 32 WHERE id = 22;
UPDATE business_attribute SET ba_attributes_order = 33 WHERE id = 137;
UPDATE business_attribute SET ba_attributes_order = 34 WHERE id = 24;
UPDATE business_attribute SET ba_attributes_order = 35 WHERE id = 23;
UPDATE business_attribute SET ba_attributes_order = 36 WHERE id = 200;
UPDATE business_attribute SET ba_attributes_order = 37 WHERE id = 201;
UPDATE business_attribute SET ba_attributes_order = 38 WHERE id = 202;
UPDATE business_attribute SET ba_attributes_order = 39 WHERE id = 203;
UPDATE business_attribute SET ba_attributes_order = 40 WHERE id = 26;
UPDATE business_attribute SET ba_attributes_order = 41 WHERE id = 28;
UPDATE business_attribute SET ba_attributes_order = 42 WHERE id = 30;
UPDATE business_attribute SET ba_attributes_order = 43 WHERE id = 32;
UPDATE business_attribute SET ba_attributes_order = 44 WHERE id = 34;
UPDATE business_attribute SET ba_attributes_order = 45 WHERE id = 25;
UPDATE business_attribute SET ba_attributes_order = 46 WHERE id = 27;
UPDATE business_attribute SET ba_attributes_order = 47 WHERE id = 29;
UPDATE business_attribute SET ba_attributes_order = 48 WHERE id = 31;
UPDATE business_attribute SET ba_attributes_order = 49 WHERE id = 33;
UPDATE business_attribute SET ba_attributes_order = 50 WHERE id = 190;
UPDATE business_attribute SET ba_attributes_order = 51 WHERE id = 191;
UPDATE business_attribute SET ba_attributes_order = 52 WHERE id = 192;
UPDATE business_attribute SET ba_attributes_order = 53 WHERE id = 193;
UPDATE business_attribute SET ba_attributes_order = 54 WHERE id = 194;
UPDATE business_attribute SET ba_attributes_order = 55 WHERE id = 195;
UPDATE business_attribute SET ba_attributes_order = 56 WHERE id = 196;
UPDATE business_attribute SET ba_attributes_order = 57 WHERE id = 197;
UPDATE business_attribute SET ba_attributes_order = 58 WHERE id = 198;
UPDATE business_attribute SET ba_attributes_order = 59 WHERE id = 199;
UPDATE business_attribute SET ba_attributes_order = 60 WHERE id = 35;
UPDATE business_attribute SET ba_attributes_order = 61 WHERE id = 36;
UPDATE business_attribute SET ba_attributes_order = 62 WHERE id = 37;
UPDATE business_attribute SET ba_attributes_order = 63 WHERE id = 38;
UPDATE business_attribute SET ba_attributes_order = 64 WHERE id = 39;
UPDATE business_attribute SET ba_attributes_order = 65 WHERE id = 40;
UPDATE business_attribute SET ba_attributes_order = 66 WHERE id = 41;
UPDATE business_attribute SET ba_attributes_order = 67 WHERE id = 42;
UPDATE business_attribute SET ba_attributes_order = 68 WHERE id = 43;
UPDATE business_attribute SET ba_attributes_order = 69 WHERE id = 44;
UPDATE business_attribute SET ba_attributes_order = 70 WHERE id = 45;
UPDATE business_attribute SET ba_attributes_order = 71 WHERE id = 46;
UPDATE business_attribute SET ba_attributes_order = 72 WHERE id = 47;
UPDATE business_attribute SET ba_attributes_order = 73 WHERE id = 138;
UPDATE business_attribute SET ba_attributes_order = 74 WHERE id = 139;
UPDATE business_attribute SET ba_attributes_order = 75 WHERE id = 140;
UPDATE business_attribute SET ba_attributes_order = 76 WHERE id = 141;
UPDATE business_attribute SET ba_attributes_order = 77 WHERE id = 142;
UPDATE business_attribute SET ba_attributes_order = 78 WHERE id = 143;
UPDATE business_attribute SET ba_attributes_order = 79 WHERE id = 144;
UPDATE business_attribute SET ba_attributes_order = 80 WHERE id = 145;
UPDATE business_attribute SET ba_attributes_order = 81 WHERE id = 146;
UPDATE business_attribute SET ba_attributes_order = 82 WHERE id = 147;
UPDATE business_attribute SET ba_attributes_order = 83 WHERE id = 170;
UPDATE business_attribute SET ba_attributes_order = 84 WHERE id = 171;
UPDATE business_attribute SET ba_attributes_order = 85 WHERE id = 172;
UPDATE business_attribute SET ba_attributes_order = 86 WHERE id = 173;
UPDATE business_attribute SET ba_attributes_order = 87 WHERE id = 174;
UPDATE business_attribute SET ba_attributes_order = 88 WHERE id = 175;
UPDATE business_attribute SET ba_attributes_order = 89 WHERE id = 176;
UPDATE business_attribute SET ba_attributes_order = 90 WHERE id = 177;
UPDATE business_attribute SET ba_attributes_order = 91 WHERE id = 178;
UPDATE business_attribute SET ba_attributes_order = 92 WHERE id = 179;
UPDATE business_attribute SET ba_attributes_order = 93 WHERE id = 180;
UPDATE business_attribute SET ba_attributes_order = 94 WHERE id = 181;
UPDATE business_attribute SET ba_attributes_order = 95 WHERE id = 182;
UPDATE business_attribute SET ba_attributes_order = 96 WHERE id = 183;
UPDATE business_attribute SET ba_attributes_order = 97 WHERE id = 184;
UPDATE business_attribute SET ba_attributes_order = 98 WHERE id = 185;
UPDATE business_attribute SET ba_attributes_order = 99 WHERE id = 187;
UPDATE business_attribute SET ba_attributes_order = 100 WHERE id = 186;
UPDATE business_attribute SET ba_attributes_order = 101 WHERE id = 188;
UPDATE business_attribute SET ba_attributes_order = 102 WHERE id = 189;
UPDATE business_attribute SET ba_attributes_order = 103 WHERE id = 48;
UPDATE business_attribute SET ba_attributes_order = 104 WHERE id = 49;
UPDATE business_attribute SET ba_attributes_order = 105 WHERE id = 50;
UPDATE business_attribute SET ba_attributes_order = 106 WHERE id = 51;
UPDATE business_attribute SET ba_attributes_order = 107 WHERE id = 52;
UPDATE business_attribute SET ba_attributes_order = 108 WHERE id = 55;
UPDATE business_attribute SET ba_attributes_order = 109 WHERE id = 58;
UPDATE business_attribute SET ba_attributes_order = 110 WHERE id = 61;
UPDATE business_attribute SET ba_attributes_order = 111 WHERE id = 74;
UPDATE business_attribute SET ba_attributes_order = 112 WHERE id = 113;
UPDATE business_attribute SET ba_attributes_order = 113 WHERE id = 116;
UPDATE business_attribute SET ba_attributes_order = 114 WHERE id = 119;
UPDATE business_attribute SET ba_attributes_order = 115 WHERE id = 122;
UPDATE business_attribute SET ba_attributes_order = 116 WHERE id = 125;
UPDATE business_attribute SET ba_attributes_order = 117 WHERE id = 128;
UPDATE business_attribute SET ba_attributes_order = 118 WHERE id = 134;
UPDATE business_attribute SET ba_attributes_order = 119 WHERE id = 54;
UPDATE business_attribute SET ba_attributes_order = 120 WHERE id = 57;
UPDATE business_attribute SET ba_attributes_order = 121 WHERE id = 60;
UPDATE business_attribute SET ba_attributes_order = 122 WHERE id = 63;
UPDATE business_attribute SET ba_attributes_order = 123 WHERE id = 112;
UPDATE business_attribute SET ba_attributes_order = 124 WHERE id = 115;
UPDATE business_attribute SET ba_attributes_order = 125 WHERE id = 118;
UPDATE business_attribute SET ba_attributes_order = 126 WHERE id = 121;
UPDATE business_attribute SET ba_attributes_order = 127 WHERE id = 124;
UPDATE business_attribute SET ba_attributes_order = 128 WHERE id = 127;
UPDATE business_attribute SET ba_attributes_order = 129 WHERE id = 133;
UPDATE business_attribute SET ba_attributes_order = 130 WHERE id = 53;
UPDATE business_attribute SET ba_attributes_order = 131 WHERE id = 56;
UPDATE business_attribute SET ba_attributes_order = 132 WHERE id = 59;
UPDATE business_attribute SET ba_attributes_order = 133 WHERE id = 62;
UPDATE business_attribute SET ba_attributes_order = 134 WHERE id = 111;
UPDATE business_attribute SET ba_attributes_order = 135 WHERE id = 114;
UPDATE business_attribute SET ba_attributes_order = 136 WHERE id = 117;
UPDATE business_attribute SET ba_attributes_order = 137 WHERE id = 120;
UPDATE business_attribute SET ba_attributes_order = 138 WHERE id = 123;
UPDATE business_attribute SET ba_attributes_order = 139 WHERE id = 126;
UPDATE business_attribute SET ba_attributes_order = 140 WHERE id = 132;
UPDATE business_attribute SET ba_attributes_order = 141 WHERE id = 75;
UPDATE business_attribute SET ba_attributes_order = 142 WHERE id = 77;
UPDATE business_attribute SET ba_attributes_order = 143 WHERE id = 76;
UPDATE business_attribute SET ba_attributes_order = 144 WHERE id = 78;
UPDATE business_attribute SET ba_attributes_order = 145 WHERE id = 80;
UPDATE business_attribute SET ba_attributes_order = 146 WHERE id = 79;
UPDATE business_attribute SET ba_attributes_order = 147 WHERE id = 81;
UPDATE business_attribute SET ba_attributes_order = 148 WHERE id = 83;
UPDATE business_attribute SET ba_attributes_order = 149 WHERE id = 82;
UPDATE business_attribute SET ba_attributes_order = 150 WHERE id = 84;
UPDATE business_attribute SET ba_attributes_order = 151 WHERE id = 86;
UPDATE business_attribute SET ba_attributes_order = 152 WHERE id = 85;
UPDATE business_attribute SET ba_attributes_order = 153 WHERE id = 87;
UPDATE business_attribute SET ba_attributes_order = 154 WHERE id = 89;
UPDATE business_attribute SET ba_attributes_order = 155 WHERE id = 88;
UPDATE business_attribute SET ba_attributes_order = 156 WHERE id = 90;
UPDATE business_attribute SET ba_attributes_order = 157 WHERE id = 92;
UPDATE business_attribute SET ba_attributes_order = 158 WHERE id = 91;
UPDATE business_attribute SET ba_attributes_order = 159 WHERE id = 93;
UPDATE business_attribute SET ba_attributes_order = 160 WHERE id = 95;
UPDATE business_attribute SET ba_attributes_order = 161 WHERE id = 94;
UPDATE business_attribute SET ba_attributes_order = 162 WHERE id = 96;
UPDATE business_attribute SET ba_attributes_order = 163 WHERE id = 98;
UPDATE business_attribute SET ba_attributes_order = 164 WHERE id = 97;
UPDATE business_attribute SET ba_attributes_order = 165 WHERE id = 99;
UPDATE business_attribute SET ba_attributes_order = 166 WHERE id = 101;
UPDATE business_attribute SET ba_attributes_order = 167 WHERE id = 100;
UPDATE business_attribute SET ba_attributes_order = 168 WHERE id = 102;
UPDATE business_attribute SET ba_attributes_order = 169 WHERE id = 104;
UPDATE business_attribute SET ba_attributes_order = 170 WHERE id = 103;
UPDATE business_attribute SET ba_attributes_order = 171 WHERE id = 105;
UPDATE business_attribute SET ba_attributes_order = 172 WHERE id = 107;
UPDATE business_attribute SET ba_attributes_order = 173 WHERE id = 106;
UPDATE business_attribute SET ba_attributes_order = 174 WHERE id = 108;
UPDATE business_attribute SET ba_attributes_order = 175 WHERE id = 110;
UPDATE business_attribute SET ba_attributes_order = 176 WHERE id = 109;
UPDATE business_attribute SET ba_attributes_order = 177 WHERE id = 64;
UPDATE business_attribute SET ba_attributes_order = 178 WHERE id = 65;
UPDATE business_attribute SET ba_attributes_order = 179 WHERE id = 66;
UPDATE business_attribute SET ba_attributes_order = 180 WHERE id = 67;
UPDATE business_attribute SET ba_attributes_order = 181 WHERE id = 68;
UPDATE business_attribute SET ba_attributes_order = 182 WHERE id = 69;
UPDATE business_attribute SET ba_attributes_order = 183 WHERE id = 70;
UPDATE business_attribute SET ba_attributes_order = 184 WHERE id = 71;
UPDATE business_attribute SET ba_attributes_order = 185 WHERE id = 72;
UPDATE business_attribute SET ba_attributes_order = 186 WHERE id = 207;
UPDATE business_attribute SET ba_attributes_order = 187 WHERE id = 208;
UPDATE business_attribute SET ba_attributes_order = 188 WHERE id = 209;
UPDATE business_attribute SET ba_attributes_order = 189 WHERE id = 210;
UPDATE business_attribute SET ba_attributes_order = 190 WHERE id = 148;
UPDATE business_attribute SET ba_attributes_order = 191 WHERE id = 149;
UPDATE business_attribute SET ba_attributes_order = 192, display_name = 'Last Promotion Date' WHERE id = 150;
UPDATE business_attribute SET ba_attributes_order = 193 WHERE id = 151;
UPDATE business_attribute SET ba_attributes_order = 194 WHERE id = 152;
UPDATE business_attribute SET ba_attributes_order = 195 WHERE id = 153;
UPDATE business_attribute SET ba_attributes_order = 196 WHERE id = 156;
UPDATE business_attribute SET ba_attributes_order = 197 WHERE id = 157;
UPDATE business_attribute SET ba_attributes_order = 198 WHERE id = 158;
UPDATE business_attribute SET ba_attributes_order = 199 WHERE id = 159;
UPDATE business_attribute SET ba_attributes_order = 200 WHERE id = 160;
UPDATE business_attribute SET ba_attributes_order = 201 WHERE id = 161;
UPDATE business_attribute SET ba_attributes_order = 202 WHERE id = 162;
UPDATE business_attribute SET ba_attributes_order = 203 WHERE id = 163;
UPDATE business_attribute SET ba_attributes_order = 204 WHERE id = 164;
UPDATE business_attribute SET ba_attributes_order = 205 WHERE id = 165;
UPDATE business_attribute SET ba_attributes_order = 206 WHERE id = 166;
UPDATE business_attribute SET ba_attributes_order = 207 WHERE id = 167;


-- ****************************** Dated On : 08-02-2020 (Done By Gaurav Kumar) ******************************

ALTER TABLE `sent_mail_new_approver` CHANGE `q_id` `q_id` INT(11) NOT NULL COMMENT 'PK of corn_job_queue tbl from admin_platform_db (batch_id)';
ALTER TABLE `sent_mail_new_approver` CHANGE `user_id` `user_id` INT(11) NOT NULL COMMENT 'Have this user id';
ALTER TABLE `sent_mail_new_approver` CHANGE `name` `name` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Have this user name';
ALTER TABLE `sent_mail_new_approver` CHANGE `email` `email` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'This is user email and use for send email';
ALTER TABLE `sent_mail_new_approver` CHANGE `status` `status` TINYINT(1) NULL DEFAULT NULL COMMENT 'Must be a status within these(0,1,2,3), 0 means Need to process for send mail(default), 1 means attempt for send mail but fail, 2 means mail send sucessfully, 3 means attempt fail mail to send mail again but again fail(Re-fail)';



ALTER TABLE `sent_mail_new_approver` ADD `priority_level` TINYINT(1) NULL DEFAULT NULL COMMENT 'Priority is high then process first' AFTER `email`, ADD `email_cc` VARCHAR(1024) NULL DEFAULT NULL COMMENT 'Have value in json format' AFTER `priority_level`, ADD `email_bcc` VARCHAR(1024) NULL DEFAULT NULL COMMENT 'Have value in json format' AFTER `email_cc`, ADD `email_from` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Have value for mail from' AFTER `email_bcc`, ADD `email_from_name` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Have value for mail from name' AFTER `email_from`, ADD `email_subject` VARCHAR(512) NULL DEFAULT NULL COMMENT 'Have value for mail subject' AFTER `email_from_name`, ADD `email_content` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Have value for mail content with stripslashes' AFTER `email_subject`, ADD `updatedon` DATETIME NULL DEFAULT NULL COMMENT 'update at the time of email send' AFTER `email_content`, ADD `createdon` DATETIME NULL DEFAULT NULL COMMENT 'update at the time of ow created' AFTER `updatedon`;


ALTER TABLE `sent_mail_new_approver` CHANGE `name` `name` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL COMMENT 'Have this user name';
ALTER TABLE `sent_mail_new_approver` CHANGE `email` `email` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NULL DEFAULT NULL COMMENT 'Have this field user email and this is use for send mail(Send mail to this email). This is same as mail_to';
ALTER TABLE `sent_mail_new_approver` CHANGE `email_cc` `email_cc` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NULL DEFAULT NULL COMMENT 'Have value in json format';
ALTER TABLE `sent_mail_new_approver` CHANGE `email_bcc` `email_bcc` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NULL DEFAULT NULL COMMENT 'Have value in json format';
ALTER TABLE `sent_mail_new_approver` CHANGE `email_from` `email_from` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NULL DEFAULT NULL COMMENT 'Have value for mail from';
ALTER TABLE `sent_mail_new_approver` CHANGE `email_from_name` `email_from_name` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NULL DEFAULT NULL COMMENT 'Have value for mail from name';
ALTER TABLE `sent_mail_new_approver` CHANGE `email_subject` `email_subject` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NULL DEFAULT NULL COMMENT 'Have value for mail subject';
ALTER TABLE `sent_mail_new_approver` CHANGE `email_content` `email_content` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NULL DEFAULT NULL COMMENT 'Have value for mail content with stripslashes';


-- ****************************** Dated On : 10-02-2020 ******************************

-- Changed ba_name_cw and display_name of few Business Attributes into tbl as business_attribute
UPDATE business_attribute SET ba_name_cw = 'Date of joining for proration  purpose', display_name = 'Date of joining for proration  purpose' WHERE id = 18;
UPDATE business_attribute SET ba_name_cw = 'Last year rating', display_name = 'Last year rating' WHERE id = 23;
UPDATE business_attribute SET ba_name_cw = '2nd last year rating', display_name = '2nd last year rating' WHERE id = 200;
UPDATE business_attribute SET ba_name_cw = '3rd last year rating', display_name = '3rd last year rating' WHERE id = 201;
UPDATE business_attribute SET ba_name_cw = '4th Last year rating', display_name = '4th Last year rating' WHERE id = 202;
UPDATE business_attribute SET ba_name_cw = '5th last year rating', display_name = '5th last year rating' WHERE id = 203;
UPDATE business_attribute SET ba_name_cw = 'Effective date of 2nd last Salary increase', display_name = 'Effective date of 2nd last Salary increase' WHERE id = 28;
UPDATE business_attribute SET ba_name_cw = 'Last year Fixed Salary', display_name = 'Last year Fixed Salary' WHERE id = 25;
UPDATE business_attribute SET ba_name_cw = '2nd last year Fixed Salary', display_name = '2nd last year Fixed Salary' WHERE id = 27;
UPDATE business_attribute SET ba_name_cw = '3rd last year Fixed Salary', display_name = '3rd last year Fixed Salary' WHERE id = 29;
UPDATE business_attribute SET ba_name_cw = '4th Last year Fixed Salary', display_name = '4th Last year Fixed Salary' WHERE id = 31;
UPDATE business_attribute SET ba_name_cw = '5th last year Fixed Salary', display_name = '5th last year Fixed Salary' WHERE id = 33;
UPDATE business_attribute SET ba_name_cw = 'Last year Total Cost To Company', display_name = 'Last year Total Cost To Company' WHERE id = 190;
UPDATE business_attribute SET ba_name_cw = '2nd last year Total Cost To Company', display_name = '2nd last year Total Cost To Company' WHERE id = 191;
UPDATE business_attribute SET ba_name_cw = '3rd last year Total Cost To Company', display_name = '3rd last year Total Cost To Company' WHERE id = 192;
UPDATE business_attribute SET ba_name_cw = '4th Last year Total Cost To Company', display_name = '4th Last year Total Cost To Company' WHERE id = 193;
UPDATE business_attribute SET ba_name_cw = '5th last year Total Cost To Company', display_name = '5th last year Total Cost To Company' WHERE id = 194;
UPDATE business_attribute SET ba_name_cw = 'Last year Target Cost to Company', display_name = 'Last year Target Cost to Company' WHERE id = 195;
UPDATE business_attribute SET ba_name_cw = '2nd last year Target Cost to Company', display_name = '2nd last year Target Cost to Company' WHERE id = 196;
UPDATE business_attribute SET ba_name_cw = '3rd last year Target Cost to Company', display_name = '3rd last year Target Cost to Company' WHERE id = 197;
UPDATE business_attribute SET ba_name_cw = '4th Last year Target Cost to Company', display_name = '4th Last year Target Cost to Company' WHERE id = 198;
UPDATE business_attribute SET ba_name_cw = '5th last year Target Cost to Company', display_name = '5th last year Target Cost to Company' WHERE id = 199;
UPDATE business_attribute SET ba_name_cw = 'Base/Basic', display_name = 'Base/Basic' WHERE id = 36;
UPDATE business_attribute SET ba_name_cw = 'Fixed salary', display_name = 'Fixed salary' WHERE id = 49;
UPDATE business_attribute SET ba_name_cw = 'Other Data-10', display_name = 'Other Data-10' WHERE id = 157;
UPDATE business_attribute SET ba_name_cw = 'Other data-11', display_name = 'Other data-11' WHERE id = 158;
UPDATE business_attribute SET ba_name_cw = 'Other data-12', display_name = 'Other data-12' WHERE id = 159;
UPDATE business_attribute SET ba_name_cw = 'Other data-13', display_name = 'Other data-13' WHERE id = 160;


-- ****************************** Dated On : 11-02-2020 ******************************

-- created a new tbl as tbl_promotion_up_gradation
CREATE TABLE IF NOT EXISTS `tbl_promotion_up_gradation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation_frm` int(11) NOT NULL COMMENT 'PK of manage_designation tbl',
  `designation_to` int(11) NOT NULL COMMENT 'PK of manage_designation tbl',
  `grade_frm` int(11) NOT NULL COMMENT 'PK of manage_grade tbl',
  `grade_to` int(11) NOT NULL COMMENT 'PK of manage_grade tbl',
  `level_frm` int(11) NOT NULL COMMENT 'PK of manage_level tbl',
  `level_to` int(11) NOT NULL COMMENT 'PK of manage_level tbl',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 2=Inactive',
  `created_by` int(11) NOT NULL COMMENT 'PK of login_user tbl',
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) NOT NULL COMMENT 'PK of login_user tbl',
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- ****************************** Dated On : 12-02-2020 ******************************

ALTER TABLE `manage_company` ADD `managers_hierarchy_based_on` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1=Manual, 2=Using 1st Manager, 3=API Integration' AFTER `preserved_days`;


-- ****************************** Dated On : 15-02-2020 ******************************

ALTER TABLE `hr_parameter` ADD `bring_emp_to_min_sal` TINYINT(1) NOT NULL DEFAULT '2' COMMENT '1=Yes (Apply market increase to bring emp to min salary), 2=No' AFTER `salary_position_based_on`;


-- ****************************** Dated On : 20-02-2020 ******************************

ALTER TABLE `employee_salary_details` CHANGE `increment_applied_on_salary` `increment_applied_on_salary` DECIMAL(18,8) NOT NULL, CHANGE `performnace_based_increment` `performnace_based_increment` DECIMAL(15,8) NOT NULL COMMENT 'No of percent', CHANGE `crr_based_increment` `crr_based_increment` DECIMAL(15,8) NOT NULL COMMENT 'No of percent', CHANGE `sp_increased_salary` `sp_increased_salary` DECIMAL(18,8) NOT NULL, CHANGE `final_merit_hike` `final_merit_hike` DECIMAL(15,8) NOT NULL, CHANGE `final_market_hike` `final_market_hike` DECIMAL(15,8) NOT NULL, CHANGE `emp_final_bdgt` `emp_final_bdgt` DECIMAL(18,8) NOT NULL COMMENT 'Calculated budget emp wise for manager', CHANGE `final_salary` `final_salary` DECIMAL(18,8) NOT NULL COMMENT 'Rule creation time salary or after modify by manager', CHANGE `actual_salary` `actual_salary` DECIMAL(18,8) NOT NULL COMMENT 'Rule creation time salary';


-- ****************************** Dated On : 23-02-2020 ******************************
ALTER TABLE `employee_salary_details` ADD `emp_currency_conversion_rate` DECIMAL(10,6) NOT NULL AFTER `manager_discretions`;

UPDATE `employee_salary_details` SET `emp_currency_conversion_rate` = (SELECT rate FROM currency_rates WHERE from_currency = (SELECT id FROM manage_currency WHERE name = employee_salary_details.currency) AND to_currency = (SELECT to_currency_id FROM hr_parameter WHERE id = rule_id));


-- ****************************** Dated On : 25-02-2020 ******************************
ALTER TABLE `hr_parameter` ADD `show_prorated_current_sal` TINYINT(1) NOT NULL DEFAULT '2' COMMENT '1=Yes(Display Employees current salary as Prorated), 2=No(Display Actual Salary)' AFTER `display_variable_salary`;


-- ****************************** Dated On : 04-03-2020 ******************************
ALTER TABLE `employee_salary_details` ADD `comments` TEXT NOT NULL COMMENT 'Comments for Salary/Promotion' AFTER `promotion_comment`;

ALTER TABLE `hr_parameter` ADD `rounding_final_salary` INT(2) NOT NULL DEFAULT '1' AFTER `show_prorated_current_sal`;

INSERT INTO `table_attribute` (`id`, `attribute_name`, `table_name`, `created_by`, `display_name`, `desciption`, `module_name`, `col_attributes_order`, `status`, `is_lock`, `updatedon`, `createdon`) VALUES ('94', 'comments', '', '1', 'Salary/Promotion Comments', 'Salary/Promotion Comments', 'hr_screen', '85', '0', '0', '2020-03-03 18:30:00', '2020-03-03 18:30:00');


-- ****************************** Dated On : 05-03-2020 ******************************
ALTER TABLE `revenue_per_business_units_in_year` ADD `updated_on` DATETIME NULL AFTER `profit`, ADD `createdon` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `updated_on`;

CREATE TABLE IF NOT EXISTS `employee_salary_details_rows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_id` varchar(50) DEFAULT NULL,
  `approver_1` varchar(50) DEFAULT NULL,
  `rule_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_combo_emp` (`email_id`,`approver_1`,`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `manage_business_level_1` ADD INDEX `m_business_level_1_name_IDX` (`name`);
ALTER TABLE `manage_business_level_2` ADD INDEX `m_business_level_2_name_IDX` (`name`);
ALTER TABLE `manage_business_level_3` ADD INDEX `m_business_level_3_name_IDX` (`name`);
ALTER TABLE `manage_city` ADD INDEX `m_city_name_IDX` (`name`);
ALTER TABLE `manage_cost_center` ADD INDEX `m_cost_center_name_IDX` (`name`);
ALTER TABLE `manage_country` ADD INDEX `m_country_name_IDX` (`name`);
ALTER TABLE `manage_critical_position` ADD INDEX `m_critical_position_name_IDX` (`name`);
ALTER TABLE `manage_critical_talent` ADD INDEX `m_critical_talent_name_IDX` (`name`);
ALTER TABLE `manage_currency` ADD INDEX `m_currency_name_IDX` (`name`);
ALTER TABLE `manage_designation` ADD INDEX `m_designation_name_IDX` (`name`);
ALTER TABLE `manage_education` ADD INDEX `m_education_name_IDX` (`name`);
ALTER TABLE `manage_employee_role` ADD INDEX `m_employee_role_name_IDX` (`name`);
ALTER TABLE `manage_employee_type` ADD INDEX `m_employee_type_name_IDX` (`name`);
ALTER TABLE `manage_function` ADD INDEX `m_function_name_IDX` (`name`);
ALTER TABLE `manage_grade` ADD INDEX `m_grade_name_IDX` (`name`);
ALTER TABLE `manage_level` ADD INDEX `m_level_name_IDX` (`name`);
ALTER TABLE `manage_rating_for_current_year` ADD INDEX `m_rating_for_current_year_name_IDX` (`name`);
ALTER TABLE `manage_special_category` ADD INDEX `m_special_category_name_IDX` (`name`);
ALTER TABLE `manage_subfunction` ADD INDEX `m_subfunction_name_IDX` (`name`);
ALTER TABLE `manage_sub_subfunction` ADD INDEX `m_sub_subfunction_name_IDX` (`name`);


-- ****************************** Dated On : 06-03-2020 ******************************
INSERT INTO email_templates (`id`, `target_point_id`, `trigger_point`, `email_subject`, `email_body`, `status`, `updatedby`, `updatedon`, `createdby`, `createdon`, `createdby_proxy`, `updatedby_proxy`) VALUES (NULL, '18', NULL, 'New salary rule released on manager', '<div>Dear {{employee_first_name}},</div><div>New salary rule as : <span style=\"font-weight: bold;\">{{rule_name}} </span>is now released.</div><div>Please go to site then login and check your salary.<br></div>', '1', '1', '2020-02-12 00:00:00', '1', current_timestamp(), 0, 0);


-- ****************************** Dated On : 07-03-2020 ******************************
UPDATE `business_attribute` SET `ba_name_cw` = 'Official Email ID', `display_name` = 'Official Email ID', `module_name` = 'official_email_id', `ba_grouping` = 'Personal', `is_required` = 1 WHERE `business_attribute`.`id` = 167;

ALTER TABLE `login_user` CHANGE `other_data_20` `other_data_20` VARCHAR(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE `login_user` CHANGE `other_data_20` `other_data_20` VARCHAR(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Use this field for official email id';

ALTER TABLE `login_user_history` CHANGE `other_data_20` `other_data_20` VARCHAR(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE `login_user_history` CHANGE `other_data_20` `other_data_20` VARCHAR(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Use this field for official email id';


-- Note :: Need to create data migration script for columns as employee_salary_details.market_salary_column