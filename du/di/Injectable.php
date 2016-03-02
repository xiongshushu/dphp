<?php
namespace du\di;


use du\DI;

/**
 * Class Injectable
 * @package du\DI
 * @property \du\View $view
 * @property \du\form\Form $form
 * @property \du\http\Request $request
 * @property \du\http\Response $response
 * @property \du\http\Session $session
 * @property \du\http\Cookie $cookie
 * @property \du\cache\Driver $cache
 * @property \du\db\Pdo $db
 * @property \du\http\Router $router
 * @property \du\verify\Captcha $captcha
 * @property \du\config $config
 */
abstract class Injectable
{

    public function __get($name)
    {
        return DI::invoke($name);
    }
}