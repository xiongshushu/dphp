## DuPHP (目前是测试版本，不断更新)##
DuPHP是一款轻量级的开源PHP框架，不到50k的压缩大小，MVC结构，轻量级内置模板引擎Smart，验证码；上传；加密；静态路由，正则路由；多模块统统都有，运行在PHP≥5.4的系统中，精简封装PDO MySql操作，操作数据库目前只通过PDO操作，完全可以使用第三方数据库操作类。DuPHP低耦合框架，可以在框架的基础上二次开发，打造完全属于自己的框架，完全的自由化。
##DuPHP与ThinkPHP的性能测试##
以下测试均在相同环境下（单纯的输出“hello world” 的测试），您若自行测试，因硬件配置不同会有所差异
###AB测试###
DuPHP

	Concurrency Level:      1
	Time taken for tests:   3.692 seconds
	Complete requests:      1000
	Failed requests:        0
	Total transferred:      353000 bytes
	HTML transferred:       11000 bytes
	Requests per second:    270.87 [#/sec] (mean)
	Time per request:       3.692 [ms] (mean)
	Time per request:       3.692 [ms] (mean, across all concurrent requests)
	Transfer rate:          93.37 [Kbytes/sec] received


ThinkPHP（DEBUG为false时）

	Concurrency Level:      1
	Time taken for tests:   10.960 seconds
	Complete requests:      1000
	Failed requests:        0
	Total transferred:      353000 bytes
	HTML transferred:       11000 bytes
	Requests per second:    91.24 [#/sec] (mean)
	Time per request:       10.960 [ms] (mean)
	Time per request:       10.960 [ms] (mean, across all concurrent requests)
	Transfer rate:          31.45 [Kbytes/sec] received


###Xhprof测试###
DuPHP

	Overall Summary	
	Total Incl. Wall Time (microsec):	4,157 microsecs
	Total Incl. CPU (microsecs):	4,000 microsecs
	Total Incl. MemUse (bytes):	399,008 bytes
	Total Incl. PeakMemUse (bytes):	411,832 bytes
	Number of Function Calls:	191
ThinkPHP（DEBUG为false时）

	Overall Summary	
	Total Incl. Wall Time (microsec):	13,293 microsecs
	Total Incl. CPU (microsecs):	13,000 microsecs
	Total Incl. MemUse (bytes):	1,363,904 bytes
	Total Incl. PeakMemUse (bytes):	1,445,408 bytes
	Number of Function Calls:	657
从中可以看出，DuPHP比ThinkPHP性能提升至少3倍！
## Apache,Nginx 配置伪静态##
Du目前只能使用伪静态

	Nginx
    if (!-e $request_filename) {
   		 rewrite  ^(.*)$ /index.php?_s=$1 last;
  		  break;
    	}
    }

----------

	Apache
	<IfModule mod_rewrite.c>
		RewriteEngine on
		RewriteCond %{REQUEST_FILENAME} !-d
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteRule ^(.*)$ index.php/?_s=$1 [QSA,L]
	</IfModule>

## MVC，模型（Model），视图（View），控制器（Controller）##
DuPHP遵循MVC结构,Du的模型主要负责数据库的操作，控制器作为调度模型和视图两者的控制层，包含业务逻辑。除了MVC结构以外还引入了“表单层”，其实就是表单验证层， 不单单是表单验证，还可以在控制器执行之前，执行一些必要的逻辑，安全过滤等等，但是表单层不是每个控制器都是必须的，除非控制器中含有$this->input()的时候，你必须要需要表单层的支持，我们建议在含有数据传递的时候，能够使用“表单层”，避免一些不必要要安全问题。
####控制器(Controller)####
控制器负责调度模型，视图会在控制器中自动渲染，只有当存在视图文件时，才进行渲染。设置模板变量，请使用$this->view->setVar()方法。
常规控制器

```php
	<?php
		namespace Home; //命名空间不能搞错;
		use Du\Controller; 
		
		class Home extends Controller //控制器名称必须大写
		{
		    public function index() //必须是公共方法且Action为后缀,不接受参数,我们不建议在控制器直接进行Action调用
		    {
		    	 $formData = $this->input(); //获取请求的数据.数据已经经过安全处理,具体查看"表单层"的说明
		    	 #一些业务逻辑......
		    	 $this->UserModel->getUserOne();//调用模型的方法,模型不需要手动实例化.具体可查看模型部分.
		         $this->view->setVar("name","DuPHP"); //使用view服务为模板分配一个变量
		    }
		}
```

控制器的Action会自动调用模板文件模块/控制器/动作(Home/Home/index.php),若要指定其他模板文件,使用view的display方法如$this->view->display("home.index");调用视图VIEW目录下的home目录下的index.php模板

####模型(Model)####
Du模型就是数据库操作类的中间人.
在使用模型之前入口文件中先要注册一个db服务,以下使用内置的pdo数据库操作类,也可以一使用其他注册为其他数据库操作类库.

	$di->register("db", function(){
	    return new Pdo([
	        'dsn' => "mysql:dbname=test;host=127.0.0.1;charset=utf8",
	        'db_user' => 'root',
	        'db_pwd' => '',
	        'db_encode'=>'utf8']);
	});

控制器中调用模型只需$this->*Model 调用即可，例如$this->UserModel,调用了User模型，必须包含Model关键词，框架自动识别
在模型中，可以直接调用数据库操作类的方法.可以开启数据库缓存,默认使用基于文件的缓存,目的是对重复查询的结果缓存,减少数据库多次查询。
默认是基于文件缓存,有一定的缺陷.要使用缓存,需要在入口文件中指定那类缓存驱动.

```php
	$di->register("cache", function(){
        $cache = new File();
        return $cache;
	});
```

####视图(View)####
Du的视图可以直接使用原生的语法。如果你要是用内置模板，你必须在入口文件中注册一个视图服务

```php
	$di->register("view", function(){
		  $view = new View();
		  $view->loadEngine(new Smart()); //声明使用内置模板引擎驱动，类似可以使用smarty模板
		  return $view;
	});
```

内置模板的语法：

{:$name} = <?php $name ?> //表示在"{:" 和"}"之间可以写入任何php代码.

{{$name}} = <?php echo $name ?> //表示在"{{" 和"}}"输出一个模板变量值,依然支持php语法.
	
{if:false==true} = <?php if (false==true){?> //没啥好说了,简洁的一个写法

{elseif:false==true} = <?php }elseif(false==true){?> //简洁的替代写法
	
{fetch:$var as $key=>$value} = <?php foreach ($var as $key => $value){?> //一样的
	
{else} = <?php }else{ ?> //简洁的使用方式
	
{end} = <?php } ?> //和控制结构语句一些使用.
	
{import:nav;title:Hello} = <?php $title="Hello";include "nav.html";?> //导入局部模板,支持对局部模板中的模板变量赋值

设置模板主题
方法一
```php
	$di->register("view", function () {
	    $view = new View();
	    $smart = new Smart();
	    $smart->theme = "Default";
	    $view->loadEngine($smart);
	    return $view;
	});
```
方法二（指定特定模块使用某个主题）
例如在新建一个Base.php的公用控制器，其他控制器继承该类，添加下面的代码即可
```php
	public function __construct()
    {
        $this->view->setTheme("theme");
    }
```
##表单层##
表单层,放置在模块目录下的Forms文件夹中.在控制器中调用$this->input()获取请求数据的时候,则控制器对应的应该有对应的数据处理的表单层,通常是这样的

```php
	<?php
	namespace Home\Forms;
	
	use Du\Form\Validator;
	
	class Home extends Validator
	{
	    public function index()
	    {
	    	#这里可以调用表单层的表单验证的方法.
	        return array(
	            "name"=>md5($this->formData['name']), //直接处理数据为MD5加密后的密文;
	        );
	    }
	}
```

中间对数据的安全过滤,除了Du本身的数据过滤之外,您本身可自由处理自己需要的数据.下面是一个用户注册时数据验证的例子

```php
		<?php
		namespace Home\Forms;

		use Du\Form\Validator;
	    use Du\Form\FormError;
		
		class User extends Validator
		{
			public function reg() //对应User Controller的reg()
		    {
		        try {
		            $this->isEmpty("id", "请输入用户名！");
		            $this->isEmpty("email", "请输入邮箱！");
		            $this->match("email", "/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/ ", "请输入正确的邮箱!");
		            $this->isEmpty("pwd", "请输入密码！");
		            $this->length("pwd",16,6, "密码强度在6~16位之间！");
		            $this->isEmpty("pwd2", "请输入第二次密码！");
		            $this->compare("pwd2",$this->post("pwd"), "两次输入的密码不一致！");
		            $this->isEmpty("code", "请输入验证码！");
		            $this->compare("agree", 1, "请同意注册协议");
		            $this->compare(md5(strtolower($this->formData["code"]),$this->session->get("cpt"), "验证码错误！");
		             //返回的数据还会进行一次html转义.
		            return array(
		                "UserName"=>$this->formData["id"],
		                "Password"=>md5($this->formData["pwd"]),
		                "RegTime"=>$_SERVER['REQUEST_TIME'],
		                "RegIp"=>$_SERVER['REMOTE_ADDR'],
		                "Email"=>$this->formData["email"],
		                "LastLogin"=>$_SERVER['REQUEST_TIME'],
		            );
		        }catch(FormError $e){
		            $this->response->json(array("info"=>$e->getMessage()));
		        }
		    }
		}
```

##加载器Loader##
Loader负责框架的初始化操作，自动加载，定义常量等。
每个应用启动前必须初始化加载器
	Loader::Init()
##多模块设置##
```php
   $di->register("router",function(){
       $router = new \Du\Router();
       $router->addModule("Admin"); //注册一个Admin模块，首字母大写.
       return $router;
   });
```
支持同时注册多个模块
```php
 	 $router->addModule("Admin","Mobile");
```
默认包含了一个“Home”模块。
## 读取配置 ##
配置读取:
```php
$config = (new \Du\Config)->php("config");
```
或者在控制器中
```php
$config = $this->config->php("config");
```
则是取当前目录下的config.php文件,指定配置目录:
```php
$this->config->setPath("./config");
```
##Cookie和Session##
要使用Session服务，可先在入口文件中注册一个session服务
```php
    $di->register("session", function(){
    	$session =  new Session();
        $session->start();
        return $session;
    });
```
这样就可以通过$this->session->set()等方法。
```php
    $this->session->start(); //启动session，如果注册服务的时候已经启动就不要再次启动。 
    $this->session->set("name","DuPHP"); //设置name的值为DuPHP；
    $this->session->get("name"); //获取Session中"name"值；
    $this->session->remove("name"); //清除Session中name的值；
    $this->session->destory(); //销毁Session；
```
要使用cookie服务,调用方法
```php
    $this->cookie->set(); //设置cookie,通setookies()；
    $this->cookie->get("name"); //获取cookie中name的值；
    $this->cookie->remove("name"); //清除Cookie中name的值；
    $this->cookie->destory(); //销毁cookie;
```
##内置常量##
    DP_VER //Du框架的版本号
    ROOT_PATH //站点根目录 默认在Du核心目录的上一层目录
    APP_PATH //应用目录 默认在ROOT_PATH下的Aplication,可自定义
    CONF_PATH //配置文件存放目录，默认在APP_PATH下Config目录
    DS //PHP内置常量DIRECTORY_SEPARATOR的缩写
    VIEW_NAME //视图目录名称,默认在模块的下Views目录
    CACHE_PATH //缓存目录,默认在APP_PATH下Cache目录
    __MOUDLE__ //当前访问的模块
    __CONTROLLER__//当前访问的控制器
    __ACTION__ //当前执行的Action
有默认值得的常量均可自由定义。
## 验证码生成 ##
验证码默认使用核心目录下Verify/Fonts/Elephant.ttf字体文件
```php
    $this->captcha->code(); //即可生成验证，验证码不区分大小写，默认存入session中MD5的形式存在“cpt”键值中，只要判断用户输入的验证码MD5值与$this->session->get("cpt")是否一致即可。验证码大小等可以自由定义。
```
## 分页 ##
```php
	$page = new \Du\Model\Page();
	$page->calc("总条数"，"第几页(默认是第一页)");
	$rst = $page->build();//生成分页信息，默认返回html分页代码。
```
	或：
```php
	$rst = $page->build("",false);//生成分页信息，返回分页的相关数据的数组
```
## 上传文件##
一个上传的例子
```php
	 	if (isset($_FILES) && !empty($_FILES))
	        {
	            $upload = new Upload();
	            $upload->input_name = "file";
	            $upload->file_Ext = "jpg,png"; //允许上传的文件
	            $upload->auto_name=false;//是否使用自动重命名，false采用原文件名
	            $upload->file_save_dir = ROOT_PATH.DS."/Upload"; //上传目录
	            $file = $upload->save(); //保存
	            if ($file['status']){ //是否上传成功
	                return "/Upload".$file['file'];
	            }else {
	               $this->response->json(["info"=>$upload->errorMsg]); //上传失败json输出错误信息
	            }
	       }
```
## 调试 ##
Du本身不带调试功能，基于PHP本身的debug。Du只会抛出框架本身的错误
