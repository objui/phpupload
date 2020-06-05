<?php
/**
 * 文件上传到本地
 * Author: objui@qq.com
 * Date: 2020/05/13
 */
namespace objui\phpupload\upload;

use objui\phpupload\IUpload;

class File implements IUpload
{
    private $config = [
        'ext'   =>'',
        'max_file_size' => 2097152 , // 最大上传限制2M      
        'save_path'   => '',
        'ext_type'      => 'image',
        'filename'  => 'file'
    ];

    private $ext_type = [
        'image' => ['jpg', 'jpeg', 'png', 'gif'],
        'video' => ['flv', 'swf', 'mp4', 'ts', 'mp3', 'ogg'],
        'apk'   => ['apk', 'ios'],
        'doc'   => ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'txt', 'xml'],
        'pack'  => ['rar', 'zip', 'tar', 'gz', '7z', 'bz2', 'iso']
    ];
   
    private $uploadfile;
    private $ext;
    private $name;
    private $size;
    private $tmp_name;
    private $error;
    private $save_name;
    private $save_path;

    public function __construct(array $config = [])
    {
        $this->config = array_merge($this->config, array_change_key_case($config));        
        $this->save_path = $this->config['save_path'] ?? dirname(dirname(__DIR__)) . '/test/upload/';
        $this->save_name = date('YmdHis') . uniqid();
    }

    public function upload()
    {
        $this->uploadfile = $_FILES[$this->config['filename']];
        if(false == $this->uploadfile || $this->uploadfile['name'] == false) {
            return false;
        }
        $this->error = $this->uploadfile['error'];
        switch($this->error) {
            case 0:
                $this->tmp_name = $this->uploadfile['tmp_name'];
                $this->name = $this->uploadfile['name'];
                $this->size = $this->uploadfile['size'];
                $this->ext = strtolower(substr(strrchr($this->name, "."), 1));
                $this->save_name .= '.' . $this->ext;
                if(!in_array($this->ext, $this->ext_type[$this->config['ext_type']])) {
                    return '非法上传';
                }        
                
                if($this->size > $this->config['max_file_size']){
                    return '文件超出最大上传限制';
                }
                
                if (!file_exists($this->save_path) && !mkdir($this->save_path, 0777, true)) {
                    return '目录不存在或权限不足';
                }
                return move_uploaded_file($this->tmp_name, $this->save_path . $this->save_name); 
                break;
            case 1:
                return '文件超过系统限定大小';
                break;

            case 2:
                return '超过最大文件上传限制';
                break;

            case 3:
                return '文件只有部分被上传';
               break;

           case 4:
               return '没有文件被上传';
               break;
          
           case 5:
               return '上传的文件为空文件';
               break;

           default:
               return '非法上传';
        }
        
    }

    public function download($filename = '')
    {
    }

    public function delete()
    {
        if(file_exists($filename)){
            return unlink($filename);
        } 
        return '删除失败';
    }
}
