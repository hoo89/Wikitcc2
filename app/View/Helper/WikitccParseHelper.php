<?php
class WikitccParseHelper extends AppHelper {
	public function parse($view,$text) {
		$wiki = new WikitccParser($text);
		$wiki->view = $view;
		$wiki->webroot = $this->webroot;
		$wiki->parse();
		return $wiki->getText();
	}
}

/**
 * Wikiの文法を解析するクラス
 * 
 * @author bokko
 */
class WikitccParser{

	public $view;
	public $webroot;
	
	/**
	 * @var string 解析するテキスト
	 */
	private $text;
	
	/**
	 * @var string ページのタイトル
	 */
	private $title;
	
	/**
	 * @var string プラグインを適用するファイル
	 */
	private $plugined_file;
	
	/**
	 * Unixスタイルで統一
	 */
	const LINE_FEED = "\n";
	/**
	 * コンストラクタ
	 * @param string $text Wikiテキスト
	 */
	public function WikitccParser($text){
		$this->text = $text;
		//    $this->text = stripslashes($text);
	}
	
	/**
	 * テキストを返す
	 * @return string テキストを返す
	 */
	public function getText(){
		return $this->text;
	}
	
	/**
	 * プラグインを適用するファイルをセット
	 */
	public function setPlugined_file($file){
		$this->plugined_file = $file;
	}

	/**
	 *
	 *
	 */
	public function setTitle($title){
		$this->title = $title;
	}
	
	/**
	 * Wikiテキストを解析し, HTML(tpl)に変換する
	 * 
	 */
	public function parse(){
		$this->defenceScriptInsertion();
		$this->unifyKaigyo();
		$this->addBrTag();
		$this->joinLine();
		$this->rmKaigyo();
		// $this->createEasyPre();
		$this->rmEmpLine();
		$this->createComment();
		$this->createSuperPre();
		$this->createHeadline();
		$this->createQuotation();
		$this->createLink();
		$this->createList('*');
		$this->createList('+');
		$this->createTable();
		$this->createHorizon();
		$this->createMailTo();
		$this->createImg();
		$this->createPlugin();
		$this->createInnerLink();
		$this->rmIgnoreDelimiter();
		$this->createPre();
		
	}
	
	/**
	 * Wikiファイルのタイトルを取得
	 * 
	 * @param string $text Wikiファイルのテキスト
	 */
	public static function getTitle($text){
		if(preg_match("/title:(.+)".WikitccParser::LINE_FEED."/", $text, $ret)){
			$title = $ret[1];
		}
		return $title;
	}
	
	/**
	 * 編集中, Wikiファイルのタイトルを隠す
	 * 
	 * @param string $text Wikiファイルのテキスト
	 */
	public static function hideTitle($text){
		return preg_replace("/title:(.+)".WikitccParser::LINE_FEED."/", "", $text);
	}
	
	/**
	 * Wikiファイルの公開設定を取得
	 */
	public static function getPublicConfig($text){
		if(preg_match("/public_config:(.+)".WikitccParser::LINE_FEED."/", $text, $ret)){
			$public_config = $ret[1];
		}
		
		return $public_config;
	}
	
	/**
	 * 編集中, Wikiファイルの公開設定を隠す
	 * 
	 * @param string $text Wikiファイルのテキスト
	 */
	public static function hidePublicConfig($text){
		return preg_replace("/public_config:(.+)".WikitccParser::LINE_FEED."/", "", $text);
	}
	
	
	/**
	 * 2行連続した空行を1行にする
	 * 
	 */
	private function rmEmpLine(){
		$this->text = preg_replace("/<br \/>".WikitccParser::LINE_FEED."<br \/>".WikitccParser::LINE_FEED."/s", 
								   "<br />".WikitccParser::LINE_FEED, $this->text);
	}
	
