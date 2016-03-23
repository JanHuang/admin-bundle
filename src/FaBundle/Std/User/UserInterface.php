<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/3/23
 * Time: 下午4:50
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FaBundle\Std\User;

/**
 * Interface UserInterface
 *
 * @package AdminBundle\Std\User
 */
interface UserInterface
{
    const SALT = '!@#**%^#)#@$(>N';

    /**
     * @return string
     */
    public function getUsernameField();

    /**
     * @return string
     */
    public function getEmailField();

    /**
     * @return string
     */
    public function getPasswordField();
}