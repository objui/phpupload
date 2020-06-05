<?php 
namespace objui\phpupload;

interface IUpload
{
    public function __construct(array $config =[]);

    public function upload();
    
    public function delete();

    public function download();
}
