<?php
namespace Du;

class Service
{
    public $middleware;
    
    public $request;

	public $response;
    
    public $view;
    
    public $cookie;
    
    public $dispatcher;
    
	public function __construct()
	{
			$this->middleware = new Middleware();
			$this->request = new Request();
			$this->response = new Response();
			$this->view = new View();
			$this->cookie = new Cookie();
			$this->dispatcher = new Dispatcher();
	}
}