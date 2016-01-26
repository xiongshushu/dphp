<?php
namespace Du;

class Application
{
    public function handle(DI $di)
    {
        try {
            $router = new Router();
            $router->parseUrl();
            define("__MODULE__", ucfirst($router->module), false);
            define("__CONTROLLER__", ucfirst($router->controller), false);
            define("__ACTION__", $router->action, false);
            (new Dispatcher())->exec();
            $di->view->display();
        } catch (Error $e) {
            $di->response->show($e->getMessage(), "/");
        }
    }
}