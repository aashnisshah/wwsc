<br>

<h1>Select Image to Upload</h1>

<br>

<?php
	if(isset($error)) {echo $error;}
?>

<!-- <button id="addLinkButton" class="btn btn-info btn-lg" type="button">Add A New Category</button> -->

<div id="addNewLink" class="newlink">
    <?php
        $attributes = array('class' => 'form-horizontal');
        echo form_open_multipart('upload/do_upload', $attributes);
    ?>
        <div class="form-group">
            <div class="">
            	<center>
            	<input type="file" class="control-label" name="userfile" />
            	</center>
            </div>
        </div>
        <div class="form-group">
            <div class="">
            	<input type="submit" class="btn btn-success" value="Upload Image" />
            </div>
        </div>
    </form>
</div>

<br>
