<?php echo doctype('html5'); ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?=empty($title) ? '' : $title . ' | '; ?>GoFruits!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sale and buy fruits and vegetates online.">
    <meta name="author" content="kod3r">

    <!-- styles -->
    <link rel="stylesheet" href="public/css/bootstrap.min.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="public/css/bootstrap-responsive.min.css" type="text/css" media="all"/>
    <link rel="stylesheet/less" href="public/css/styles.less" type="text/css" media="all"/>
    <link rel="stylesheet/less" href="public/css/login.less" type="text/css" media="all"/>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="public/js/html5shiv.js"></script>
    <![endif]-->
    <script type="text/javascript" src="public/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="public/js/less-1.3.3.min.js"></script>

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="public/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="public/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="public/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="public/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="public/ico/favicon.png">
</head>

<body>

<div class="container-fluid">

<form class="form-signin" method="post" action="">
    <h2 class="form-signin-heading">Please sign in</h2>
    <input type="text" class="input-block-level" placeholder="Email address">
    <input type="password" class="input-block-level" placeholder="Password">
    <label class="checkbox">
        <input type="checkbox" value="remember-me"> Remember me
    </label>
    <button class="btn btn-primary" type="submit">Sign in</button>
</form>