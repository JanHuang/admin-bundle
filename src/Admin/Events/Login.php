<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/7/30
 * Time: 下午10:26
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Admin\Events;

use FastD\Framework\Events\TemplateEvent;
use FastD\Http\Request;

class Login extends TemplateEvent
{
    public function loginAction()
    {
        return $this->render('Admin/Resources/views/login.twig');
    }

    public function signInAction(Request $request)
    {

    }
}