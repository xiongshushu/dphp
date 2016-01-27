<?php
namespace Du;

class Service
{
    public $form;
    
    public $request;

	public $response;
    
    public $view;

	public $models = array();
    
	public function __construct()
	{
			$this->form = new Form();
			$this->request = new Request();
			$this->response = new Response();
			$this->view = new View();
	}
}