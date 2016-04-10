<?php
// Contains the cookie for majestic
include('init.php');
class ContentHelper
{

    static function makeHashTags($url)
    {
        $html = HtmlHelper::takeHtml($url);
        
        // Weights
        $titleWeight = 20;
        $strongKeywordWeight = 17;
        $altKeywordWeight = 15;
        $backlingCaptionWeight = 17;
        $h1KeywordWeight = 14;
        $metaKeywordWeight = 9;
        $h2KeywordWeight = 8;
        $h3KeywordWeight = 5;
        $contentKeywordWeight = 0.5;

        // KeyWords Initialize
        $title = HtmlHelper::findTitle($html);
        $title = preg_replace("/[^A-Za-z0-9 ]/", '', $title);
        $title = strtolower($title);
        $strongs = ContentHelper::extractStrongKeywords($html);
        $alts = ContentHelper::extractImagesAlts($html);
        $h1s = ContentHelper::extractHeading1Keywords($html);
        $h2s = ContentHelper::extractHeading2Keywords($html);
        $h3s = ContentHelper::extractHeading3Keywords($html);
        $metas = ContentHelper::extractMetaDescriptionTags($html);
        $backlingCaptions = ContentHelper::getMajecticBacklinks($url);
        $contents = ContentHelper::extractContentKeywords($html);

        // Clear multiple values and add weight to them
        foreach ($strongs as &$strong)
        {
            $strong = strtolower($strong);

        }
        $uniqueStrongs = array_count_values($strongs);
        foreach ($uniqueStrongs as  $name => &$weight )
        {
            $weight *= $strongKeywordWeight;
        }


        foreach ($alts as &$alt)
        {
            $alt = strtolower($alt);
        }
        $uniqueAlts = array_count_values($alts);
        foreach ($uniqueAlts as  $name => &$weight )
        {
            $weight *= $altKeywordWeight;
        }

        foreach ($h1s as &$h1)
        {
            $h1 = strtolower($h1);
        }
        $uniqueH1s = array_count_values($h1s);
        foreach ($uniqueH1s as  $name => &$weight )
        {
            $weight *= $h1KeywordWeight;
        }

        foreach ($h2s as &$h2)
        {
            $h2 = strtolower($h2);
        }
        $uniqueH2s = array_count_values($h2s);
        foreach ($uniqueH2s as  $name => &$weight )
        {
            $weight *= $h2KeywordWeight;
        }

        foreach ($h3s as &$h3)
        {
            $h3 = strtolower($h3);
        }
        $uniqueH3s = array_count_values($h3s);
        foreach ($uniqueH3s as  $name => &$weight )
        {
            $weight *= $h3KeywordWeight;
        }

        foreach ($metas as &$meta)
        {
            $meta = strtolower($meta);
        }
        $uniqueMetas = array_count_values($metas);
        foreach ($uniqueMetas as  $name => &$weight )
        {
            $weight *= $metaKeywordWeight;
        }

        foreach ($backlingCaptions as &$backlingCaption)
        {
            $backlingCaption = strtolower($backlingCaption);
        }
        $uniqueBacklingCaptions = array_count_values($backlingCaptions);
        foreach ($uniqueBacklingCaptions as  $name => &$weight )
        {
            $weight *= $backlingCaptionWeight;
        }

        foreach ($contents as &$content)
        {
            $content = strtolower($contents);
        }
        $uniqueContents = array_count_values($contents);
        foreach ($uniqueContents as  $name => &$weight )
        {
            $weight *= $contentKeywordWeight;
        }

        // Merge arrays
        $keywords = array_merge($uniqueStrongs,$uniqueAlts);
        $keywords = array_merge($keywords,$uniqueH1s);
        $keywords = array_merge($keywords,$uniqueH2s);
        $keywords = array_merge($keywords,$uniqueH3s);
        $keywords = array_merge($keywords,$uniqueMetas);
        $keywords = array_merge($keywords,$uniqueBacklingCaptions);
        $keywords = array_merge($keywords,$uniqueContents);

        arsort($keywords); // Sort ascending

        // Add weights
        $uniqueKeywords = array();
        foreach ($keywords as $name => $weight)
        {
            if(array_key_exists($name, $uniqueKeywords))
            {
                $uniqueKeywords[$name] +=  $weight;
            }
            else
            {
                $uniqueKeywords[$name] = $weight;
            }
        }

        // Creating Hashtag Objects
        $keywordCount = 50;
        $hashTags  = array();

        $title = trim($title);
        $title = str_replace("- ", "", $title);
        $title = str_replace("-", "", $title);
        $title = "#" . str_replace(" ", "_",$title);
        array_push($hashTags,new HashTag($title,$titleWeight));

        $i=0;
        foreach ($uniqueKeywords as $name => $weight)
        {
            if (strlen($name) < 3 || strlen($name) > 35) { continue;}
            $i++;
            if($i>$keywordCount) { break;}

            // Add # and replace < >,<-> with <_>
            $name = trim($name);
            $name = str_replace("- ", "", $name);
            $name = str_replace("-", "", $name);
            $name = "#" . str_replace(" ", "_",$name);

            $hashtag = new HashTag($name,$weight);
            if(strlen($hashtag->getName()) < 1 || $hashtag->getName() == "")
            {
                break;
            }

            array_push($hashTags,$hashtag);
        }

        // Shuffling the array
        shuffle($hashTags);

        return $hashTags;
    }

