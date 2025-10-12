<?php
class UserProfilePage{
    public $pfpUrl;
    public $bannerUrl;
    public $themeColor;
    public $music;

    public function __construct($pfpUrl, $bannerUrl, $themeColor, $music){
        $this->pfpUrl=$pfpUrl;
        $this->bannerUrl=$bannerUrl;
        $this->themeColor=$themeColor;
        $this->music=$music;
        
    }

    public function customizeTheme($themeColor){
        $this->themeColor=$themeColor;
    }

    public function uploadPfp($pfpUrl){
        $this->pfpUrl=$pfpUrl;
    }

}