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
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="stylesheets/blue_styles.css">

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

<footer class="custom-footer navbar navbar-fixed-bottom">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <p>Developed by <a href="http://rafael.glikis.net/">Rafael Glikis</a> for <a href="http://nextweb.ninja/">Web Ninja</a> contest.</p>
            </div>
            <div class="col-xs-12 col-md-4">
                <a href="http://www.facebook.com/rafael.glikis"> <i class="fa fa-facebook" id="custom-footer-icon"></i></a>
                <a href="http://www.linkedin.com/in/rafael-glikis-b4361a80?trk=hp-identity-name"><i class="fa fa-linkedin"></i></a>
                <a href="http://github.com/rafaelglikis"> <i class="fa fa-github"></i></a>
                <a href="mailto:rafaelglikis@gmail.com"><i class="fa fa-envelope"></i></a>
            </div>
        </div>
    </div>
</footer>
</body>
</html>

