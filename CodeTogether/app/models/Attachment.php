<?php
    declare(strict_types=1);

    class Attachment{
        public string $url;
        public string $fileData;
    
        public function __construct(string $url, string $fileData){
            $this->url=$url;
            $this->fileData=$fileData;
        }
    
    }
?>