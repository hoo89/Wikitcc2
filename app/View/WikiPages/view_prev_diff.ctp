<pre class="diff">
<?php
require ROOT . DS . APP_DIR . DS . 'Vendor/autoload.php';
require_once 'Text/Diff.php';
require_once 'Text/Diff/Renderer/inline.php';
require_once 'Text/Diff/Renderer/unified.php';


if(!empty($diff['WikiPage']['body']) && !empty($diff['WikiPage']['body'][1]) && !empty($diff['WikiPage']['body'][0])){
	$old = explode("\n",h($diff['WikiPage']['body'][1]));
	$new = explode("\n",h($diff['WikiPage']['body'][0]));
	$differ = new Text_Diff('auto',array($old,$new));
	$renderer = new Text_Diff_Renderer_unified();
	//$renderer->_leading_context_lines = 10000;
	//$renderer->_trailing_context_lines = 10000;

	$text = $renderer->render($differ);
	//行頭のみ改行を入れない 他は見やすさのため @~~~ の前に改行を入れる
	$text = preg_replace("/^(@.*)/", "<span class=\"info\">\\1</span>", $text);
	$text = preg_replace("/^(@.*)/m", "<br /><span class=\"info\">\\1</span>", $text);
	$text = preg_replace("/^(\+.*)/m", "<span class=\"ins\">\\1</span>", $text);
	$text = preg_replace("/^(-.*)/m", "<span class=\"del\">\\1</span>", $text);
	echo $text;
}
?>
</pre>