
<div class="cycling">
<a href="<?php echo $urlbase;?>?action=nextPage&page=<?php
	echo $this->source->getPageNo()-1;
?>" target="_self" title="previous (up to <?php
	echo $pictcount;
?> pictures)"><button class="button">&lt;</button></a>
<a href="<?php echo $urlbase;?>?action=nextPage&page=<?php
	echo $this->source->getPageNo()+1;
?>" target="_self" title="next (up to <?php
	echo $pictcount;
?> pictures)"><button class="button">&gt;</button></a>
</div>


