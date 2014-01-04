<pre class="diff">
<?php
require_once 'Text/Diff.php';
require_once 'Text/Diff/Renderer/inline.php';
require_once 'Text/Diff/Renderer/unified.php';

//print_r($diff);
$old = explode("\n",h($diff['WikiPage']['body'][1]));
$new = explode("\n",h($diff['WikiPage']['body'][0]));
$differ = new Text_Diff('auto',array($old,$new));
$renderer = new Text_Diff_Renderer_unified();
//$renderer->_leading_context_lines = 10000;
//$renderer->_trailing_context_lines = 10000;

$text = $renderer->render($differ);
//頭のみ改行を入れない
$text = preg_replace("/^(@.*)/", "<span class=\"info\">\\1</span>", $text);
$text = preg_replace("/^(@.*)/m", "<br><span class=\"info\">\\1</span>", $text);
$text = preg_replace("/^(\+.*)/m", "<span class=\"ins\">\\1</span>", $text);
$text = preg_replace("/^(-.*)/m", "<span class=\"del\">\\1</span>", $text);
echo $text;
?>
</pre>