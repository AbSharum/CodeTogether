<?php
declare(strict_types=1);

class Repost
{
    public $originalPostID;
    public $repostText;

    public function __construct(int $postID, int $postAuthorID, string $content, DateTime $datePosted, string $hashTag, string $tags, string $comments, string $attachment)
    {
        $this->postID = $postID;
        $this->postAuthorID = $postAuthorID;
        $this->$content = $content;
        $this->datePosted = $datePosted;
        $this->hashTag = $hashTag;
        $this->tags = $tags;
        $this->$comments = $comments;
        $this->$attachment = $attachment;

    }


    public function share($post): void
    {
        #shares the repost
    }
}
?>