<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-02-16
 * $ID: upload.class.php
*/ 
if(!defined('IN_XSCMS')){
   die('Access Denied!');
}
class upload{
	var $upload_form_field = 'upfile';
	var $upload_save_path  = 'data/attachments';
	var $upload_file_name  = '';
	var $upload_file_small = '';
	var $upload_file_size  = '';
	var $upload_file_type  = '';
	var $parsed_file_name  = '';

	var $max_file_size = 1024000000;
	var $allowed_file_ext = array('jpg','gif','png');
	var $create_small = true;	
	var $small_width  = 160;
	var $small_height = 120;
	
	/*********图片水印********/
	var $water_mark  = false;
	var $water_type  = 1;
	var $water_image = 'include/water/water.png';
	var $water_pos   = 9;
	var $water_alpha = 100;
	var $water_text  = 'www.songdewei.com';
	var $water_fontsize  = 16;
	var $water_fontcolor = '#FFFFFF';
	var $water_fontfile  = "include/font/arial.ttf";
	var $water_xoffset = 0;
	var $water_yoffset = 0;
	var $error = array();
	var $errornum = 0;

	
	function __construct($input_form_name='upfile'){
		$this->upload($input_form_name);
	}
	function upload($input_form_name='upfile'){
	    $this->upload_form_field = $input_form_name;
	    $this->upload_save_path  = ROOT_PATH.'/'.$GLOBALS['config']['attachdir'];
	    $this->max_file_size     = $GLOBALS['config']['attachmax']*1024*1024;
	    $this->allowed_file_ext  = explode('|',$GLOBALS['config']['imgtype']);
	    $this->create_small		 = $GLOBALS['config']['thumbstatus'];
	    $this->small_width		 = $GLOBALS['config']['thumbwidth'];
	    $this->small_height		 = $GLOBALS['config']['thumbheight'];
	    $this->water_mark		 = $GLOBALS['config']['watermarkstatus'];
	    $this->water_type 		 = $GLOBALS['config']['watermarktype'];
	    $this->water_image 		 = ROOT_PATH.'/'.$GLOBALS['config']['watermarkimg'];
	    $this->water_fontfile    = ROOT_PATH.'/'.$GLOBALS['config']['watermarkfontfile'];
	    $this->water_pos         = $GLOBALS['config']['watermarkstatus'];
	    $this->water_alpha       = $GLOBALS['config']['watermarkalpha'];
	    $this->water_text        = $GLOBALS['config']['watermarktext'];
	    $this->water_fontsize    = $GLOBALS['config']['watermarkfontsize'];
	    $this->water_fontcolor   = $GLOBALS['config']['watermarkfontcolor'];
	    $this->water_xoffset     = $GLOBALS['config']['watermarkoffsetx'];
	    $this->water_yoffset     = $GLOBALS['config']['watermarkoffsety'];
	}
	function save_local_image(){
	    $this->_clean_paths();
		$newpath = date("Y").'/'.date("m").'/'.date('d');
		$this->_mk_dir($newpath);		
		$this->upload_save_path.= '/'.$newpath;
		$filepath = $GLOBALS['config']['attachdir'].'/'.$newpath;
		//echo $this->upload_save_path;exit();
		$file = $_FILES[$this->upload_form_field];
		if (!isset($file['name'])||empty($file['name'])){
			return;
		}
		if(is_array($file['name'])){
			foreach ($file['name'] as $key=>$value){
				$file_type = preg_replace( "/^(.+?);.*$/", "\\1", $file['type'][$key]);
				$file_name = preg_replace( "/[^\w\.]/", "_", $file['name'][$key]);
				$file_size = $file['size'][$key];
				$file_ext = $this->_get_file_extension($file['name'][$key]);				
				if (!is_uploaded_file($file['tmp_name'][$key])){
					$this->error[] = 'Upload file is empty';
					$this->errornum++;
					continue;
				}			
				if (!is_array($this->allowed_file_ext) or (!count($this->allowed_file_ext)>0)){
					$this->allowed_file_ext = array('jpg','jpeg','gif','png');
				}								
				if (!in_array($file_ext,$this->allowed_file_ext)){
					$this->error[] = 'This file type not allowes to upload';
					$this->errornum++;
					continue;
				}
				if (($this->max_file_size ) and ($file_size > $this->max_file_size)){
					$this->error[] = 'This file is too large.';
					$this->errornum++;
					continue;
				}								
				$saved_file_name = $this->_set_filename($file_ext);
				$saved_full_name = $this->upload_save_path.'/'.$saved_file_name;				
				if(!@move_uploaded_file($file['tmp_name'][$key], $saved_full_name)){
					$this->error[] = 'move file failed.';
					$this->errornum++;
					continue;
				}else{
					@chmod($saved_full_name, 0777 );					
					if($this->create_small){
						$small_img = $this->ImageResize($saved_file_name,$this->small_width,$this->small_height);
						$this->upload_file_small[] = $filepath.'/'.$small_img;
					}else {
						$this->upload_file_small[] = $filepath.'/'.$saved_file_name;
					}										
					if($this->water_mark){
						$this->imageWaterMark($saved_full_name);
					}
					$this->upload_file_name[] = $filepath.'/'.$saved_file_name;
					$this->upload_file_size[] = $file_size;
					$this->upload_file_type[] = $file_type;
					$this->parsed_file_name[] = $saved_file_name;
				}			
			}
		}else{
			$file['type'] = preg_replace( "/^(.+?);.*$/", "\\1", $file['type']);
			$file['name'] = preg_replace( "/[^\w\.]/", "_", $file['name']);
			$this->upload_file_size = $file['size'];
			$this->upload_file_type = $file['type'];
			
			if( !is_uploaded_file($file['tmp_name'])){
				$this->error[] = 'Upload file is empty';
				$this->errornum++;
				return 1;
			}
			if(!is_array($this->allowed_file_ext) or (!count($this->allowed_file_ext)>0)){
				$this->allowed_file_ext = array('jpg','jpeg','gif','png');
			}
			
			$file_ext = $this->_get_file_extension($file['name']);
			if (!in_array($file_ext,$this->allowed_file_ext)){
				$this->error[] = 'This file type not allowes to upload';
				$this->errornum++;
				return 2;
			}
			if ($this->max_file_size and ($file['size'] > $this->max_file_size)){
				$this->error[] = 'This file is too large.';
				$this->errornum++;
				return 3;
			}
			
			$this->parsed_file_name = $this->_set_filename($file_ext);
			$saved_full_name = $this->upload_save_path.'/'.$this->parsed_file_name;
			
			if (!@move_uploaded_file($file['tmp_name'], $saved_full_name)){
				$this->error[] = 'move file failed.';
				$this->errornum++;
				return 5;
			}else{
				@chmod($saved_full_name, 0777);
				if($this->create_small){
					$small_img = $this->ImageResize($this->parsed_file_name,$this->small_width,$this->small_height);
				}else {
					$small_img = $this->parsed_file_name;
				}
				if($this->water_mark){
					$this->imageWaterMark($saved_full_name);
				}
				$this->upload_file_small = $filepath.'/'.$small_img;
				$this->upload_file_name  = $filepath.'/'.$this->parsed_file_name;
			}					
		}
	}
	
