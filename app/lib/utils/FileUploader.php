<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 7/8/18
 * Time: 12:14 PM
 */

namespace App\lib\utils;


use Klein\Request;
use FileUpload\Validator\Simple as SimpleValidator;
use FileUpload\PathResolver\Simple as SimplePathResolver;
use FileUpload\FileSystem\Simple as SimpleFileSystem;
use FileUpload\FileNameGenerator\Random as NameGenerator;
use FileUpload\FileUpload;

class FileUploader
{
    /**
     * @var Request
     */
    private $_request = null;

    public function __construct(Request $request)
    {
        $this->_request = $request;
    }

    /**
     * @param string $fileInputName
     * @param null $folderPath
     * @return array
     */
    public function store($fileInputName='file', $folderPath = null){
        $validator = new SimpleValidator('2M');

        // Todo: 需要检查给定的文件夹是否存在, 如果不存在, 则需要创建它
        $folderPath = is_null($folderPath) ? env('PUBLIC_UPLOADS_PATH_ROOT') : $folderPath;
        $pathresolver = new SimplePathResolver($folderPath);
        $filesystem = new SimpleFileSystem();
        $fileupload = new FileUpload($this->_request->files()->get($fileInputName),$this->_request->server()->all());

        $fileupload->setPathResolver($pathresolver);
        $fileupload->setFileSystem($filesystem);
        $fileupload->addValidator($validator);

        $nameGenerator = new NameGenerator(); // 32 characters long by default

        // Doing the deed
        $fileupload->setFileNameGenerator($nameGenerator);
        return  $fileupload->processAll();
    }
}