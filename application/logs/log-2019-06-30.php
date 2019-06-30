<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-06-30 04:05:33 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 04:07:49 --> 404 Page Not Found: Web/index
ERROR - 2019-06-30 04:12:01 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 04:28:27 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 04:29:17 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 04:29:52 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 04:33:41 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 04:33:53 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 04:34:20 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 04:34:44 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 04:36:02 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 04:36:12 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 04:37:07 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 04:40:21 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 04:46:35 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 10:04:12 --> Severity: Notice --> Undefined variable: data D:\CT\XAMPP7.3\htdocs\freelancer\loyalty\application\models\Mcustomersanticipates.php 217
ERROR - 2019-06-30 10:04:12 --> Severity: Notice --> Undefined variable: data D:\CT\XAMPP7.3\htdocs\freelancer\loyalty\application\models\Mcustomersanticipates.php 217
ERROR - 2019-06-30 05:04:26 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:04:34 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 10:04:34 --> Severity: Notice --> Undefined variable: data D:\CT\XAMPP7.3\htdocs\freelancer\loyalty\application\models\Mcustomersanticipates.php 217
ERROR - 2019-06-30 10:04:34 --> Severity: Notice --> Undefined variable: data D:\CT\XAMPP7.3\htdocs\freelancer\loyalty\application\models\Mcustomersanticipates.php 217
ERROR - 2019-06-30 05:05:08 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:05:10 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:06:37 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:07:10 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 10:07:11 --> Query error: Unknown column 'cards.CardActiveId1' in 'where clause' - Invalid query: select users.FullName, cards.CardTypeId, customersanticipates.CustomersAnticipateId 
                from customersanticipates 
                LEFT JOIN playerwins ON playerwins.CustomersAnticipateId = customersanticipates.CustomersAnticipateId 
                INNER JOIN cards ON cards.CardId = playerwins.CardId AND cards.CardId 
                LEFT JOIN users ON customersanticipates.UserId = users.UserId 
                LEFT JOIN lotterystations ON lotterystations.LotteryStationId = customersanticipates.LotteryStationId 
                LEFT JOIN lotteryresults ON lotteryresults.LotteryStationId = lotterystations.LotteryStationId 
                LEFT JOIN lotteryresultdetails ON lotteryresultdetails.LotteryResultId = lotteryresults.LotteryResultId 
                where  lotteryresultdetails.Raffle = customersanticipates.Number 
                AND  lotteryresults.StatusId = 2 AND customersanticipates.StatusId = 2 AND users.RoleId = 2 AND cards.CardActiveId1 IN (3, 4) AND users.StatusId = 2   AND customersanticipates.UserId = 5 ORDER BY lotteryresults.CrDateTime
ERROR - 2019-06-30 05:14:39 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 10:14:40 --> Query error: Unknown column 'cards.CardActiveId1' in 'where clause' - Invalid query: select users.FullName, cards.CardTypeId, customersanticipates.CustomersAnticipateId 
                from customersanticipates 
                LEFT JOIN playerwins ON playerwins.CustomersAnticipateId = customersanticipates.CustomersAnticipateId 
                INNER JOIN cards ON cards.CardId = playerwins.CardId AND cards.CardId 
                LEFT JOIN users ON customersanticipates.UserId = users.UserId 
                LEFT JOIN lotterystations ON lotterystations.LotteryStationId = customersanticipates.LotteryStationId 
                LEFT JOIN lotteryresults ON lotteryresults.LotteryStationId = lotterystations.LotteryStationId 
                LEFT JOIN lotteryresultdetails ON lotteryresultdetails.LotteryResultId = lotteryresults.LotteryResultId 
                where  lotteryresultdetails.Raffle = customersanticipates.Number 
                AND  lotteryresults.StatusId = 2 AND customersanticipates.StatusId = 2 AND users.RoleId = 2 AND cards.CardActiveId1 IN (3, 4) AND users.StatusId = 2   ORDER BY lotteryresults.CrDateTime
