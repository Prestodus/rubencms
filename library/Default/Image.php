<?php

class Default_Image {
	
	public $base;
	public $destination;
	public $width = 100;
	public $height = 100;
	
	public $iteration = 1;
	public $error = false;

	public function setBase($base) {
		$this->base = $base;
		return $this;
	}
	public function getBase() {
		return $this->base;
	}

	public function setDestination($destination) {
		$this->destination = $destination;
		return $this;
	}
	public function getDestination() {
		return $this->destination;
	}

	public function setWidth($width) {
		$this->width = $width;
		return $this;
	}
	public function getWidth() {
		return $this->width;
	}

	public function setHeight($height) {
		$this->height = $height;
		return $this;
	}
	public function getHeight() {
		return $this->height;
	}

	public function setError($error) {
		$this->error = $error;
		return $this;
	}
	public function getError() {
		return $this->error;
	}
	
	
	
	
	public function resize() {
		if (is_file($this->base)) {
			$base_details = getimagesize($this->base);
			
			$base = array('width' => $base_details[0], 'height' => $base_details[1], 'mime' => $base_details['mime']);
			
			if (!file_exists($this->destination)) mkdir($this->destination);
			
			if ($base['mime'] == 'image/jpeg') {
				$image = imagecreatefromjpeg($this->base);
			}
			else if ($base['mime'] == 'image/png') {
				$image = imagecreatefrompng($this->base);
			}
			else if ($base['mime'] == 'image/gif') {
				$image = imagecreatefromgif($this->base);
			}
			else {
				return false;
			}
			
			$percent = 100;
			if ($base['width'] > $this->width) $percent = floor(($this->width*100)/$base['width']);
			if (floor(($base['height']*$percent)/100) > $this->height) $percent = (($this->height*100)/$base['height']);
			
			if ($base['width'] > $base['height']) {
				$width = $this->width;
				$height = round(($this->height*$percent)/100);
			} else {
				$width = round(($this->width*$percent)/100);
				$height = $this->height;
			}
			
			$ratio = min($this->width/$base['width'], $this->height/$base['height']);
			$width = $ratio*$base['width'];
			$height = $ratio*$base['height'];
						
			if ($base['mime'] == 'image/jpeg') {
		        $imagetype = "ImageJPEG";
		        $createfrom = "ImageCreateFromJPEG";
			}
			else if ($base['mime'] == 'image/png') {
		        $imagetype = "ImagePNG";
		        $createfrom = "ImageCreateFromPNG";
			}
			else if ($base['mime'] == 'image/gif') {
		        $imagetype = "ImageGIF";
		        $createfrom = "ImageCreateFromGIF";
			} else {
				return false;
			}

		    if ($imagetype) {
				$old_image = $createfrom($this->base);
				$new_image = imagecreatetruecolor($width, $height);
				$filename = $this->destination."/".sha1($this->base);
				
				if ($base['mime'] == 'image/jpeg') {
					imagecopyresampled($new_image, $old_image, 0, 0, 0, 0, $width, $height, $base['width'], $base['height']);
					imagejpeg($new_image, $filename.'.jpg', 100);
					$this->iteration++;
					return true;
				}
				else if ($base['mime'] == 'image/png') {
					imagealphablending($new_image, false);
					imagesavealpha($new_image,true);
					$transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
					//imagefilledrectangle($new_image, 0, 0, $width, $height, $transparent);
					imagecopyresampled($new_image, $old_image, 0, 0, 0, 0, $width, $height, $base['width'], $base['height']);
					imagepng($new_image, $filename.'.png', 9);
					$this->iteration++;
					return true;
				}
				else if ($base['mime'] == 'image/gif') {
					imagecopyresampled($new_image, $old_image, 0, 0, 0, 0, $width, $height, $base['width'], $base['height']);
					imagegif($new_image, $filename.'.gif');
					$this->iteration++;
					return true;
				} else {
					return false;
				}
		    } else {
		    	return false;
		    }
		} else {
			return false;
		}
	}
	
	public function upload() {
		$imageinfo = getimagesize($this->base['tmp_name']);
		
		if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png') {
			$this->error = 1;
			return false;
		}
		if ($imageinfo['mime'] == 'image/jpeg') $extension = '.jpg';
		if ($imageinfo['mime'] == 'image/png') $extension = '.png';
		if ($imageinfo['mime'] == 'image/gif') $extension = '.gif';
		
		$image = $this->destination.'/'.time().'-'.sha1($this->base['name']).rand(1,9999).$extension;
		
		if (move_uploaded_file($this->base['tmp_name'], $image)) {
			return $image;
		} else {
			$this->error = 2;
			return false;
		}
	}
	
}