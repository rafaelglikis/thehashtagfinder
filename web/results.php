<?php

require('../vendor/autoload.php');

include ('views/header.php');

?>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h2>Url: <?php echo $_POST["url"];?></h2>
        </div>
    </div>
</div>
<?php

include ('views/footer.php');

?>
