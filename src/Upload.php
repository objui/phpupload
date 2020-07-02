<?php
/**
 * 文件上传
 * Author；objui@qq.com
 * Time: 2020/05/13
 */
namespace objui\phpupload;

class Upload
{
    private $config = [];
    private static $obj = null;

    public function __construct(array $config = [])
    {
        $this->config = array_merge($this->config, array_change_key_case($config));        
        $this->getInstance();
    }

    public function getInstance()
    {
        if(empty(self::$obj)){
        
            $type = $this->config['type'] ? $this->config['type']: 'file';
            switch($type){
                case 'qiniu':
                    self::$obj = new \objui\phpupload\upload\Qiniu($this->config);
                    break;
                
                case 'file':
                default:
                   self::$obj = new \objui\phpupload\upload\File($this->config);
            }
        }
        return self::$obj;
    }

    public function upload()
    {
        return self::$obj->upload();
    }

    public function delete()
    {

    }

    public function download()
    {

    }
}
