<?php

require('../vendor/autoload.php');

?>
<!DOCTYPE html>
<html>
<head>
    <title>The HashTag Finder</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrab -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">

    <link rel="stylesheet" href="../web/stylesheets/mystyles.css">
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <h1>The HashTag Finder</h1>
        <p>A Tool that process a given url and retrieves <strong>#hashtags</strong> from its content.</p>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-2 col-md-offset-2">
            <img src="images/hashtag_blue.png" alt="hashtag" style="height:125px; width:125px;">
        </div>
        <div class="col-xs-12 col-md-6">
            <div id="custom-search-input">
                <h2>Give me the link!</h2>
                <div class="input-group col-md-12">
                    <input type="text" class="form-control input-lg" placeholder="http://www.example.com/blabla/" />
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
        </div>
    </div>
</div>

<footer>
    <section id="footer" style="background-color:#292b34;">
        <div class="container">
            <center style="color:#fff;">
                <div class="container">
                    <div class="well well-sm main-footer"  style="background-color:#292b34; border:0px">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h1 class="title-footer">
                                            Quick Contact</h1>
                                    </div><!--end .col-md-4-->
                                    <div class="col-md-4 contact-email">
                                        <h2>
                                            <a href="mailto:nico@nicoplyley.com">nico@nicoplyley.com</a></h2>
                                        <h3>
                                            © Copyright Nico Plyley 2014</h3>
                                    </div><!--end .col-md-4 .contact-email-->
                                    <div class="col-md-4">
                                        <div class="row contact row-first">
                                            <div class="col-md-6">
                                                <a href="skype:nico.plyley?chat" class="skype"><i class="fa fa-skype"></i>nico.plyley</a>
                                            </div><!--end .col-md-6-->
                                            <div class="col-md-6">
                                                <a href="http://instagram.com/nicoplyley" class="instagram"><i class="fa fa-instagram"></i>@nicoplyley</a>
                                            </div><!--end .col-md-6-->
                                        </div><!--end .row .contact .row-first-->
                                        <div class="row contact">
                                            <div class="col-md-6">
                                                <a href="http://facebook.com/nicoplyley" class="facebook"><i class="fa fa-facebook"></i>@nicoplyley</a>
                                            </div><!--end .col-md-6-->
                                            <div class="col-md-6">
                                                <a href="http://twitter.com/nicoplyley" class="twitter"><i class="fa fa-twitter"></i>@nicoplyley</a>
                                            </div><!--end .col-md-6-->
                                        </div><!--end .row .contact-->
                                    </div><!--end .col-md-6-->
                                </div><!--end .row-->
                            </div><!--end .col-md-12-->
                        </div><!--end .row-->
                    </div><!--end .well .well-sm .main-footer-->
                </div><!--end .container-->
            </center>
        </div><!--end .container-->
    </section><!--end #footer-->
</footer>
</body>
</html>

