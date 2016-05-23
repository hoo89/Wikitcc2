<?php
App::uses('Attachment', 'Model');

/**
 * Attachment Test Case
 */
class AttachmentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.attachment',
		'app.wiki_page',
		'app.category'
	);

/**
 * temporary filename of image for the test
 *
 * @var string
 */
	public $tmpFilename = null;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Attachment = ClassRegistry::init('Attachment');

		$this->tmpFilename = TMP . uniqid() . '.jpg';
		$this->makeTmpJpegImage($this->tmpFilename);
	}

	public function makeTmpJpegImage($filename) {
		if (touch($filename)) {
			$fp = fopen($filename, 'w');
			fwrite($fp, base64_decode($this->encoded_image));
			fclose($fp);
		}
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Attachment);

		if(file_exists($this->tmpFilename)){
			unlink($this->tmpFilename);
		}
		$thumb_filename = dirname($this->tmpFilename)."/thumb_".basename($this->tmpFilename);
		if(file_exists($thumb_filename)){
			unlink($thumb_filename);
		}

		parent::tearDown();
	}

/**
 * testCreateThumnail method
 *
 * @return void
 */
	public function testCreateThumnail() {
		$this->Attachment->createThumnail($this->tmpFilename);

		// assert original image exists
		$this->assertTrue(file_exists($this->tmpFilename));
		$thumb_filename = dirname($this->tmpFilename)."/thumb_".basename($this->tmpFilename);

		// assert thumbnail created
		$this->assertTrue(file_exists($thumb_filename));
	}

	public $encoded_image = '/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0a
HBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIy
MjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAEAAQADASIA
AhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQA
AAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3
ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWm
p6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEA
AwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSEx
BhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElK
U1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3
uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwDdZyRi
oyTmnAZpyoWcYoAltxtGSKo6y+IGA7irztsGKzNV/wCPckjPFAHIxMd7DHGasbiOaqxHMjcd6smg
CSJvmzV2M4AxVGLg1dSgCwGz+NLnketMBp2eKAHjGBRnk03PIoyc0AO3e1NYk80MdvvTBJu4oAeT
0pST6VHv6VJvyuMUAISSc03J4pWOB9aaTQAHkVVnB24q1nNQSjg+ooAsaVOB8hHIrbYFwGHpiuXt
CVugRxXUW7AoKADa232puKnzjio2/SgBu7HFdB4fvFMZt24ZTke4rniD+VLBcPaXKTKeVPPuKALX
jvTJJEiv48ssfDj0HrXIRvuWvWk8rUrAq2GjkWvLNT099J1SW1cHaDuQ+q0AMzzTs5FMHTqKljG7
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';
}
