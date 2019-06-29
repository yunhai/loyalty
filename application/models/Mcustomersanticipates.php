<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcustomersanticipates extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "customersanticipates";
        $this->_primary_key = "CustomersAnticipateId";
    }

    public function checkExist_1($userId, $date){
        $query = "SELECT UserId FROM customersanticipates WHERE UserId=? AND StatusId=? AND  CrDateTime = ?";
       	$datas = $this->getByQuery($query, array($userId, STATUS_ACTIVED, $date));
        if (!empty($datas)) return true;
        return false;
    }

    public function checkExist_2($userId, $date){
        $query = "SELECT UserId FROM customersanticipates WHERE UserId=? AND StatusId=? AND  CrDateTime = ? ";
       	$datas = $this->getByQuery($query, array($userId, STATUS_ACTIVED, $date));
        if (!empty($datas)) return true;
        return false;
    }

    public function searchByFilter($searchText, $itemFilters, $limit, $page, $userId = 0){
        $queryCount = "select customersanticipates.CustomersAnticipateId AS totalRow from customersanticipates {joins} where {wheres}";
        $query = "select {selects} from customersanticipates {joins} where {wheres} ORDER BY customersanticipates.CustomersAnticipateId DESC LIMIT {limits}";
        $selects = [
            'customersanticipates.*',
            'users.FullName',
            'lotterystations.LotteryStationName',
        ];
        $joins = [
            'users' => "LEFT JOIN users ON customersanticipates.UserId = users.UserId",
            'lotterystations' => "LEFT JOIN lotterystations ON customersanticipates.LotteryStationId = lotterystations.LotteryStationId",
        ];
        $wheres = array('customersanticipates.StatusId = 2');
        $dataBind = [];
       
        $whereSearch= '';
        $searchText = strtolower($searchText);
        //search theo text
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'customersanticipates.CrDateTime like ?';
                $dataBind[] = "$searchText%";
            }else{
                $whereSearch = 'customersanticipates.Number like ?';
                for( $i = 0; $i < 1; $i++) $dataBind[] = "%$searchText%";
            }
            
        }
        if(!empty($whereSearch)) {
            $whereSearch = "( $whereSearch )";
            $wheres[] = $whereSearch;
        }
        $selects_string = implode(',', $selects);
        $wheres_string = implode(' and ', $wheres);
        $joins_string = implode(' ', $joins);
        $query = str_replace('{selects}', $selects_string, $query);
        $query = str_replace('{joins}', $joins_string, $query);
        $query = str_replace('{wheres}', $wheres_string, $query);
        $query = str_replace('{limits}', $limit * ($page - 1) . "," . $limit, $query);
        $queryCount = str_replace('{joins}', $joins_string, $queryCount);
        $queryCount = str_replace('{wheres}', $wheres_string, $queryCount);
        if (count($wheres) == 0){
            $query = str_replace('where', '', $query);
            $queryCount = str_replace('where', '', $queryCount);
        }
        $now = new DateTime(date('Y-m-d'));
        $datas = $this->getByQuery($query, $dataBind);
        for ($i = 0; $i < count($datas); $i++) {
            $dayDiff = getDayDiff($datas[$i]['CrDateTime'], $now);
            $datas[$i]['CrDateTime'] = ddMMyyyy($datas[$i]['CrDateTime'], 'd/m/Y');;
            $datas[$i]['DayDiff'] = $dayDiff;
        }
        $data = array();
        $totalRows = $this->getByQuery($queryCount, $dataBind);
        $totalRow = count($totalRows);
        $totalIds = array();
        foreach ($totalRows as $v) $totalIds[] = intval($v['totalRow']);
        $pageSize = ceil($totalRow / $limit);
        $data['dataTables'] = $datas;
        $data['page'] = $page;
        $data['pageSize'] = $pageSize;
        $data['callBackTable'] = 'renderContents';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        $data['totalIds'] = json_encode($totalIds);
        return $data;
    }


    public function searchByFilterWin($searchText, $itemFilters, $limit, $page, $userId = 0){
       
        //search theo text
        $dateNow = getDateNow();
        if(!empty($searchText)){
            $dateNow = ddMMyyyyToDate($searchText, 'd/m/Y', 'Y-m-d');
        }
        $queryCount = "select customersanticipates.CustomersAnticipateId AS totalRow from customersanticipates {joins} where {wheres}";
        $query = "select {selects} from customersanticipates {joins} where {wheres} ORDER BY customersanticipates.CustomersAnticipateId DESC LIMIT {limits}";
        $selects = [
            'customersanticipates.*',
            'users.FullName',
            'users.PhoneNumber',
            'lotteryresultdetails.Raffle',
            'lotteryresults.CrDateTime AS LrCrDateTime',
            'lotterystations.LotteryStationName',
            'cards.CardId',
            'cards.CardNameId',
            'cards.CardNumber',
            'cards.CardSeri',
            'cards.CardTypeId',
            'COALESCE(cards.CardActiveId, 0) AS CardActiveId'
        ];
      
        $joins = [
            'playerwins' => "LEFT JOIN playerwins ON playerwins.CustomersAnticipateId = customersanticipates.CustomersAnticipateId",
            'cards' => "LEFT JOIN cards ON cards.CardId = playerwins.CardId AND cards.CardActiveId IN (3,4)",
            'users' => "LEFT JOIN users ON customersanticipates.UserId = users.UserId",
            'lotterystations' => "LEFT JOIN lotterystations ON lotterystations.LotteryStationId = customersanticipates.LotteryStationId",
            'lotteryresults' => "LEFT JOIN lotteryresults ON lotteryresults.LotteryStationId = lotterystations.LotteryStationId",
            'lotteryresultdetails' => "LEFT JOIN lotteryresultdetails ON lotteryresultdetails.LotteryResultId = lotteryresults.LotteryResultId",
        ];
        $wheres = array("customersanticipates.CrDateTime = '".$dateNow."' AND lotteryresultdetails.Raffle = customersanticipates.Number AND lotteryresults.CrDateTime = '".$dateNow."' AND lotteryresults.StatusId = 2 AND customersanticipates.StatusId = 2 AND users.RoleId = 2 AND users.StatusId = 2");
        $dataBind = [];
       
        $whereSearch= '';
        $searchText = strtolower($searchText);
        
        if(!empty($whereSearch)) {
            $whereSearch = "( $whereSearch )";
            $wheres[] = $whereSearch;
        }
        $selects_string = implode(',', $selects);
        $wheres_string = implode(' and ', $wheres);
        $joins_string = implode(' ', $joins);
        $query = str_replace('{selects}', $selects_string, $query);
        $query = str_replace('{joins}', $joins_string, $query);
        $query = str_replace('{wheres}', $wheres_string, $query);
        $query = str_replace('{limits}', $limit * ($page - 1) . "," . $limit, $query);
        $queryCount = str_replace('{joins}', $joins_string, $queryCount);
        $queryCount = str_replace('{wheres}', $wheres_string, $queryCount);
        if (count($wheres) == 0){
            $query = str_replace('where', '', $query);
            $queryCount = str_replace('where', '', $queryCount);
        }
        $now = new DateTime(date('Y-m-d'));
        $datas = $this->getByQuery($query, $dataBind);
        for ($i = 0; $i < count($datas); $i++) {
            $dayDiff = getDayDiff($datas[$i]['CrDateTime'], $now);
            $datas[$i]['LrCrDateTime'] = ddMMyyyy($datas[$i]['LrCrDateTime'],'d/m/Y');
            $datas[$i]['CrDateTime'] = ddMMyyyy($datas[$i]['CrDateTime'], 'd/m/Y');
            $datas[$i]['DayDiff'] = $dayDiff;
            $datas[$i]['InfoCard'] = '';
            $datas[$i]['UserCardUse'] = '';
            if($datas[$i]['CardId'] > 0){
                $datas[$i]['InfoCard'] .= '<p>- '.$this->Mconstants->homeNetwork[$datas[$i]['CardNameId']].'</p>';
                $datas[$i]['InfoCard'] .= '<p>- '.$this->Mconstants->typeCard[$datas[$i]['CardTypeId']].'</p>';
                $datas[$i]['InfoCard'] .= '<p>- Seri:'.$datas[$i]['CardSeri'].'</p>';
                $datas[$i]['InfoCard'] .= '<p>- Number:'.$datas[$i]['CardNumber'].'</p>';

                $datas[$i]['UserCardUse'] = $this->Mconstants->cardActive[$datas[$i]['CardActiveId']];
                
            }
            $datas[$i]['AddCard'] = '';
            if($datas[$i]['CardActiveId'] != 3){
                if( $datas[$i]['CardActiveId'] != 4){
                    $datas[$i]['AddCard'] = '<a href="javascript:void(0)" style="color:#ffffff" class="btn btn-success btn-xs btnShowModal "  data-id="'.$datas[$i]['CustomersAnticipateId'].'">Add Card</a>';
                }
                
            }
        }
        $data = array();
        $totalRows = $this->getByQuery($queryCount, $dataBind);
        $totalRow = count($totalRows);
        $totalIds = array();
        foreach ($totalRows as $v) $totalIds[] = intval($v['totalRow']);
        $pageSize = ceil($totalRow / $limit);
        $data['dataTables'] = $datas;
        $data['page'] = $page;
        $data['pageSize'] = $pageSize;
        $data['callBackTable'] = 'renderContents';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        $data['totalIds'] = json_encode($totalIds);
        return $data;
    }

    public function getListHomeWin($user){
        $where = '';
        $flag = false;
        if($user){
            $where =  ' AND customersanticipates.UserId = '.$user['UserId'];
            $flag = true;
        }
        $query = "select users.FullName, cards.CardTypeId, customersanticipates.CustomersAnticipateId 
                from customersanticipates 
                LEFT JOIN playerwins ON playerwins.CustomersAnticipateId = customersanticipates.CustomersAnticipateId 
                INNER JOIN cards ON cards.CardId = playerwins.CardId AND cards.CardActiveId = 3
                LEFT JOIN users ON customersanticipates.UserId = users.UserId 
                LEFT JOIN lotterystations ON lotterystations.LotteryStationId = customersanticipates.LotteryStationId 
                LEFT JOIN lotteryresults ON lotteryresults.LotteryStationId = lotterystations.LotteryStationId 
                LEFT JOIN lotteryresultdetails ON lotteryresultdetails.LotteryResultId = lotteryresults.LotteryResultId 
                where  lotteryresultdetails.Raffle = customersanticipates.Number 
                AND  lotteryresults.StatusId = 2 AND customersanticipates.StatusId = 2 AND users.RoleId = 2 AND users.StatusId = 2  ".$where." ORDER BY customersanticipates.CustomersAnticipateId";
        $datas = $this->getByQuery($query);
        if($flag){
            for ($i = 0; $i < count($datas); $i++) {
                $datas[$i]['CardType'] = '<a class="receive-card" href="javascript:void(0)" data-id="'.$datas[$i]['CustomersAnticipateId'].'">Thẻ Cào Điện Thoại '.$this->Mconstants->typeCard[$datas[$i]['CardTypeId']].' VNĐ </a>';
            }
        }else{
            for ($i = 0; $i < count($datas); $i++) {
                $datas[$i]['CardType'] = 'Thẻ Cào Điện Thoại '.$this->Mconstants->typeCard[$datas[$i]['CardTypeId']].' VNĐ';
            }
        }
        
        return $datas;
    }

    public function getCardId($userId, $customersAnticipateId){
        $query = "SELECT playerwins.CardId from customersanticipates
                INNER JOIN playerwins ON playerwins.CustomersAnticipateId = customersanticipates.CustomersAnticipateId
                WHERE customersanticipates.CustomersAnticipateId = ? AND customersanticipates.UserId = ? AND customersanticipates.StatusId = ?";
        $datas = $this->getByQuery($query, array($customersAnticipateId, $userId, STATUS_ACTIVED));
        if($datas) return $datas[0]['CardId'];
        else return 0;
    }

}