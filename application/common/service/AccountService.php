<?php
namespace app\common\service;

use app\common\service\BaseService;
use app\account\model\User as UserModel;
use app\account\model\Role as RoleModel;
use app\account\model\Auth as AuthModel;
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
            //todo
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
        ;//todo
    }
    
    public function deleteUser($param=array()) 
    {
        $user=$this->getUserById($param['id']);
        if($user!=null){
            $result = $user->deleteData($param);
            return $result;
        }
        return false;
        
    }
    
    public function deleteUsers($param) 
    {
        $ids=array_values($param);
        $result=UserModel::destroy($ids);
        return $result;
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
    
    public function getRoleById($id)
    {
        $role=RoleModel::get($id);
        return $role;
    }
    
    public function getRole($param) {
        ;
    }
    
    public function getRoles($param=null) {
        if(isset($param)){
           //todo
        }else{
            $roles=RoleModel::all();
        }
        return $roles;
    }
    
    public function saveRole($param) 
    {
        $param['permission']=isset($param['permission'])?$param['permission']:'';
        if($param['id']){
            $role=$this->getRoleById($param['id']);
            $result=$role->allowField(true)->validate(true)->editData(['id'=>$param['id']], $param);
            return $role->getMessage($result);
        }else{
            $role=new RoleModel();
            $result=$role->allowField(true)->validate(true)->addData($param);
            return $role->getMessage($result);
        }
    }
    
    public function saveRoles($param) {
        ;
    }
    
    public function deleteRole($param=array()) 
    {
        $role=$this->getRoleById($param['id']);
        if($role!=null){
            $result = $role->deleteData($param);
            return $result;
        }
        return false;
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
    
    public function getAuthTree()
    {
        $auth=new AuthModel();
        return $auth->getTreeData('level','id','title');
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

