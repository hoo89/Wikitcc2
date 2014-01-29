<?php
$this->set('channel', array (
    'title' => '京都工芸繊維大学コンピュータ部',
    'link' => '/',
    'description' => '京都工芸繊維大学コンピュータ部のウェブページ'
));
echo $this->Rss->items($wikiPages, 'transformRSS');
function transformRSS($wikiPage) {
    return array(
        'title' => $wikiPage['WikiPage']['title'],
        'link' => array('action' => 'view', $wikiPage['WikiPage']['title']),
        'guid' => array('action' => 'view', $wikiPage['WikiPage']['title']),
        'description' => nl2br(h($wikiPage['WikiPage']['body'])),
        'pubDate' => $wikiPage['WikiPage']['modified']
    );
}