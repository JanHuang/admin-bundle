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

use Admin\Repository\UserRepositoryInterface;
use Admin\Services\Signature;
use FastD\Debug\Exceptions\ServerInternalErrorException;
use FastD\Framework\Events\TemplateEvent;
use FastD\Http\JsonResponse;
use FastD\Http\Request;
use FastD\Http\Response;

class Login extends TemplateEvent
{
    protected $account;

    protected $password;

    public function loginAction()
    {
        return $this->render('Admin/Resources/views/login.twig');
    }

    protected function getAccount()
    {
        return $this->account;
    }

    protected function getPassword()
    {
        return $this->password;
    }

    protected function verifyAccountAndPassword(Request $request)
    {
        $account = $request->request->hasGet('_account', null);
        $passwrod = $request->request->hasGet('_password', null);
        if (empty($account) || empty($passwrod)) {
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'code' => 10086,
                    'msg' => 'Access denied.'
                ], Response::HTTP_FORBIDDEN);
            }
            return $this->redirect($this->generateUrl('dash_admin_login'));
        }

        $this->account = $account;
        $this->password = $passwrod;
        unset($account, $passwrod);

        return $this;
    }

    public function signInAction(Request $request)
    {
        $this->verifyAccountAndPassword($request);

        try {
            try {
                $redirectUrl = $this->generateUrl($this->getParameters('admin_bundle.redirect_url'));
            } catch (\Exception $e) {
                if (!$request->request->has('redirect_url')) {
                    throw new ServerInternalErrorException('redirect_url unconfiguration.');
                }
                $redirectUrl = $request->request->get('redirect_url');
            }
            $repository = $this->getParameters('admin_bundle.repository');
            $connection = $this->getParameters('admin_bundle.connection');
            $managerRepository = $this->getConnection($connection)->getRepository($repository);
            unset($repository, $connection);
        } catch (\Exception $e) {
            throw new ServerInternalErrorException('Admin bundle is unconfiguration. Parameters "redirect_url", "repository", "connection"');
        }

        if (!($managerRepository instanceof UserRepositoryInterface)) {
            throw new ServerInternalErrorException('Repository implements extends "Admin\\Repository\\AdminInterface');
        }

        $manager = $managerRepository->find(['OR' => [$managerRepository->getUsernameField() => $this->getAccount(), $managerRepository->getEmailField() => $this->getAccount()]]);

        if (false == $manager) {
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'code' => 10086,
                    'msg' => 'Access denied.'
                ], Response::HTTP_FORBIDDEN);
            }
            return $this->redirect($this->generateUrl('dash_admin_login'));
        }

        $signature = new Signature();
        $sign = $signature->makeMd5Password($manager[$managerRepository->getUsernameField()], $this->getPassword(), $manager['salt']);
        if ($sign !== $manager[$managerRepository->getPasswordField()]) {
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'code' => 10087,
                    'msg' => 'Manger authorization fail.'
                ], Response::HTTP_FORBIDDEN);
            }
            return $this->redirect($this->generateUrl('dash_admin_login'));
        }

        unset($manager['pwd']);
        $request->setSession('manager', $manager);
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(['redirect_url' => $redirectUrl]);
        }

        return $this->redirect($redirectUrl);
    }
}