SELECT s.`id` AS schoolid,sl.id AS schoollevelid,CONCAT(s.`name`,' (',sl.`code`,')') AS sectionname,sl.`code` AS sectioncode,CONCAT(s.`name`,' (',sl.`code`,')') AS sectiondescription,NULL, NULL, NULL,CONCAT(s.`municipalityid`,'-',s.`id`,'-',sl.`id`) AS `sin`,NOW(),NOW()
FROM cmsc209.school s
INNER JOIN
(SELECT xx.OFFICEID, xx.OFFICE_DESC,xx.type,(SELECT id FROM cmsc209.municipality m WHERE xx.district LIKE CONCAT('%',m.name,'%')) AS municipalityid,xx.district
FROM (
SELECT o.`OFFICEID`,o.`OFFICE_DESC`,xx.`district`,'ALS' AS `type` FROM offices o
INNER JOIN earlyreg_als xx ON xx.`entry_by` = o.`OFFICEID`
UNION
SELECT o.`OFFICEID`,o.`OFFICE_DESC`,xx.`district`,'ELEM' AS `type` FROM offices o
INNER JOIN earlyreg_elem xx ON xx.`entry_by` = o.`OFFICEID`
UNION
SELECT o.`OFFICEID`,o.`OFFICE_DESC`,xx.`district`,'JHS' AS `type` FROM offices o
INNER JOIN earlyreg_jhs xx ON xx.`entry_by` = o.`OFFICEID`
UNION
SELECT o.`OFFICEID`,o.`OFFICE_DESC`,xx.`district`,'SHS' AS `type` FROM offices o
INNER JOIN earlyreg_shs xx ON xx.`entry_by` = o.`OFFICEID`)  xx ORDER BY xx.OFFICEID) yy  ON yy.OFFICE_DESC = s.name
INNER JOIN cmsc209.`schoollevel` sl ON sl.`type` = yy.type
ORDER BY s.id,sl.`id`;
