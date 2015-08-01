<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/7/31
 * Time: 上午10:00
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Admin\Events;

use FastD\Http\Request;

class Manager extends DashAuthorization
{
    public function profileAction()
    {

    }

    public function createManagerAction(Request $request)
    {

    }

    public function passwdAction(Request $request)
    {
        if ($request->isMethod('get')) {
            return $this->render('Admin/Resources/views/profile/passwd.twig');
        }

        $oldPassword = $request->request->hasGet('old_password', null);
        $newPassword = $request->request->hasGet('new_password', null);
        $comfirm = $request->request->hasGet('comfirm_password', null);


    }
}