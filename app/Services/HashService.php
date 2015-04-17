<?php namespace Butler\Services;

use Vinkla\Hashids\HashidsManager;

class HashService {

    /**
     * @var HashidsManager
     */
    private $hashids;

    /**
     * @param HashidsManager $hashids
     */
    function __construct(HashidsManager $hashids)
    {
        $this->hashids = $hashids;
    }

    /**
     * @param $string
     */
    public function encode($string)
    {
        $this->hashids->encode($string);
    }

    /**
     * @param $string
     */
    public function decode($string)
    {
        $this->hashids->decode($string);
    }
}