ERROR - 2019-06-30 10:21:25 --> Query error: Table 'lodaty.lotteryresultdetails' doesn't exist - Invalid query: SELECT *
FROM `lotteryresultdetails`
WHERE `LotteryResultId` = '1'
ERROR - 2019-06-30 05:23:24 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:23:28 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:24:07 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 10:24:10 --> Query error: Table 'lodaty.lotteryresultdetails' doesn't exist - Invalid query: SELECT *
FROM `lotteryresultdetails`
WHERE `LotteryResultId` = '1'
ERROR - 2019-06-30 10:24:27 --> Severity: Notice --> Undefined variable: i D:\CT\XAMPP7.3\htdocs\freelancer\loyalty\application\views\lotteryresult\edit.php 56
ERROR - 2019-06-30 05:24:35 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:25:26 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:25:30 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:26:10 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 10:26:10 --> Query error: Table 'lodaty.lotteryresultdetails' doesn't exist - Invalid query: select users.FullName, cards.CardTypeId, customersanticipates.CustomersAnticipateId 
                from customersanticipates 
                LEFT JOIN playerwins ON playerwins.CustomersAnticipateId = customersanticipates.CustomersAnticipateId 
                INNER JOIN cards ON cards.CardId = playerwins.CardId AND cards.CardId 
                LEFT JOIN users ON customersanticipates.UserId = users.UserId 
                LEFT JOIN lotterystations ON lotterystations.LotteryStationId = customersanticipates.LotteryStationId 
                LEFT JOIN lotteryresults ON lotteryresults.LotteryStationId = lotterystations.LotteryStationId 
                LEFT JOIN lotteryresultdetails ON lotteryresultdetails.LotteryResultId = lotteryresults.LotteryResultId 
                where  lotteryresultdetails.Raffle = customersanticipates.Number 
                AND  lotteryresults.StatusId = 2 AND customersanticipates.StatusId = 2 AND users.RoleId = 2 AND cards.CardActiveId1 IN (3, 4) AND users.StatusId = 2   AND customersanticipates.UserId = 1 ORDER BY lotteryresults.CrDateTime
ERROR - 2019-06-30 05:26:12 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 10:26:12 --> Query error: Table 'lodaty.lotteryresultdetails' doesn't exist - Invalid query: select users.FullName, cards.CardTypeId, customersanticipates.CustomersAnticipateId 
                from customersanticipates 
                LEFT JOIN playerwins ON playerwins.CustomersAnticipateId = customersanticipates.CustomersAnticipateId 
                INNER JOIN cards ON cards.CardId = playerwins.CardId AND cards.CardId 
                LEFT JOIN users ON customersanticipates.UserId = users.UserId 
                LEFT JOIN lotterystations ON lotterystations.LotteryStationId = customersanticipates.LotteryStationId 
                LEFT JOIN lotteryresults ON lotteryresults.LotteryStationId = lotterystations.LotteryStationId 
                LEFT JOIN lotteryresultdetails ON lotteryresultdetails.LotteryResultId = lotteryresults.LotteryResultId 
                where  lotteryresultdetails.Raffle = customersanticipates.Number 
                AND  lotteryresults.StatusId = 2 AND customersanticipates.StatusId = 2 AND users.RoleId = 2 AND cards.CardActiveId1 IN (3, 4) AND users.StatusId = 2   ORDER BY lotteryresults.CrDateTime
