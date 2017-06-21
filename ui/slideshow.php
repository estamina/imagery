<body id="slideshow">
<?php
    $pth=$relativeCategoriesPath;
    $pictcount=$this->getPicsPerPage();
    $catcount=$this->getCategoriesPerPage();
?>
<div class="cycle-slideshow"
    data-cycle-fx="scrollHorz"
    data-cycle-pause-on-hover="true"
    data-cycle-speed="400"
>

<?php
    if (empty($files)) echo "No images";
    else
	foreach ($files as $afile):
?>
<img src="<?php echo $pth.$afile;?>" />
<?php 
	endforeach;
?>
</div>
</body>
</html>