<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mmenuitems extends MY_Model {
    
    function __construct() {
        parent::__construct();
        $this->_table_name = "menuitems";
        $this->_primary_key = "MenuItemId";
    }
    
    /**
     * Delete item in menu
     * @param unknown $menuId
     * @return number
     */
    public function deleteItemInMenu($menuId) {
        $menuItem = $this->deleteMultiple(['MenuId'=>$menuId]);
        return 0;
    }
    
    /**
     * Save menu item
     * @param unknown $data
     * @return number
     */
    public function saveMenuItem($data) {
        $menuItem = $this->save($data, 0, array('CrUserId', 'CrDateTime'));
        return $menuItem;
    }
    
    /**
     * Get list menu with condition
     * @param unknown $arr
     * @return unknown
     */
    public function getWithCondition($arr) {
        return $this->getBy($arr, false, "SortId", "", 0, 0, $orderType='asc');
    }
    
    /**
     * Get menu children
     * @param unknown $menuId
     * @return NULL|unknown
     */
    public function getChildrenItem($menuId) {
        $query = "SELECT * FROM menuitems WHERE ParentItemId > 0 AND MenuId=".$menuId." group by ParentItemId";
        $listMenuChildren =  $this->getByQuery($query);
        if (!$listMenuChildren) {
            return null;
        }
        $arrKeyParent = $this->pluckData('MenuItemId', 'ParentItemId', $listMenuChildren);
        foreach ($arrKeyParent as $key=>$val) {
            $data[$val] = $this->getBy(['ParentItemId'=>$val],false,'SortId','',0,0,'asc');
        }
        return $data;
    }

    private function pluckData($key, $val, $list) {
        $arr = array();
        foreach ($list as $k=>$v) {
            $arr[$v[$key]] = $v[$val];
        }
        return $arr;
    }
    
    /**
     * Store create/update data menu item
     * @param unknown $user
     * @param unknown $postData
     * @param unknown $menuId
     * @return boolean
     */
    public function createMenuItem($user, $postData, $menuId) {
        $this->deleteItemInMenu($menuId);
        $sortIdParent = 1;
        foreach ($postData as $key=>$val) {
            // Luu menu cha
            $data['MenuId'] = $menuId;
            $data['SortId'] = $sortIdParent;
            $data['Title'] = isset($val['title'])?$val['title']:"";
            $data['Type'] = $val['type'];
            $data['CSSClass'] = isset($val['class'])?$val['class']:"";
            $data['IconFont'] = isset($val['icon-font'])?$val['icon-font']:"";
            $data['Target'] = $val['target'];
            $data['CrUserId'] = $user['UserId'];
            $data['UpdateUserId'] = $user['UserId'];
            $data['CrDateTime'] = getCurentDateTime();
            $data['UpdateDateTime'] = getCurentDateTime();
            $idParent = $this->saveMenuItem($data);
            if ($idParent == 0) {
                return false;
            }
            unset($data);
            // Luu menu con neu co
            $sortIdChildren = 1;
            if (isset($val['children'])) {
                foreach ($val['children'] as $k=>$v) {
                    $data['MenuId'] = $menuId;
                    $data['ParentItemId'] = $idParent;
                    $data['SortId'] = $sortIdChildren;
                    $data['Title'] = isset($v['title'])?$v['title']:"";
                    $data['Type'] = $v['type'];
                    $data['CSSClass'] = isset($v['class'])?$v['class']:"";
                    $data['IconFont'] = isset($v['icon-font'])?$v['icon-font']:"";
                    $data['Target'] = $v['target'];
                    $data['CrUserId'] = $user['UserId'];
                    $data['UpdateUserId'] = $user['UserId'];
                    $data['CrDateTime'] = getCurentDateTime();
                    $data['UpdateDateTime'] = getCurentDateTime();
                    $idChild = $this->saveMenuItem($data);
                    if ($idParent == 0) {
                        return false;
                    }
                    unset($data);
                    $sortIdChildren++;
                }
            }
            $sortIdParent++;
        }
        return true;
    }
}
