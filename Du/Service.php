<?php
namespace Du;

class Service
{
    public $router;
    
    public $response;
    
    public $middleware;
    
    public $request;
    
    public $view;
    
    public $cookie;
    
    public $dispatcher;
    
    public $module;
    
	public function __construct()
	{
			$this->router  = new Router();
			$this->response =new Response();
			$this->middleware = new Middleware();
			$this->request = new Request();
			$this->view = new View();
			$this->cookie = new Cookie();
			$this->dispatcher = new Dispatcher();
			$this->module = new Module();
	}
}