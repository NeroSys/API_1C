<?php
namespace common\modules\rbac\interfaces;

interface UserRbacInterface
{
    public function getId();

    public function getUserName();

    public static function findIdentity($id);
}
