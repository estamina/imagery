<!DOCTYPE html>
<html lang="en-us">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<title>Imagery</title>
<style>
.thumbnail { position:relative; float: left; margin: 1px; padding: 5px; border: 1px solid black; background-color: white;}
div {  padding: 5px; }
body {font-family: Verdana, sans-serif; font-size:0.8em;background-color: #b0c4de;}
.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 1px 2px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
.button2 {background-color: #008CBA;} /* Blue */
.button3 {background-color: #f44336;} /* Red */ 
.checkbox { position: absolute; bottom: 7px; right: 3px; }
topline { display:block; color: white; background-color:#008CBA; border:none; padding: 1px; font-size: 16px; }  
.clearfix {    overflow: auto;}
.cycle-slideshow { /*width: 50%; */ min-width: 90vw; max-width: 90vw; min-height: 90vh; max-height: 90vh; margin: 10px auto; padding: 0; position: relative; background-color: #008CBA;}
.cycle-slideshow, .cycle-slideshow * { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; }
.cycle-slideshow img { 
    /* 
    some of these styles will be set by the plugin (by default) but setting them here
    helps avoid flash-of-unstyled-content
    */
    position: absolute; top: 0; left: 0; /*width: 100%;*/ height:100%; padding: 0; display: block;
}
.cycle-paused:after {
    content: 'Paused'; color: white; background: black; padding: 10px;
    z-index: 500; position: absolute; top: 10px; right: 10px;
    border-radius: 10px;
    opacity: .5; filter: alpha(opacity=50);
}

</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://malsup.github.com/jquery.cycle2.js"></script>
<script type="text/javascript">
   var pth="<?php $pth=$relativeCategoriesPath;echo $pth; ?>";
   var picheight="<?php echo $this->getPicHeight();?>";
   var wh=$(window).height()-50;
	$(document).ready(function () {
		$('.cycling').append($('<a></a>').attr('href',"<?php echo $urlbase;?>?action=cycle").html('<button class="button button2">Cycle</button>'));
		var $pics=$(<?php $this->getJSON(); ?>);
		var h=0, $elem, done=false;
		$pics.each(function (index) {
			$elem=$('<div class="thumbnail"></div>').html('<a href="'+pth+$pics[index]+'" title="'+$pics[index]+'"><img src="'+pth+$pics[index]+'" alt="thumbNail" style="height: '+picheight+'"/><input class="checkbox" type="checkbox" name="mark[]" value="'+pth+$pics[index]+'" /></a>');
			if (!done){
				if (h<wh) $('div.clearfix').append($elem);
				h=$('div.clearfix').height();
				if (h>wh){
					$('div.clearfix div.thumbnail').last().remove();				
					done=true;			
				}
			}
			//console.log(index+":"+$pics[index]+">"+h+'>'+done+">"+wh);
		});
	});
</script>
</head>
