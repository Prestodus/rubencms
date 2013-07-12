<?php

class front_filecreatorController extends Base_Controller {
	
	public function indexAction() {
		
		$this->view->title = "RubenC Framework - Create files";
		
		$this->view->numberActions = (int) $this->postVar('actions', 1);
		
		return $this;
		
	}
	
	public function zip($source, $destination) {
		
	    if (!extension_loaded('zip') || !file_exists($source)) {
	        return false;
	    }
	
	    $zip = new ZipArchive();
	    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
	        return false;
	    }
	
	    $source = str_replace('\\', '/', realpath($source));
	
	    if (is_dir($source) === true) {
	        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
	
	        foreach ($files as $file) {
	            $file = str_replace('\\', '/', $file);
	            if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
	                continue;
	
	            $file = realpath($file);
	
	            if (is_dir($file) === true) {
	                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
	            }
	            elseif (is_file($file) === true) {
	                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
	            }
	        }
	    }
	    elseif (is_file($source) === true) {
	        $zip->addFromString(basename($source), file_get_contents($source));
	    }
	
	    return $zip->close();
		
	}
	
	public function createAction() {
		
		if ($this->postVars == false) {
			$this->redirect();
			exit;
		}
		
		if ($this->postVar('controller') == false) {
			$this->redirect('front', 'filecreator');
			exit;
		}
		
		if ($this->postVar('actions') == false) {
			$this->redirect('front', 'filecreator');
			exit;
		}
		
		$folder = date('d-m-Y h-i-s', time()).' - '.$this->postVar('controller');
		
		mkdir('zips/'.$folder, 0777, true);
		mkdir('zips/'.$folder.'/application/controller', 0777, true);
		mkdir('zips/'.$folder.'/application/view/scripts/'.$this->postVar('controller'), 0777, true);
		
		$handle = fopen('zips/'.$folder.'/application/controller/'.$this->postVar('controller').'Controller.php', 'w');
		$content = "<?php\n\nclass ".$this->postVar('controller')."Controller extends Base_Controller {\n\n";
		foreach ($this->postVar('actions') as $action) {
			if ($action != '') {
				$content .= "\tpublic function ".$action."Action() {\n\n\t\t\$this->view->title = '".$action." title';\n\n\t\treturn \$this;\n\n\t}\n\n";
			}
		}
		$content .= "}";
		fwrite($handle, $content);
		fclose($handle);
		
		foreach ($this->postVar('actions') as $action) {
			if ($action != '') {
				$handle = fopen('zips/'.$folder.'/application/view/scripts/'.$this->postVar('controller').'/'.$action.'.phtml', 'w');
				$content = '';
				fwrite($handle, $content);
				fclose($handle);
			}
		}

		$zip = new recursiveZip();
		$zip->compress('zips/'.$folder, 'zips');
		
		$delete = new removeDir();
		$delete->deleteDir('zips/'.$folder);
		
		$this->view->title = "RubenC Framework - Create files";
		$this->view->download = '/zips/'.$folder.'.zip';
		
		return $this;
		
	}
	
}