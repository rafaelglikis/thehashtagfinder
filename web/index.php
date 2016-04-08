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
    <!-- FontAwesome 
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
    -->
    
    <link rel="stylesheet" href="../web/stylesheets/mystyles.css">


</head>
<style>
    /* Search */
    #custom-search-input{
        padding: 3px;
        border: solid 1px #E4E4E4;
        border-radius: 6px;
        background-color: #fff;
    }

    #custom-search-input input{
        border: 0;
        box-shadow: none;
    }

    #custom-search-input button{
        margin: 2px 0 0 0;
        background: none;
        box-shadow: none;
        border: 0;
        color: #666666;
        padding: 0 8px 0 10px;
        border-left: solid 1px #ccc;
    }

    #custom-search-input button:hover{
        border: 0;
        box-shadow: none;
        border-left: solid 1px #ccc;
    }

    #custom-search-input .glyphicon-search{
        font-size: 23px;
    }

    /* Footer */
    .row-footer {
        margin: 0px auto;
        padding: 20px 0px;
        background-color: #AfAfAf;
    }
</style>
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

<footer class="row-footer navbar navbar-fixed-bottom">
    <div class="container">
        <div class="row">
            <p>Developed by Rafael Glikis for nextWebNinja Contest.</p>
        </div>
    </div>
</footer>
</body>
</html>

