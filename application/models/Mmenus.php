<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mmenus extends MY_Model {
    
    function __construct() {
        parent::__construct();
        $this->_table_name = "menus";
        $this->_primary_key = "MenuId";
    }
    
    /**
     * Check duplicate menu name
     * @param unknown $menuId
     * @param unknown $menuName
     * @return mixed|number
     */
    public function checkExist($menuId = 0, $menuName){
        if (!isset($menuId)) {
            $menuId = 0;
        }
        $query = "SELECT MenuId FROM menus WHERE MenuId!=? AND Name=?";
        $param = array($menuId, $menuName);
        $menus = $this->getByQuery($query, $param);
        if (!empty($menus)) return $menus[0]['MenuId'];
        return 0;
    }
    
    /**
     * Add menu
     * @param unknown $postData
     * @param number $menuId
     * @return number
     */
    public function update($postData, $menuId = 0){
        $isUpdate = $menuId > 0 ? true : false;
        $this->db->trans_begin();
        $menuId = $this->save($postData, $menuId);
        if ($this->db->trans_status() === false){
            $this->db->trans_rollback();
            return 0;
        }
        else{
            $this->db->trans_commit();
            return $menuId;
        }
    }
    
    /**
     * Get list menu
     * @return unknown
     */
    public function getList(){
        return $this->get();
    }
    
    /**
     * Get info to edit
     * if !isset($id) then get min id
     * @param unknown $id
     */
    public function getMenuEdit($id) {
        if (!$id) {
            $id = $this->getBy([],false,'MenuId','MenuId',1,0,'asc')[0]['MenuId'];
        }
        return $this->get($id);
    }
}
