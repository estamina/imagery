<?php
require_once("lib/general.php");
/**
 * @author 
 * @copyright 2015
 */


function is_file_type($current){
    //error_log('----------------'.$current->getFilename());
    return $current->isFile() && !$current->isDot();;
}

function is_link_type($current){
    //return $current->isLink(); // @todo bug?
    //error_log('----------------'.$current->getFilename());
    return !$current->isDir() && !$current->isFile(); //workaround for bug    
}

function is_dir_type($current){
    //error_log('----------------'.$current->getFilename());
    return $current->isDir() && ! $current->isDot();
}    


class DirLister
{
    private $pageNo = 0;//which page
    private $pageSize;// items in page
    private $list=array();
    private $prefetchedPages = 5;// pages into client memory pages before and after
    private $ftype; //file true directory false
    private $changeId; //each change from any user recorded in a file, upload/delete, filename with del/upl, comparing them, via rss xml partly 
    private $dirIterator;
    private $instanceId;
    
    
    public function __construct( $pth, $instanceId, $pgsz=6 ,$ft = 'is_file_type' ) 
    {
        $this->pageSize=$pgsz;
        error_log(get_class($this));
        error_log($pth);
        $this->instanceId=$instanceId;
        if (isset($_SESSION[$instanceId])) $this->pageNo=$_SESSION[$instanceId];// @todo this is not usable for more than one instance
        try{        
            if (file_exists($pth)){ 
                $this->dirIterator=new DirectoryIterator($pth);
                $this->ftype=$ft;
                $this->setPageNo($this->pageNo);
            }
        }
        catch(ErrorException $e){
            echo "no directory to iterate over";
            $_SESSION['category']=all;
        }
    }

    public function setPageSize( $pgsz )
    {
        $this->pageSize = $pgsz;
    }     

    public function setPageNo($pgno){
        error_log('setPageNo');
        //$this->dirIterator->rewind();
        error_log($pgno);
        $this->pageNo=$pgno<0?0:$pgno;//check min boundary
        if ($this->pageNo > $pages=round($this->getFilesCount()/$this->pageSize)){
            error_log("pages:".$pages);
            $this->pageNo=$pages;//check max boundary @todo when not rounded floating point value caused nice aligning to last page... why?
        }
        
        $_SESSION[$this->instanceId]=$this->pageNo;
        error_log("===".$this->pageNo);
        $i=0;
        foreach (
            new LimitIterator(new CallbackFilterIterator($this->dirIterator,$this->ftype), 
                $this->pageNo*$this->pageSize, 
                $this->pageSize ) 
            as $item)
        {
            error_log($item->getFilename());
            $items[$i++]=$item->getFilename();
        }
        if (!empty($items)){
            dbgmp($items);
            $this->list=$items;
        } 
        elseif ($this->pageNo>0) $this->setPageNo(--$this->pageNo); 
        elseif ($this->pageNo<0) $this->setPageNo(0);// @todo wacth it! recursive !!! test when no images! check of max boundary
    }
    
    public function getList(){
        error_log('getList');
        return $this->list;
    }
    
    public function getPageNo(){
        return $this->pageNo;
    }
    
    public function getPageSize(){
        return $this->pageSize;
    }
    
    public function setRelativePage($offset){
        $this->setPageNo($this->pageNo+$offset);
    }
    
    public function setDirectory($pth){
        try{
//            if (file_exists($pth)){ 
                $this->pageNo=0;
                $this->dirIterator=new DirectoryIterator($pth);
                $this->setPageNo(0);
//            }
        }catch(InvalidArgumentException $e){
            
            throw new pathMissingException;                            
        
        }
        catch(UnexpectedValueException $e){
              echo "no category directory to iterate over";
            $_SESSION['category']=all;
            //throw new pathMissingException;
        }
    }
    
    public function getFilesCount(){
        error_log('getFileCount');
        $count=0;
        foreach (new CallbackFilterIterator($this->dirIterator,$this->ftype) as $item){
            $count++;
        }
        error_log($count);
        if (!$count) $this->list=array();// @todo not proper place, check later
        return $count;        
    }
}


?>