ERROR - 2019-06-30 05:28:12 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:28:26 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 10:29:31 --> Query error: Table 'lodaty.lotteryresultdetails' doesn't exist - Invalid query: select customersanticipates.*,users.FullName,users.PhoneNumber,lotteryresultdetails.Raffle,lotteryresults.CrDateTime AS LrCrDateTime,lotterystations.LotteryStationName,cards.CardId,cards.CardNameId,cards.CardNumber,cards.CardSeri,cards.CardTypeId,COALESCE(cards.CardActiveId, 0) AS CardActiveId from customersanticipates LEFT JOIN playerwins ON playerwins.CustomersAnticipateId = customersanticipates.CustomersAnticipateId LEFT JOIN cards ON cards.CardId = playerwins.CardId AND cards.CardActiveId IN (3,4) LEFT JOIN users ON customersanticipates.UserId = users.UserId LEFT JOIN lotterystations ON lotterystations.LotteryStationId = customersanticipates.LotteryStationId LEFT JOIN lotteryresults ON lotteryresults.LotteryStationId = lotterystations.LotteryStationId LEFT JOIN lotteryresultdetails ON lotteryresultdetails.LotteryResultId = lotteryresults.LotteryResultId where lotteryresultdetails.Raffle = customersanticipates.Number AND lotteryresults.StatusId = 2 AND customersanticipates.StatusId = 2 AND users.RoleId = 2 AND users.StatusId = 2 ORDER BY lotteryresults.CrDateTime DESC LIMIT 0,20
ERROR - 2019-06-30 05:29:53 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:29:55 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 10:29:55 --> Query error: Table 'lodaty.lotteryresultdetails' doesn't exist - Invalid query: select customersanticipates.*,users.FullName,users.PhoneNumber,lotteryresultdetails.Raffle,lotteryresults.CrDateTime AS LrCrDateTime,lotterystations.LotteryStationName,cards.CardId,cards.CardNameId,cards.CardNumber,cards.CardSeri,cards.CardTypeId,COALESCE(cards.CardActiveId, 0) AS CardActiveId from customersanticipates LEFT JOIN playerwins ON playerwins.CustomersAnticipateId = customersanticipates.CustomersAnticipateId LEFT JOIN cards ON cards.CardId = playerwins.CardId AND cards.CardActiveId IN (3,4) LEFT JOIN users ON customersanticipates.UserId = users.UserId LEFT JOIN lotterystations ON lotterystations.LotteryStationId = customersanticipates.LotteryStationId LEFT JOIN lotteryresults ON lotteryresults.LotteryStationId = lotterystations.LotteryStationId LEFT JOIN lotteryresultdetails ON lotteryresultdetails.LotteryResultId = lotteryresults.LotteryResultId where lotteryresultdetails.Raffle = customersanticipates.Number AND lotteryresults.StatusId = 2 AND customersanticipates.StatusId = 2 AND users.RoleId = 2 AND users.StatusId = 2 ORDER BY lotteryresults.CrDateTime DESC LIMIT 0,20
ERROR - 2019-06-30 05:33:33 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:34:17 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:34:37 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:34:45 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:34:47 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:35:11 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:35:15 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:35:42 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:35:47 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:36:02 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:36:34 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:36:36 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 10:38:47 --> Severity: Notice --> Undefined index: CardActiveId D:\CT\XAMPP7.3\htdocs\freelancer\loyalty\application\models\Mcustomersanticipates.php 216
ERROR - 2019-06-30 10:39:18 --> Severity: Notice --> Undefined index: CardActiveId D:\CT\XAMPP7.3\htdocs\freelancer\loyalty\application\models\Mcustomersanticipates.php 216
ERROR - 2019-06-30 05:39:31 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:39:34 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 10:39:34 --> Severity: Notice --> Undefined index: CardActiveId D:\CT\XAMPP7.3\htdocs\freelancer\loyalty\application\models\Mcustomersanticipates.php 216
ERROR - 2019-06-30 05:40:09 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 05:41:16 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 10:50:05 --> Severity: Notice --> Undefined variable: listQuestions D:\CT\XAMPP7.3\htdocs\freelancer\loyalty\application\controllers\Site.php 28
ERROR - 2019-06-30 10:50:05 --> Severity: Warning --> Invalid argument supplied for foreach() D:\CT\XAMPP7.3\htdocs\freelancer\loyalty\application\models\Mconstants.php 82
ERROR - 2019-06-30 06:27:38 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 06:30:11 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 06:33:21 --> 404 Page Not Found: Assets/ckfinder
ERROR - 2019-06-30 06:33:21 --> 404 Page Not Found: Assets/ckfinder
ERROR - 2019-06-30 11:42:00 --> Severity: error --> Exception: syntax error, unexpected ')', expecting ',' or ';' D:\CT\XAMPP7.3\htdocs\freelancer\loyalty\application\views\user\forgotpass.php 36
ERROR - 2019-06-30 06:42:30 --> 404 Page Not Found: Assets/js
ERROR - 2019-06-30 06:42:31 --> 404 Page Not Found: Assets/js
ERROR - 2019-06-30 07:07:36 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 12:07:47 --> Severity: Notice --> Undefined property: Site::$Mcustomersanticipates D:\CT\XAMPP7.3\htdocs\freelancer\loyalty\application\controllers\Site.php 24
ERROR - 2019-06-30 12:07:48 --> Severity: error --> Exception: Call to a member function getNum() on null D:\CT\XAMPP7.3\htdocs\freelancer\loyalty\application\controllers\Site.php 24
ERROR - 2019-06-30 07:10:10 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 07:10:22 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 07:13:10 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 07:14:03 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 07:17:52 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 07:17:55 --> 404 Page Not Found: Assets/vendor
ERROR - 2019-06-30 07:18:23 --> 404 Page Not Found: Assets/vendor
