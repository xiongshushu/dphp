<?php
namespace Du\Smart;

class SmartParse
{

    public $data;

    public $tplVar = array();

    public function compile($tpldata,$tplPath,$suffix=".html")
    {
        $this->data = $tpldata;
        $this->parseImport($tplPath,$suffix);
        $this->parseIf();
        $this->parseRang();
        $this->parseElse();
        $this->parseTag();
        $this->parseEnd();
    }

    /**
     * 基本解析
     */
    private function parseTag()
    {
        $this->data = preg_replace('/{:=(.+?)}/', "<?php echo \\1 ?>", $this->data);
        $this->data = preg_replace('/{:(.+?)}/', "<?php \\1 ?>", $this->data);
    }

    /**
     * 解析import
     */
    private function parseImport($tplPath,$suffix)
    {
        if (preg_match_all('/{import:([\\a-zA-Z0-9]+?);(:[,a-zA-Z0-9_]+:.*)*}/', $this->data, $matchImport)) {
            foreach ($matchImport[1] as $file) {
                $filePath = trim($tplPath . DS . $file, ":") .$suffix;
                if (is_file($filePath)) {
                    $importData = file_get_contents($filePath);
                    $this->data = preg_replace('/{import:.*}/', $importData, $this->data,1);
                }
            }
            foreach ($matchImport[2] as $var => $value) {
                if (preg_match('/(.*?):(.*?);/', trim($value, ":"), $var)) {
                    $vars = explode(",", $var[1]);
                    foreach ($vars as $k => $varName) {
                        $this->tplVar[$varName] = $var[2];
                    }
                }
            }
        }
    }

    /**
     * 解析if/esleif
     */
    private function parseIf()
    {
        $this->data = preg_replace('/{if:([\\a-zA-Z0-9\$_.]+)}/', "<?php if( \\1){?>", $this->data);
        $this->data = preg_replace('/{elseif:([\\a-zA-Z0-9\$_.]+)}/', "<?php }elseif(\\1){?>", $this->data);
    }

    /**
     * 解析end
     */
    private function parseEnd()
    {
        $this->data = str_replace('{end}', '<?php }?>', $this->data);
    }

    /**
     * 解析else
     */
    private function parseElse()
    {
        $this->data = str_replace('{else}', '<?php }else{?>', $this->data);
    }

    /**
     * 解析rang
     */
    private function parseRang()
    {
        $this->data = preg_replace('/{fetch:([\\a-zA-Z0-9\$_.]+)}/', "<?php foreach(\\1){?>", $this->data);
    }
}