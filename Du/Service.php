<?php
namespace Du;

class Service
{
    public $form;
    
    public $request;

	public $response;
    
    public $view;
    
	public function __construct()
	{
			$this->middleware = new Form();
			$this->request = new Request();
			$this->response = new Response();
			$this->view = new View();
	}
}