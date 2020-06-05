<?php
private $config = [
    'ext'   =>'',
    'max_file_size' => 2097152 , // 最大上传限制2M      
    'save_path'   => '/up/',
    'filetype'    => [
        'image' => ['jpg', 'jpeg', 'png', 'gif'],
        'video' => ['flv', 'swf', 'mp4', 'ts', 'mp3', 'ogg'],
        'apk'   => ['apk', 'ios'],
        'doc'   => ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'txt', 'xml'],
        'pack'  => ['rar', 'zip', 'tar', 'gz', '7z', 'bz2', 'iso']
     ],
    'type'      => 'image',
    'filename'  => 'file'
];
