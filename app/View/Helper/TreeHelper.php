<?php
class TreeHelper extends AppHelper {
    public $helpers = array('Html');
    public function generate($array,$sub_pages=null,$first=true,$id="tree") {
        if (!empty($array)) {
            if($first){
                echo '<ul id="'.$id.'" class="treeview">';
            }else{
                echo '<ul>';
            }

            foreach ($array as $vals) {
                echo "<li id=\"".$vals['Category']['id']."\">".$vals['Category']['name'];
                $this->generate($vals['children'],null,false);
                if(!empty($vals['WikiPage'])){
                    echo '<ul>';
                    foreach ($vals['WikiPage'] as $page){
                        $link = $this->Html->link($page['title'],
                            array('controller' => 'wikiPages', 'action' => 'view', $page['title']));
                        echo "<li>".$link;
                    }
                    echo '</ul>';
                }
                echo "</li>\n";
            }
            
            if($first && !empty($sub_pages)){
                foreach ($sub_pages as $page){
                    $link = $this->Html->link($page['WikiPage']['title'],
                            array('controller' => 'wikiPages', 'action' => 'view', $page['WikiPage']['title']));
                        echo "<li>".$link;
                    }
            }
            echo "</ul>\n";
            if($first){
                $this->Html->scriptBlock('$(document).ready(
                    function(){$("#'.$id.'").treeview({animated:"fast",persist: "cookie"});}
                    );',array('inline'=>false));
            }
        }
    }
}