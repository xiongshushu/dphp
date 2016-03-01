<?php
namespace Du\Verify;

class Captcha
{

    /**
     * 随机因子
     * @var string
     */
    private $charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';

    /**
     * 验证码
     * @var string
     */
    private $code;

    /**
     * 验证码长度
     * @var int
     */
    public $codeLen = 4;

    /**
     * 宽度
     * @var int
     */
    public $width = 80;

    /**
     * 高度
     * @var int
     */
    public $height = 30;

    /**
     * 图形资源句柄
     * @var Resoure
     */
    private $img;

    /**
     * 指定的字体路径
     * @var string
     */
    public $font = "Fonts/Elephant.ttf";

    /**
     * 指定字体大小
     * @var int
     */
    public $fontsize = 15;

    /**
     * 指定字体颜色
     * @var unknown
     */
    private $fontcolor;

    /**
     * 生成随机码
     */
    private function createCode()
    {
        $_len = strlen($this->charset) - 1;
        for ($i = 0; $i < $this->codeLen; $i ++) {
            $this->code .= $this->charset[mt_rand(0, $_len)];
        }
    }

    /*
     * 生成背景
     */
    private function createBg()
    {
        $this->img = imagecreatetruecolor($this->width, $this->height);
        $color = imagecolorallocate($this->img, mt_rand(157, 255), mt_rand(157, 255), mt_rand(157, 255));
        imagefilledrectangle($this->img, 0, $this->height, $this->width, 0, $color);
    }

    /**
     * 生成文字
     */
    private function createFont()
    {
        $_x = $this->width / $this->codeLen;
        for ($i = 0; $i < $this->codeLen; $i ++) {
            $this->fontcolor = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            imagettftext($this->img, $this->fontsize, mt_rand(- 30, 30), $_x * $i + mt_rand(1, 5), $this->height / 1.4, $this->fontcolor, $this->font, $this->code[$i]);
        }
    }

    /**
     * 生成线条、雪花
     */
    private function createLine()
    {
        for ($i = 0; $i < 6; $i ++) {
            $color = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            imageline($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), $color);
        }
        for ($i = 0; $i < 100; $i ++) {
            $color = imagecolorallocate($this->img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
            imagestring($this->img, mt_rand(1, 5), mt_rand(0, $this->width), mt_rand(0, $this->height), '*', $color);
        }
    }

    /**
     * 输出验证码
     * @param string $sKey
     * 验证存储在session的键名
     */
    public function code($sKey = "cpt")
    {
        $this->font = __DIR__ . DS . $this->font;
        $this->createBg();
        $this->createCode();
        $this->createLine();
        $this->createFont();
        // 加入验证码到session中
        $_SESSION[$sKey] = md5(strtolower($this->code));
        ob_clean();
        header('Content-type:image/png');
        imagepng($this->img);
        imagedestroy($this->img);
    }
}
