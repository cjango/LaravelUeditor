<?php

namespace RuLong\Ueditor\Uploader;

class UploadCatch extends Upload
{
    private $ext;

    public function uploadNow()
    {
        $imgUrl = strtolower(str_replace("&amp;", "&", $this->config['imgUrl']));

        if (strpos($imgUrl, "http") !== 0) {
            $this->stateInfo = 'ERROR_HTTP_LINK';
            return false;
        }
        // 获取请求头并检测死链
        $headers = get_headers($imgUrl);
        if (!(stristr($headers[0], "200") && stristr($headers[0], "OK"))) {
            $this->stateInfo = 'ERROR_DEAD_LINK';
            return false;
        }
        $contentType = array_where($headers, function ($value, $key) {
            return stristr($value, "Content-Type");
        });
        if (!$contentType) {
            $this->stateInfo = 'ERROR_CONTENT_TYPE_ERROR';
            return false;
        }
        // 格式验证(扩展名验证和Content-Type验证)
        $fileType = str_replace('Content-Type: image/', '.', head($contentType));
        if (!in_array($fileType, $this->config['allowFiles'])) {
            $this->stateInfo = 'ERROR_HTTP_CONTENTTYPE';
            return false;
        }
        $this->ext = $fileType;

        // 检查文件大小是否超出限制
        $contentLength = array_where($headers, function ($value, $key) {
            return stristr($value, "Content-Length");
        });
        $fileLength = str_replace('Content-Length: ', '', head($contentLength));

        if ($fileLength > $this->config['maxSize']) {
            $this->stateInfo = 'ERROR_SIZE_EXCEED';
            return false;
        }
        // 打开输出缓冲区并获取远程图片
        ob_start();
        $context = stream_context_create(
            [
                'http' => [
                    'follow_location' => false,
                ],
            ]
        );
        readfile($imgUrl, false, $context);
        $img = ob_get_contents();

        $this->hash = md5($img);
        ob_end_clean();

        preg_match("/[\/]([^\/]*)[\.]?[^\.\/]*$/", $imgUrl, $m);

        $this->oriName  = $m ? $m[1] : "";
        $this->fileSize = strlen($img);
        $this->fileType = $this->getFileExt();
        $this->fullName = $this->getFullName();
        $this->fileName = basename($this->fullName);
        $dirname        = dirname($this->fullName);

        if (file_exists($this->fullName)) {
            $this->stateInfo = 'SUCCESS';
            return true;
        }
        try {
            file_put_contents(public_path() . $this->fullName, $img);
            $this->stateInfo = 'SUCCESS';
            return true;
        } catch (\Exception $e) {
            $this->stateInfo = 'ERROR_WRITE_CONTENT';
            return false;
        }
    }

    /**
     * 获取文件扩展名
     * @return string
     */
    protected function getFileExt()
    {
        return strtolower($this->ext);
    }
}
