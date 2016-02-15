<?php
namespace Du;

class Service
{
    public $form;

    public $request;

    public $response;

    public $view;

    public $models = array();

    public $router;

    public function __construct()
    {
        $this->form = new Form();
        $this->router = new Router();
        $this->request = new Request();
        $this->response = new Response();
        $this->view = new View();
    }
}