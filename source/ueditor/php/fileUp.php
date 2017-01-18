<?php
error_reporting(E_ERROR|E_WARNING);
require_once 'common.php';
//�ϴ�����
$config = array(
    "uploadPath" => ROOT_PATH."/data/attachment" , //����·��
    "fileType" => array( ".rar" , ".doc" , ".docx" , ".zip" , ".pdf" , ".txt" , ".swf", ".wmv",'.xls','xlsx','.jpg','.gif','.png','ppt' ) , //�ļ������ʽ
    "fileSize" => 100 //�ļ���С���ƣ���λMB
);

//�ļ��ϴ�״̬,���ɹ�ʱ����SUCCESS������ֵ��ֱ�ӷ��ض�Ӧ�ַ���
$state = "SUCCESS";
$fileName = "";
//����·��
$path = $config[ 'uploadPath' ];
$path.= '/'.date('Y').'/'.date('m');
@mkdir($path,0777,true);
$clientFile = $_FILES[ "upfile" ];
if(!isset($clientFile)){
    echo "{'state':'error[0]','url':'null','fileType':'null'}";
    //���޸�php.ini�е�upload_max_filesize��post_max_size
    exit;
}
//��ʽ��֤
$current_type = strtolower( strrchr( $clientFile[ "name" ] , '.' ) );
if ( !in_array( $current_type , $config[ 'fileType' ] ) ) {
    $state = "error[1]";
}
//��С��֤
$file_size = 1024 * 1024 * $config[ 'fileSize' ];
if ( $clientFile[ "size" ] > $file_size ) {
    $state = "error[2]";
}
//�����ļ�
if ( $state == "SUCCESS" ) {
    $tmp_file = $clientFile[ "name" ];
    $fileName = $path . rand( 1 , 10000 ) . time() . strrchr( $tmp_file , '.' );
    $result = move_uploaded_file( $clientFile[ "tmp_name" ] , $fileName );
    if ( !$result ) {
        $state = "error[3]";
    }
}
//���������������json����
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