    static function extractHeading1Keywords($html)
    {
        return HtmlHelper::findHtmlTagContent($html,'h1');
    }

    static function extractHeading2Keywords($html)
    {
        return HtmlHelper::findHtmlTagContent($html,'h2');
    }

    static function extractHeading3Keywords($html)
    {
        return HtmlHelper::findHtmlTagContent($html,'h3');
    }

    static function extractStrongKeywords($html)
    {
        return HtmlHelper::findHtmlTagContent($html,'strong');
    }
    
    // Return an array of content keywords
    static function extractContentKeywords($html)
    {
        $content = HtmlHelper::fixHtml($html);
        $keyWords = ContentHelper::stringToArray($content);
        
        return $keyWords;
    }

    // Return an array of the url backlings (using cookie) taken from init.php
    static function getMajecticBacklinks($url)
    {
        $fields_string = "format=Csv&MaxSourceURLsPerRefDomain=1&UsePrefixScan=0&index_data_source=Fresh&item=".urlencode($url)."&mode=0&request_name=ExplorerBacklinks&RefDomain=";
        //open connection
        $ch = curl_init();

        //read cookie from init,php
        global $majesticCookie;
        $cookie = $majesticCookie;

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, "https://majestic.com/data-output");
        curl_setopt($ch,CURLOPT_POST, count($fields_string));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch,CURLOPT_COOKIE, $cookie);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_ENCODING ,"UTF-8");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $keywords = array();

        $result = curl_exec($ch);

        if ($result || strpos($result, 'eURL","AnchorText","SourceTrustFlow","SourceCitationFlow","Domain","DomainTrustFlow')!== FALSE)
        {
            $lines = explode("\n", $result);
            foreach ($lines as $line)
            {
                $csv = str_getcsv($line);
                if ($csv
                    && is_array($csv)
                    &&  isset($csv[1])
                    && $csv[1]
                    && strpos($url,$csv[1]) === false
                    && strpos($csv[1],"http://") === false
                    && $csv[1]!='AnchorText'
                )
                {
                    $keywords[] = $csv[1];
                }
            }
        }
        curl_close($ch);

        //clearing non-alphanumerics
        foreach($keywords as &$keyword)
        {
            $keyword = preg_replace("/[^A-Za-z0-9. ]/", '', $keyword);
            $keyword = trim($keyword);
        }
        return $keywords;
    }

    // Return an array of url image alts
    static function extractImagesAlts($html)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($html);

        $tags = $doc->getElementsByTagName('img');
        $alts = array();
        foreach ($tags as $tag)
        {
            if(strlen($tag->attributes->getNamedItem('alt')->nodeValue) <3)
            {
                continue;
            }
            array_push($alts, $tag->attributes->getNamedItem('alt')->nodeValue);
        }
        return $alts;
    }

    // Return an array of url meta description tags
    static function extractMetaDescriptionTags($html)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $metas = $doc->getElementsByTagName('meta');
        $description = NULL;
        for ($i = 0; $i < $metas->length; $i++)
        {
            $meta = $metas->item($i);
            if($meta->getAttribute('property') == 'og:description')
            {
                $description = $meta->getAttribute('content');
            }
        }
        $keyWords = ContentHelper::stringToArray($description);
        return $keyWords;
    }

    // Convert a string to array of strings clear from html, js, stopwords, smallwords
    static function stringToArray($string)
    {
        $string = ContentHelper::remove2CharWords($string);
        $string = ContentHelper::removeCommonWords($string);
        $words = explode(" ", $string); // Creat an array from $content words
        $words = preg_replace('/[0-9]+/', '', $words); // Remove numbers
        $words = array_filter($words); // Remove empty values etc

        return $words;
    }
    
    static function remove2CharWords($content)
    {
        return trim( preg_replace(
            "/[^a-z0-9']+([a-z0-9']{1,3}[^a-z0-9']+)*/i",
            " ",
            " $content "
        ) );
    }

    static function removeCommonWords($input)
    {
        // EEEEEEK Stop words
        // https://gist.github.com/keithmorris/4155220
        $commonWords = array('a','able','about','above','abroad',
            'according','accordingly','across','actually','adj',
            'after','afterwards','again','against','ago','ahead',
            'ain\'t','all','allow','allows','almost','alone','along',
            'alongside','already','also','although','always','am',
            'amid','amidst','among','amongst','an','and','another',
            'any','anybody','anyhow','anyone','anything','anyway','anyways',
            'anywhere','apart','appear','appreciate','appropriate',
            'are','aren\'t','around','as','a\'s','aside','ask','asking',
            'January','February','March','April','May','June','July',
            'August','September','October','November','December',
            'associated','at','available','away','awfully','b','back','backward',
            'backwards','be','became','because','become','becomes','becoming','been',
            'before','beforehand','begin','behind','being','believe','below','beside',
            'besides','best','better','between','beyond','both','brief','but','by','c',
            'came','can','cannot','cant','can\'t','caption','cause','causes','certain',
            'certainly','changes','clearly','c\'mon','co','co.','com','come','comes',
            'concerning','consequently','consider','considering','contain','containing',
            'contains','corresponding','could','couldn\'t','course','c\'s','currently',
            'd','dare','daren\'t','definitely','described','despite','did','didn\'t',
            'different','directly','do','does','doesn\'t','doing','done','don\'t',
            'down','downwards','during','e','each','edu','eg','eight','eighty',
            'either','else','elsewhere','end','ending','enough','entirely','especially',
            'et','etc','even','ever','evermore','every','everybody','everyone',
            'everything','everywhere','ex','exactly','example','except','f','fairly',
            'far','farther','few','fewer','fifth','first','five','followed','following',
            'follows','for','forever','former','formerly','forth','forward','found','four',
            'from','further','furthermore','g','get','gets','getting','given','gives','go',
            'goes','going','gone','got','gotten','greetings','h','had','hadn\'t','half',
            'happens','hardly','has','hasn\'t','have','haven\'t','having','he','he\'d',
            'he\'ll','hello','help','hence','her','here','hereafter','hereby','herein',
            'here\'s','hereupon','hers','herself','he\'s','hi','him','himself','his',
            'hither','hopefully','how','howbeit','however','hundred','i','i\'d','ie',
            'if','ignored','i\'ll','i\'m','immediate','in','inasmuch','inc','inc.',
            'indeed','indicate','indicated','indicates','inner','inside','insofar',
            'instead','into','inward','is','isn\'t','it','it\'d','it\'ll','its','it\'s',
            'itself','i\'ve','j','just','k','keep','keeps','kept','know','known','knows',
            'l','last','lately','later','latter','latterly','least','less','lest','let',
            'let\'s','like','liked','likely','likewise','little','look','looking','looks',
            'low','lower','ltd','m','made','mainly','make','makes','many','may','maybe',
            'mayn\'t','me','mean','meantime','meanwhile','merely','might','mightn\'t',
            'mine','minus','miss','more','moreover','most','mostly','mr','mrs','much',
            'must','mustn\'t','my','myself','n','name','namely','nd','near','nearly',
            'necessary','need','needn\'t','needs','neither','never','neverf','neverless',
            'nevertheless','new','next','nine','ninety','no','nobody','non','none',
            'nonetheless','noone','no-one','nor','normally','not','nothing','notwithstanding',
            'novel','now','nowhere','o','obviously','of','off','often','oh','ok','okay','old',
            'on','once','one','ones','one\'s','only','onto','opposite','or','other','others',
            'otherwise','ought','oughtn\'t','our','ours','ourselves','out','outside','over',
            'overall','own','p','particular','particularly','past','per','perhaps','placed',
            'please','plus','possible','presumably','probably','provided','provides','q','que',
            'quite','qv','r','rather','rd','re','really','reasonably','recent','recently',
            'regarding','regardless','regards','relatively','respectively','right','round','s',
            'said','same','saw','say','saying','says','second','secondly','see','seeing','seem',
            'seemed','seeming','seems','seen','self','selves','sensible','sent','serious',
            'seriously','seven','several','shall','shan\'t','she','she\'d','she\'ll','she\'s',
            'should','shouldn\'t','since','six','so','some','somebody','someday','somehow',
            'someone','something','sometime','sometimes','somewhat','somewhere','soon','sorry',
            'specified','specify','specifying','still','sub','such','sup','sure','t','take',
            'taken','taking','tell','tends','th','than','thank','thanks','thanx','that',
            'that\'ll','thats','that\'s','that\'ve','the','their','theirs','them','themselves',
            'then','thence','there','thereafter','thereby','there\'d','therefore','therein',
            'there\'ll','there\'re','theres','there\'s','thereupon','there\'ve','these','they',
            'they\'d','they\'ll','they\'re','they\'ve','thing','things','think','third','thirty',
            'this','thorough','thoroughly','those','though','three','through','throughout','thru',
            'thus','till','to','together','too','took','toward','towards','tried','tries','truly',
            'try','trying','t\'s','twice','two','u','un','under','underneath','undoing',
            'unfortunately','unless','unlike','unlikely','until','unto','up','upon','upwards',
            'us','use','used','useful','uses','using','usually','v','value','various','versus',
            'very','via','viz','vs','w','want','wants','was','wasn\'t','way','we','we\'d',
            'welcome','well','we\'ll','went','were','we\'re','weren\'t','we\'ve','what',
            'whatever','what\'ll','what\'s','what\'ve','when','whence','whenever','where',
            'whereafter','whereas','whereby','wherein','where\'s','whereupon','wherever',
            'whether','which','whichever','while','whilst','whither','who','who\'d','whoever',
            'whole','who\'ll','whom','whomever','who\'s','whose','why','will','willing','wish',
            'with','within','without','wonder','won\'t','would','wouldn\'t','x','y','yes','yet',
            'you','you\'d','you\'ll','your','you\'re','yours','yourself','yourselves','you\'ve',
            'z','zero', 'nbsp');

        return preg_replace('/\b('.implode('|',$commonWords).')\b/','',$input);
    }

}