<?php
class WikiPageFixture extends CakeTestFixture {
		public $import = 'WikiPage';
		public $records = array(
			array('id' => 1, 'title' => 'Public Article', 'body' => 'First Article Body', 'created' => '2007-03-18 10:39:23', 'modified' => '2007-03-18 10:41:31', 'is_public'=> true),
			array('id' => 2, 'title' => 'Private Article', 'body' => 'Second Article Body', 'created' => '2007-03-18 10:41:23', 'modified' => '2007-03-18 10:43:31', 'is_public'=> false),
			array('id' => 3, 'title' => 'BelongToCategory1', 'category_id' => 1),
		);
}