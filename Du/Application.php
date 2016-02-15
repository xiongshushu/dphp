<?php
namespace Du;

class Application
{
    public function handle(DI $di)
    {
        try {
            $di->router->parseUrl();
            define("__MODULE__", ucfirst($di->router->module), false);
            define("__CONTROLLER__", ucfirst($di->router->controller), false);
            define("__ACTION__", $di->router->action, false);
            (new Dispatcher())->exec();
            $di->view->display();
        } catch (Error $e) {
            $di->response->show($e->getMessage(), "/");
        }
    }
}