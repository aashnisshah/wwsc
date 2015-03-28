<br>

<h3>Your file was successfully uploaded!</h3>

<p>Select which friends you want to send the image to, as well as 
   what the image shows, below.</p>

<!-- Ideally show a list of friends
 	  and have the user select which friends
 	  they want to send the picture to -->


<div id="addNewLink" class="newlink">
    <?php
        $attributes = array('class' => 'form-horizontal');
        echo form_open('images/newImage', $attributes);
    ?>
        <div class="form-group">
            <label for="url" class="control-label">Recepients Name: </label>
            <input type="text" class="form-control" name="name" placeholder="e.g. John Smith">
        </div>
        <div class="form-group">
            <label for="name" class="control-label">Item Name: </label>
            <input type="text" class="form-control" name="description" placeholder="e.g. Coke, Pineapple, Shoe">
        </div>
        <div class="form-group hidden">
            <label for="imageId" class="control-label">Item Name: </label>
            <input type="text" class="form-control" name="description" value="<?php echo $upload_data['file_name'] ?>">
        </div>
        <div class="form-group">
            <div class="">
                <button type="submit" class="btn btn-success">Send Image</button>
            </div>
        </div>
    </form>
</div>

<br>




<p><?php echo anchor('upload', 'Change Image'); ?></p>