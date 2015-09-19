-- POPULATE PROVINCE
INSERT INTO `egov_main`.`province`(`provinceName`) SELECT DISTINCT(`provinceStateName`) FROM `egov_main`.`_templocation`;

-- POPULATE MUNICIPALITY
INSERT INTO `egov_main`.`city_municipality`(`cityMunicipalityName`,`cityMunicipalityType`,`provinceID`) SELECT a.`cityMunicipalityName`, a.`cityMunicipalityType`, b.`provinceID` FROM `egov_main`.`_templocation` a JOIN `egov_main`.`province` b ON a.`provinceStateName` = b.`provinceName` ORDER BY a.`provinceStateName` ASC, a.`cityMunicipalityName` ASC;