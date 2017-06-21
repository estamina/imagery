<?php
//session_start();
require_once("lib/general.php");
require_once('lib/rssupdater.php');

class Upload
{
    private $target_dir;
    private $target_category;
    function __construct($path){
        error_log(get_class($this));
        $this->target_dir= storagePath.'/';// just for preliminary test
        $this->target_category= categoriesPath;
        //.'/'.$_SESSION['category'].'/';
        $this->process(); 
    }

    public function process()
    {
        if(!isset($_POST["submit"])) return; 
        if (empty($_FILES['files']['name'][0])) return;//no file chosen-> no response or warning
        $_SESSION['message']="";
        $_SESSION['message'] .= "Uploaded?: ";
        foreach ($_FILES['files']['name'] as $it => $mmm)
        { 
            $namehandle=basename( $_FILES["files"]["name"][$it]);
            $_SESSION['message'] .= $namehandle;
            $target_file = $this->target_dir . $namehandle;
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            // Check if image file is a actual image or fake image
            $check = @getimagesize($_FILES["files"]["tmp_name"][$it]);
            if($check !== false) {
                error_log( "File is an image - " . $check["mime"] . ".");
                $uploadOk = 1;
            } else {
                error_log("File is not an image.");
                $_SESSION['message'] .= " noIMG ";
                $uploadOk = 0;
                break;
            }

            // Check file size
            if ($_FILES["files"]["size"][$it] > 20000000) {
                $_SESSION['message'] .= " >20MB! ";
                $uploadOk = 0;
                break;
            }

            $validextensions = array("jpeg", "jpg", "png", "gif"); //Extensions which are allowed

            $ext = explode('.', $namehandle); //explode file name from dot(.)
            dbgmp($_FILES); 
            $file_extension = end($ext); //store extensions in the variable
            error_log($file_extension);

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                error_log( "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                $_SESSION['message'] .= " noFMT ";
                $uploadOk = 0;
                break;
            }
        
            // Check if file already exists
            $storedSHA=sha1_file($_FILES["files"]["tmp_name"][$it]);
            $storedfile= $storedSHA.".".$ext[count($ext) - 1];
            $target_file = $this->target_dir .$storedfile; //set the target path with a new name of image


            $newitem=false;//for rss feed and name conflict

            if (file_exists($target_file)) {
                error_log ("Sorry, file already exists.");
                $_SESSION['message'] .= " dupl! ";
                $uploadOk = 0;
            }else{
                $newitem=true;//for rss feed and name conflict
            }

            error_log('mkdir?');

            if (!file_exists($this->target_category.'/'. $_POST['category'])) {
                error_log('mkdir!');
                mkdir($this->target_category .'/'.$_POST['category']);
                $_SESSION['category']=$_POST['category'];
            }


            if (move_uploaded_file($_FILES["files"]["tmp_name"][$it], $target_file)) {
                error_log( "The file ".$namehandle. " has been uploaded.");
                $_SESSION['message'] .=  " OK ";
                $allPath='../'.appdataDir.'/'.categoriesDir.'/'.all;
                nextsearch:
    		if ( file_exists($allPath.'/'.$namehandle) && $storedSHA!=sha1_file($allPath.'/'.$namehandle) && set_version_of_name($namehandle)) goto nextsearch;// adds or increments numbering to the file
                error_log("renaming it to:".$namehandle);
/////////////CATEGORIZE
                categories\categorize($storedfile,all,$namehandle);
                if (!($_SESSION['category']==all))categories\categorize($storedfile,$_POST['category'],$namehandle);
//////////////RSS update
                if ($newitem) new RssUpdater(dirname(dirname($_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'])).'/'.appdataDir.'/'. categoriesDir.'/'.all.'/'.$namehandle);
            } else {
                error_log("Sorry, there was an error uploading your file.");
                $_SESSION['message'] .= " error ";
            }
        }
        header("Location: ".url);exit;
    }

}

?>