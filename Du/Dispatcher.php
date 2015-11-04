<?php
namespace Du;

class Dispatcher
{

    private $_di;

    public function __construct(Service $di)
    {
        $this->_di = $di;
    }

    public function exec()
    {
        $this->run();
    }

    public function cliExec()
    {
        $this->run(2);
    }

    private function run($type = 1)
    {
        if ($type == 1) {
            $ctr = __MODULE__ . "\\Controllers\\" . __CONTROLLER__;
        } else {
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
        $call->setDI($this->_di);
        if (method_exists($call, "main")) {
            $call->main();
        }
        $call->$action();
    }
}