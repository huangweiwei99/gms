<?php
/**
 * Created by PhpStorm.
 * User: huangweiwei
 * Date: 2017/5/10
 * Time: 11:17
 */

namespace app\common\behavior;


class AuditLog
{
    public function run($request)
    {
        $this->writeAuditLog($request);
    }

    private function writeAuditLog($request)
    {

    }

}