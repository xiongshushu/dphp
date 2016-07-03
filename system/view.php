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
        '/{{(.+?)}}/' => "<?php echo \\1 ?>",
        '/{:(.+?)}/' => "<?php \\1 ?>",
        '/{if:([\\a-zA-Z0-9\$_.|&]+)}/' => "<?php if( \\1){?>",
        '/{elseif:([\\a-zA-Z0-9\$_.]+)}/' => "<?php }elseif(\\1){?>",
        '/{end}/' => '<?php }?>',
        '/{else}/' => '<?php }else{?>',
        '/{fetch:([\\a-zA-Z0-9\$_.]+)}/' => "<?php foreach(\\1){?>",
    );

    static function compile($data)
    {
        foreach (self::$tags as $pattern => $tag) {
            $data = preg_replace($pattern, $tag, $data);
        }
        return $data;
    }

    static function tag($tag, $pattern)
    {
        self::$tags[$tag] = $pattern;
    }

    static function display($tpl = _ACTION_, $vars = array())
    {
        $target = ROOT_PATH . "/cache/" . _SUBMOD_ . "/" . _MODULE_ . "/" . $tpl . ".php";
        $tplDir = APP_PATH . "/" . _MODULE_ . "/" . _SUBMOD_ . "/template/";
        $file = $tplDir . $tpl . ".php";
        if (file_exists($file)) {
            $data = self::compile(file_get_contents($file), $tplDir, ".php");
            self::create($target, $data, -1);
            if (is_file($target)) {
                extract($vars);
                require $target;
            }
        }
    }
}