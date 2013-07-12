<?php

class removeDir {
	
	private $dirmn;
	
	function removeDir() {
	}
	
	function isEmpty($path) {
		
        $handle = opendir($path); 
        $i = 0; 
        while (false !== ($file = readdir($handle)))  $i++; 
        closedir($handle);  
        if($i >= 2) return false; 
        else return true;
			 
    } 
    function deleteDir($dirnm) {

        $d=dir($dirnm);
        while(false !== ($entry = $d->read())) {
            if($entry == "." || $entry == "..") continue;
            $currele = $d->path."/".$entry;
            if(is_dir($currele)) {
                if($this->isEmpty($currele)) {
                    @rmdir($currele);
                }
                else {
                    $this->deleteDir($currele);
                }
            }
            else {
                @unlink($currele);
            }
        }
        $d->close();
        rmdir($dirnm);
        return true;
    }

}