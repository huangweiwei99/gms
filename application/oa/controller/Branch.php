<?php

namespace app\oa\controller;

use app\common\controller\Admin as AdminController;
use app\oa\model\Branch as BranchModel;
use app\account\model\Profile as ProfileModel;
use think\Request;

class Branch extends AdminController
{
    public function index(Request $request)
    {
      if($request->isPost()){
          $params = $request->param();
          if(isset($params['customActionType'])&isset($params['customActionName'])){
              switch ($params['customActionName']){
                  case 'delete':
                    $deleteResult=BranchModel::destroy(array_values($params['id']));
                    if($deleteResult!==false){
                        foreach ($params['id'] as $branch_id){
                            foreach (ProfileModel::all(['branch_id'=>$branch_id]) as $profile){
                                $profile->save(['branch_id'=>'']);
                            }
                        }
                    }
                    break;
              }
          }

          if(isset($params['customActionType'])&isset($params['customActionType'])){
              switch ($params['customActionType']){
                  case 'delete':
                      $deleteResult=BranchModel::destroy(array_values($params['id']));
                      if($deleteResult!==false){
                          foreach ($params['id'] as $branch_id){
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

          $queryFunc=function ($query)use($params){
              if(isset($params['search1'])){
                  $query->where('name','销售部');
              }
              switch ($params['order']['0']['column'])
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
              switch ($params['order']['0']['dir'])
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
              $query->limit($params['start'],$params['length']);
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
          $result=array('draw'=>$params['draw'],'data'=>$display,'recordsFiltered'=>count($filter),'recordsTotal'=>count($all));
          return json($result);
      }
        return view();
    }

    public function create()
    {
        $profile=ProfileModel::all(['branch_id'=>'']);
        $assign=array('profile'=>$profile);
        return view('form')->assign($assign);
    }

    public function save(Request $request)
    {
        $data = $request->param();
        if ($data['id'] != 0) {
            $id = $data['id'];
            $branch= BranchModel::get($id);
            $map = array( 'id' => $id );
            if($branch->allowField(true)->editData($map, $data)===0|true){
                $array=array('flag'=>true,'message'=>'编辑成功','level'=>'success');
                return json($array);
            }else{
                $array=array('flag'=>false,'message'=>$branch->getErrors(),'level'=>'error');
                return json($array);
            }
        }else{
            $branch=new BranchModel();
            if($branch->allowField(true)->validate(true)->addData($data)){
                $array=array('flag'=>true,'message'=>'新增成功','level'=>'success');
                return json($array);
            }else{
                $array=array('flag'=>false,'message'=>$branch->getErrors(),'level'=>'error');
                return json($array);
            }
        }
    }

    public function read($id)
    {
        $branch=BranchModel::get($id);
        $selectProfile=array();
        if(count($branch->profiles()->select())){
            $profile=ProfileModel::all(function($query)use($id){
                $query->where("branch_id='' OR branch_id=".$id);
            });
            foreach ($branch->profiles()->select() as $p){
                array_push($selectProfile,$p->branch_id);
            }
        }else{
            $profile=ProfileModel::all(['branch_id'=>'']);
        }
        $assign=array('branch'=>$branch,'profile'=>$profile,'selectProfile'=>$selectProfile);
        return view('form')->assign($assign);
    }

}