    category:
    <input type="test" name="category" id="category" value="<?php
	echo $_SESSION['category'];
?>" />
    <button class="button button3" type="submit" value="add" name="submit">Add!</button>
    <button class="button button3" type="submit" value="delete" name="submit">Delete!</button>
    files:
    <input type="file" name="files[]" id="files" multiple accept=".jpeg,.jpg,.gif,.png" />
    <button class="button button3" type="submit" value="upload" name="submit">Upload!</button>