	function save_remote_image(){
	    $this->_clean_paths();
		$newpath = date("Y").'/'.date("m").'/'.date('d');
		$this->_mk_dir($newpath);
		$this->upload_save_path.= '/'.$newpath;
	    $filepath = $GLOBALS['config']['attachdir'].'/'.$newpath;		
		$file_url = $_POST[$this->upload_form_field];
		if (!isset($file_url)||empty($file_url)){
			return ;
		}
		
		if(is_array($file_url)) {
		    foreach($file_url as $fileurl) {
		    	if (empty($fileurl)){
		    		continue;
		    	}
			    $ext = $this->_get_file_extension($fileurl);
				if (!($file_content = @file_get_contents($fileurl))){
					continue;
				}
				$save_file_name = $this->_set_filename($ext);
				$save_full_name = $this->upload_save_path.'/'.$save_file_name;
				$fp = @fopen($save_full_name,'w');
				@fwrite($fp,$file_content);
				@fclose($fp);
				
				if($this->create_small){
					$small_img = $this->ImageResize($save_file_name,$this->small_width,$this->small_height);
				}else {
					$small_img = $save_file_name;
				}
				if($this->water_mark) $this->ImageWaterMark($save_full_name);
				$this->upload_file_type[]  = $ext;
				$this->parsed_file_name[]  = $save_file_name;
				$this->upload_file_name[]  = $filepath.'/'.$save_file_name;
				$this->upload_file_small[] = $filepath.'/'.$small_img;
				$this->upload_file_size[]  = filesize($save_full_name);				
			}
		}else{
			$ext = $this->_get_file_extension($file_url);
			if (!($file_content = @file_get_contents($file_url))){
				return false;
			}
			$save_file_name = $this->_set_filename($ext);
			$save_full_name = $this->upload_save_path.'/'.$save_file_name;
			$fp = @fopen($save_full_name,'w');
			@fwrite($fp,$file_content);
			@fclose($fp);
			
			if($this->create_small){
				$small_img = $this->ImageResize($save_file_name,$this->small_width,$this->small_height);
				$this->upload_file_small = $filepath.'/'.$small_img;
			}else {
				$this->upload_file_small = $filepath.'/'.$save_file_name;
			}
			if($this->water_mark) $this->ImageWaterMark($save_full_name);
			$this->upload_file_name = $filepath.'/'.$save_file_name;
			$this->upload_file_size = filesize($save_full_name);
			$this->upload_file_type = $ext;
		}
	}
	
