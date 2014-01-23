<?php
 
class WikiPageShell extends AppShell
{
	var $uses = array('WikiPage');
	public function startup()
	{
		parent::startup();
		$this->Wikipage = new WikiPage();
	}
 
	public function create()
	{
		if(!isset($this->args[0])) {
			$this->out('require filename');
			return;
		}
		$page = file_get_contents($this->args[0]);
		if(empty($page)){
			$this->out('invalid or empty file');
			return;
		}
		$title = $this->getTitle($page);
		$isPublic = $this->getIsPublic($page);

		$post = $this->WikiPage->findByTitle($title);
		if($post){
             	$this->WikiPage->id = $post['WikiPage']['id'];
         }

         $mtime = date('Y-m-d H:i:s', filemtime($this->args[0]));
         $data = array('WikiPage'=>array('title'=>$title,'is_public'=>$isPublic,'body'=>trim($page),'modified'=>$mtime,'created'=>$mtime,'category_id'=>3));
         if($this->WikiPage->save($data)){
         	$this->out('data saved');
         }else{
         	$this->out('data is not saved');
         }

	}

	function getTitle(&$text){
		if(preg_match("/title:(.+)\n/", $text, $ret)){
            $title = $ret[1];
        }
        $text = preg_replace("/title:(.+)\n/", "", $text);
        return $title;

	}
	function getIsPublic(&$text){
		if(preg_match("/public_config:(.+)\n/", $text, $ret)){
            $public_config = $ret[1];
        }
        $text = preg_replace("/public_config:(.+)\n/", "", $text);

        if($public_config === 'inner'){
        	$public_config = 0;
        }else{
        	$public_config = 1;
        }
        return $public_config;
	}
 
}