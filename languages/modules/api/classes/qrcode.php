<?php
/** 飞天系统二维码生成系统
     * @param type $data 二维码内容
     * @param type $level 纠错等级，从低到高 L M Q H
     * @param type $size 图片大小
     * @param type $filelogo 中心小图片logo
     * @param type $filebg 背景图片
     * @param type $finename 如果有值则保存为图片如：aa.png，为空则直接输出图片
     * @param type $s 样式：2液态 1直角 0圆角
     *input是左上角那蓝色方块
     *pu是那蓝色方块周围的方框
     *b是背景色
     *f是二维码色
     *size是图形尺寸
     *level是纠错级别，lmqh从低到高，h最高
     *s是样式，0是圆角，1是标准直角，2是液态
*/
error_reporting(0);
//此处为防盗用设置，请把url换成你自己的
if(!(strpos($_SERVER['HTTP_REFERER'],'http://www.05273.com')===0 || strpos($_SERVER['HTTP_REFERER'],'http://05273.com')===0)){echo "<img src=http://www.05273.com/api/error.png>";exit;}
include('erweima_shuyang/qrcode_img.class.php');
if(isset($_REQUEST["t"])){
            $data=$_REQUEST["t"];
        }else{
            $data="http://www.05273.com";
        }
        if(isset($_REQUEST["f"])){
            $f=$_REQUEST["f"];
        }else{
            $f='';
        }
        if(isset($_REQUEST["b"])){
            $b=$_REQUEST["b"];
        }else{
            $b='#FFFFFF';
        }
        if(isset($_REQUEST["pt"])){
            $pt=$_REQUEST["pt"];
        }else{
            $pt='';
        }
        if(isset($_REQUEST["inpt"])){
            $inpt=$_REQUEST["inpt"];
        }else{
            $inpt='';
        }
		if(isset($_REQUEST["size"])){
            $size=intval($_REQUEST["size"]);
        }else{
            $size='300';
        }
        //样式状态 液态 直角 圆圈
        if(isset($_REQUEST["s"])){
            $s=intval($_REQUEST["s"]);
        }else{
            $s=1;
        }
        //纠错等级
        if(isset($_REQUEST["level"])){
            $level=$_REQUEST["level"];
        }else{
            $level="L";
        }
		
		if(isset($_REQUEST["logo"])){
           $filelogo= trim($_REQUEST["logo"]);
        }else{
            $filelogo='http://www.05273.com/images/90px.jpg';
        }
        if(isset($_REQUEST["bg"])){
           $filebg = trim($_REQUEST["bg"]);

        }else{
            $filebg='';
        }
        
        $z=new Qrcode_image;

        $z->set_qrcode_error_correct($level);   # set ecc level H
        $z->qrcode_image_out($data,$filename,$size,$filelogo,$filebg,$pt,$inpt,$f,$b,'#000000',$s);
?>