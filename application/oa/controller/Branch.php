<?php

namespace app\oa\controller;

use app\common\controller\Admin as AdminController;
use app\oa\model\Branch as BranchModel;
use think\Request;

class Branch extends AdminController
{
    public function index(Request $request)
    {
        if($request->isPost()){
            $params = $request->param();
            $result=$this->OAService()->getBranchDatatable($params);
            return json($result);
        }
        return view();
    }
    
    public function create()
    {
        $assign=array('profile'=>$this->accountService()->getProfiles(['branch_id'=>'']));
        return view('form')->assign($assign);
    }

    public function save(Request $request)
    {
        $data = $request->param();
        $result=$this->OAService()->saveBranch($data);
        return json($result);
    }

    public function read($id)
    {
        $branch=BranchModel::get($id);
        $assign=array('branch'=>$branch,'profile'=>$branch->branchInProfiles(),'selectProfile'=>$branch->branchInProfileIdsArray());
        return view('form')->assign($assign);
    }

}