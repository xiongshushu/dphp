<?php
namespace du;


class Application
{
    public function handle(DI $di)
    {
        try {
            $di->router->parseUrl();
            define("__MODULE__", $di->router->module, false);
            define("__CONTROLLER__", $di->router->controller, false);
            define("__ACTION__", $di->router->action, false);
            $this->exec();
            $di->view->display();
        } catch (Error $e) {
            $di->response->error($e->getMessage(), "/");
        }
    }

    public function exec()
    {
        $mc = __MODULE__ . "\\" . ucfirst(__CONTROLLER__);
        if (IS_CLI) {
            $mc = CLI_APP . "\\" . $mc;
        }
        if (!class_exists($mc)) {
            throw new Error("Couldn't find controller: " . __CONTROLLER__);
        }
        if (!method_exists($mc, __ACTION__)) {
            throw new Error("Couldn't find action : " . __ACTION__ . " of " . __CONTROLLER__);
        }
        (new $mc())->{__ACTION__}();
    }
}