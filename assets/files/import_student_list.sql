-- POPULATE SECTION
INSERT INTO `academic_section`(`AcademicGradeID`,`AcademicSectionName`,`EffectivityDateFrom`,`EffectivityDateTo`,`Active`) SELECT DISTINCT  b.`AcademicGradeID`, a.`Section`,'2015-06-01','2016-04-30','1' FROM `_tempstudentlist` a JOIN `academic_grade` b ON a.`Grade` = b.`AcademicGradeName` ORDER BY b.`AcademicGradeID` ASC, a.`Section` ASC


-- INSERT INTO PERSON
INSERT INTO `person`(`AddressID`,`FirstName`,`MiddleName`,`LastName`,`ExtensionName`,`Gender`,`MaritalStatus`,`CitizenshipID`,`Birthday`) SELECT '1', TRIM(`Firstname`), TRIM(`Middlename`), TRIM(`Lastname`), TRIM(`Extension`), CASE WHEN TRIM(`Gender`) = 'M' THEN 'male' ELSE 'female' END, 'single','1',STR_TO_DATE(`Birthdate`,'%m/%d/%Y') FROM `_tempstudentlist`;

-- INSERT INTO STUDENT
INSERT INTO `student`(`LRN`,`PersonID`,`AcademicGradeID`,`AcademicSectionID`,`DateOfFirstAttendance`,`Guardian`,`RelationshipToGuardian`,`GASTPERecipient`,`Active`) SELECT a.`LearnerReferenceNumber`, b.`PersonID`, c.`AcademicGradeID`,d.`AcademicSectionID`,STR_TO_DATE(a.`DateOfFirstAttendance`,'%m/%d/%Y'),TRIM(a.`Guardian`),TRIM(a.`RelationshipToGuardian`),CASE WHEN TRIM(a.`GASTPERecipient`)= 'Y' THEN 1 ELSE 0 END, '1' FROM `_tempstudentlist` a JOIN `person` b ON TRIM(a.`Firstname`) = b.`FirstName` AND TRIM(a.`Middlename`) = b.`MiddleName` AND TRIM(a.`Lastname`) = b.`LastName` AND TRIM(a.`Extension`) = b.`ExtensionName` LEFT JOIN `academic_grade` c ON a.`Grade` = c.`AcademicGradeName` LEFT JOIN `academic_section` d ON a.`Section` = d.`AcademicSectionName`;