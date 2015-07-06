## DuPHP ##
DuPHP是一款轻量级的PHP框架，不到50k的压缩大小，麻雀虽小，五脏俱全，MVC结构，轻量级的内置模板引擎Smart，验证码，上传，加密，静态路由（以后会考虑增加动态路由），运行在PHP≥5.4的系统中，精简的封装了PDO MySql操作，操作数据库目前只能通过PDO操作。不过DuPHP是个低耦合的框架，你完全可以使用自己的数据库操作类，不仅如此，你还能在框架的基础上二次开发，打造完全属于自己的框架，完全的自由化。
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
DuPHP遵循MVC结构,Du的模型主要负责数据库的操作，控制器作为调度模型和视图两者的控制层，包含了业务逻辑。除了MVC结构以外还引入了“中间件”，其实就是表单验证层， 又不单单是表单验证，还可以控制在控制器之前的一些动作，执行一些必要的逻辑，安全过滤等等，但是中间件不是每个控制器都是必须的，除非控制器中含有$this->input()的时候，你必须要需要中间件的支持，我们建议在含有数据传递的时候，能够使用“中间件”，避免一些不必要要安全问题。

控制器负责调度模型，视图会在控制器中自动渲染，只有当存在视图文件时，才进行渲染。设置模板变量，请使用$this->view->setVar()方法。调用模型只需$this->*Model 调用即可，例如$this->UserModel,调用了User模型，必须包含Model关键词，框架自动识别。

Du模型其实没做其他重要的事情，说白了就是数据库操作类的中间人,在模型中，可以直接调用
数据库操作类的方法，纯属数据库的操作。

视图，Du的视图可以直接使用原生的语法。如果你要是用内置模板，你必须在入口文件中注册一个视图服务
```
$di->registe("view", function(){
   $view = new View();
   $view->registerEngine(new Smart()); //声明使用内置模板引擎驱动，类似可以使用smarty模板
   return $view;
});
```
内置模板的语法：

{:} = <?php ?>

{:=} = <?php echo ?>

{if:false==true} = <?php if (false==true)?>

{fetch:$var as $key=>$value} = <?php foreach ($var as $key => $value)?>

{end} = <?php } ?>

{import:nav;title:Hello} = <?php $title="Hello";include "nav.html";?>

内置模板支持简单的布局模式，若要使用，在入口文件中添加
```
$di->registe("view", function(){
   $view = new View();
   $view->registerEngine( new Smart(array(
		"layout"=>"layout.php"
   ))); 
   return $view;
});
```
使用layout.php布局文件，内容包含需要替换内容位置的关键字"{MAIN}"，视图先渲染layout,替换"{MAIN}"，再渲染控制器视图，在控制器可以使用$this->view->disableLayout();跳过本次的布局渲染。
## 读取配置 ##
配置默认在APP_PATH下的Config文件夹，常量CONF_PATH的值，可以自已的配置目录。配置读取
Config::php("config");则是读取目录下的config.php文件Config::php("config"，"menu");读取config.php二维数组的menu项配置。
## 调试 ##
Du本身不带调试功能，基于PHP本身的debug。Du只会抛出框架本身的错误
