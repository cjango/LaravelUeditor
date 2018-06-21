<?php

namespace RuLong\Ueditor\Uploader;

class UploadScrawl extends Upload
{

    public function uploadNow()
    {

        $base64Data = $this->request->get($this->config['fieldName']);
        $img        = base64_decode($base64Data);

        if (empty($img)) {
            $this->stateInfo = 'ERROR_UNVALIDATED_FILE';
            return false;
        }

        $this->fileSize = strlen($img);

        if (!$this->checkSize()) {
            $this->stateInfo = 'ERROR_SIZE_EXCEED';
            return false;
        }

        $this->hash = md5($img);

        $this->oriName = $this->config['oriName'];

        $this->fullName = $this->getFullName();

        $this->fileName = basename($this->fullName);

        file_put_contents(public_path() . $this->fullName, $img);

        return true;
    }

    public function getFileExt()
    {
        return '.png';
    }
}
