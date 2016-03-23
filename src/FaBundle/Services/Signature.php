<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/7/30
 * Time: 下午10:31
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FaBundle\Services;

class Signature
{
    protected $options = [];
    protected $salt;

    public function __construct(array $options, $salt = '')
    {
        $this->options = $options;

        $this->salt = $salt;
    }

    public function toMd5()
    {
        return md5(implode($this->salt, $this->options));
    }

    public static function instance(array $options, $salt = '')
    {
        return new static($options, $salt);
    }
}