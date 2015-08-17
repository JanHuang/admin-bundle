<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/7/30
 * Time: 下午10:35
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Admin\Commands;

use Admin\Repository\AdminInterface;
use Admin\Services\Signature;
use FastD\Console\Command;
use FastD\Console\IO\Input;
use FastD\Console\IO\Output;
use FastD\Debug\Exceptions\ServerInternalErrorException;
use FastD\Framework\Events\BaseEvent;

class MakeUser extends Command
{
    const STR = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

    public function getName()
    {
        return 'admin:make:user';
    }

    public function configure()
    {
        $this
            ->setOption('name')
            ->setOption('pwd')
            ->setOption('salt')
            ->setOption('email')
        ;
    }

    public function getPwd(Input $input)
    {
        $pwd = $input->getParameterOption('pwd');
        if (!empty($pwd)) {
            return $pwd;
        }
        return $this->getRandString(8);
    }

    public function getRandString($length)
    {
        $str = MakeUser::STR;
        $strlen = strlen($str) - 1;
        $pwd = '';
        for ($i = 0; $i < $length; $i++) {
            $pwd .= $str{mt_rand(0, $strlen)};
        }
        return $pwd;
    }

    public function getSalt(Input $input)
    {
        $pwd = $input->getParameterOption('salt');
        if (!empty($pwd)) {
            return $pwd;
        }
        return $this->getRandString(6);
    }

    public function getUsername(Input $input)
    {
        $username = (null === ($username = $input->getParameterOption('user'))) ? null : $username;
        return empty($username) ? $this->getRandString(6) : $username;
    }

    public function getEmail(Input $input)
    {
        $email = (null === ($email = $input->getParameterOption('email'))) ? null : $email;
        return empty($email) ? '' : $email;
    }

    public function execute(Input $input, Output $output)
    {
        $username = $this->getUsername($input);
        $pwd = $this->getPwd($input);
        $salt = $this->getSalt($input);
        $email = $this->getEmail($input);

        $signature = new Signature();
        $password = $signature->makeMd5Password($username, $pwd, $salt);
        $container = $this->getContainer();
        $event = new BaseEvent();
        $event->setContainer($container);

        try {
            $repository = $event->getParameters('admin_bundle.repository');
            $connection = $event->getParameters('admin_bundle.connection');
            $managerRepository = $event->getConnection($connection)->getRepository($repository);
            unset($repository, $connection);
        } catch (\Exception $e) {
            throw new ServerInternalErrorException('Admin bundle is unconfiguration. Parameters "redirect_url", "repository", "connection"');
        }

        if (!($managerRepository instanceof AdminInterface)) {
            throw new ServerInternalErrorException('Repository implements extends "Admin\\Repository\\AdminInterface');
        }

        if ($managerRepository->insert([
            $managerRepository->getUsernameField()  => $username,
            $managerRepository->getEmailField()     => $email,
            $managerRepository->getPasswordField()  => $password,
            $managerRepository->getSaltField()      => $salt,
            $managerRepository->getRolesField()     => '["ROLE_USER"]',
        ])) {
            $output->writeln($managerRepository->getUsernameField() . ': ' . $username, Output::STYLE_SUCCESS);
            $output->writeln($managerRepository->getPasswordField() . ': ' . $pwd, Output::STYLE_SUCCESS);
            $output->writeln($managerRepository->getEmailField() . ': ' . $email, Output::STYLE_SUCCESS);
            $output->writeln($managerRepository->getSaltField() . ': ' . $salt, Output::STYLE_SUCCESS);
            $output->writeln($managerRepository->getRolesField() . ': ' . $salt, Output::STYLE_SUCCESS);
            return 0;
        }

        $output->writeln('make fiald. error. ' . json_encode($managerRepository->getErrors()));
        return 1;
    }
}