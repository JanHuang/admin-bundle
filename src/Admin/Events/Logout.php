<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/7/30
 * Time: 下午11:58
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Admin\Events;

use FastD\Http\JsonResponse;
use FastD\Http\Request;
use FastD\Http\Response;

class Logout extends DashAuthorization
{
    public function signOutAction(Request $request)
    {
        $request->clearSession('manager');
        if ($request->hasSession('manager')) {
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'code' => 10088,
                    'msg' => 'Operation fail.'
                ], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirect($this->generateUrl('dash_admin_board'));
        }

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'msg' => 'ok'
            ]);
        }
        return $this->redirect($this->generateUrl('dash_admin__login'));
    }
}