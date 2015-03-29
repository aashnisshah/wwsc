<?php

    if(count($allLinks) < 1) {
        echo '<p>There are currently no images to list.</p>';
    } else {

?>

     <?php
        foreach($allLinks as $link) {
                echo '<div class="col-sm-3">'
                        . '<h4>' . $link['sender'] . '</h4>'
                        . '<img class="img-responsive" src="../uploads/'
                        . $link['imageId'] . '">'
                        .'</div>';
        }
    ?>


<?php
    }
?>
