<?php
namespace app\common\service;

use app\common\service\BaseService;
use app\account\model\User as UserModel;
use app\account\model\Role as RoleModel;
use app\account\model\Auth as AuthModel;
use app\account\model\Profile as ProfileModel;
use app\account\model\Project as ProjectModel;
use app\account\model\Task as TaskModel;
use think\Request;

class AccountService extends BaseService
{
    ////////////////////////user////////////////////////
    
    public function getUserById($id)
    {
        $user = UserModel::get($id);
        return $user;
    }
    
    public function getUser($param=array())
    {
        if(isset($param)){
            $user=UserModel::get($param);
            return $user;
        }
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
    
    public function saveUser($param=array(),$scene='User.edit')
    {
        if($param['id']!=0){
            $user=$this->getUserById($param['id']);
            $result=$user->allowField(true)->validate($scene)->editData(['id'=>$param['id']], $param);
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
    
    public function getProfileById($id) {
        $profile=new ProfileModel();
        return $profile;
    }
    
    public function getProfile($param) {
        ;//todo
    }
    
    public function getProfiles($param=null) {
        if(isset($param)){
            $profiles=ProfileModel::all($param);
        }else{
            $profiles=ProfileModel::all();
        }
        return $profiles;
    }
    
    public function saveProfile($param) {
        $user=$this->getUserById($param['user_id']);
        $profile=new ProfileModel();
        if(empty($user->profile()->select())){
            $result=$profile->allowField(true)->validate(true)->addData($param);
            return $profile->getMessage($result);
        }else{
            $id=$user->profile->id;
            
            if(empty($param['new_password'])){
                $result=$profile->allowField(true)->validate(true)->editData(['id'=>$id], $param);
                return $profile->getMessage($result);
            }else{
                
                $user=$this->getUser(['password'=>md5($param['current_password']),'id'=>$param['user_id']]);
                if($user){
                    $result=$this->saveUser(array('id'=>$param['user_id'],'password'=>$param['new_password']),'User.updatepw');
                    return $user->getMessage($result);
                }else{
                    return array('flag'=>false,'message'=>'请先填入当前正确的密码再修改','level'=>'error');
                }
            }
        }
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
    
    public function getAuthById($id) {
        $auth=AuthModel::get($id);
        return $auth;
    }
    
    public function getAuth($param) {
        ;
    }
    
    public function getAuthList($param=null)
    {
        if(isset($param)){
            //todo
        }else{
            $authlist=AuthModel::all();
            return $authlist;
        }
    }
    
    public function getAuthLevel()
    {
        $auth=new AuthModel();
        return $auth->getTreeData('level','id','title');
    }
    
    public function getAuthTree()
    {
        $auth=new AuthModel();
        return $auth->getTreeData('tree','id','title');
    }
    
    public function saveAuth($param) {
        if($param['id']){
            $auth=$this->getAuthById($param['id']);
            $result=$auth->allowField(true)->validate(true)->editData(['id'=>$param['id']], $param);
            return $auth->getMessage($result);
        }else{
            $auth=new AuthModel();
            $result=$auth->allowField(true)->validate(true)->addData($param);
            return $auth->getMessage($result);
        }
    }
    
    public function saveAuthList($param) {
        ;
    }
    
    public function deleteAuth($param=array()) {
        $auth=$this->getAuthById($param['id']);
        if($auth!=null){
            $result = $auth->deleteData($param);
            return $result;
        }
        return false;
    }
    
    public function deleteAuthList($param) {
        ;
    }
    
    ////////////////////////Project////////////////////////
    
    public function getProjectById($id) {
        $project=ProjectModel::get($id);
        return $project;
    }
    
    public function getProject($param) {
        ;
    }
    
    public function getProjects($param=null) {
        if(isset($param)){
            
        }else{
            $projects=ProjectModel::all();
        }
        return $projects;
    }
    
    public function saveProject($param) 
    {
        if($param['id']){
            $project=$this->getProjectById($param['id']);
            $result=$project->allowField(true)->validate(true)->editData(['id'=>$param['id']], $param);
            return $project->getMessage($result);
        }else{
            $project=new ProjectModel();
            $result=$project->allowField(true)->validate(true)->addData($param);
            return $project->getMessage($result);
        }
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
    
    public function getTaskById($id) {
        $task=TaskModel::get($id);
        return $task;
    }
    
    public function getTask($param) {
        ;
    }
    
    public function getTasks($param) {
        if(isset($param)){
            //todo
        }else{
            $tasks=TaskModel::all();
        }
        return $tasks;
    }
    
    public function saveTask($param=array()) {
        if($param['id']){
            $task=$this->getTaskById($param['id']);
            $result=$task->allowField(true)->validate(true)->editData(['id'=>$param['id']], $param);
            return $task->getMessage($result);
        }else{
            $auth=new TaskModel();
            $result=$task->allowField(true)->validate(true)->addData($param);
            return $task->getMessage($result);
        }
    }
    
    public function saveTasks($param) {
        ;
    }
    
    public function deleteTask($param=array()) {
        $task=$this->getTaskById($param['id']);
        if($task!=null){
            $result = $role->deleteData($param);
            return $result;
        }
        return false;
    }
    
    public function deleteTasks($param) {
        ;
    }
}

