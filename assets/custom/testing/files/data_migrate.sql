--insert data into address table: migrate employee address details from emlaybar_db.kms_usermeta
INSERT INTO lbmis_main.address(`Address1`,`Address2`, `City`,`State`,`ZipCode`,`Country`) SELECT `address1`, `address2`, `city`,  `state`, `zip_code`, `country` FROM emlaybar_db.kms_usermeta WHERE TRIM(`address1`) !='' OR TRIM(`address2`) != '';

--Insert data into person table: migrate employee personal info from emlaybar_db.kms_usermeta
INSERT INTO lbmis_main.person(`FirstName`,`MiddleName`,`LastName`,`Gender`,`MaritalStatus`,`Birthday`,`SSSNumber`,`PhilhealthNumber`,`PagIbigNumber`,`TIN`,`HomePhone`) SELECT `first_name`, `middle_name`, `last_name`, `gender`, `civil_status`, STR_TO_DATE(CONCAT(SUBSTRING(`b_month`,1,3),' ',`b_day`,' ',`b_year`),'%b %d %Y'),`sss_id`,`philhealth_id`,`pagibig_id`,`tin_id`, `telephone_num` FROM emlaybar_db.kms_usermeta WHERE user_id != '';

--Update person table: Link address to person via AddressID
UPDATE lbmis_main.person old, (SELECT a.AddressID, b.first_name, b.middle_name, b.last_name FROM lbmis_main.address a JOIN emlaybar_db.kms_usermeta b ON a.Address1 = b.address1 AND a.Address2 = b.address2 AND a.city = b.city AND a.state = b.state) new SET old.AddressID = new.AddressID WHERE old.FirstName = new.first_name AND old.MiddleName = new.middle_name AND old.LastName = new.last_name;

--Insert data into employee table: migrate work information from emlaybar_db.kms_usermeta
INSERT INTO lbmis_main.employee(`EmployeeID`,`CompanyEmail`,`CompanyMobileNumber`,`DateHired`,`MonthlySalary`,`BankAccountNumber`,`SSSNumber`,`PhilhealthNumber`,`PagIbigNumber`,`EmployeeSkills`) SELECT `emp_id`,`email`,`mobile_num`,STR_TO_DATE(`date_hired`,'%m-%d-%Y'),`reg_rate`,`bankaccount_id`,`sss_id`,`philhealth_id`,`pagibig_id`,`emp_skills` FROM emlaybar_db.kms_usermeta WHERE  trim(emp_id) != '';

--Update employee table:  link work info to personal info
UPDATE lbmis_main.employee old, (SELECT a.PersonID, b.emp_id FROM lbmis_main.person a JOIN emlaybar_db.kms_usermeta b ON a.FirstName = b.first_name AND a.MiddleName = b.middle_name AND a.LastName = b.last_name) new SET old.PersonID = new.PersonID WHERE old.EmployeeID = new.emp_id;

-- Insert data into company table:  migrate company_list data from emlaybar_db.company
INSERT INTO lbmis_main.company(`CompanyName`,`CompanyGroupID`) SELECT `com_name`, 1 FROM emlaybar_db.company_list;

-- Insert data into department table: migrate department data from emlaybar_db.department
INSERT INTO lbmis_main.department(`DepartmentName`) SELECT `dep_name` FROM emlaybar_db.department;

-- Insert data into job_title table: migrate job title data from emlaybar_db.job_title
INSERT INTO lbmis_main.job_title(`JobTitleName`) SELECT `job_name` FROM emlaybar_db.job_title;
UPDATE lbmis_main.job_title a JOIN emlaybar_db.job_title b ON a.`JobTitleName` = b.`job_name` JOIN emlaybar_db.department c ON b.`dep_id` = c.`dep_id` SET `DepartmentID` = (SELECT `DepartmentID` FROM lbmis_main.department WHERE `DepartmentName` = c.`dep_name`);

-- Update employee table: Link job title, department, and company into work info
UPDATE lbmis_main.employee a JOIN lbmis_main.person b ON a.`PersonID` = b.`PersonID` JOIN emlaybar_db.kms_usermeta c ON b.`FirstName` = c.`first_name` AND b.`MiddleName` = c.`middle_name` AND b.`LastName` = c.`last_name` JOIN emlaybar_db.job_title d ON c.`position` = d.`job_id` SET `JobTitleID` = (SELECT `JobTitleID` FROM lbmis_main.job_title WHERE `JobTitleName` = d.`job_name`);

