<?php


namespace CalderaLearn\RestSearch;

class Something
{
    protected $arg;

    public function __construct($arg)
    {
        $this->arg = $arg;
    }

    public function getArg()
    {
        return $this->arg;
    }
}