	/**
	 * 見出しを作成
	 * 
	 *
	 */
	private function createHeadline(){


		$this->text = preg_replace("/^!!!(.+)#(.+)<br \/>$/m", 
								   "<a name=\"\\2\"><h2 class=\"headline\">\\1</h2></a>", $this->text);
		
		$this->text = preg_replace("/^!!(.*)#(.+)<br \/>$/m", 
								   "<a name=\"\\2\"><h3 class=\"headline\">\\1</h3></a>", $this->text);
		
		$this->text = preg_replace("/^!(.*)#(.+)<br \/>$/m", 
								   "<a name=\"\\2\"><h4 class=\"headline\">\\1</h4></a>", $this->text);
		
		$this->text = preg_replace("/^!!!(.*)<br \/>$/m", 
								   "<h2 class=\"headline\">\\1</h2>", $this->text);
		
		$this->text = preg_replace("/^!!(.*)<br \/>$/m", 
								   "<h3 class=\"headline\">\\1</h3>", $this->text);
		
		$this->text = preg_replace("/^!(.*)<br \/>$/m", 
								   "<h4 class=\"headline\">\\1</h4>", $this->text);

	}
	
	/**
	 * 引用を作成
	 */
	private function createQuotation(){
		$this->text = preg_replace("|".WikitccParser::LINE_FEED.">><br />|", "<blockquote>", $this->text);
		$this->text = preg_replace("|".WikitccParser::LINE_FEED."<<<br />|", "</blockquote>", $this->text);
		$this->text = preg_replace("|".WikitccParser::LINE_FEED.">>|", "<blockquote>".WikitccParser::LINE_FEED, $this->text);
		$this->text = preg_replace("|".WikitccParser::LINE_FEED."<<|", "</blockquote>", $this->text);
	}
	
	/**
	 * リンクを作成
	 * 
	 */
	private function createLink(){
		
		$reg_url = "(https?|ftp):\/\/[-_.!~*\'a-zA-Z0-9;\/?:\@&=+\$,%#]+";
		
		//例:http://www.kitcc.org
		$this->text = preg_replace("/([^\|:<])($reg_url)([^>])/", 
								   "\\1<a href=\"\\2\">\\2</a>\\4", $this->text);
		
		//例:link:KITCC;url:http://www.kitcc.org
		$this->text = preg_replace("/([^<])link:([^;]+);url:($reg_url)([^>])/", 
								   "\\1<a href=\"\\3\">\\2</a>\\5", $this->text);
		
		
		//イメージリンク(仮)
		//例:[image:logo.jpg|http://www.kitcc.org]
		$img_path = $this->webroot."files/attachment/";       
		$this->text = preg_replace("/([^<])\[image:(.+)\|($reg_url)\]([^>])/",
								   "\\1<a href=\"\\3\"><img src=\"$img_path\\2\"></a>\\5", $this->text);
		
		//例:[KITCC|http://www.kitcc.org]
		$this->text = preg_replace("/([^<])\[([^\[]+?)\|($reg_url)\]([^>])/", 
								   "\\1<a href=\"\\3\">\\2</a>\\5", $this->text);
		
		//ページ内リンク
		//例:[KITCC|#kitcc]
		$this->text = preg_replace("/([^<])\[([^\[]+?)\|#(.+)\]([^>])/",
								   "\\1<a href=\"#\\3\">\\2</a>\\4", $this->text);
		
	}
	
	/**
	 * コメントを作成
	 * 
	 */
	private function createComment(){
		
		$text = "";
		$lines = explode(WikitccParser::LINE_FEED, $this->text);
		$is_spre = false;                       //スーパーpre記法内か?
		
		//スーパーpre記法内のコメントは除去する
		foreach($lines as $line){
			if(preg_match("/^>\|\|(.*)/", $line)){
				$is_spre = true;
			}
			elseif(preg_match("/^\|\|</", $line)){
				$is_spre = false;
			}
			if($is_spre){
				$text .= $line.WikitccParser::LINE_FEED;
			}
			else{
				//複数行コメント
				$line = preg_replace("/^\/\*/", "<!--", $line);
				$line = preg_replace("/^\*\/<br \/>/", "-->", $line);
				//一行コメント
				$line = preg_replace("/^\/\/(.*)/", "<!-- \\1 -->", $line);
				$text .= $line.WikitccParser::LINE_FEED;
			}
		}
		$this->text = $text;
	}
	