UPDATE lbmis_main.employee a JOIN lbmis_main.person b ON a.`PersonID` = b.`PersonID` JOIN emlaybar_db.kms_usermeta c ON b.`FirstName` = c.`first_name` AND b.`MiddleName` = c.`middle_name` AND b.`LastName` = c.`last_name` JOIN emlaybar_db.department d ON c.`dep_id` = d.`dep_id` SET `DepartmentID` = (SELECT `DepartmentID` FROM lbmis_main.department WHERE `DepartmentName` = d.`dep_name`);

UPDATE lbmis_main.employee a JOIN lbmis_main.person b ON a.`PersonID` = b.`PersonID` JOIN emlaybar_db.kms_usermeta c ON b.`FirstName` = c.`first_name` AND b.`MiddleName` = c.`middle_name` AND b.`LastName` = c.`last_name` JOIN emlaybar_db.company_list d ON c.`com_id` = d.`id` SET `CompanyID` = (SELECT `CompanyID` FROM lbmis_main.company WHERE `CompanyName` = d.`com_name`);

--Update employee table: link employment status
UPDATE lbmis_main.employee a JOIN lbmis_main.person b ON a.`PersonID` = b.`PersonID` JOIN emlaybar_db.kms_usermeta c ON b.`FirstName` = c.`first_name` AND b.`MiddleName` = c.`middle_name` AND b.`LastName` = c.`last_name` SET `EmploymentStatusID` = CASE WHEN c.`status` = 1 THEN (CASE WHEN c.`emp_status`= 1 THEN 3 WHEN c.`emp_status` = 3 THEN 1 ELSE 2 END) WHEN c.`status`= 2 THEN 5 WHEN c.`status` = 3 THEN 6 WHEN c.`status` = 4 THEN 7 WHEN c.`status` = 5 THEN 8 END;

--Insert data into tax_exemption table: migrate data from emlaybar_db.tax_exemption
INSERT INTO lbmis_main.tax_exemption(`TaxExemptionName`) SELECT `te_name` FROM emlaybar_db.tax_exemption;
INSERT INTO lbmis_main.tax_exemption_schedule(`TaxExemptionID`,`PersonalExemption`,`DependentExemption`,`EffectivityDate`) SELECT a.`TaxExemptionID`,b.`p_exempt`,b.`te_dep`,'2009-01-01' FROM lbmis_main.tax_exemption a JOIN emlaybar_db.tax_exemption b ON a.`TaxExemptionName` = b.`te_name`;

--Update employee table:  link tax exemption
UPDATE lbmis_main.employee a JOIN lbmis_main.person b ON a.`PersonID` = b.`PersonID` JOIN emlaybar_db.kms_usermeta c ON b.`FirstName` = c.`first_name` AND b.`MiddleName` = c.`middle_name` AND b.`LastName` = c.`last_name` JOIN emlaybar_db.tax_exemption d ON c.`te_id` = d.`id` SET `TaxExemptionID` = (SELECT `TaxExemptionID` FROM lbmis_main.tax_exemption WHERE `TaxExemptionName` = d.`te_name`);

--Insert data into payment_frequency table: migrate data from emlaybar_db.payment_frequency
INSERT INTO lbmis_main.payment_frequency(`PaymentFrequencyName`) SELECT `pf_name` FROM emlaybar_db.payment_frequency;

--Update employee table: link payment frequency
UPDATE lbmis_main.employee a JOIN lbmis_main.person b ON a.`PersonID` = b.`PersonID` JOIN emlaybar_db.kms_usermeta c ON b.`FirstName` = c.`first_name` AND b.`MiddleName` = c.`middle_name` AND b.`LastName` = c.`last_name` JOIN emlaybar_db.payment_frequency d ON c.`pf_id` = d.`id` SET `PaymentFrequencyID` = (SELECT `PaymentFrequencyID` FROM lbmis_main.payment_frequency WHERE `PaymentFrequencyName` = d.`pf_name`);

