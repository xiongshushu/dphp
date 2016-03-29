<?php
namespace smart;

class parser
{
    static function compile($data, $fileDir, $suffix = ".html")
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
        return self::import($fileDir, $suffix, $data);
    }

    /**
     * 解析import
     * @param $fileDir
     * @param $suffix
     * @param $data
     * @return string
     */
    static function import($fileDir, $suffix, $data)
    {
        if (preg_match_all('/{import:([\\a-zA-Z0-9]+?);([,a-zA-Z0-9_]+:.*)*}/', $data, $matchImport)) {
            $tplVar = "<?php ";
            foreach ($matchImport[2] as $value) {
                if (preg_match_all('/(.*?):(.*?);/', $value, $vars, 2)) {
                    foreach ($vars as $varName) {
                        $tplVar .= "\$" . $varName[1] . "=\"" . $varName[2] . "\";";
                    }
                }
            }
            $tplVar .= "?>\n";
            foreach ($matchImport[1] as $file) {
                $filePath = trim($fileDir . $file, ":") . $suffix;
                if (is_file($filePath)) {
                    $importData = file_get_contents($filePath);
                    $data = preg_replace('/{import:.*}/', $tplVar . $importData, $data, 1);
                }
            }
        }
        return $data;
    }
}