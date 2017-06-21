<body id="viewer">

<?php
if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
	echo $_SESSION['message'];
	$_SESSION['message'] ="";
	noset($_SESSION['message']);
}
?>
<topline>
<a href="rssimagery.xml"><img src="ui/feed-icon-14x14.png" title="rss feed for pictures" alt="rss icon" style="width: 14px; height: 14px;"/></a>
Pictures in categories:</topline>

<?php

    $pictcount=$this->getPicsPerPage();
    $catcount=$this->getCategoriesPerPage();
    require_once "ui/categories.php";
    echo '<topline>';
    include "ui/picpaging.php";
?>
<form action="?action=process" method="post" enctype="multipart/form-data" >
<?php
    require_once("ui/upload.php");
?>
<div class="clearfix">
<noscript>
<?php
    if (empty($files)) echo "No images";
    else
	foreach ($files as $afile):
?>
<div class="thumbnail">
<a href="<?php echo $pth.$afile;?>" title="<?php echo $afile;?>">
<img src="<?php echo $pth.$afile;?>" alt="thumbNail" style="height: <?php echo $this->getPicHeight();?>;"/>
</a>
<input class="checkbox" type="checkbox" name="mark[]" value="<?php echo $pth.$afile;?>" />
</div><?php 
	endforeach;
?>
</noscript>
</div>
</form>
<br />
<?php
	include "ui/picpaging.php";
?>
</topline>


</body>
</html>