--Insert data into batch table: migrate data from emlaybar_db.batch_code
INSERT INTO lbmis_main.batch(`BatchName`,`StartTime`,`EndTime`) SELECT `batch_name`, CASE WHEN `batch_name` like '%8:00%' THEN '08:00:00' WHEN `batch_name` like '%8:30%' THEN '08:30:00' WHEN `batch_name` like '%9:00%' THEN '09:00:00' WHEN `batch_name` like '%9:30%' THEN '09:30:00' END, CASE WHEN `batch_name` like '%8:00%' THEN '15:00:00' WHEN `batch_name` like '%8:30%' THEN '15:30:00' WHEN `batch_name` like '%9:00%' THEN '16:00:00' WHEN `batch_name` like '%9:30%' THEN '16:30:00' END FROM emlaybar_db.batch_code;

--Update employee table: link batch
UPDATE lbmis_main.employee a JOIN lbmis_main.person b ON a.`PersonID` = b.`PersonID` JOIN emlaybar_db.kms_usermeta c ON b.`FirstName` = c.`first_name` AND b.`MiddleName` = c.`middle_name` AND b.`LastName` = c.`last_name` JOIN emlaybar_db.batch_code d ON c.`batch_id` = d.`id` SET `BatchID` = (SELECT `BatchID` FROM lbmis_main.batch WHERE `BatchName` = d.`batch_name`);

--Insert data into SSS Contribution Schedule
INSERT INTO lbmis_main.sss_schedule(`MinimumRange`,`MaximumRange`,`MonthlySalaryCredit`,`EmployerShare`,`EmployeeShare`,`EffectivityDate`) SELECT `min_range`,`max_range`,`sal_cred`,`ee_er`,`ee_ee`,'2014-01-01' FROM emlaybar_db.sss_list ORDER BY `id`;

--Insert data into philhealth contribution schedule
INSERT INTO lbmis_main.philhealth_schedule(`MinimumRange`,`MaximumRange`,`SalaryBase`,`EmployeeShare`,`EmployerShare`,`EffectivityDate`) SELECT `min_range`,`max_range`,`sal_base`,`ee_share`,`er_share`,'2014-01-01' FROM emlaybar_db.philhealth_list ORDER BY `id`;

--Insert data into pagibig contribution schedule
INSERT INTO lbmis_main.pagibig_schedule(`MinimumRange`,`MaximumRange`,`EmployerShare`,`EmployeeShare`,`EffectivityDate`) SELECT `min_range`,`max_range`,`er`,`ee`,'2014-01-01' FROM emlaybar_db.pagibig_list ORDER BY `id`;

--Insert data into withholding tax table
UPDATE lbmis_main.withholding_tax_schedule a JOIN lbmis_main.tax_exemption b ON a.TaxExemptionID = b.TaxExemptionID LEFT JOIN emlaybar_db.tax_exemption c ON b.TaxExemptionName = c.te_name
SET a.`TaxExempt` = (SELECT CASE WHEN a.TaxRate = 0.00 THEN tr1 WHEN a.TaxRate = 0.05 THEN tr2 WHEN a.TaxRate = 0.10 THEN tr3 WHEN a.TaxRate = 0.15 THEN tr4 WHEN a.TaxRate = 0.20 THEN tr5 WHEN a.TaxRate = 0.25 THEN tr6 WHEN a.TaxRate = 0.30 THEN tr7 WHEN a.TaxRate = 0.32 THEN tr8 END FROM emlaybar_db.wtax_monthly WHERE te_id=c.id), 
a.`TaxDue` = (SELECT CASE WHEN a.TaxRate = 0.00 THEN 0 WHEN a.TaxRate = 0.05 THEN 0 WHEN a.TaxRate = 0.10 THEN 41.67 WHEN a.TaxRate = 0.15 THEN 208.33 WHEN a.TaxRate = 0.20 THEN 708.33 WHEN a.TaxRate = 0.25 THEN 1875 WHEN a.TaxRate = 0.30 THEN 4166.67 WHEN a.TaxRate = 0.32 THEN 10416.67 END);

