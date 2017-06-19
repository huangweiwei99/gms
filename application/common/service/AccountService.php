<?php
namespace app\common\service;

use app\common\service\BaseService;
use app\account\model\User as UserModel;
use app\account\model\Role as RoleModel;
use think\Request;

class AccountService extends BaseService
{
    ////////////////////////user////////////////////////
    
    public function getUserById($id)
    {
        $user = UserModel::get($id);
        return $user;
    }
    
    public function getUser($param)
    {
        //todo
    }
    
    public function getUsers($param=null) {
        if(isset($param)){
            
        }else{
            $users=UserModel::all();
        }
        return $users;
    }
    
    public function saveUser($param)
    {
        if($param['id']!=0){
            $user=$this->getUserById($param['id']);
            $result=$user->allowField(true)->validate('User.edit')->editData(['id'=>$param['id']], $param);
            return $user->getMessage($result);
        }else{
            $user = new UserModel();
            $request = Request::instance();
            $param["last_login_ip"] = $request->ip();
            $result=$user->allowField(true)->validate(true)->addData($param);
            return $user->getMessage($result);
        }
    }
    
    public function saveUsers($param)
    {
        ;
    }
    
    public function deleteUser($param=array()) 
    {
        $user=$this->getUserById($param['id']);
        $result = $user->deleteData($param);
        return $result;
    }
    
    public function deleteUsers($param) 
    {
        ;
    }
    
    public function getUserWithRoles($param=null){
        $user_with_roles=array();
        $user=$this->getUserById($param['user_id']);
        $roles=RoleModel::all();
        $select_roles=$user->roles()->select();
    }
    
    ////////////////////////profile////////////////////////
    
    public function getProfileById($param) {
        ;
    }
    
    public function getProfile($param) {
        ;
    }
    
    public function getProfiles($param) {
        ;
    }
    
    public function saveProfile($param) {
        ;
    }
    
    public function saveProfiles($param) {
        ;
    }
    
    public function deleteProfile($param) {
        ;
    }
    
    public function deleteProfiles($param) {
        ;
    }
    
    ////////////////////////Role////////////////////////
    
    public function getRoleById($param) {
        ;
    }
    
    public function getRole($param) {
        ;
    }
    
    public function getRoles($param=null) {
        if(isset($param)){
            
        }else{
            $roles=RoleModel::all();
        }
        return $roles;
    }
    
    public function saveRole($param) {
        ;
    }
    
    public function saveRoles($param) {
        ;
    }
    
    public function deleteRole($param) {
        ;
    }
    
    public function deleteRoles($param) {
        ;
    }
    
    ////////////////////////Auth////////////////////////
    
    public function getAuthById($param) {
        ;
    }
    
   
    public function getAuth($param) {
        ;
    }
    
    public function getAuthList($param) {
        ;
    }
    
    public function saveAuth($param) {
        ;
    }
    
    public function saveAuthList($param) {
        ;
    }
    
    public function deleteAuth($param) {
        ;
    }
    
    public function deleteAuthList($param) {
        ;
    }
    
    ////////////////////////Project////////////////////////
    
    public function getProjectById($param) {
        ;
    }
    
    public function getProject($param) {
        ;
    }
    
    public function getProjects($param) {
        ;
    }
    
    public function saveProject($param) {
        ;
    }
    
    public function saveProjects($param) {
        ;
    }
    
    public function deleteProject($param) {
        ;
    }
    
    public function deleteProjects($param) {
        ;
    }
    
    ////////////////////////Task////////////////////////
    
    public function getTaskById($param) {
        ;
    }
    
    public function getTask($param) {
        ;
    }
    
    public function getTasks($param) {
        ;
    }
    
    public function saveTask($param) {
        ;
    }
    
    public function saveTasks($param) {
        ;
    }
    
    public function deleteTask($param) {
        ;
    }
    
    public function deleteTasks($param) {
        ;
    }
}

