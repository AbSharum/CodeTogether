<?php
declare(strict_types=1);

class Music
{
    public string $url;
    public string $fileData;

    public function __construct($url, $fileData)
    {
        $this->url = $url;
        $this->fileData = $fileData;
    }

}
?>