<?php
namespace Du\DI;


use Du\DI;

/**
 * Class Injectable
 * @package Du\Di
 * @property \Du\View $view
 * @property \Du\Form\Form $form
 * @property \Du\Http\Request $request
 * @property \Du\Http\Response $response
 * @property \Du\Storage\Session $session
 * @property \Du\Storage\Cookie $cookie
 * @property \Du\Cache\Driver $cache
 * @property \Du\Db\Pdo $db
 * @property \Du\Http\Router $router
 * @property \Du\Verify\Captcha $captcha
 * @property \Du\Config $config
 */
abstract class Injectable
{

    public function __get($name)
    {
        return DI::invoke($name);
    }
}