<?php
class HtmlHelper
{
    static function curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

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
        return $html;
    }

    static function fixHtml($html)
    {
        $html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
        $html = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $html);
        $html = strip_tags($html);

        return $html;
    }

    static function findTitle($url)
    {
        $html = HtmlHelper::takeHtml($url);
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $nodes = $doc->getElementsByTagName('title');

        $title = $nodes->item(0)->nodeValue;

        return $title;
    }

    static function findMainImage($url)
    {
        $html = HtmlHelper::takeHtml($url);
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $nodes = $doc->getElementsByTagName('title');

        //get and display what you need:
        $metas = $doc->getElementsByTagName('meta');

        $image = NULL;
        for ($i = 0; $i < $metas->length; $i++)
        {
            $meta = $metas->item($i);
            if($meta->getAttribute('property') == 'og:image')
            {
                $image = $meta->getAttribute('content');
                break;
            }
        }
        if(filter_var($image, FILTER_VALIDATE_URL))
        {
            return $image;
        }
        else
        {
            $html = strip_tags($html, '<img>');
            var_dump($html);
        }
    }
}