	function _set_filename($ext){
	    return date('Ymdhis').rand(100,1000).'.'.$ext;
	}
	
    /**获得文件扩展名**/
	function _get_file_extension($file){
		return strtolower( str_replace( ".", "", substr( $file, strrpos( $file, '.' ) ) ) );
	}
	
	function _clean_paths(){
		$this->upload_save_path = preg_replace( "#/$#", "", $this->upload_save_path);
	}
	
	function _mk_dir($path){
		$dirs = array();
		$dirlist = '';
		$rootpath = $this->upload_save_path;
		$path = str_replace('\\','/',$path);
		$dirs = explode('/',$path);
		foreach ($dirs as $val){
			if (!empty($val)){
				$dirlist.= '/'.$val;
				$dirpath = $rootpath.$dirlist;
				if (!file_exists($dirpath)){
					@makedir($dirpath);
					@chmod($dirpath,0777);
				}
			}
		}
	}
	
	function ImageResize($filename,$sm_width,$sm_height){
		//生成缩略图函数
		$source_Bigimg = $this->upload_save_path ."/".$filename;
		$imageInfo = getimagesize($source_Bigimg);
		$width  = $imageInfo[0];
		$height = $imageInfo[1];
		$type   = $imageInfo[2];
		if($width >= $height){
			//如果大图的宽比高大则将大图按宽等比缩小
			if ($width<$sm_width){
				return $filename;
			}
			$des_width = $sm_width;
			$des_height = ($sm_width / $width) * $height;
		}elseif($height > $width){
			//如果大图的高比宽大则将大图按高等比缩小
			if ($height<$sm_height){
				return $filename;
			}
			$des_height = $sm_height;
			$des_width = ($sm_height / $height) * $width;
		}
		switch($type){
			//根据上传好的图形文件类型新建一个用来生成缩略图的源文件。
			case 1:
				$srcf = imagecreatefromgif($source_Bigimg);
				break;
			case 2:
				$srcf = imagecreatefromjpeg($source_Bigimg);
				break;
			case 3:
				$srcf = imagecreatefrompng($source_Bigimg);
				break;
			default:
				break;
		}

		//生成缩略图文件
		if(function_exists("imagecreatetruecolor")){
			$desf = imagecreatetruecolor($des_width,$des_height);
			imagecopyresampled($desf,$srcf,0,0,0,0,$des_width,$des_height,$width,$height);
		}else{
			$desf = imagecreate($des_width,$des_height);
			imagecopyresized($desf,$srcf,0,0,0,0,$des_width,$des_height,$width,$height);
		}
		
		$thumb = 'thumb_' .$filename;
		$sm_name = $this->upload_save_path.'/'.$thumb;
		switch($type){
			case 1:
				imagegif($desf,$sm_name);
				break;
			case 2:
				imagejpeg($desf,$sm_name);
				break;
			case 3:
				imagepng($desf,$sm_name);
				break;
			default:
				//echo('无法生成' . $source_FileType . '的缩略图。');
				//die();
				break;
		}
		imagedestroy($desf);
		imagedestroy($srcf);
		return $thumb;
	}

