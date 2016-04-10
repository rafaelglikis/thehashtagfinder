<!-- Form -->
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <ol class="breadcrumb">
                <li class="active"><a href="#">Home</a></li>
            </ol>
        </div>
        <div class="col-xs-12 col-md-2 col-md-offset-2">
            <img src="images/hashtag_blue.png" alt="hashtag" style="height:125px; width:125px;">
        </div>
        <div class="col-xs-12 col-md-6">
            <div id="custom-search-input">
                <form role="form"  method="get" action="../results.php">
                    <h2>Give me the link!</h2>
                    <div class="input-group col-md-12">
                        <input type="url"
                               class="form-control input-lg"
                               placeholder="http://www.example.com/blabla/"
                               name="url" id="focusedInput"
                               aria-required=”true” required/>
                        <span class="input-group-btn">
                            <button class="btn btn-info btn-lg" type="submit">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xs-12 col-md-2"></div>
        <div class="row">
            <div class="col-xs-12">
                <h3>Examples: </h3>
                <p><a href="https://blooming-stream-76734.herokuapp.com/results.php?url=https%3A%2F%2Fen.wikipedia.org%2Fwiki%2FBon_Jovi">
                        https://en.wikipedia.org/wiki/Bon_Jovi
                    </a>
                </p>
                <p>
                    <a href="https://blooming-stream-76734.herokuapp.com/results.php?url=http%3A%2F%2Fwww.codingdojo.com%2Fblog%2F9-most-in-demand-programming-languages-of-2016%2F">
                        http://www.codingdojo.com/blog/9-most-in-demand-programming-languages-of-2016/
                    </a>
                </p>
                <p>
                    <a href="https://blooming-stream-76734.herokuapp.com/results.php?url=http%3A%2F%2Fstackoverflow.com%2Fquestions%2F36533908%2Fhow-to-select-specific-data-from-mysql">
                        http://stackoverflow.com/questions/36533908/how-to-select-specific-data-from-mysql
                    </a>
                </p>
                <p>
                    <a href="https://blooming-stream-76734.herokuapp.com/results.php?url=http%3A%2F%2Fwww.psarema.info">
                        http://www.psarema.info
                    </a>
                </p>
            <div>
        </div>
        <br><br><br><br><br><br><br>
    </div>
</div>