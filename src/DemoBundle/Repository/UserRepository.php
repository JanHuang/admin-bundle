<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/3/23
 * Time: 下午5:36
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace DemoBundle\Repository;

use FaBundle\Std\User\UserInterface;
use FastD\Database\Repository\Repository;

class UserRepository extends Repository implements UserInterface
{
    protected $table = 'test';

    /**
     * @return string
     */
    public function getUsernameField()
    {
        return 'username';
    }

    /**
     * @return string
     */
    public function getEmailField()
    {
        return 'email';
    }

    /**
     * @return string
     */
    public function getPasswordField()
    {
        return 'password';
    }
}