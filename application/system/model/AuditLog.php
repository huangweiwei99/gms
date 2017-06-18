<?php

namespace app\system\model;

use app\common\model\SystemBase as SystemBaseModel;

class AuditLog extends SystemBaseModel
{
    public $autoWriteTimestamp = false;
   // protected $table="gms_auditlog";

    // 定义类型转换
    public $type = [
        'log_time' => 'timestamp:Y/m/d H:i:s',
    ];
}
