<?php

    // var_dump(get_defined_vars());

    if(count($allLinks) < 1) {
        echo '<p>There are currently no images to list.</p>';
    } else {

?>

<table class="table table-condensed">

    <tr>
        <td>Image ID</td>
        <td>Image ID</td>
        <!-- <td>words</td> -->
        <td>From</td>
        <!-- <td>receiver</td> -->
        <td>status</td>
    </tr>

    <?php
        foreach($allLinks as $link) {
            echo '<tr>';
                echo '<td>' . $link['imageId'] . '</td>';
                echo '<td><img src="../uploads/' . $link['imageId'] . '"></td>';
                // echo '<td>' . $link['words'] . '</td>';
                echo '<td>' . $link['sender'] . '</td>';
                // echo '<td>' . $link['receiver'] . '</td>';
                echo '<td>' . $link['status'] . '</td>';
            echo '</tr>';
        }
    ?>
</table>

<?php
    }
?>
