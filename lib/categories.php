<?php

/**
 * @author 
 * @copyright 2015
 */

namespace categories;

require_once "lib/general.php";

/*
    function __construct($category='any'){
        //$this->category=$category;        
    }
*/    

function categorize($afile,$category,$alink)
{   
    //todo: sha hash rename
    global $OperatingSystem;
    $old_path = getcwd();
    chdir(categoriesPath.'/'.$category);
    $afile='../'.storageDir.'/'.$afile;
    error_log("afile:".$afile);
    error_log("alink:".$alink);
    try{
        switch ($OperatingSystem){ 
            case windows:file_exists($alink)?$ret=true:$ret=symlinkWindows('../'.$afile,$alink);break;//symlink is not reliable under windows and is supposed to work with fullpaths
            case linux:file_exists($alink)?$ret=true:$ret=symlink('../'.$afile,$alink);break;
            case mac:file_exists($alink)?$ret=true:$ret=symlink('../'.$afile,$alink);break;//@todo perhaps works the same as for linux
        }
    }catch(ErrorException $e){
		$ret=copy('../'.$afile,$alink);           
    }
    chdir($old_path);
    return $ret;
}

function copylink($alink,$category){
    $old_path = getcwd();
    //chdir(categoriesPath.'/'.$category);
	$ret=copy($alink,'../'.$category.'/'.$alink);           
    //chdir($old_path);
    return $ret;
}    

function getCategory(){
    //return $this->category;
}

function delete(){
    if(isset($_POST["submit"]) && isset($_POST['mark'])) 
    {
        if (empty($_POST['mark'])) return;//no file chosen-> no response or warning
        $files=$_POST['mark'];
        foreach ($files as $key=>$afile) unlink($afile);
        header("Location: ".url);
    }
}

function add(){
    global $OperatingSystem;
    if(isset($_POST["submit"]) && isset($_POST['mark'])) 
    {
        if (empty($_POST['mark'])) return;//no file chosen-> no response or warning
        $files=$_POST['mark'];
        $catdir=dirname(dirname($files[0])).'/'.$_POST['category'];            
        if (!file_exists($catdir))mkdir($catdir);
        foreach ($files as $key=>$afile) {
            $nfile=$catdir.'/'.basename($afile);
//                echo "dir:".$catdir." nfile:".$nfile.'<br>'." aflie:".$afile.'<br>';
            switch ($OperatingSystem){
            
                 case windows:{
                    $afile=str_replace('/','\\',$afile);    //windows bug workaround for slashes
                    $nfile=str_replace('/','\\',$nfile);    //windows bug workaround for slashes
                    shell_exec("copy /L ".$afile.' '.$nfile); } break;
                 case linux:  
                    shell_exec("cp -l ".$afile.' '.$nfile);break;        
                    //copy($afile,$nfile);break;//does not work for links copies full
            }
        }
        header("Location: ".url);exit;
    }
    
}

?>