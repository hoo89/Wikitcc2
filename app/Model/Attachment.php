<?php
/**
 * Attachment
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 *
 * @copyright	Copyright (c) 2014, hoo89
 * @link		https://github.com/hoo89/Wikitcc2
 * @license		MIT License
 */

class Attachment extends AppModel {
	public $validate = array(
		'name' => array(
			array('rule' => 'notEmpty'),
			array('rule' => 'isUnique','message' => '既にそのファイル名のファイルが存在するようです.別のファイル名を指定してください.')
			)
		);

	public $belongsTo = 'WikiPage';
	public function beforeValidate($options = array()) {
		setlocale(LC_ALL, 'ja_JP.UTF-8');
		if(array_key_exists('name',($this->data[$this->alias])))
			$this->data[$this->alias]['name'] = basename($this->data[$this->alias]['name']);
		return true;
	}
	public function beforeSave($options = array()){
		$upload_dir = 'files/attachment';
		if(!array_key_exists('name',($this->data[$this->alias]))){
			return false;
		}
		$filename = $this->data[$this->alias]['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if($ext === "php" || $ext === "cgi"){
			return false;
		}

		$upload_file = $upload_dir.DS.$filename;
		if(file_exists($upload_file)){
			return false;
		}
		if(!move_uploaded_file($this->data['Attachment']['attachment']['tmp_name'],$upload_file)){
			unlink($this->data['Attachment']['attachment']['tmp_name']);
			return false;
        }
		$thumb_dir = $this->createThumnail($upload_file);

		$this->data[$this->alias]['dir'] = $upload_file;
		if($thumb_dir){
			$this->data[$this->alias]['thumb_dir'] = $thumb_dir;
		}
		return true;
	}

	function createThumnail($filename){
		$file = new File($filename);
		$type = $file->mime();
		if($type !== "image/jpeg" && $type !== "image/png" && $type !== "image/gif"){
			return false;
		}

		list($width, $height) = getimagesize($filename);
		$thumb_width = $thumb_height = 140;

		if ( $width >= $height ) {
			// 横長の画像の時
			$side = $height;
			$x = floor( ( $width - $height ) / 2 );
			$y = 0;
			$width = $side;
		} else {
			// 縦長の画像の時
			$side = $width;
			$y = floor( ( $height - $width ) / 2 );
			$x = 0;
			$height = $side;
		}

		if ($type === "image/jpeg"){
			$src = imagecreatefromjpeg($filename);
		}else if($type === "image/png"){
			$src = imagecreatefrompng($filename);
		}else if($type === "image/gif"){
			$src = imagecreatefromgif($filename);
		}

		$image = imagecreatetruecolor($thumb_width, $thumb_height);
		imagecopyresampled($image, $src, 0, 0, $x, $y, $thumb_width, $thumb_height, $width, $height);

		if ($type === "image/jpeg"){
			imagejpeg($image, dirname($filename)."/thumb_".basename($filename));
		}else if($type === "image/png"){
			imagepng($image, dirname($filename)."/thumb_".basename($filename));
		}else if($type === "image/gif"){
			imagegif($image, dirname($filename)."/thumb_".basename($filename));
		}else {
			return false;
		}

		imagedestroy($image);
		imagedestroy($src);

		return dirname($filename)."/thumb_".basename($filename);
	}

	public function beforeDelete($options = array()){
		$attachment = $this->findById($this->id);
		if(!empty($attachment[$this->alias]['dir'])){
			unlink($attachment[$this->alias]['dir']);
		}
		if(!empty($attachment[$this->alias]['thumb_dir'])){
			unlink($attachment[$this->alias]['thumb_dir']);
		}
		return true;
	}
}
