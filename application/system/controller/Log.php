<?php
/**
 * Created by PhpStorm.
 * User: huangweiwei
 * Date: 2017/5/4
 * Time: 22:40
 */

namespace app\system\controller;

use app\common\controller\Admin as AdminController;
use app\system\model\AuditLog as AuditLogModal;

class Log extends AdminController
{
  public function  index()
  {
      return view();
  }

  public function auditdata()
  {
    $data=AuditLogModal::all();

    $result=array('draw'=>1,'data'=>$data,'recordsFiltered'=>10,'recordsTotal'=>10);
    return json($result);
  }
}