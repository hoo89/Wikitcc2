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

/**
 * バリデーションルール
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			array('rule' => 'notBlank'),
			array('rule' => 'isUnique', 'message' => '既にそのファイル名のファイルが存在するようです.別のファイル名を指定してください.')
			)
		);

/**
 * Attachment belongs to WikiPage
 *
 * @var string
 */
	public $belongsTo = 'WikiPage';

/**
 * バリデーションの前に$this->data[$this->alias]['name']をパスの最後にある名前の部分に変更する
 *
 * @param array $options
 * @return bool
 */
	public function beforeValidate($options = array()) {
		setlocale(LC_ALL, 'ja_JP.UTF-8');
		if(array_key_exists('name', ($this->data[$this->alias])))
			$this->data[$this->alias]['name'] = basename($this->data[$this->alias]['name']);
		return true;
	}

/**
 * DB反映前にアップロードファイル保存処理を行う
 *
 * @param array $options
 * @return bool
 */
	public function beforeSave($options = array()) {
		$uploadDir = 'files/attachment';
		if (!array_key_exists('name', ($this->data[$this->alias]))) {
			return false;
		}
		$filename = $this->data[$this->alias]['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if ($ext === "php" || $ext === "cgi") {
			return false;
		}

		$uploadFile = $uploadDir . DS . $filename;
		if (file_exists($uploadFile)) {
			return false;
		}
		if (!move_uploaded_file($this->data['Attachment']['attachment']['tmp_name'], $uploadFile)) {
			unlink($this->data['Attachment']['attachment']['tmp_name']);
			return false;
		}
		$thumbDir = $this->createThumnail($uploadFile);

		$this->data[$this->alias]['dir'] = $uploadFile;
		if ($thumbDir) {
			$this->data[$this->alias]['thumb_dir'] = $thumbDir;
		}
		return true;
	}

/**
 * サムネイル作成
 * 同一ディレクトリ中のthumb_(filename).(png|jpg|gif)にサムネイルを作成し保存する
 *
 * @param string $filename Filename of image(fullpath).
 * @return bool
 */
	public function createThumnail($filename) {
		$file = new File($filename);
		$type = $file->mime();
		if ($type !== "image/jpeg" && $type !== "image/png" && $type !== "image/gif") {
			return false;
		}

		list($width, $height) = getimagesize($filename);
		$thumbWidth = $thumbHeight = 140;

		if ($width >= $height) {
			// 横長の画像の時
			$side = $height;
			$x = floor( ($width - $height) / 2 );
			$y = 0;
			$width = $side;
		} else {
			// 縦長の画像の時
			$side = $width;
			$y = floor( ($height - $width) / 2 );
			$x = 0;
			$height = $side;
		}

		if ($type === "image/jpeg"){
			$src = imagecreatefromjpeg($filename);
		}elseif ($type === "image/png"){
			$src = imagecreatefrompng($filename);
		}elseif ($type === "image/gif"){
			$src = imagecreatefromgif($filename);
		}

		$image = imagecreatetruecolor($thumbWidth, $thumbHeight);
		imagecopyresampled($image, $src, 0, 0, $x, $y, $thumbWidth, $thumbHeight, $width, $height);

		if ($type === "image/jpeg"){
			imagejpeg($image, dirname($filename) . "/thumb_" . basename($filename));
		}elseif ($type === "image/png"){
			imagepng($image, dirname($filename) . "/thumb_" . basename($filename));
		}elseif ($type === "image/gif"){
			imagegif($image, dirname($filename) . "/thumb_" . basename($filename));
		}else {
			return false;
		}

		imagedestroy($image);
		imagedestroy($src);

		return dirname($filename) . "/thumb_" . basename($filename);
	}

/**
 * レコード削除前にファイルを削除する
 *
 * @param array $options
 * @return bool
 */
	public function beforeDelete($options = array()) {
		$attachment = $this->findById($this->id);
		if (!empty($attachment[$this->alias]['dir'])) {
			unlink($attachment[$this->alias]['dir']);
		}
		if (!empty($attachment[$this->alias]['thumb_dir'])) {
			unlink($attachment[$this->alias]['thumb_dir']);
		}
		return true;
	}
}
