<?php
namespace Du;

class Dispatcher
{

    public function exec($type = "normal")
    {
        
        $ctr = __MODULE__ . "\\Controllers\\" . __CONTROLLER__;
        if ($type == "console") {
            $ctr = CLI_MOD . "\\" . __MODULE__ . "\\" . __CONTROLLER__;
        }
        $action = __ACTION__ . "Action";
        if (! class_exists($ctr)) {
            throw new DUException("Couldn't find controller: " . __CONTROLLER__);
        }
        if (! method_exists($ctr, $action)) {
            throw new DUException("Couldn't find  action : " . $action . " of " . __CONTROLLER__);
        }
        $call = new $ctr();
        if (method_exists($call, "main")) {
            $call->main();
        }
        $call->$action();
    }
}