<?php

namespace RuLong\Ueditor\Uploader;

use File;

class UploadFile extends Uploader
{

    public function uploadNow()
    {
        $this->file = $this->request->file($this->config['fieldName']);

        if (!$this->file->isValid()) {
            $this->stateInfo = 'ERROR_UNVALIDATED_FILE';
            return false;
        }

        $this->fileSize = $this->file->getSize();

        if (!$this->checkSize()) {
            $this->stateInfo = 'ERROR_SIZE_EXCEED';
            return false;
        }

        if (!$this->checkType()) {
            $this->stateInfo = 'ERROR_TYPE_NOT_ALLOWED';
            return false;
        }

        $this->hash = File::hash($this->file->path());

        $this->oriName = $this->file->getClientOriginalName();

        $this->fullName = $this->getFullName();

        $this->fileName = basename($this->fullName);

        $this->pathName = public_path() . dirname($this->fullName);

        $this->file->move($this->pathName, $this->fileName);

        return true;
    }
}
