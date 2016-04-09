<?php
// Contains the cookie for majestic
include('init.php');
class ContentHelper
{
    // Calculate the keywords weight and return an array of hashtags
    static function calculateKeyWordsWeight($keyWords, $url)
    {
        $uniqueKeyWordCounts = array_count_values ($keyWords);

        // Sort ascending
        arsort($uniqueKeyWordCounts);

        // Take the url backlinks from Majestic
        $majesticKeywords = ContentHelper::getMajecticBacklinks($url);

        $hashTags  = array();

        $i=0;

        // Creating hashtag objects O(n^2)
        foreach ($uniqueKeyWordCounts as $name => $weight)
        {
            if (strlen($name) < 3)
            {
                break;
            }
            $i++;
            if($i>50) break;

            $hashtag = new HashTag($name,$weight);

            // Give more weight to keywords from backlinks
            foreach($majesticKeywords as $majesticKeyword)
            {
                if (strpos($majesticKeyword, $hashtag->getName()) != false)
                {
                    $hashtag->increamentWeightBy(2);
                }
            }
            array_push($hashTags,$hashtag);
        }

        // Shuffling the array
        shuffle($hashTags);

        return $hashTags;
    }

    // Clear return an array of hashtags
    static function extractKeyWords($url)
    {
        $content = ContentHelper::extractContent($url);

        $keyWords = explode(" ", $content); // Creat an array from $content words
        $keyWords = preg_replace('/[0-9]+/', '', $keyWords); // Remove numbers
        $keyWords = array_filter($keyWords); // Remove empty values etc
        
        $newKeyWords = ContentHelper::calculateKeyWordsWeight($keyWords, $url);
        
        return $newKeyWords;
    }
    
    // Return a String clear from html, js, stopwords, smallwords
    static function extractContent($url)
    {
        $html = HtmlHelper::takeHtml($url);
        $content = HtmlHelper::fixHtml($html);
        $content = ContentHelper::remove2CharWords($content);
        $content = ContentHelper::removeCommonWords($content);
        
        return $content;
    }

    // Return an array of the url backlings (using cookie) taken from init.php
    function getMajecticBacklinks($url)
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
        return $keywords;
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
        //'January','February','March','April','May','June','July',
        //'August','September','October','November','December',
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