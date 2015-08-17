<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/8/17
 * Time: 下午10:44
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Admin\Repository;

use FastD\Database\Repository\Repository;

class DemoRepository extends Repository implements UserRepositoryInterface
{
    protected $table = 'fastd_manager';

    public function getUser($username)
    {
        return $this->find([$this->getUsernameField() => $username]);
    }

    public function getUsernameField()
    {
        return 'username';
    }

    public function getEmailField()
    {
        return 'email';
    }

    public function getPasswordField()
    {
        return 'pwd';
    }

    public function getSaltField()
    {
        return 'salt';
    }

    public function getRolesField()
    {
        return 'roles';
    }
}