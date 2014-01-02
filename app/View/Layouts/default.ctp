<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>
        <?php echo __('CakePHP: the rapid development php framework:'); ?>
        <?php echo $title_for_layout; ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php echo $this->Html->css('cake.generic'); ?>
    <?php echo $this->Html->css('bootstrap.min'); ?>
    <?php echo $this->Html->css('jquery.treeview'); ?>
    <?php echo $this->Html->css('wikitcc'); ?>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <!--
    <link rel="shortcut icon" href="/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">
    -->
    <?php
    echo $this->fetch('meta');
    echo $this->fetch('css');
    ?>
</head>

<body>
    <div class="container-fluid">
        <?php
        if(!$logged_in){
            echo $this->element('header');
        }else{
            if(!empty($page_title)){
                echo $this->element('private_header',compact($page_title));
            }else{
                echo $this->element('private_header');
            }
        }
        ?>

        <div class="row">
            <div class="col-sm-2" id="sidebar">
                <?php
                if(!$logged_in){
                    echo $this->element('sidebar/sidemenu');
                    echo $this->element('sidebar/recent_updates');
                }else{
                    echo $this->element('sidebar/sidemenu');
                    echo $this->element('sidebar/private_recent_updates');
                }
                ?>
            </div>
            
            <div class="col-sm-offset-2 col-md-9 col-sm-10" id="content">
                <div id="content-header">
                <?php
                if(empty($content_title)){
                    $content_title=null;
                }
                echo $this->element('content_header',array('logged_in'=>$logged_in,'content_title'=>$content_title));
                ?>
                </div>
                <?php echo $this->Session->flash('flash', array('element' => 'message')); ?>
                <?php echo $this->fetch('title'); ?>
                <hr>
                <?php echo $this->fetch('content'); ?>
                <hr>
            </div>
        </div>
        <div id="footer">Copyright© KITCC All Rights Reserved. Since 2013 - <?php echo date('Y')?><br/>Powered by Wikitcc2 with CakePHP2.4.4 and PHP5</div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <?php echo $this->Html->script('bootstrap.min'); ?>
    <?php echo $this->Html->script('jquery.treeview'); ?>
    <?php echo $this->Html->script('jquery.cookie'); ?>
    <?php echo $this->fetch('script'); ?>
</body>
</html>
