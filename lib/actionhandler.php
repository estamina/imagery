<?php

/**
 * @author 
 * @copyright 2015
 */
require_once("core/dirlister.php");
require_once("lib/upload.php");
require_once("lib/general.php");
require_once "lib/categories.php";


class ActionHandler
{
    private $dirServer;
    private $ctgServer;
    
    function __construct(DirLister &$dir, DirLister &$ctg)
    {
        error_log(get_class($this));
        $this->dirServer=$dir;
        $this->ctgServer=$ctg;
    }
    
    public function process($request){
        //    var_dump($request);
        if (isset($request['category']) && isset($request['submit'])){
        //    var_dump($request);
            if ($request['submit']=='upload') new Upload(storagePath);
            elseif ($request['submit']=='delete'){
                if (isset($request['mark'])) categories\delete();
            }
            elseif ($request['submit']=='add'){
                if (isset($request['mark'])) categories\add();
            }
        }
    }
    
    public function nextPage(){
        if (isset($_GET['page'])) $this->dirServer->setPageNo($_GET['page']);
    }

    public function nextCPage(){
        if (isset($_GET['cpage'])) $this->ctgServer->setPageNo($_GET['cpage']);
    }
    
    public function choose(){
        if (isset($_GET['category'])) {
            $_SESSION['category']=$_GET['category'];
            $this->dirServer->setDirectory(categoriesPath.'/'.$_GET['category']);
        }
    }  
    
    public function cycle(){
    	$this->dirServer->setPageSize(500);
    	$this->dirServer->setPageNo(0);
    	dbg("CYCLE");$_SESSION['show']=true;
    }
}

?>