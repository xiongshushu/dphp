<?php

class smart
{
    private static $func;

    static function compile($data)
    {
        $tags = array(
            '/{{(.+?)}}/' => "<?php echo \\1 ?>",
            '/{:(.+?)}/' => "<?php \\1 ?>",
            '/{if:([\\a-zA-Z0-9\$_.|&]+)}/' => "<?php if( \\1){?>",
            '/{elseif:([\\a-zA-Z0-9\$_.]+)}/' => "<?php }elseif(\\1){?>",
            '/{end}/' => '<?php }?>',
            '/{else}/' => '<?php }else{?>',
            '/{fetch:([\\a-zA-Z0-9\$_.]+)}/' => "<?php foreach(\\1){?>",
        );
        foreach ($tags as $pattern => $tag) {
            $data = preg_replace($pattern, $tag, $data);
        }
        return $data;
    }
}