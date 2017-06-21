<?php

/**
 * @author 
 * @copyright 2015
 */

require_once("lib/general.php");

class RssUpdater
{
    function __construct($imagefile)
    {
        $this->rssfile=rssxmlfile;
        $this->doc = new DOMDocument($imagefile);
        try{
            if (!file_exists($this->rssfile)){
                echo "no rss file present, copy it from template";
                copy("ui/".rssxmlfile,rssxmlfile);
            }
            $this->doc->load($this->rssfile);
            $this->additem($imagefile);
        } catch(ErrorException $e){ echo "problem with rss:".$e->__toString();}
    }
    
    public function additem($imagefile){
        $nodelist=$this->doc->getElementsByTagName('item');// search for first <item>
        $timestamp=time();//latest time to compare with
        dbgmp($timestamp);
        $eldest=null;
        $count=0;
        if ($nodelist){
            //find the eldest to remove
            foreach ($nodelist as $element){
                $count++;
                $elem=$element;
                $el=$elem->getElementsByTagName('pubDate')->item(0);// search for <pubDate> under given <item>
                $time0=new DateTime($el->nodeValue);
                $ts=$time0->getTimestamp();                
                if ($ts<$timestamp){
                    $timestamp=$ts;
                    $eldest=$elem;
                };
            }
        }
        $nodelist=$this->doc->getElementsByTagName('channel');//take <channel>
        $channel_node=$nodelist->item(0);

        if ($count>max_number_of_rss_items){            
            dbgmp($eldest->nodeValue);
            $channel_node->removeChild($eldest->previousSibling);// removing tab ident before <item>
            $channel_node->removeChild($eldest);//remove eldest <item> from this <channel>
        }
        $date_f = date("D, d M Y H:i:s T", time());//current time to add
        $date_rfc = gmdate(DATE_RFC2822, strtotime($date_f));

        $channel_node->removeChild($channel_node->lastChild);//removing tab ident before </channel>
        $text_node = $channel_node->appendChild($this->doc->createTextNode("\n      "));

        $item_node = $channel_node->appendChild($this->doc->createElement("item")); //create and append a new <item>
        $title_node = $item_node->appendChild($this->doc->createElement("title", basename($imagefile)) ); //<title> of a new image
        $link_node = $item_node->appendChild($this->doc->createElement("link", "http://".$imagefile)); //<link> to this image

        $pub_date = $this->doc->createElement("pubDate", $date_rfc);  
        $pub_date_node = $item_node->appendChild($pub_date);//<pubDate> of the this <item> 
        $text_node= $channel_node->appendChild($this->doc->createTextNode("\n   "));// adds removed tab ident before </channel>


        $nodelist=$this->doc->getElementsByTagName('link');//find first whole <channel> <link> 
        $nodelist->item(0)->nodeValue='http://'.dirname($_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);//and change it

        $nodelist=$this->doc->getElementsByTagName('pubDate');//find whole <channel> <pubDate> 
        $nodelist->item(0)->nodeValue=$date_rfc;//and change it
        
        $this->doc->save($this->rssfile);
    }
}

?>