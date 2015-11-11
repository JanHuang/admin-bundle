<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/7/30
 * Time: 下午11:40
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Admin\Events;

use FastD\Framework\Events\TemplateEvent;
use FastD\Http\JsonResponse;
use FastD\Http\Request;
use FastD\Http\Response;

class Authorization extends TemplateEvent
{
    /**
     * @var Request
     */
    protected $request;

    protected $user;

    public function __initialize(Request $request)
    {
        $this->request = $request;
        if (!$request->hasSession('manager')) {
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'code' => 10086,
                    'msg' => 'Access denied.',
                ], Response::HTTP_FORBIDDEN);
            }
            return $this->redirect($this->generateUrl('dash_admin_login'));
        }

        $this->user = $request->getSession('manager');
    }

    protected function getUser()
    {
        return $this->user;
    }

    protected function getUsername()
    {
        return $this->user['username'];
    }

    protected function getNickname()
    {
        return $this->user['nickname'];
    }

    protected function getEmail()
    {
        return $this->user['email'];
    }

    protected function getAvatar()
    {
        return $this->user['avatar'];
    }

    protected function getRoles()
    {
        return false !== ($roles = json_decode($this->user['roles'], true)) ? $roles : $this->user['roles'];
    }
}
