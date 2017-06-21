
<a href="<?php echo $urlbase;?>?action=nextCPage&cpage=<?php
	echo $this->catsource->getPageNo()-1;
?>" target="_self" title="previous (up to <?php
	echo $catcount;
?> categories)"><button class="button">&lt;</button></a>
<a href="<?php echo $urlbase;?>?action=nextCPage&cpage=<?php
	echo $this->catsource->getPageNo()+1;
?>" target="_self" title="next (up to <?php
	echo $catcount;
?> categories)"><button class="button">&gt;</button></a>
<a href="<?php echo $urlbase;?>?action=choose&category=all" target="_self" title="each picture belongs to this main category" ><button class="button button3">all</button></a>
<?php
    $pth=$relativeCategoriesPath;
    if (empty($categDirs)) echo "No categories";
    else
	foreach ($categDirs as $categ):
?>
<a href="<?php echo $urlbase;?>?action=choose&category=<?php echo $categ;?>" target="_self" ><?php echo $categ;?></a>
<?php
	endforeach;
    echo '<br>';    
?>