	//图片水印
	function imageWaterMark($groundImage){
	    $waterPos   = $this->water_pos;
	    $waterImage = $this->water_image;
	    $waterText  = iconv("gb2312","UTF-8",$this->water_text);
	    $fontSize   = $this->water_fontsize;
	    $textColor  = $this->water_fontcolor;
	    $fontfile   = $this->water_fontfile; 
	    $xOffset    = $this->water_xoffset;
	    $yOffset    = $this->water_yoffset;
	    $waterpct   = $this->water_alpha;
		$isWaterImage = $this->water_type == 0 ? TRUE : FALSE;
	     //读取水印文件
	     if(!empty($waterImage) && file_exists($waterImage)) {
	         //$isWaterImage = TRUE;
	         $water_info = getimagesize($waterImage);
	         $water_w = $water_info[0];//取得水印图片的宽
	         $water_h = $water_info[1];//取得水印图片的高
	
	         switch($water_info[2])   {    //取得水印图片的格式  
	             case 1:$water_im = imagecreatefromgif($waterImage);break;
	             case 2:$water_im = imagecreatefromjpeg($waterImage);break;
	             case 3:$water_im = imagecreatefrompng($waterImage);break;
	             default:return 1;
	         }
	     }else {
	     	$isWaterImage = FALSE;
	     }
	
	     //读取背景图片
	     if(!empty($groundImage) && file_exists($groundImage)) {
	         $ground_info = getimagesize($groundImage);
	         $ground_w = $ground_info[0];//取得背景图片的宽
	         $ground_h = $ground_info[1];//取得背景图片的高
	
	         switch($ground_info[2]) {    //取得背景图片的格式  
	             case 1:$ground_im = imagecreatefromgif($groundImage);break;
	             case 2:$ground_im = imagecreatefromjpeg($groundImage);break;
	             case 3:$ground_im = imagecreatefrompng($groundImage);break;
	             default:return 1;
	         }
	     } else {
	         return 2;
	     }
	
	     //水印位置
	     if($isWaterImage) { //图片水印  
	         $w = $water_w;
	         $h = $water_h;
	         $label = "图片的";
	     } else {  
	         //文字水印
	         if(!file_exists($fontfile))return 4;
	         $temp = imagettfbbox($fontSize,0,$fontfile,$waterText);//取得使用 TrueType 字体的文本的范围
	         $w = $temp[2] - $temp[6];
	         $h = $temp[3] - $temp[7];
	         unset($temp);
	     }
	     if( ($ground_w < $w) || ($ground_h < $h) ) {
	         return 3;
	     }
	     switch($waterPos) {
	         case 0://随机
	             $posX = rand(0,($ground_w - $w));
	             $posY = rand(0,($ground_h - $h));
	             break;
	         case 1://1为顶端居左
	             $posX = 0;
	             $posY = 0;
	             break;
	         case 2://2为顶端居中
	             $posX = ($ground_w - $w) / 2;
	             $posY = 0;
	             break;
	         case 3://3为顶端居右
	             $posX = $ground_w - $w;
	             $posY = 0;
	             break;
	         case 4://4为中部居左
	             $posX = 0;
	             $posY = ($ground_h - $h) / 2;
	             break;
	         case 5://5为中部居中
	             $posX = ($ground_w - $w) / 2;
	             $posY = ($ground_h - $h) / 2;
	             break;
	         case 6://6为中部居右
	             $posX = $ground_w - $w;
	             $posY = ($ground_h - $h) / 2;
	             break;
	         case 7://7为底端居左
	             $posX = 0;
	             $posY = $ground_h - $h;
	             break;
	         case 8://8为底端居中
	             $posX = ($ground_w - $w) / 2;
	             $posY = $ground_h - $h;
	             break;
	         case 9://9为底端居右
	             $posX = $ground_w - $w;
	             $posY = $ground_h - $h;
	             break;
	         default://随机
	             $posX = rand(0,($ground_w - $w));
	             $posY = rand(0,($ground_h - $h));
	             break;     
	     }
	
	     //设定图像的混色模式
	     imagealphablending($ground_im, true);
	
	     if($isWaterImage) { //图片水印
	         //imagecopy($ground_im, $water_im, $posX + $xOffset, $posY + $yOffset, 0, 0, $water_w,$water_h);//拷贝水印到目标文件    
	         imagecopymerge($ground_im, $water_im, $posX + $xOffset, $posY + $yOffset, 0, 0, $water_w,$water_h,$waterpct);     
	     } else {//文字水印
	         if( !empty($textColor) && (strlen($textColor)==7) ) {
	             $R = hexdec(substr($textColor,1,2));
	             $G = hexdec(substr($textColor,3,2));
	             $B = hexdec(substr($textColor,5));
	         } else {
	             return 5;
	         }
	         //imagettftext ( $ground_im, $fontSize, 0, ($posX + $xOffset)+1, ($posY + $h + $yOffset)+1, imagecolorallocate($ground_im, 0, 0, 0), $fontfile, $waterText);
			 imagettftext ( $ground_im, $fontSize, 0, $posX + $xOffset, $posY + $h + $yOffset, imagecolorallocate($ground_im, $R, $G, $B), $fontfile, $waterText);
	     }
	
	     //生成水印后的图片
	     @unlink($groundImage);
	     switch($ground_info[2]) {//取得背景图片的格式
	         case 1:imagegif($ground_im,$groundImage);break;
	         case 2:imagejpeg($ground_im,$groundImage);break;
	         case 3:imagepng($ground_im,$groundImage);break;
	         default: return 6;
	     }
	
	     //释放内存
	     if(isset($water_info)) unset($water_info);
	     if(isset($water_im)) imagedestroy($water_im);
	     unset($ground_info);
	     imagedestroy($ground_im);
	     //
	     return 0;
	}
	
	function shoError(){
		$errorstr = $key = $value = '';
		if ($this->errornum>0){
			foreach ($this->error as $key=>$value){
				$errorstr.= '<li>'.$value.'</li>\n';
			}
			echo '<ol>'.$errorstr.'</ol>';
			exit();
		}else {
			return ;
		}
	}
}
?>