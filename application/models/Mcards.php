<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcards extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "cards";
        $this->_primary_key = "CardId";
    }

    public function checkExist($postData = array(), $cardId = 0){
        $datas = $this->getByQuery('SELECT CardId FROM cards WHERE CardNameId = ? AND CardSeri = ? AND CardNumber = ? AND CardId != ? AND StatusId = 2', array($postData['CardNameId'], $postData['CardSeri'], $postData['CardNumber'], $cardId));
        if(!empty($datas)) return true;
        return false;
    }

    public function searchByFilter($searchText, $itemFilters, $limit, $page, $userId = 0){
        $queryCount = "select cards.CardId AS totalRow from cards  where {wheres}";
        $query = "select {selects} from cards  where {wheres} ORDER BY cards.CardId DESC LIMIT {limits}";
        $selects = [
            'cards.*'
        ];
        $wheres = array('StatusId = 2');
        $dataBind = [];
       
        $whereSearch= '';
        $searchText = strtolower($searchText);
        //search theo text
        if(!empty($searchText)){
            $whereSearch = 'cards.CardSeri like ? or cards.CardNumber like ?';
            for( $i = 0; $i < 2; $i++) $dataBind[] = "%$searchText%";
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
        $dataCards = $this->getByQuery($query, $dataBind);
        for ($i = 0; $i < count($dataCards); $i++) {
            $dataCards[$i]['labelCss'] = $this->Mconstants->labelCss; 
            $dataCards[$i]['CardName'] = $this->Mconstants->homeNetwork[$dataCards[$i]['CardNameId']];
            $dataCards[$i]['CardActive'] = $this->Mconstants->cardActive[$dataCards[$i]['CardActiveId']];
        }
        $data = array();
        $totalRows = $this->getByQuery($queryCount, $dataBind);
        $totalRow = count($totalRows);
        $totalIds = array();
        foreach ($totalRows as $v) $totalIds[] = intval($v['totalRow']);
        $pageSize = ceil($totalRow / $limit);
        $data['dataTables'] = $dataCards;
        $data['page'] = $page;
        $data['pageSize'] = $pageSize;
        $data['callBackTable'] = 'renderContentCards';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        $data['totalIds'] = json_encode($totalIds);
        return $data;
    }
}