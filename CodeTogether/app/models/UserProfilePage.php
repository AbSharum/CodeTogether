<?php
declare(strict_types=1);

class UserProfilePage
{
    public string $pfpUrl;
    public string $bannerUrl;
    public string $themeColor;
    public string $music;

    public function __construct(string $pfpUrl, string $bannerUrl, string $themeColor, string $music)
    {
        $this->pfpUrl = $pfpUrl;
        $this->bannerUrl = $bannerUrl;
        $this->themeColor = $themeColor;
        $this->music = $music;

    }

    public function customizeTheme($themeColor): void
    {
        $this->themeColor = $themeColor;
    }

    public function uploadPfp($pfpUrl): void
    {
        $this->pfpUrl = $pfpUrl;
    }

}
?>