	/**
	 * リストを作成
	 * 
	 */
	private function createList($sl){
		$text = "";
		$lines = explode(WikitccParser::LINE_FEED, $this->text);
		$in_list_flag = false;
		$is_spre = false;
		
		if($sl === '*'){
			$lt = "<ul>";
			$rt = "</ul>";
		}
		else if($sl === '+'){
			$lt = "<ol>";
			$rt = "</ol>";
		}
		
		$ii = 0;
		foreach($lines as $line){
			if(!$in_list_flag){//リストの外
				if(preg_match("/^<pre>/", $line)){
					$is_spre = true;
				}
				elseif(preg_match("/^<\/pre>/", $line)){
					$is_spre = false;
				}
				if(preg_match("/^\\$sl/", $line) && $is_spre == false){//リストの開始
					$in_list_flag = true;
					$line = preg_replace("|<br />|", "", $line);
					$a_num = strspn($line, $sl);
					$line = substr($line, strspn($line, $sl), strlen($line)-1); //*,+の除去
					for($i=0;$i<$a_num;$i++){$text .= $lt.WikitccParser::LINE_FEED;}
					$text .= "<li>".$line;
				}
				else{$text .= $line.WikitccParser::LINE_FEED;}
			}
			else{//リストの中
				$a_num_before = strspn($lines[$ii-1], $sl);//前の行の+,*の数
				$a_num_current = strspn($line, $sl);//現在処理している行の*,+の数
				$a_num_next = strspn($lines[$ii+1], $sl);//次の行の+,*の数
				
				if(!preg_match("/^\\$sl/", $line)){//リストの終了
					$in_list_flag = false;
					$text .= "</li>".WikitccParser::LINE_FEED;
					for($i=0;$i<$a_num_before-1;$i++){
						$text .= "$rt</li>".WikitccParser::LINE_FEED;
					}
					$text .= $rt.WikitccParser::LINE_FEED;
					$text .= $line.WikitccParser::LINE_FEED;
				}
				else{
					$line = preg_replace("|<br />|", "", $line);
					$line = substr($line, $a_num_current, strlen($line)-$a_num_current);//*,+の除去
					if($a_num_before < $a_num_current){
						$n = $a_num_current - $a_num_before;
						for($i=0;$i<$n;$i++){
							$text .= "$lt".WikitccParser::LINE_FEED;
						}
						if($a_num_current < $a_num_next && $a_num_next != 0){$text .= "<li>".$line;}
						else{$text .= "<li>".$line."</li>".WikitccParser::LINE_FEED;}
					}
					else if($a_num_before > $a_num_current){
						$n = $a_num_before - $a_num_current;
						for($i=0;$i<$n;$i++){
							$text .= "</li>$rt";
						}
						if($a_num_current < $a_num_next && $a_num_next != 0){$text .= "<li>".$line.WikitccParser::LINE_FEED;}
						else{$text .= "<li>".$line."</li>".WikitccParser::LINE_FEED;}
					}
					else{
						if($a_num_current == $a_num_next && $a_num_next != 0){$text .= "<li>".$line."</li>".WikitccParser::LINE_FEED;}
						else{$text .= "<li>".$line;}
					}
				}
			}
			$ii++;
		}
		$this->text = $text;
	}
	
	/**
	 * テーブルを作成
	 * 
	 */
	private function createTable(){
		
		$in_table_flag = false;
		$is_header = true;
		$text = "";
		$lines = explode(WikitccParser::LINE_FEED, $this->text);
		$is_spre = false;
		
		foreach($lines as $line){
			if(preg_match("/^<pre>/", $line)){
				$is_spre = true;
			}
			elseif(preg_match("/^<\/pre>/", $line)){
				$is_spre = false;
			}
			if(preg_match("/^,/", $line) && $is_spre == false){
				$in_table_flag = true;
				if($is_header){
					$text .= '<table  class="table table-bordered">'.WikitccParser::LINE_FEED.'<tr>';
					$tag = "th";
				}
				else{
					$tag = "td";
				}
				$is_header = false;
				$elements = explode(",", $line);
				for($i=1;$i<count($elements);$i++){
					$n = count($elements) - 1;//テーブルのセル数
					if(preg_match("/\[(col|row):(.*)\]/", $elements[$i], $ret)){
						$elements[$i] = preg_replace("/\[(col|row):.*\]/", "", $elements[$i]);
						if(is_numeric(strval($ret[2]))){ $num = $ret[2]; }
						else{ $num = 0;}
						if($ret[1] === "col"){ $span = "colspan"; }
						elseif($ret[1] === "row"){ $span = "rowspan"; }
						$text .= "<$tag $span=\"$num\">".$elements[$i]."</$tag>";
					}
					else{
						$text .= "<$tag>".$elements[$i]."</$tag>";
					}
				}
				$text .= "</tr>".WikitccParser::LINE_FEED;
			}
			else{
				if($in_table_flag){
					$text .= "</table>";
				}
				$in_table_flag = false;
				$is_header     = true;
				$text .= $line.WikitccParser::LINE_FEED;
			}
		}
		$this->text = $text;
	}
	
