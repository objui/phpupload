<?php
require '../vendor/autoload.php';

use objui\phpupload\Upload;

if($_FILES){
//    var_dump($_FILES);
    $config = [
       'save_path' =>   __DIR__ . '/upload/',
       'type'      => 'qiniu',
       'accessKey' => '',
       'secrekey'  => '',
       'bucket'    => 'objui'        
    ];
    $obj = new Upload($config);

    var_dump($obj->upload());
}
?>

<form action="index.php" method="post" enctype="multipart/form-data">  
    <input type="file" name="file" value="" />  
    <input type="submit" name="submit"  value="upload" />  
</form> 
