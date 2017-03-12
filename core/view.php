<?php

class view
{
    static function create($target, $tData, $expireTime)
    {
        if (($_SERVER['REQUEST_TIME'] - @filemtime($target)) > $expireTime) {
            $path = dirname($target);
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            return file_put_contents($target, $tData);
        }
        return "";
    }

    private static $tags = array(
        '/{{(.+?)}}/' => "view::VEcho",
        '/{:(.+?)}/' => "view::VPhp",
        '/{if:([\\a-zA-Z0-9\$_.|&]+)}/' => "view::Vif",
        '/{elseif:([\\a-zA-Z0-9\|\$_.]+)}/' => "view::VElf",
        '/{end}/' => 'view::VEnd',
        '/{else}/' => 'view::VElse',
        '/{fetch:([\\a-zA-Z0-9\$_.]+)}/' => "view::VFetch",
        '/{import:([a-zA-Z0-9\$_]+)\/([a-zA-Z0-9\$_]+)}/' => "view::VImport",
    );

    static function compile($data)
    {
        foreach (self::$tags as $pattern => $func) {
            $data = preg_replace_callback($pattern, $func, $data);
        }
        return $data;
    }

    static function tag($tag, $callback)
    {
        self::$tags[$tag] = $callback;
    }

    static function assign($tpl = _ACTION_, $vars = array())
    {
        $target = ROOT_PATH . "/cache/" . _LAYER_ . "/" . _MODULE_ . "/" . $tpl . ".php";
        $file = MOD_PATH . "/" . _LAYER_ . "/template/" . $tpl . ".php";
        if (file_exists($file)) {
            $data = self::compile(file_get_contents($file));
            self::create($target, $data, -1);
            if (is_file($target)) {
                extract($vars);
                require_once $target;
            }
        }
    }

    static function VEcho($matches)
    {
        return "<?php echo $matches[1]; ?>";
    }

    static function VPhp($matches)
    {
        return "<?php $matches[1]; ?>";
    }

    static function Vif($matches)
    {
        return "<?php if($matches[1]){ ?>";
    }

    static function VElf($matches)
    {
        return "<?php }elseif($matches[1]){ ?>";
    }

    static function VElse()
    {
        return "<?php }else{ ?>";
    }

    static function VEnd()
    {
        return "<?php } ?>";
    }

    static function VFetch($matches)
    {
        return "<?php foreach($matches[1]){ ?>";
    }

    static function VImport($matches)
    {
        $file = APP_PATH . "/" . $matches[1] . "/template/" . $matches[2] . ".php";
        if (file_exists($file)) {
            return self::compile(file_get_contents($file));
        }
    }
}