	/**
	 * 水平線(hrタグ)生成
	 * 
	 */
	private function createHorizon(){
		$this->text = preg_replace("/".WikitccParser::LINE_FEED."\-\-\-\-<br \/>/", WikitccParser::LINE_FEED."<hr />", $this->text);
	}
	
	/**
	 * mailto:記法
	 * 
	 */
	private function createMailTo(){
		
		//例:bokko@kitcc.org
		$reg = "/([^\|<])mailto:([a-zA-Z0-9_\.\-]+?@[A-Za-z0-9_\.\-]+)([^>])/";
		$this->text = preg_replace($reg, "\\1<a href=\"mailto:\\2\">\\2</a>\\3", $this->text);
		
		//例:[bokko|bokko@kitcc.org]
		$reg = "mailto:([a-zA-Z0-9_\.\-]+?@[A-Za-z0-9_\.\-]+)";
		$this->text = preg_replace("/([^<])\[([^\[]+?)\|($reg)\]([^>])/", "\\1<a href=\"\\3\">\\2</a>\\5", $this->text);
	}
	
	/**
	 * pre記法
	 * 
	 */
	private function createPre(){
		
		$text = "";
		$lines = explode(WikitccParser::LINE_FEED, $this->text);
		$in = false;
		
		foreach($lines as $line){
			if($in){
				$text .= preg_replace("/<br \/>/", "", $line).WikitccParser::LINE_FEED;
			}
			else{
				$text .= $line.WikitccParser::LINE_FEED;
			}
			if(preg_match("/^>\|<br \/>/", $line)){
				$in = true;
				$text = preg_replace("/>\|<br \/>/", "<pre>", $text);
			}
			elseif(preg_match("/^\|</", $line)){
				$in = false;
				$text = preg_replace("/".WikitccParser::LINE_FEED."\|</", WikitccParser::LINE_FEED."</pre>", $text);
			}
		}
		
		$this->text = $text;
	}
	
	/**
	 * pre記法簡易版
	 * 
	 */
	private function createEasyPre(){
		
		$text = "";
		$lines = explode(WikitccParser::LINE_FEED, $this->text);
		$in = false;
		
		foreach($lines as $line){
			if($in == false && preg_match("/^\s\S+/", $line)){
				$in = true;
				$line = preg_replace("/^\s/", "<pre>".WikitccParser::LINE_FEED, $line);
			}
			elseif($in == true && preg_match("/^[^\s]/", $line)){
				$in = false;
				$line = preg_replace("/(^.)/", "</pre>".WikitccParser::LINE_FEED."\\1", $line);
				$line = preg_replace("/<br \/>/", "", $line).WikitccParser::LINE_FEED;
			}
			if($in){
				$line =  preg_replace("/^\s/", "", $line);
				$text .= preg_replace("/<br \/>/", "", $line).WikitccParser::LINE_FEED;
			}
			else{
				$text .= $line.WikitccParser::LINE_FEED;
			}
		}       
		$this->text = $text;
	}
	
