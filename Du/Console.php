<?php
namespace Du;

class Console
{

    public function handle($argv)
    {
        if (php_sapi_name() != "cli") {
            throw new Error("please run in cli mode!\n");
        }
        if (empty($argv[1])) {
            throw new Error("cli task no found!\n");
        }
        if (empty($argv[2])) {
            throw new Error("cli task action no found!\n");
        }
        define("__MODULE__", "Task", false);
        define("__CONTROLLER__", ucfirst($argv[1]), false);
        define("__ACTION__", ucfirst($argv[2]), false);
        try {
            DI::$di->dispatcher->exec("console");
        } catch (Error $e) {
            DI::$di->response->show($e->getMessage());
        }
    }
}