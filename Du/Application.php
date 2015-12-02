<?php
namespace Du;

class Application
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
    
    public function registe($name,$call)
    {
        if(!is_callable ($call))
        {
            $this->$name= new $call;
        }else{
            $this->$name= $call();
        }
    }
    
	public function handle()
	{
	       DI::Load($this);
		   $query = $this->router->parseUrl($this->module);
	       define("__MODULE__", ucfirst($query->defautModule),false);
	       define("__CONTROLLER__", ucfirst($query->defaultController),false);
	       define("__ACTION__",$query->defaultAcion,false);
	       try{
	             $this->dispatcher->exec();
	             $this->view->display();
	       }catch (DUException $e){
	       	     $this->response->show($e->getMessage(),"/");
	       }
	 }
}