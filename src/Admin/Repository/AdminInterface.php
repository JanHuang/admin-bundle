<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/8/17
 * Time: 下午10:13
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Admin\Repository;

interface AdminInterface
{
    public function getUser();

    public function getUsernameField();

    public function getEmailField();

    public function getPasswordField();

    public function getSaltField();

    public function getRolesField();
}