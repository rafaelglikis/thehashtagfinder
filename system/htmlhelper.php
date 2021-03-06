<?php
class HtmlHelper
{
    static function curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    // Return the html code of url
    static function takeHtml($url)
    {
        $html = '0';
        $html = file_get_contents($url);

        if ($html == '0')
        {
            ///*/**/*/print "file_get_contents_failed!\n";
            //print "Trying cURL!\n";
            $html = HtmlHelper::curl($url);
            if ($html == '0')
            {
                //print "Failed to get url content.\n";
            }
        }
        //$html = HtmlHelper::curl($url);

        return $html;
    }

    // Removes scripts, styles, and clear html tags
    static function fixHtml($html)
    {
        $html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
        $html = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $html);
        $html = strip_tags($html);

        return $html;
    }

    // Return the <title> of the url
    static function findTitle($html)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $nodes = $doc->getElementsByTagName('title');

        $title = $nodes->item(0)->nodeValue;

        return $title;
    }

    //Return an array of tag contents
    static function findHtmlTagContent($html,$tag)
    {
        $dom = new DOMDocument;
        @$dom->loadHTML($html);
        $phrases = array();
        $tagValues = $dom->getElementsByTagName($tag);
        foreach ($tagValues as $tagValue) 
        {
            $phrase = $tagValue->nodeValue;
            $phrase = preg_replace("/[^A-Za-z ]/", '',  $phrase);
            array_push($phrases, $phrase);
        }
        return $phrases;
    }

    //Tries to complete relative image urls, for example /images/logo.png becomes 
    private function fixImage($imageUrl, $baseUrl)
    {
        if ((strpos(strtolower($imageUrl),"http://") === false
        &&strpos(strtolower($imageUrl),"https://") === false
        ))
        {
            if ($baseUrl)
            {
                $url = $baseUrl;
                $parse = parse_url($url);
                $domain = $parse['host'];
                $imageUrl = $parse['scheme'].'://'.$domain.'/'.$imageUrl;
            }
        }

        return $imageUrl;
    }

    //Tries to find the main image of the url.
    // Tries to find the facebook og:image tag and
    // if that fails, it retrieves the first image from the source code
    static function findMainImage($html, $url = false)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($html);

        //get and display what you need:
        $metas = $doc->getElementsByTagName('meta');

        $image = NULL;
        for ($i = 0; $i < $metas->length; $i++)
        {
            $meta = $metas->item($i);
            if($meta->getAttribute('property') == 'og:image')
            {
                $image = $meta->getAttribute('content');
                $image = HtmlHelper::fixImage($image, $url);
                break;
            }
        }
        if(filter_var($image, FILTER_VALIDATE_URL))
        {
            return $image;
        }
        else
        {
            $html = file_get_contents($url);
            $dom = new domDocument;
            @$dom->loadHTML($html);
            $dom->preserveWhiteSpace = false;
            $images = $dom->getElementsByTagName('img');
            $image = '';
            foreach ($images as $image)
            {
                $image = $image->getAttribute('src');
                break;
            }
            $image = HtmlHelper::fixImage($image, $url);
            if (!filter_var($image, FILTER_VALIDATE_URL) )
            {
                if(substr($url, -1) !== '/' )
                {
                    $url = $url . '/';
                }
                $image = $url . $image;
            }
            if (filter_var($image, FILTER_VALIDATE_URL))
            {
                return $image;
            }
        }
        return NULL;
    }
}
