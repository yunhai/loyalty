<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconstants extends CI_Model {

    function __construct() {
        parent::__construct();
    }

   
    public $answer = array(
        1 => 'YES',
        2 => 'NO',
    );

    public $homeNetwork = array(
        1 => 'Viettel',
        2 => 'Mobifone',
        3 => 'Vinaphone',
        4 => 'Vietnamobile',
        5 => 'Gmobile',
    );

    public $typeCard = array(
        1 => '20,000',
        2 => '50,000',
        3 => '100,000',
        4 => '200,000',
        5 => '500,000'
    );

    public $cardActive = array(
        1 => 'Đã dùng',
        2 => 'Chưa dùng',
        3 => 'Card đã add cho khách',
        4 => 'Khách đã nhận card',
    );

    /*
    đanh sô table trong actionlog
    Customerlike có ItemTypeId = 1
    */

    public $labelCss = array(
        1 => 'label label-default',
        2 => 'label label-success',
        3 => 'label label-warning',
        4 => 'label label-danger',
        5 => 'label label-default',
        6 => 'label label-success',
        7 => 'label label-warning',
        8 => 'label label-danger',
        9 => 'label label-default',
        10 => 'label label-success',
        11 => 'label label-warning',
        12 => 'label label-danger'
    );

    public function selectConstants($key, $selectName, $itemId = 0, $isAll = false, $txtAll = 'Tất cả', $selectClass = '', $attrSelect = ''){
        $obj = $this->$key;
        if($obj) {
            echo '<select class="form-control'.$selectClass.'" name="'.$selectName.'" id="'.lcfirst($selectName).'"'.$attrSelect.'>';
            if($isAll) echo '<option value="0">'.$txtAll.'</option>';
            foreach($obj as $i => $v){
                if($itemId == $i) $selected = ' selected="selected"';
                else $selected = '';
                echo '<option value="'.$i.'"'.$selected.'>'.$v.'</option>';
            }
            echo "</select>";
        }
    }

    public function selectObject($listObj, $objKey, $objValue, $selectName, $objId = 0, $isAll = false, $txtAll = "Tất cả", $selectClass = '', $attrSelect = ''){
        $id = str_replace('[]', '', lcfirst($selectName));
        echo '<select class="form-control'.$selectClass.'" name="'.$selectName.'" id="'.$id.'"'.$attrSelect.'>';
        if($isAll) echo '<option value="0">'.$txtAll.'</option>';
        /*if($isAll){
            if(empty($txtAll)) echo '<option value="0">Tất cả</option>';
            else echo '<option value="0">'.$txtAll.'</option>';
        }*/
        $isSelectMutiple = is_array($objId);
        foreach($listObj as $obj){
            $selected = '';
            if(!$isSelectMutiple) {
                if ($obj[$objKey] == $objId) $selected = ' selected="selected"';
            }
            elseif(in_array($obj[$objKey], $objId)) $selected = ' selected="selected"';
            echo '<option value="'.$obj[$objKey].'"'.$selected.'>'.$obj[$objValue].'</option>';
        }
        echo '</select>';
    }

    public function selectNumber($start, $end, $selectName, $itemId = 0, $asc = false, $attrSelect = ''){
        echo '<select class="form-control" name="'.$selectName.'" id="'.lcfirst($selectName).'"'.$attrSelect.'>';
        if($asc){
            for($i = $start; $i <= $end; $i++){
                if($i == $itemId) $selected = ' selected="selected"';
                else $selected = '';
                echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
            }
        }
        else{
            for($i = $end; $i >= $start; $i--){
                if($i == $itemId) $selected = ' selected="selected"';
                else $selected = '';
                echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
            }
        }
        echo '</select>';
    }

    public function getObjectValue($listObj, $objKey, $objValue, $objKeyReturn){
        foreach($listObj as $obj){
            if($obj[$objKey] == $objValue) return $obj[$objKeyReturn];
        }
        return '';
    }

    public function getUrl($itemSlug, $itemId, $itemTypeId, $siteId = 1){
        $retVal = 'javascript:void(0)';
        if($siteId == 1){
            if ($itemTypeId == 1) $retVal = base_url($itemSlug . '-c' . $itemId . '.html');
            elseif ($itemTypeId == 3) $retVal = base_url('products/' . $itemSlug);
            elseif ($itemTypeId == 4) $retVal = base_url('pages/' . $itemSlug);
            elseif ($itemTypeId == 5) $retVal = base_url('article/' . $itemSlug);

        }
        
        return $retVal;
    }
}