-- Insert data into employee_attendance table:  the data is coming from the imported biometrics text file
INSERT INTO lbmis_main.employee_attendance(`EmployeeID`,`Date`,`TimeIn`,`Timeout`) SELECT `EmployeeID`,STR_TO_DATE(`LogDate`,'%m/%d/%Y'),MIN(STR_TO_DATE(`LogTime`,'%h:%i:%s')), MAX(STR_TO_DATE(`LogTime`,'%h:%i:%s')) FROM lbmis_main.timelog GROUP BY `EmployeeID`,`LogDate`;


----------------------------
-- QUERIES
--GET LATE
SELECT a.`Date`, CASE WHEN c.`Time` IS NOT NULL THEN c.`Time` ELSE a.`TimeIn` END AS TimeIn, ROUND(TIME_TO_SEC(TIMEDIFF(CASE WHEN c.`Time` IS NOT NULL THEN c.`Time` ELSE a.`TimeIn` END, b.`TimeIn`))/60) AS Late FROM employee_attendance a LEFT JOIN employee_schedule b ON a.`EmployeeID` = b.`EmployeeID` AND a.`Date` BETWEEN b.`DateStart` AND b.`DateEnd` LEFT JOIN employee_time_adjustment c ON a.`EmployeeID` = c.`EmployeeID` AND a.`Date` = c.`Date` AND c.`LogType` = 'Time In' WHERE (TIME_TO_SEC(TIMEDIFF(CASE WHEN c.`Time` IS NOT NULL THEN c.`Time` ELSE a.`TimeIn` END, b.`TimeIn`))/60)>15 AND a.`EmployeeID` = '2014-0177';

--GET UNDERTIME
SELECT a.`Date`, CASE WHEN c.`Time` IS NOT NULL THEN c.`Time` ELSE a.`Timeout` END AS TimeOut, ROUND (TIME_TO_SEC(TIMEDIFF(b.`TimeOut`, CASE WHEN c.`Time` IS NOT NULL THEN c.`Time` ELSE a.`TimeOut` END ))/60) AS Undertime FROM employee_attendance a LEFT JOIN employee_schedule b ON a.`EmployeeID` = b.`EmployeeID` AND a.`Date` BETWEEN b.`DateStart` AND b.`DateEnd` LEFT JOIN employee_time_adjustment c ON a.`EmployeeID` = c.`EmployeeID` AND a.`Date` = c.`Date` AND c.`LogType` = 'Time Out' WHERE (TIME_TO_SEC(TIMEDIFF(b.`TimeOut`, CASE WHEN c.`Time` IS NOT NULL THEN c.`Time` ELSE a.`TimeOut` END ))/60)>0 AND a.`EmployeeID` = '2014-0177';

-- GET ABSENT

SELECT COUNT(*) FROM `employee_attendance` WHERE DATE NOT IN (SELECT `Date` FROM `employee_attendance` WHERE `EmployeeID` = '2011-0036') AND DATE NOT IN (SELECT DATE FROM employee_travel_schedule WHERE `EmployeeID`='2011-0036' AND `RequestStatus`='Approved' AND DATE BETWEEN `DateStart` AND `DateEnd`)  AND (DATE BETWEEN '2015-02-16' AND '2015-02-28') AND (DAYOFWEEK(DATE) BETWEEN 2 AND 6) AND `EmployeeID` = '2011-0036';
-- TIMEDIFF()

SELECT ROUND(COUNT(*)*(b.`MonthlySalary`/22)) FROM `employee_attendance` a JOIN `employee` b ON a.`EmployeeID`=b.`EmployeeID` WHERE DATE NOT IN (SELECT `Date` FROM `employee_attendance` WHERE `EmployeeID` = '2011-0036') AND DATE NOT IN (SELECT DATE FROM employee_travel_schedule WHERE `EmployeeID`='2011-0036' AND `RequestStatus`='Approved' AND DATE BETWEEN `DateStart` AND `DateEnd`) AND DATE NOT IN (SELECT DATE FROM employee_leave WHERE `EmployeeID`='2011-0036' AND `RequestStatus`='Approved' AND DATE BETWEEN `DateStart` AND `DateEnd`) AND (DATE BETWEEN '2015-02-16' AND '2015-02-28') AND (DAYOFWEEK(DATE) BETWEEN 2 AND 6);
-- TIME_TO_SEC('00:00:1') / 60


