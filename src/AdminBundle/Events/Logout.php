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
use FastD\Debug\Exceptions\ServerInternalErrorException;

class Logout extends Authorization
{
    public function signOutAction(Request $request)
    {
        try {
            $redirectUrl = $this->generateUrl($this->getParameters('admin-bundle.logout_url'));
        } catch (\Exception $e) {
            if (!$request->request->has('redirect_url')) {
                throw new ServerInternalErrorException('redirect_url unconfiguration.');
            }
            $redirectUrl = $request->request->get('logout_url');
        }

        $request->clearSession('manager');
        if ($request->hasSession('manager')) {
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'code' => 10088,
                    'msg' => 'Operation fail.'
                ], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirect($redirectUrl);
        }

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'msg' => 'ok'
            ]);
        }
        return $this->redirect($redirectUrl);
    }
}