<?php
namespace du\di;


use du\di;

/**
 * Class injectable
 * @package du\di
 * @property \du\view $view
 * @property \du\form\form $form
 * @property \du\http\request $request
 * @property \du\http\response $response
 * @property \du\http\session $session
 * @property \du\http\cookie $cookie
 * @property \du\db\pdo $db
 * @property \du\http\router $router
 * @property \du\verify\captcha $captcha
 * @property \du\config $config
 */
abstract class injectable
{

    public function __get($name)
    {
        return di::invoke($name);
    }
}