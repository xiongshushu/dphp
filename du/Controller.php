<?php
namespace du;

use du\di\Injectable;

/**
 * Class Controller
 * @package Du
 */
abstract class Controller extends Injectable
{
    public function __construct()
    {

        if (method_exists($this, "main")) {
            $this->main();
        }
    }

    public function input($key = "")
    {
       return $this->form->input($key);
    }
}