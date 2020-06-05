### 说明
使用PHP开发，集合本地，七牛、阿里云、腾讯云等多种文件上传

### 安装
```
composer require objui/phpupload
```

使用示例
```
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
 
```
