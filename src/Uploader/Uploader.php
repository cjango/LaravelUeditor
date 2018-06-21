<?php

namespace RuLong\Ueditor\Uploader;

use File;

class Uploader
{

    protected $config;
    protected $request;
    protected $file;

    protected $stateInfo = 'UNKNOWN ERRIR';
    protected $fileType;
    protected $fullName;
    protected $fileName;
    protected $oriName;
    protected $pathName;
    protected $fileSize;

    public function __construct($config, $request)
    {
        $this->config  = $config;
        $this->request = $request;
    }

    public function upload()
    {
        if ($this->uploadNow()) {
            $this->stateInfo = 'SUCCESS';
        }
        return $this->getFileInfo();
    }

    /**
     * 重命名文件
     * @return string
     */
    protected function getFullName()
    {
        //替换日期事件
        $time   = time();
        $date   = explode('-', date("Y-y-m-d-H-i-s"));
        $format = $this->config["pathFormat"];
        $format = str_replace("{yyyy}", $date[0], $format);
        $format = str_replace("{yy}", $date[1], $format);
        $format = str_replace("{mm}", $date[2], $format);
        $format = str_replace("{dd}", $date[3], $format);
        $format = str_replace("{hh}", $date[4], $format);
        $format = str_replace("{ii}", $date[5], $format);
        $format = str_replace("{ss}", $date[6], $format);
        $format = str_replace("{time}", $time, $format);

        $oriName = substr($this->oriName, 0, strrpos($this->oriName, '.'));
        $oriName = preg_replace("/[\|\?\"\<\>\/\*\\\\]+/", '', $oriName);
        $format  = str_replace("{filename}", $oriName, $format);

        $format = str_replace("{hash}", $this->hash, $format);

        //替换随机字符串  数值太大可能导致部分环境报错
        $randNum = rand(1, 10000000000) . rand(1, 10000000000);
        if (preg_match("/\{rand\:([\d]*)\}/i", $format, $matches)) {
            $format = preg_replace("/\{rand\:[\d]*\}/i", substr($randNum, 0, $matches[1]), $format);
        }

        $ext = $this->getFileExt();
        return $format . $ext;
    }

    protected function getFileExt()
    {
        $this->fileType = $this->file->extension();
        return '.' . $this->fileType;
    }

    protected function checkType()
    {
        return in_array($this->getFileExt(), $this->config["allowFiles"]);
    }

    protected function checkSize()
    {
        return $this->fileSize <= $this->config["maxSize"];
    }

    public function getFileInfo()
    {
        return [
            "name"         => $this->fileName,
            "originalName" => $this->oriName,
            "state"        => $this->stateInfo,
            "url"          => $this->fullName,
            "title"        => $this->fileName,
            "original"     => $this->oriName,
            "type"         => $this->fileType,
            'size'         => $this->fileSize,
        ];
    }
}
