TheHashTagFinder
================

TheHashTagFinder is my entry to the [http://nextweb.ninja](nextweb.ninja) 2016 competition.

It is a tool that takes a url as input and returns a list of semantic hashtags relevant to the content of the website.

Technologies
============

TheHashTagFinder is build with php and bootstrap. Composer package manager is used for php packages. 

A demo is deployed on Heroku here: [https://blooming-stream-76734.herokuapp.com/](https://blooming-stream-76734.herokuapp.com/)

Methodology
===========

The methodology followed is text analysis in the content and anchor text on backlinks. Different tags in the html have different weights.

For example:

    - Title, bold bold text, h1, h2 have very high priority.
    - Image alt tags and h3 tags have high priority
    - All other text has low priority, but the frequency of each keyword is taken into account.

Also Anchor text on backlinks has very high priority and its being used by the search engines for keyword relevance analysis. In a nutshell if we are analysing http://www.example.com/ what is important is to find websites that link to http://www.example.com/ and get the keywords in the anchor. For example if we have: <strong>&lt;a href="http://www.gnu.org/"&gt;free software&lt;/a&gt; </strong> we know that www.gnu.org contains information about free software.

More on Anchor text importance here: [https://seo-hacker.com/important-anchor-text-backlink/](https://seo-hacker.com/important-anchor-text-backlink/)

The way we use to extract Anchor text is by scraping Majectic Seo with a cookie from a registered account: [example](https://majestic.com/reports/site-explorer/anchor-text?folder=&q=https%3A%2F%2Fseo-hacker.com%2Fimportant-anchor-text-backlink%2F&oq=https%3A%2F%2Fseo-hacker.com%2Fimportant-anchor-text-backlink%2F&IndexDataSource=F). Then the results are merged into the rest of the analysis, with a configurable weight. Then the first 50 hashtags are displayed.


Limitations
===========

Due to the competition rules (the app has to be build in 3 days) we have a limited support for other languages except english, due to php curl limitations.
