<?php
namespace app\common\service;

use app\common\service\BaseService;
use app\oa\model\Branch as BranchModel;
use app\account\model\Profile as ProfileModel;

class OAService extends BaseService
{
    public function getBranchById($id) {
        $branch=BranchModel::get($id);
        return $branch;
    }
    
    public function getBranch($param) {
        ;
    }
    
    public function getBranchList($param=null) 
    {
        if($param){
            //todo
        }else{
            $brachList=BranchModel::all();
            return $brachList;
        }
    }
    
    public function saveBranch($param) 
    {
        if($param['id']!=0){
            $branch=$this->getBranchById($param['id']);
            $result=$branch->allowField(true)->validate(true)->editData(['id'=>$param['id']], $param);
            return $branch->getMessage($result);
        }else{
            $branch= new BranchModel();
            $result=$branch->allowField(true)->validate(true)->addData($param);
            return $branch->getMessage($result);
        }
    }
    
    public function saveBranchList($param) {
        ;
    }
    
    public function deleteBranch($param) {
        $branch=$this->getBranchById($param['id']);
        if($branch!=null){
            $result = $branch->deleteData($param);
            return $result;
        }
        return false;
    }
    
    public function deleteBranchList($param) 
    {
        $ids=array_values($param);
        $result=BranchModel::destroy($ids);
        return $result;
    }
    
    public function getBranchDatatable($param) 
    {
        if(isset($param['customActionType'])&isset($param['customActionName'])){
            switch ($param['customActionName']){
                case 'delete':
                    $deleteResult=BranchModel::destroy(array_values($param['id']));
                    if($deleteResult!==false){
                        foreach ($param['id'] as $branch_id){
                            foreach (ProfileModel::all(['branch_id'=>$branch_id]) as $profile){
                                $profile->save(['branch_id'=>'']);
                            }
                        }
                    }
                    break;
            }
        }
        
        if(isset($param['customActionType'])&isset($param['customActionType'])){
            switch ($param['customActionType']){
                case 'delete':
                    $deleteResult=BranchModel::destroy(array_values($param['id']));
                    if($deleteResult!==false){
                        foreach ($param['id'] as $branch_id){
                            foreach (ProfileModel::all(['branch_id'=>$branch_id]) as $profile){
                                $profile->save(['branch_id'=>'']);
                            }
                        }
                    }
                    break;
            }
        }
        
        $all=BranchModel::all();
        $filter=$all;
        
        $queryFunc=function ($query)use($param){
            if(isset($param['search1'])){
                $query->where('name','销售部');
            }
            switch ($param['order']['0']['column'])
            {
                case 1:
                    $sortColumn='name';
                    break;
                case 2:
                    $sortColumn='description';
                    break;
                default:
                    $sortColumn='id';
            }
            switch ($param['order']['0']['dir'])
            {
                case 'asc':
                    $sortDirection='asc';
                    break;
                case 'desc':
                    $sortDirection='desc';
                    break;
                default :
                    $sortDirection='desc';
            }
            $query->limit($param['start'],$param['length']);
            $query->order($sortColumn,$sortDirection);
        };
        
        $display=BranchModel::all($queryFunc);
        $array=array();
        foreach ($display as $branch){
            //array_push($array,['id'=>$branch->id,'name'=>$branch->name,'description'=>$branch->description,'staff'=>$branch->profiles()->select()]);
            array_push($array,['id'=>$branch->id,'name'=>$branch->name,'description'=>$branch->description,'staff'=>$branch->staff]);
        }
        $display=$array;
        if(isset($data['search1'])){
            $filter=$display;
        }
        $result=array('draw'=>$param['draw'],'data'=>$display,'recordsFiltered'=>count($filter),'recordsTotal'=>count($all));
        
        return $result;
    }

    
}

