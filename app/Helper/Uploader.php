<?php
namespace App\Helper;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class Uploader {

    //file content
    private $file;

    //file type
    private $type;

    /** @var $from */
    private $from;
    private $disk;

    private $storePath;

    private $fileName;
    private $fileSize;
    private $fileExtension;
    private $filePath;

    private $result;

    public function __construct($file, $type = 'image', $from = 'upload') {
        $this->from = $from;
        $this->file = $file;
        $this->type = $type;

        if ($from == 'upload') {
            $this->filePath = $file->path();
            $this->fileName = $file->getClientOriginalName();
            $this->fileSize = $file->getSize();
            $this->fileExtension = $file->extension();
        }
        $this->disk = 'public';

    }

    public function setDisk($disk) {
        $this->disk = $disk;
    }

    public function setPath($path) {
        $this->storePath = $path;
        return $this;
    }

    public function directUpload() {
        $this->result = Storage::disk($this->disk)->put($this->storePath, $this->file);
        return $this;
    }

    public function result() {
        return $this->result;
    }

}
