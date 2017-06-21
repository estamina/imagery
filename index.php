<?php
session_start();
/**
 * @author 
 * @copyright 2015
 */

require_once('ui/display.php');
require_once('lib/actionhandler.php');

try{
    $catdir=new DirLister(categoriesPath,'pageNo1',15,'is_dir_type');//categories
    
    if (!isset($_SESSION['category'])) $_SESSION['category']=all;
    $category=$_SESSION['category'];
    
    $filedir=new DirLister(categoriesPath.'/'.$category, 'pageNo2', 40);//files in a category
    
    $control=new ActionHandler($filedir,$catdir);
    
    //var_dump($_POST);var_dump($_GET);var_dump($_SESSION);
    if (isset($_GET['action'])) $control->{$_GET['action']}($_POST);
    
    $view=new Display($filedir,$catdir);
    $view->viewport();
    
}catch(pathMissingException $e){
    echo $e->errorMessage();
    error_log($e->errorMessage());
}catch(InvalidArgumentList $e){
    echo "exception: ".$e->__toString();
    error_log($e->__toString());

}catch(UnexpectedValueException $e){
    echo "exception: ".$e->__toString();
    error_log($e->__toString());
    
}catch(ErrorException $e){
    echo "exception: ".$e->__toString();
    error_log($e->__toString());
}
?>