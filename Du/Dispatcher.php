<?php
namespace Du;

class Dispatcher
{

    public function exec()
    {
        $mc = __MODULE__ . "\\" . __CONTROLLER__;
        if(IS_CLI){
            $mc = CLI_APP."\\".$mc;
        }
        if (!class_exists($mc)) {
            throw new Error("Couldn't find controller: " . __CONTROLLER__);
        }
        if (!method_exists($mc, __ACTION__)) {
            throw new Error("Couldn't find  action : " . __ACTION__ . " of " . __CONTROLLER__);
        }
        $call = new $mc();
        if (method_exists($call, "main")) {
            $call->main();
        }
        $call->{__ACTION__}();
    }
}