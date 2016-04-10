<?php
class Url
{
    private $url;
    private $title;
    private $image;
    private $hashTags  = array();
    
    public function __construct($url)
    {
        $this->url = $url;
        $this->title = HtmlHelper::findTitle($url);
        $this->image = HtmlHelper::findMainImage($url);

        $this->hashTags = array_merge($this->hashTags, ContentHelper::takeHashTags($url));
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImages($image)
    {
        $this->images = $image;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function addHashTag($hashTag)
    {
        array_push($this->hashTags,$hashTag);
    }

    
    public function getHashTags()
    {
        return $this->hashTags;
    }
}
?>