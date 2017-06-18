<?php
/**
 * Created by PhpStorm.
 * User: huangweiwei
 * Date: 2017/5/8
 * Time: 15:29
 */

namespace app\account\controller;

use app\account\model\Project as ProjectModel;
use app\account\model\Task as TaskModel;
use app\oa\model\Branch as BranchModel;
use app\common\controller\Admin as AdminController;
use think\Request;


class Todo extends AdminController
{
    public function index()
    {
        $projects= ProjectModel::all();
        $branch=BranchModel::all();
        $assign=array('projects'=>$projects,'branch'=>$branch);
        return view()->assign($assign);
    }

    public function create()
    {
        return view('form');
    }

    public function save(Request $request)
    {
        $data = $request->param();
        if ($data['id'] != 0) {
            $id = $data['id'];
        }else{
            $project=new ProjectModel();
            if($project->allowField(true)->addData($data)){
                $array=array('flag'=>true,'message'=>'新增成功','level'=>'success');
                return json($array);

            }else{
                $array=array('flag'=>false,'message'=>$project->getErrors(),'level'=>'error');
                return json($array);
            };
        }
    }

    public function read($id=null)
    {

    }

    public function delete($id=null)
    {

    }

    public function selectStaff($id=null)
    {

        $projects= ProjectModel::all();
        $branch=BranchModel::all();
        $selectedStaffs=array();
        foreach (ProjectModel::get($id)->profiles()->select() as $profile)
        {
            array_push($selectedStaffs,$profile->id);
        }
        $assign=array('projects'=>$projects,'branch'=>$branch,'project_id'=>$id,'selected_staffs'=>$selectedStaffs);
        return view()->assign($assign);
    }

    public function saveStaff(Request $request)
    {

        $data=$request->param();
        $project=ProjectModel::get($data['project_id']);
        $profile_ids=array();
        foreach ($project->profiles()->select() as $profile){
            array_push($profile_ids,$profile->id);
        }
        $project->profiles()->detach(array_values($profile_ids));
        $result=$project->profiles()->attach(array_values($data['staffs']));
        if($result!==false){
            $this->redirect('index');
        }
    }

    public function taskList($id=null)
    {
        $project=ProjectModel::get($id);
        $task=$project->task()->select();
        $selected_staffs=array();
        foreach ($project->profiles()->select() as $profile) {
            array_push($selected_staffs,$profile->id);
        }

        $assign=array('task'=>$task,'selected_staffs'=>$project->profiles()->select());
        return view()->assign($assign);
    }

    public function task($project_id=null)
    {
        $project=ProjectModel::get($project_id);
        $staffs=$project->profiles()->select();
        return view()->assign(array('project_id'=>$project_id,'staffs'=>$staffs));
    }

    public function readTask($id=null)
    {
        $task=TaskModel::get($id);
        $assign=array('task'=>$task);
        return view('taskdetail')->assign($assign);
    }

    public function saveTask(Request $request)
    {
        $data=$request->param();
        if ($data['id'] != 0) {
            $id = $data['id'];
        }else{
            $project=ProjectModel::get($data['project_id']);
            $result=$project->task()->save($data);
            if($result!==false){
                $this->redirect('index');
            }
        }
    }
}
