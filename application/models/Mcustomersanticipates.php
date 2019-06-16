<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcustomersanticipates extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "customersanticipates";
        $this->_primary_key = "CustomersAnticipateId";
    }

    public function checkExist_1($userId){
        $query = "SELECT UserId FROM customersanticipates WHERE UserId=? AND StatusId=? AND  (CrDateTime BETWEEN DATE_FORMAT(NOW() - INTERVAL 1 DAY,'%Y-%m-%d 16:00:00') AND DATE_FORMAT(NOW(),'%Y-%m-%d 16:00:00'))";
       	$datas = $this->getByQuery($query, array($userId, STATUS_ACTIVED));
        if (!empty($datas)) return true;
        return false;
    }

    public function checkExist_2($userId){
        $query = "SELECT UserId FROM customersanticipates WHERE UserId=? AND StatusId=? AND  (CrDateTime BETWEEN DATE_FORMAT(NOW(),'%Y-%m-%d 16:01:00') AND DATE_FORMAT(NOW() + INTERVAL 1 DAY,'%Y-%m-%d 15:59:59') ) ";
       	$datas = $this->getByQuery($query, array($userId, STATUS_ACTIVED));
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
            $datas[$i]['CrDateTime'] = ddMMyyyy($datas[$i]['CrDateTime'], $dayDiff > 2 ? 'd/m/Y' : '');
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

//     SELECT users.FullName FROM customersanticipates
// LEFT JOIN users ON customersanticipates.UserId = users.UserId
// LEFT JOIN lotterystations ON lotterystations.LotteryStationId = customersanticipates.LotteryStationId
// LEFT JOIN lotteryresults ON lotteryresults.LotteryStationId = lotterystations.LotteryStationId
// LEFT JOIN lotteryresultdetails ON lotteryresultdetails.LotteryResultId = lotteryresults.LotteryResultId

// WHERE customersanticipates.CrDateTime BETWEEN DATE_FORMAT(NOW() - INTERVAL 1 DAY,'%Y-%m-%d 00:00:00') AND DATE_FORMAT(NOW() - INTERVAL 1 DAY,'%Y-%m-%d 16:00:00') AND lotteryresultdetails.Raffle = customersanticipates.Number AND lotteryresults.CrDateTime = DATE_FORMAT(NOW() - INTERVAL 1 DAY,'%Y-%m-%d 00:00:00') AND lotteryresults.StatusId = 2 AND customersanticipates.StatusId = 2 AND users.RoleId = 2 AND users.StatusId = 2


}