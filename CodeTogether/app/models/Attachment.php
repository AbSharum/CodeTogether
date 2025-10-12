<?php
class Attachment{
    public $url;
    public $fileData;

    public function __construct($url, $fileData){
        $this->url=$url;
        $this->fileData=$fileData;
    }

}