<?php

//Config
$image_suffix_list=array(  //允许上传的后缀
    'jpg',
    'jpeg',
    'png',
    'gif',
    'bmp',
    'webp',
    'tiff',
);
$server_url='http://192.168.31.2/img/'; //服务器URL(图片前的URL,可以理解为 {server_url}/xxx.jpg )
$conf_api_key='5grAtvQ0v5Ktq73TmaRM'; //上传Key,请求API上传时需要在Body中传入key参数
$max_file_size=10485760; //最大文件大小 单位:字节(B)

//----------------


header("Content-type:application/json;charset=utf-8");

@$api_key = $_POST['key'];



if ($api_key != $conf_api_key or empty($api_key)) {
    http_response_code(403);
    echo json_encode(array('code' => '001', 'msg' => 'Key is null or invalid'));
    exit;
} else {

    if (empty($_FILES["file"])) {
        http_response_code(400);
        echo json_encode(array('code' => '002', 'msg' => 'No file uploaded'));
        exit;
    } else {

        if ($_FILES["file"]["error"] != 0) {

            #返回错误Json

            if ($_FILES["file"]["error"] == 1) {
                http_response_code(400);
                echo json_encode(array('code' => '003', 'msg' => 'File size exceeds limit'));
                exit;
            } else if ($_FILES["file"]["error"] == 2) {
                http_response_code(400);
                echo json_encode(array('code' => '004', 'msg' => 'File size exceeds limit'));
                exit;
            } else if ($_FILES["file"]["error"] == 3) {
                http_response_code(400);
                echo json_encode(array('code' => '005', 'msg' => 'File was only partially uploaded'));
                exit;
            } else if ($_FILES["file"]["error"] == 4) {
                http_response_code(400);
                echo json_encode(array('code' => '006', 'msg' => 'No file was uploaded'));
                exit;
            } else if ($_FILES["file"]["error"] == 6) {
                http_response_code(400);
                echo json_encode(array('code' => '007', 'msg' => 'Missing a temporary folder'));
                exit;
            } else if ($_FILES["file"]["error"] == 7) {
                http_response_code(400);
                echo json_encode(array('code' => '008', 'msg' => 'Failed to write file to disk'));
                exit;
            } else if ($_FILES["file"]["error"] == 8) {
                http_response_code(400);
                echo json_encode(array('code' => '009', 'msg' => 'A PHP extension stopped the file upload'));
                exit;
            } else {
                http_response_code(400);
                echo json_encode(array('code' => '010', 'msg' => 'Unknown error'));
                exit;
            }
        } else {

            $file_size=$_FILES["file"]["size"];
            $file_name=$_FILES["file"]["name"];
            $file_type=$_FILES["file"]["type"];
            $file_tmp_name=$_FILES["file"]["tmp_name"];
            
            if ($file_size>$max_file_size) {
                http_response_code(400);
                echo json_encode(array('code' => '011', 'msg' => 'File size exceeds limit'));
                exit;
            } else {
                
                #按\分割file_type
                @$image_type=explode("/",$file_type)[0]; #获取上传的文件是否为图片
                #按.分割file_name
                $suff_list=explode(".",$file_name);
                @$image_suffix=$suff_list[count($suff_list)-1]; #获取上传的文件后缀

                if (!in_array($image_suffix, $image_suffix_list)) {
                    http_response_code(403);
                    echo json_encode(array('code' => '012', 'msg' => 'format not allowed','type' => $file_type));
                    exit;
                } {

                    #获取时间戳
                    $time = time();
                    #时间戳转换为文本
                    $time = strval($time);
                    #获取5位的随机字母
                    $rand = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 5);
                    #md5加密
                    $md5 = 'amg'.md5($time . $rand);

                    $file_path=$md5.'.'.$image_suffix;

                    $file_url=$server_url.$file_path;

                    if (move_uploaded_file($file_tmp_name,$file_path)==true){

                        //echo $file_size;

                        http_response_code(200);

                        $Original_file_info=
                        array(
                            'file_size'=>$file_size,
                            'file_name'=>$file_name,
                            'file_type'=>$file_type,
                            //'file_tmp_name'=>$file_tmp_name,
                            //'file_path'=>$file_path
                        );

                        echo json_encode(array('code' => '000', 'msg' => 'File uploaded successfully','Original_file_info'=>$Original_file_info,'file_url'=>$file_url));
                    } else {
                        http_response_code(500);
                        echo json_encode(array('code' => '013', 'msg' => 'Failed to upload file'));
                        exit;
                    }
                }
            }
        }
    }
}
