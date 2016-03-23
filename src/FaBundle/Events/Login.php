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

namespace FaBundle\Events;

use FaBundle\Services\Signature;
use FaBundle\Std\User\UserInterface;
use FastD\Debug\Exceptions\ServerInternalErrorException;
use FastD\Framework\Events\RestEvent;
use FastD\Http\JsonResponse;
use FastD\Http\Request;
use FastD\Http\Response;

/**
 * Class Login
 *
 * @package FaBundle\Events
 */
class Login extends RestEvent
{
    /**
     * @param Request $request
     * @return array|JsonResponse|\FastD\Http\RedirectResponse
     */
    protected function verifyAccountAndPassword(Request $request)
    {
        $account = $request->request->hasGet('_username', null);
        $password = $request->request->hasGet('_password', null);
        if (empty($account) || empty($password)) {
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'code' => 10086,
                    'msg' => 'Access denied.'
                ], Response::HTTP_FORBIDDEN);
            }
            $url = $request->header->hasGet('REFERER', null);

            if (null === $url) {
                throw new \RuntimeException('Access denied.');
            }
            return $this->redirect($url);
        }

        return [
            'username' => $account,
            'password' => $password,
        ];
    }

    /**
     * @param Request $request
     * @return array|JsonResponse|\FastD\Http\RedirectResponse
     * @throws ServerInternalErrorException
     */
    public function signInAction(Request $request)
    {
        if (($user = $this->verifyAccountAndPassword($request)) instanceof Response) {
            return $user;
        }

        $referer = $request->header->hasGet('REFERER', null);

        if (!$request->isXmlHttpRequest() && null === $referer) {
            throw new \RuntimeException('Access denied.');
        }

        try {
            $redirectUrl = $this->generateUrl($this->getParameters('admin-bundle.login_url'));
        } catch (\Exception $e) {
            if (!$request->request->has('login_url')) {
                throw new ServerInternalErrorException('redirect_url unconfiguration.');
            }
            $redirectUrl = $request->request->get('login_url');
        }

        $repository = $this->getParameters('admin-bundle.repository');
        $connection = $this->getParameters('admin-bundle.connection');
        $managerRepository = $this->getConnection($connection)->getRepository($repository);
        unset($repository, $connection);
        
        if (!($managerRepository instanceof UserInterface)) {
            throw new ServerInternalErrorException(sprintf('Repository implements extends ["%s"]', UserInterface::class));
        }

        $manager = $managerRepository->find([
            'OR' => [
                $managerRepository->getUsernameField() => $user['username'],
                $managerRepository->getEmailField() => $user['password'],
            ]
        ]);

        if (empty($manager)) {
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'code' => 10086,
                    'msg' => 'Access denied.'
                ], Response::HTTP_FORBIDDEN);
            }
            return $this->redirect($referer);
        }

        $sign = Signature::instance($user, $managerRepository::SALT)->toMd5();

        if ($sign !== $manager[$managerRepository->getPasswordField()]) {
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'code' => 10087,
                    'msg' => 'Manger authorization fail.'
                ], Response::HTTP_FORBIDDEN);
            }
            return $this->redirect($redirectUrl);
        }

        unset($manager['pwd']);
        $request->setSession('manager', $manager);

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(['redirect_url' => $redirectUrl]);
        }

        return $this->redirect($redirectUrl);
    }
}