AND DATE NOT IN (SELECT DATE FROM employee_leave WHERE `EmployeeID`='2011-0036' AND `RequestStatus`='Approved' AND DATE BETWEEN `DateStart` AND `DateEnd`)

--POPULATE EMPLOYEE ATTENDANCE
SELECT a.`EmployeeID`,STR_TO_DATE(a.`LogDate`,'%m/%d/%Y'),MIN(STR_TO_DATE(a.`LogTime`,'%h:%i:%s')), MAX(STR_TO_DATE(a.`LogTime`,'%h:%i:%s')), b.`EmployeeID`,b.`Date` FROM lbmis_main.timelog a LEFT JOIN lbmis_main.employee_attendance b ON a.`EmployeeID` = b.`EmployeeID` and STR_TO_DATE(a.`LogDate`,'%m/%d/%Y') = b.`Date` WHERE b.`EmployeeID` IS NULL GROUP BY a.`EmployeeID`,a.`LogDate`

--UPDATE EMPLOYEE ATTENDANCE
UPDATE `employee_attendance` old, (SELECT `EmployeeID`, `LogDate`, `LogTime` FROM `timelog` ORDER BY `LogTime` DESC) new SET `TimeOut` = new.`LogTime` where old.`EmployeeID` = new.`EmployeeID` and old.`Date` = STR_TO_DATE(new.`LogDate`,'%m/%d/%Y');


-- GET THE ABSENT DEDUCTION BY EMPLOYEE
-- Get the number of days
SELECT IFNULL(ROUND((SELECT COUNT(DISTINCT(DATE))
FROM `employee_attendance`
-- check if the date has no time in 
WHERE DATE NOT IN (SELECT `Date` FROM `employee_attendance` WHERE `EmployeeID` = '1')
-- check if there is no travel on the said date 
AND DATE NOT IN (SELECT DATE FROM employee_travel_schedule WHERE `EmployeeID`='1' AND `RequestStatus`='Approved' AND DATE BETWEEN `DateStart` AND `DateEnd`) 
-- check if there the employee is not on leave on the said date
AND DATE NOT IN (SELECT DATE FROM employee_leave WHERE `EmployeeID`='1' AND `RequestStatus`='Approved' AND DATE BETWEEN `DateStart` AND `DateEnd`) 
-- check if the date is not holiday
AND DATE NOT IN (SELECT `Date` FROM holiday_schedule WHERE `Date` BETWEEN '2015-01-01' AND '2015-01-15')
-- check if the date is not weekend
AND (DAYOFWEEK(DATE) BETWEEN 2 AND 6)
-- get the dates based on the specified range.   After the number of days has been countend then multiply by the employee's daily rate
AND DATE BETWEEN '2015-01-01' AND '2015-01-15')*(SELECT `MonthlySalary`/22 FROM `employee` WHERE `EmployeeID`='1')),0) AS AbsentDeduction 


--Get Time Differential
SELECT a.`Date`, (TIME_TO_SEC(TIMEDIFF(CASE WHEN IFNULL(c.`Time`,'00:00:00')>'22:00:00' AND c.`Status`='Approved' AND c.`LogType`='Time Out' THEN c.`Time` ELSE a.`TimeOut` END, CASE WHEN IFNULL(c.`Time`,'00:00:00')>'22:00:00' AND c.`Status`='Approved' AND c.`LogType`='Time In' THEN c.`Time` ELSE '22:00:00' END))/60)/60 as NightDifferential
FROM `employee_attendance` a JOIN `employee_schedule` b ON a.`EmployeeID` = b.`EmployeeID` LEFT JOIN `employee_time_adjustment` c ON a.`EmployeeID` = c.`EmployeeID` AND a.`Date` = c.`Date` LEFT JOIN `employee_overtime` d ON a.`EmployeeID`= d.`EmployeeID` AND a.`Date` = d.`OvertimeDate`
WHERE (b.`EndTime`>'22:00:00' OR (IFNULL(d.`EndTime`,'00:00:00')>'22:00:00' AND d.`RequestStatus`='Approved')) AND a.`EmployeeID` = '2011-0036' GROUP BY a.`Date`