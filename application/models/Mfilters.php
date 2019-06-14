<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mfilters extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "filters";
        $this->_primary_key = "FilterId";
    }

    public function getList($itemTypeId){
        return $this->getBy(array('StatusId' => STATUS_ACTIVED, 'ItemTypeId' => $itemTypeId), false, 'DisplayOrder', 'FilterId, FilterName, DisplayOrder', 0, 0, 'asc');
    }

    public function getInfo($filterId){
        $retVal = array(
            'itemFilters' => array(),
            'tagFilters' => array()
        );
        $filter = $this->get($filterId, true, '', 'FilterData, TagFilter');
        if($filter){
            $retVal['itemFilters'] = json_decode($filter['FilterData'], true);
            $retVal['tagFilters'] = json_decode($filter['TagFilter'], true);
        }
        return $retVal;
    }

    public function updateBatch($valueData){
        if(!empty($valueData)) $this->db->update_batch('filters', $valueData, 'FilterId');
        return true;
    }
}