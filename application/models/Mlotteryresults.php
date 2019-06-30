<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mlotteryresults extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "lotteryresults";
        $this->_primary_key = "LotteryResultId";
    }


    public function searchByFilter($searchText, $itemFilters, $limit, $page, $userId = 0){
        $queryCount = "select lotteryresults.LotteryResultId AS totalRow from lotteryresults  where {wheres}";
        $query = "select {selects} from lotteryresults  where {wheres} ORDER BY lotteryresults.CrDateTime DESC LIMIT {limits}";
        $selects = [
            'lotteryresults.*'
        ];
        $wheres = array('StatusId = 2');
        $dataBind = [];
       
        $whereSearch= '';
        $searchText = strtolower($searchText);
        //search theo text
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'lotteryresults.CrDateTime like ?';
                $dataBind[] = "$searchText%";
            }
            else{
                // $whereSearch = 'lotteryresults.FullName like ? or users.Email like ? or users.PhoneNumber like ?';
                // for( $i = 0; $i < 3; $i++) $dataBind[] = "%$searchText%";
            }
        }
        if(!empty($whereSearch)) {
            $whereSearch = "( $whereSearch )";
            $wheres[] = $whereSearch;
        }
        $selects_string = implode(',', $selects);
        $wheres_string = implode(' and ', $wheres);
        $query = str_replace('{selects}', $selects_string, $query);
        $query = str_replace('{wheres}', $wheres_string, $query);
        $query = str_replace('{limits}', $limit * ($page - 1) . "," . $limit, $query);
        $queryCount = str_replace('{wheres}', $wheres_string, $queryCount);
        if (count($wheres) == 0){
            $query = str_replace('where', '', $query);
            $queryCount = str_replace('where', '', $queryCount);
        }
        $now = new DateTime(date('Y-m-d'));
        $datas = $this->getByQuery($query, $dataBind);
        $this->load->model(array('Mlotterystations'));
        for ($i = 0; $i < count($datas); $i++) {
            $dayDiff = getDayDiff($datas[$i]['CrDateTime'], $now);
            $datas[$i]['CrDateTime'] = ddMMyyyy($datas[$i]['CrDateTime'], $dayDiff > 2 ? 'd/m/Y' : '');
            $datas[$i]['DayDiff'] = $dayDiff;
            $datas[$i]['LotteryName'] = $this->Mlotterystations->getFieldValue(array('LotteryStationId' => $datas[$i]['LotteryStationId']), 'LotteryStationName', '');
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
        $data['callBackTable'] = 'renderContentLotteryResults';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        $data['totalIds'] = json_encode($totalIds);
        return $data;
    }
}