<?php

/**
 * @author 
 * @copyright 2015
 */

const bugs=
0;//add 1 to switch it on

const linux=0;
const windows=1;
const mac=2;
const all='all';
define ('url','http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?action=nextPage&page=0');


$OperatingSystem=server_os_detect();

function exception_error_handler($errno, $errstr, $errfile, $errline ) {
throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
set_error_handler("exception_error_handler");


class pathMissingException extends exception {
    public function errorMessage(){
        $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
        .': <b>'.$this->getMessage().'</b> wrong path!';
        return $errorMsg;        
    }
}

function set_version_of_name(&$afile){
	error_log("set_version_of_name");
//	if (!file_exists($afile)) return false;//checked before call of this function
	$ext=explode('.',$afile);
	dbgmp($ext);
        $extension=end($ext);
        if (is_numeric($prev=prev($ext))) {
            $prev=strval($prev+1);
            $ext[key($ext)]=$prev;
        }else{
            array_pop($ext);
            array_push($ext,"0");
            array_push($ext,$extension);
        }
        dbgmp($ext);
	$afile=implode('.',$ext);
	return true;
}


define ('rootPath',dirname(getcwd()));
const appdataDir="appdata";
const categoriesDir="categories";
define ('categoriesPath',rootPath.'/'.appdataDir.'/'.categoriesDir);
const storageDir="storage";
define ('storagePath',rootPath.'/'.appdataDir.'/'.storageDir);
const rssxmlfile="rssimagery.xml";
const max_number_of_rss_items=4;//for 5 should be 4=5-1;
const imgheight=20;//% of browser heigth


function initialDirs(){
    file_exists('../'.appdataDir)?:mkdir('../'.appdataDir);
    file_exists('../'.appdataDir.'/'.categoriesDir)?:mkdir('../'.appdataDir.'/'.categoriesDir);
    file_exists('../'.appdataDir.'/'.categoriesDir.'/'.all)?:mkdir('../'.appdataDir.'/'.categoriesDir.'/'.all);
    file_exists('../'.appdataDir.'/'.storageDir)?:mkdir('../'.appdataDir.'/'.storageDir);
}

initialDirs();

function server_os_detect(){
    function windows(){if (DIRECTORY_SEPARATOR == '\\') return true;}
    return windows() ? windows : linux ;// @todo add mac and sophisticated checks
/*
if (DIRECTORY_SEPARATOR == '/') {
    // linux
}
//php_uname('s') or PHP_OS
//if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
    echo 'This is a server using Windows!';
} else {
    echo 'This is a server not using Windows!';
}
*/    
}

function symlinkWindows($afile,$alink)
{
    $afile=str_replace('/','\\',$afile);    //windows bug workaround for slashes
    $alink=str_replace('/','\\',$alink);    //windows bug workaround for slashes
    //print 'mklink '.$alink.' '.$afile;
    return shell_exec('mklink '.$alink.' '.$afile);// for relative path under windows
    //return symlink($afile,$alink); //very unreliable     
}

function noset(&$var){ if (isset($var)) unset($var);}

function dbg($msg)
{
    if (bugs) echo $msg.'<br>';
}

function dbgmp($var)
{
    if (bugs) var_dump($var);
}

?>