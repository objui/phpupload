<?php 
/**
 * 七牛云上传
 * Author: objui@qq.com
 * Date: 2020/05/14
 */
namespace objui\phpupload\upload;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use objui\phpupload\IUpload;

class Qiniu implements IUpload
{
    private $accessKey;
    private $secreKey;
    private $auth;
    private $upToken;
    private $tmp_path;  //缓存路径
    private $save_name; //保存文件名
    private $uploadfile;
    private $config = [
        'bucket'        => '',    // 空间名
        'expires'       => 7200,
        'policy'        => null,
        'filename'      => 'file',
        'ext'           => '',
        'max_file_size' => 2097152 , // 最大上传限制2M      
        'save_path'     => '',
        'ext_type'      => 'image',
        'prefix'        => 'up'
    ];
    
    private $ext_type = [
        'image' => ['jpg', 'jpeg', 'png', 'gif'],
        'video' => ['flv', 'swf', 'mp4', 'ts', 'mp3', 'ogg'],
        'apk'   => ['apk', 'ios'],
        'doc'   => ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'txt', 'xml'],
        'pack'  => ['rar', 'zip', 'tar', 'gz', '7z', 'bz2', 'iso']
    ];

    public function __construct(array $config = [])
    {
        $this->accessKey = $config['accesskey'] ? $config['accesskey']: '';
        $this->secreKey = $config['secrekey'] ? $config['secrekey']: '';
        unset($config['accesskey']);
        unset($config['secrekey']);
        $this->config = array_merge($this->config, $config);
        $this->auth = new Auth($this->accessKey, $this->secreKey);
        $this->upToken = $this->auth->uploadToken($this->config['bucket'], null, $this->config['expires'], $this->config['policy'], true);
    }

    public function getToken()
    {
        return $this->upToken;
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
                $this->save_name = $this->config['prefix'] . '/' . date('YmdHis') . '/' . uniqid() . '.' . $this->ext;
                if(!in_array($this->ext, $this->ext_type[$this->config['ext_type']])) {                                                                                                            
                    return '非法上传';          
                }              
                               
                if($this->size > $this->config['max_file_size']){
                    return '文件超出最大上传限制';                                                                                                                                                       
                }              
                               
                $uploadMgr = new UploadManager();   
                list($ret, $err) = $uploadMgr->putFile($this->upToken, $this->save_name, $this->tmp_name);
                if ($err !== null) {
                    return $err;
                } else {
                    return $ret;
                }             
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

    public function delete()
    {

    }

    public function download()
    {

    }   
}