	/**
	 * スーパーpre記法
	 * 
	 */
	private function createSuperPre(){
		
		$text = "";
		$lines = explode(WikitccParser::LINE_FEED, $this->text);
		$in = false;
		$reg_url = "(https?|ftp):\/\/[-_.!~*\'a-zA-Z0-9;\/?:\@&=+\$,%#]+";
		$modes = array("aa" => false);

		foreach($lines as $line){
			if($in){
				$line = preg_replace("/<br \/>/", "", $line).WikitccParser::LINE_FEED;
				if(!preg_match("/^\|\|</", $line)){
					$line = htmlspecialchars($line, ENT_QUOTES);
					$line = preg_replace("/($reg_url)/", "<\\1>", $line);
					$line = preg_replace("/(\[[^\[]+?\|#.+\])/", "<\\1>", $line);
					$line = preg_replace("/(\[[^\[]+?\|mailto:[a-zA-Z0-9_\.\-]+?@[A-Za-z0-9_\.\-]+\])/", "<\\1>", $line);
					$line = preg_replace("/(mailto:[a-zA-Z0-9_\.\-]+?@[A-Za-z0-9_\.\-]+)/", "<\\1>", $line);
					$line = preg_replace("/(\[image:[^\[]+\])/", "<\\1>", $line);
					$line = preg_replace("/(\{\{[^\{ ]*\}\})/", "<\\1>", $line);
					$line = preg_replace("/(\{\{[^\{]* [^\{]*\}\})/", "<\\1>", $line);
					$line = preg_replace("/(\[\[([^\[])+\]\])/", "<\\1>", $line);
					$text .= $line;
				}
			}
			elseif($modes["aa"]){
				if(!preg_match("/^\|\|</", $line)){
					$line = preg_replace("/<br \/>/", "", $line);
					$line = htmlentities($line, ENT_NOQUOTES, 'UTF-8');
					$line .= "<br />";
				}
				$text .= $line.WikitccParser::LINE_FEED;
			}
			else{
				$text .= $line.WikitccParser::LINE_FEED;
			}
			if(preg_match("/^>\|\|/", $line)){
				$in = true;
				$text = preg_replace("/>\|\|<br \/>/", "<pre>", $text);
			}
			elseif(preg_match("/^>\|(.+)\|/", $line, $mode)){
				$mode = $mode[1];
				if($mode === "aa"){
					$text = preg_replace("/>\|aa\|<br \/>/", "<div class=\"aa\">", $text);
					$modes["aa"] = true;
				}
				else{
					$text = preg_replace("/>\|(.+)\|<br \/>/", "<div>", $text);
				}
			}
			elseif(preg_match("/^\|\|</", $line)){
				$mode = null;
				if($in){
					$text .= preg_replace("/^\|\|</", "</pre>", $line);
					$in = false;
				}
				if($modes["aa"]){
					$modes["aa"] = false;
					$text = preg_replace("/".WikitccParser::LINE_FEED."\|\|</", WikitccParser::LINE_FEED."</div>", $text);
				}
			}
		}       
		$this->text = $text;
	}
	
	/**
	 * image記法
	 * [image:ファイル名]
	 */
	private function createImg(){
		// must fix change path
		$img_path = $this->webroot."files/attachment/";
		$this->text = preg_replace("/([^<])\[image:([^\[]+)\]([^>])/", 
								   "\\1<a href=\"$img_path\\2\"><img src=\"$img_path\\2\"></a>\\3",
								   $this->text);
	}
	
	/**
	 * プラグイン記法
	 * 
	 * {{プラグイン名 引数}}
	 */
	private function createPlugin(){
		$view=$this->view;
		$callback = function ($matches) use ($view){
			$plugin = basename($matches[2]);
			if(!$view->elementExists('plugin/'.$plugin)){
				return $matches[1].('Not Found!').$matches[4];
			}else{
				return $matches[1].$view->element('plugin/'.$plugin).$matches[4];
			}
		};
		$this->text = preg_replace_callback("/([^<])\{\{([^\{ ]*)()\}\}([^>])/",
								   $callback,
								   $this->text);
		
		$this->text = preg_replace_callback("/([^<])\{\{([^\{]*) ([^\{]*)\}\}([^>])/",
								   $callback,
								   $this->text);
	}
	
