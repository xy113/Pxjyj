<?php
////////////////////////////文件说明/////////////////////////////////
//功能描述：产生验证码模块
//////////////////////////////////////////////////////////////////////
/* 取得当前系统所在的根目录 */
define('ROOT_PATH', str_replace("/source/include/randcode.php", '', str_replace('\\', '/', __FILE__)));
@ini_set('session.save_path', ROOT_PATH.'/data/sessions');
session_start();
header("Content-type: image/png");
header('Expires: Fri, 14 Mar 1980 20:53:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
if(PHP_VERSION < '4.1.0') $_SESSION = &$HTTP_SESSION_VARS;
unset($HTTP_SESSION_VARS);
/*
* 初始化
*/
$randcode = array();
$randcode['border']   = 1; //是否要边框 1要:0不要
$randcode['how']	  = 4; //验证码位数
$randcode['width']	  = $randcode['how']*15; //图片宽度
$randcode['height']   = 23; //图片高度
$randcode['fontsize'] = 6; //字体大小
$randcode['alpha']    = "01234"; //数字1
$randcode['number']   = "56789"; //数字2
$randcode['code']	  = "";//验证码字符串初始化

srand((double)microtime()*1000000); //初始化随机数种子
$im = ImageCreate($randcode['width'], $randcode['height']); //创建验证图片
/*
* 绘制基本框架
*/
$bgcolor = ImageColorAllocate($im, 255, 255, 255); //设置背景颜色
ImageFill($im, 0, 0, $bgcolor); //填充背景色
if($randcode['border']){
    $black = ImageColorAllocate($im, 0, 0, 0); //设置边框颜色
    ImageRectangle($im, 0, 0, $randcode['width']-1, $randcode['height']-1, $black);//绘制边框
}
/*
* 逐位产生随机字符
*/
for($i=0; $i<$randcode['how']; $i++)
{   
    $alpha_or_number = mt_rand(0, 1); //选择数字1还是2
    $str = $alpha_or_number ? $randcode['alpha'] : $randcode['number'];
    $which = mt_rand(0, strlen($str)-1); //取哪个字符
    $code = substr($str, $which, 1); //取字符
    $j = !$i ? 4 : $j+15; //绘字符位置
    $color3 = ImageColorAllocate($im, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100)); //字符随即颜色
    ImageChar($im, $randcode['fontsize'], $j, 3, $code, $color3); //绘字符
    $randcode['code'] .= $code; //逐位加入验证码字符串
}
/*
* 添加干扰
*/ 
for($i=0; $i<$randcode['how']*10; $i++)//绘背景干扰点
{   
    $color2 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)); //干扰点颜色 
    ImageSetPixel($im, mt_rand(0,$randcode['width']), mt_rand(0,$randcode['height']), $color2); //干扰点
}
//把验证码字符串写入session
$_SESSION['randcode'] = $randcode['code'];
unset($randcode);
/*绘图结束*/
Imagepng($im);
ImageDestroy($im);
/*绘图结束*/
?> 
