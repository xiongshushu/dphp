<?php
namespace du;

use du\di\injectable;

/**
 * Class controller
 * @package du
 */
abstract class controller extends injectable
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