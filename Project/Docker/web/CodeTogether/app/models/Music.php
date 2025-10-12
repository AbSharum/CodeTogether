<?php
class Music{
    public $url;
    public $fileData;
    
    public function __construct($url, $fileData){
        $this->url=$url;
        $this->fileData=$fileData;
    }

}