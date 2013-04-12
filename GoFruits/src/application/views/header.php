<?php echo doctype('html5'); ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?=empty($title) ? '' : $title . ' | '; ?>GoFruits!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sale and buy fruits and vegetates online.">
    <meta name="author" content="kod3r">

    <!-- styles -->
    <link rel="stylesheet" href="<?=base_url();?>public/css/bootstrap.min.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="<?=base_url();?>public/css/bootstrap-responsive.min.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="<?=base_url();?>public/css/style.css" type="text/css"/>
    <!--<link rel="stylesheet" href="<?/*=base_url();*/?>public/css/style_002.css" type="text/css" media="all"/>-->
    <link rel="stylesheet/less" href="<?=base_url();?>public/css/styles.less" type="text/css" media="all"/>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="<?=base_url();?>public/js/html5shiv.js"></script>
    <![endif]-->
    <script type="text/javascript" src="<?=base_url();?>public/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>public/js/less-1.3.3.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>public/js/OpenLayers.js"></script>
    <script type="text/javascript" src="<?=base_url();?>public/js/MapController.js"></script>

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?=base_url();?>public/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?=base_url();?>public/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?=base_url();?>public/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?=base_url();?>public/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="<?=base_url();?>public/ico/favicon.png">

</head>

<body onload="init()">

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?=anchor('/', 'GoFruits!', array('class' => 'brand'));?>

            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="active"><?=anchor('/', 'Home'); ?></li>
                    <li><?=anchor('about', 'About'); ?></li>
                    <li><?=anchor('contact', 'Contact'); ?></li>
                </ul>
                <form class="navbar-form pull-right">
                    <input class="span2" type="text" placeholder="Email">
                    <input class="span2" type="password" placeholder="Password">
                    <button type="submit" class="btn">Sign in</button>
                </form>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>

<div class="container-fluid">