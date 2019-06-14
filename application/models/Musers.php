<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Musers extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "users";
        $this->_primary_key = "UserId";
    }

    public function login($userName, $userPass){
        if(!empty($userName) && !empty($userPass)){
            $query = "SELECT * FROM users WHERE UserPass=? AND StatusId=? AND (UserName=? OR PhoneNumber=?) LIMIT 1";
            $users = $this->getByQuery($query, array(md5($userPass), STATUS_ACTIVED, $userName, $userName));
            if(!empty($users)){
                $user = $users[0];
                /*$this->load->model('Mlogins');
                $this->Mlogins->save(array('UserId' => $user['UserId'], 'IpAddress' => $this->input->ip_address(), 'UserAgent' => $this->input->user_agent(), 'LoginDateTime' => getCurentDateTime()));*/
                return $user;
            }
        }
        return false;
    }

    public function checkExist($userId, $email, $phoneNumber){
        $query = "SELECT UserId FROM users WHERE UserId!=? AND StatusId=?";
        if(!empty($email) && !empty($phoneNumber)){
            $query .= " AND (Email=? OR PhoneNumber=?) LIMIT 1";
            $users = $this->getByQuery($query, array($userId, STATUS_ACTIVED, $email, $phoneNumber));
        }
        elseif(!empty($email)){
            $query .= " AND Email=? LIMIT 1";
            $users = $this->getByQuery($query, array($userId, STATUS_ACTIVED, $email));
        }
        elseif(!empty($phoneNumber)){
            $query .= " AND PhoneNumber=? LIMIT 1";
            $users = $this->getByQuery($query, array($userId, STATUS_ACTIVED, $phoneNumber));
        }
        if (!empty($users)) return true;
        return false;
    }

    public function checkStaffExist($staffId, $phoneNumber, $ceoId){ // roleId = 3
        $users = $this->getByQuery("SELECT UserId FROM users WHERE UserId != ? AND StatusId = ? AND RoleId = ? AND PhoneNumber = ? AND CrUserId = ?", array($staffId, STATUS_ACTIVED, 3, $phoneNumber, $ceoId));
        if (!empty($users)) return true;
        return false;
    }

    public function getCount($postData){
        $query = "StatusId > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM users WHERE StatusId > 0" . $this->buildQuery($postData);
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';
        if(isset($postData['UserName']) && !empty($postData['UserName'])) $query.=" AND UserName LIKE '%{$postData['UserName']}%'";
        if(isset($postData['FullName']) && !empty($postData['FullName'])) $query.=" AND FullName LIKE '%{$postData['FullName']}%'";
        if(isset($postData['Email']) && !empty($postData['Email'])) $query.=" AND Email LIKE '%{$postData['Email']}%'";
        if(isset($postData['PhoneNumber']) && !empty($postData['PhoneNumber'])) $query.=" AND PhoneNumber LIKE '%{$postData['PhoneNumber']}%'";
        if(isset($postData['DegreeName']) && !empty($postData['DegreeName'])) $query.=" AND DegreeName LIKE '%{$postData['DegreeName']}%'";
        if(isset($postData['GenderId']) && $postData['GenderId'] > 0) $query.=" AND GenderId=".$postData['GenderId'];
        if(isset($postData['StatusId']) && $postData['StatusId'] > 0) $query.=" AND StatusId=".$postData['StatusId'];
        if(isset($postData['GroupId']) && $postData['GroupId'] > 0) $query.=" AND UserId IN(SELECT UserId FROM usergroups WHERE GroupId={$postData['GroupId']})";
        $flag1 = isset($postData['PartId']) && $postData['PartId'] > 0;
        $flag2 = isset($postData['RoleId']) && $postData['RoleId'] > 0;
        if($flag1 && $flag2) $query.=" AND UserId IN(SELECT UserId FROM userparts WHERE PartId={$postData['PartId']} AND RoleId={$postData['RoleId']} AND (EndDate IS NULL OR EndDate >= NOW()))";
        elseif($flag1) $query.=" AND UserId IN(SELECT UserId FROM userparts WHERE PartId={$postData['PartId']} AND (EndDate IS NULL OR EndDate >= NOW()))";
        elseif($flag2) $query.=" AND UserId IN(SELECT UserId FROM userparts WHERE RoleId={$postData['RoleId']} AND (EndDate IS NULL OR EndDate >= NOW()))";
        return $query;
    }

    public function getListForSelect($userIdFirst = 0, $fullNameFist = '') {
        $retVal = array();
        if($userIdFirst > 0){
            $users = $this->getByQuery('SELECT UserId,UserName,FullName,PhoneNumber,Email FROM users WHERE StatusId = ? ORDER BY (CASE UserId WHEN ? THEN 1 ELSE 2 END) ASC, UserId DESC', array(STATUS_ACTIVED, $userIdFirst));
            $i = 0;
            foreach($users as $u){
                $i++;
                if($i == 1 && !empty($fullNameFist)) $u['FullName'] = $fullNameFist;
                $retVal[] = $u;
            }
        }
        else $retVal = $this->getBy(array('StatusId' => STATUS_ACTIVED), false, '', 'UserId,UserName,FullName,PhoneNumber,Email');
        return $retVal;
    }

   

    public function update($postData, $userId = 0, $isAdminUpdate = false){
        $isUpdate = $userId > 0;
        $this->db->trans_begin();
        $userId = $this->save($postData, $userId);
        if($userId > 0){
            $userName = 'KH'.($userId > 9 ? $userId : '0'.$userId);
            $this->db->update('users', array('UserName' => $userName), array('UserId' => $userId));
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return 0;
        }
        else {
            $this->db->trans_commit();
            return $userId;
        }
    }

    public function getByIds($userIds){
        $retVal = array();
        $users = $this->getByQuery('SELECT UserId,FullName FROM users WHERE UserId IN ?', array($userIds));
        foreach($users as $user) $retVal[$user['UserId']] = $user['FullName'];
        return $retVal;
    }

    public function searchByFilter($searchText, $itemFilters, $limit, $page, $userId = 0){
        $queryCount = "select users.UserId AS totalRow from users  where {wheres}";
        $query = "select {selects} from users  where {wheres} ORDER BY users.CrDateTime DESC LIMIT {limits}";
        $selects = [
            'users.*'
        ];
        $wheres = array('StatusId = 2 AND UserId != '.$userId);
        $dataBind = [];
       
        $whereSearch= '';
        $searchText = strtolower($searchText);
        //search theo text
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'users.CrDateTime like ?';
                $dataBind[] = "$searchText%";
            }
            else{
                $whereSearch = 'users.FullName like ? or users.Email like ? or users.PhoneNumber like ?';
                for( $i = 0; $i < 3; $i++) $dataBind[] = "%$searchText%";
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
        $dataUsers = $this->getByQuery($query, $dataBind);
        for ($i = 0; $i < count($dataUsers); $i++) {
            $dayDiff = getDayDiff($dataUsers[$i]['CrDateTime'], $now);
            $dataUsers[$i]['CrDateTime'] = ddMMyyyy($dataUsers[$i]['CrDateTime'], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i');
            $dataUsers[$i]['DayDiff'] = $dayDiff;
            $dataUsers[$i]['labelCss'] = $this->Mconstants->labelCss; 
        }
        $data = array();
        $totalRows = $this->getByQuery($queryCount, $dataBind);
        $totalRow = count($totalRows);
        $totalIds = array();
        foreach ($totalRows as $v) $totalIds[] = intval($v['totalRow']);
        $pageSize = ceil($totalRow / $limit);
        $data['dataTables'] = $dataUsers;
        $data['page'] = $page;
        $data['pageSize'] = $pageSize;
        $data['callBackTable'] = 'renderContentUsers';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        $data['totalIds'] = json_encode($totalIds);
        return $data;
    }
}