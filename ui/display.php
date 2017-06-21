<?php

/**
 * @author 
 * @copyright 2015
 */

require ("core/dirlister.php");
class Display
{
    private $height;
    private $source;
    private $catsource;
    function __construct(DirLister &$folderList, DirLister &$catlist, $pgno=0, $hght = 250)
    {
        error_log(get_class($this));
        $this->catsource=$catlist;
        $this->source=$folderList;
        $this->height=$hght;
    }
    
    function viewport()
    {
        $relativeCategoriesPath='../'.appdataDir.'/'.categoriesDir.'/'.$_SESSION['category'].'/';
        $urlbase='http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['PHP_SELF'];
        $categDirs=$this->catsource->getList();
        $key=array_search(all,$categDirs);
        if ($key!==false)// hide/unlist category all
        {
        	dbg("reducing array:");
        	dbgmp($categDirs);
        	unset($categDirs[$key]);
        	dbgmp($categDirs);
        //	array_splice($categDirs, $key,1);//not needed?
        	dbgmp($categDirs);
        }
        $files=$this->source->getList();
        dbgmp($files);
        include "ui/header.php";
        if (isset($_SESSION['show'])) if ($_SESSION['show']){
        include "ui/slideshow.php";
        $_SESSION['show']=false;}
        else include "ui/thumbnails.php";        
        else include "ui/thumbnails.php";
    }
    
    function getPicHeight(){
        return strval(imgheight).'vh';
    }
    public function getPicsPerPage(){
        return $this->source->getPageSize();
    }

    public function getCategoriesPerPage(){
        return $this->catsource->getPageSize();
    }

	public function getJSON() {
	  $files=$this->source->getList();
	  dbgmp($files);
	  echo json_encode($files);
	  }
		
    
}

?>