<?php
error_reporting(E_ERROR|E_WARNING);
require_once 'common.php';
//上传配置
$config = array(
    "uploadPath" => ROOT_PATH."/data/attachment" , //保存路径
    "fileType" => array( ".rar" , ".doc" , ".docx" , ".zip" , ".pdf" , ".txt" , ".swf", ".wmv",'.xls','xlsx','.jpg','.gif','.png','ppt' ) , //文件允许格式
    "fileSize" => 100 //文件大小限制，单位MB
);

//文件上传状态,当成功时返回SUCCESS，其余值将直接返回对应字符窜
$state = "SUCCESS";
$fileName = "";
//保存路径
$path = $config[ 'uploadPath' ];
$path.= '/'.date('Y').'/'.date('m');
@mkdir($path,0777,true);
$clientFile = $_FILES[ "upfile" ];
if(!isset($clientFile)){
    echo "{'state':'error[0]','url':'null','fileType':'null'}";
    //请修改php.ini中的upload_max_filesize和post_max_size
    exit;
}
//格式验证
$current_type = strtolower( strrchr( $clientFile[ "name" ] , '.' ) );
if ( !in_array( $current_type , $config[ 'fileType' ] ) ) {
    $state = "error[1]";
}
//大小验证
$file_size = 1024 * 1024 * $config[ 'fileSize' ];
if ( $clientFile[ "size" ] > $file_size ) {
    $state = "error[2]";
}
//保存文件
if ( $state == "SUCCESS" ) {
    $tmp_file = $clientFile[ "name" ];
    $fileName = $path . rand( 1 , 10000 ) . time() . strrchr( $tmp_file , '.' );
    $result = move_uploaded_file( $clientFile[ "tmp_name" ] , $fileName );
    if ( !$result ) {
        $state = "error[3]";
    }
}
//向浏览器返回数据json数据
$fileName=str_replace(ROOT_PATH,'',$fileName);
$json = json_encode(array(
		'state'=>$state,
		'url'=>'http://'.site().$fileName,
		'fileType'=>$current_type,
		'original'=>$clientFile['name']
));
echo $json;
exit();
?>


