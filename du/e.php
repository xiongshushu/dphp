<?php

class e extends \Exception
{
    static function panic($message = "", $code = 0, \Exception $previous = null)
    {
        throw new self($message, $code, $previous);
    }
}