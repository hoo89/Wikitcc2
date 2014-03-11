<?php
class WikiPagesControllerTest extends ControllerTestCase {
	public $fixtures = array('app.wiki_page','app.category','app.attachment','app.wiki_pages_rev');

	public function testIndex() {
        //$this->testAction('/wiki_pages/public_index',array('method' => 'get'));
        //debug($this->view);
        //debug($this->headers);

        $this->testAction('/wiki_pages/index',array('method' => 'get'));
        debug($this->headers);
        $a = $this->testAction('/wiki_pages/index',array('method' => 'get','return' => 'view'));
        debug($a);
        //$this->assertEquals()
    }

    public function testView() {
        $this->testAction('/wiki_pages/view/Public%20Article');
        debug($this->vars);
    }

    public function testAdd() {
        $a = $this->testAction('/wiki_pages/add',array('method' => 'get','return' => 'view'));
        debug($a);
    }
}