	/**
	 * 記法を<>で囲んだ部分の<>を取り除く(<と>で囲まれた記法はパースされない)
	 * 無視する記法はリンク記法, mailto記法, img記法
	 * あとの記法は, 前に空白を入れるなどして対処してください。
	 * 例:<mailto:bokko@kitcc.org>
	 */
	private function rmIgnoreDelimiter(){
		
		$reg_url = "(https?|ftp):\/\/[-_.!~*\'a-zA-Z0-9;\/?:\@&=+\$,%#]+";      
		
		$this->text = preg_replace("/<($reg_url)>/",
								   "\\1", $this->text);
		$this->text = preg_replace("/<(link:[^;]+;url:$reg_url)>/", 
								   "\\1", $this->text);
		$this->text = preg_replace("/<(\[[^\[]+?\|$reg_url\])>/", 
								   "\\1", $this->text);
		$this->text = preg_replace("/<(\[[^\[]+?\|#.+\])>/",
								   "\\1", $this->text);
		$this->text = preg_replace("/<(mailto:[a-zA-Z0-9_\.\-]+?@[A-Za-z0-9_\.\-]+)>/", 
								   "\\1", $this->text);
		$this->text = preg_replace("/<(\[[^\[]+?\|mailto:[a-zA-Z0-9_\.\-]+?@[A-Za-z0-9_\.\-]+\])>/", 
								   "\\1", $this->text);
		$this->text = preg_replace("/<(\[image:[^\[]+\])>/", 
								   "\\1", $this->text);
		$this->text = preg_replace("/<(\{\{[^\{ ]*\}\})>/", 
								   "\\1", $this->text);
		$this->text = preg_replace("/<(\{\{[^\{]* [^\{]*\}\})>/", 
								   "\\1", $this->text);
		$this->text = preg_replace("/<(\/\/)>/", 
								   "\\1", $this->text);
		$this->text = preg_replace("/<(\[\[([^\[]+)\]\])>/", 
								   "\\1", $this->text);
	}
	
	/**
	 * Script Insertionを防御
	 */
	private function defenceScriptInsertion(){
		$callback = function ($matches) {
			return h($matches[1]);
		};

		$this->text = strip_tags($this->text,'<b><br><em><span><i><s><u><strong><small>');
		$this->text = preg_replace("/(<[^\\/]*?(br|b|em|span|u|strong|small|s).*?>)/", "<\\2>", $this->text);

		//$this->text = preg_replace_callback("/(<script.*>.*?<\/script>)/", $callback, $this->text);
		
		//$this->text = preg_replace_callback("/(<style.*>.*?<\/style>)/", $callback, $this->text);
	}
	
	/**
	 * 内部リンク作成
	 * 
	 */
	private function createInnerLink(){
		//$dir = Config::GetInnerLinkIndexDir();
		$text = "";
		$lines = explode(WikitccParser::LINE_FEED, $this->text);
		/*
		$f = create_function('$dir,$file,&$filename,$f', 
							 'if(!is_dir($dir."/".$file)){
								  if($filename === preg_replace("/:.+$/", "", $file)){
									  if($fp = fopen($dir."/".$file, "r")){
										  flock($fp, LOCK_SH);
										  $link = fgets($fp);
										  flock($fp, LOCK_UN);
										  fclose($fp);
										  $filename = $link;
									  }
								  }
							  }
							  else{
								  divGeneric($dir."/".$file, $f, $filename);
							  }
							 ');*/

		foreach($lines as $line){
			if(preg_match_all("/\[\[([^\[]+)\]\]/", $line, $titles)){
				foreach($titles[1] as $title){
					$line = preg_replace("/\[\[$title\]\]([^>])/u", 
										 '<a href='.$this->webroot.'wiki/'.h($title).'>'.h($title).'</a>\\1', $line);                    
				}
			}
			$text .= $line.WikitccParser::LINE_FEED;
		}
		$this->text = $text;
	}
	/**
	 * 改行の前にbrタグをはさむ
	 * 
	 */
	private function addBrTag(){
		$this->text = nl2br($this->text);
	}
	
	/**
	 * 行を結合
	 * 
	 */
	private function joinLine(){
		$this->text = preg_replace("/ \\\\\\\\<br \/>".WikitccParser::LINE_FEED."/m", "", $this->text);
	}
	
	/**
	 * 改行を取り除く
	 * 
	 * 
	 */
	private function rmKaigyo(){
		$this->text = preg_replace("/ \\\\<br \/>".WikitccParser::LINE_FEED."/m", "<br />", $this->text);
	}
	
	/**
	 * 改行コードを統一する
	 * 
	 */
	private function unifyKaigyo(){
		$this->text = preg_replace("!\r\n?!", WikitccParser::LINE_FEED, $this->text);
	}
}
