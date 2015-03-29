<br>

<?php

    if($childSafe) {
?>

<h3>Your file was successfully uploaded!</h3>

<p><?php echo anchor('upload', 'Click here'); ?> if you would like to change the picture before proceeding.</p>

<p>Select which friends you want to send the image to, as well as 
   what the image shows, below.</p>

<div>
    <div class="col-sm-6">
        <?php echo '<img src="http://aashni.me/uploads/' . $file_name . '">'; ?>
    </div>
    <div class="col-sm-6">
        <div id="addNewLink" class="newlink">
            <?php
                $attributes = array('class' => 'form-horizontal');
                echo form_open('submissions/add_new_submission', $attributes);
            ?>
                <div class="form-group">
                    <label for="url" class="control-label">Recepients Name: </label>
                    <input type="text" class="form-control" name="receiver" placeholder="e.g. John Smith">
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Image Description: </label>
                    <input type="text" class="form-control" name="words" placeholder="e.g. Coke, Pineapple, Shoe">
                </div>
                <div class="form-group hidden">
                    <label for="imageId" class="control-label">Item ID: </label>
                    <input type="text" class="form-control" name="imageId" value="<?php echo $upload_data['file_name'] ?>">
                </div>
            </form>
        </div>
    </div>
</div>


<div class="form-group">
    <div class="">
        <button type="submit" class="btn btn-success">Send Image</button>
    </div>
</div>

<?php
    } else {
?>

<h3>Your file was not uploaded!</h3>

<p>Your file was not considered safe. Your account has been temporarily suspended.</p>
<p>Your account shall be reviewed, afterwhich we shall send you an email regarding the next steps.</p>

<?php
    }
?>

<br>

