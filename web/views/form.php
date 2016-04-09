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
                <form role="form"  method="post" action="../results.php">
                    <h2>Give me the link!</h2>
                    <div class="input-group col-md-12">
                        <input type="url" <!--oninvalid="setCustomValidity('Enter a valid url bro!')"-->
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
        <br><br><br><br><br><br><br>
    </div>
</div>