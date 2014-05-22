<?php

namespace Chtrupal;

class GreeterNeedsMe
{
    public function __construct(GreeterNeederNeedsMe $iAmNeeded)
    {
        $this->iAmNeeded = $iAmNeeded;
    }
}
