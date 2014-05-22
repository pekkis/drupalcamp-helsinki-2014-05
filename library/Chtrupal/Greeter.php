<?php

namespace Chtrupal;

class Greeter
{
    private $iAmNeeded;

    public function __construct(GreeterNeedsMe $iAmNeeded)
    {
        $this->iAmNeeded = $iAmNeeded;
    }

    public function getStuff()
    {
        return [
            'key' => 'value',
            'avain' => 'arvo',
            'tenhukainen' => 'lipaisee'
        ];
    }
}
