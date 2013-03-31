<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title>Administration: <?= $this->title ?> </title>
    <meta name="description" content="<?= $this->pageDescription ?>">
    <!-- Mobile viewport optimisation -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- (en) Add your meta data here -->
    <!-- (de) Fuegen Sie hier ihre Meta-Daten ein -->

    <link href="/<?= Bootstrap::getBasePath() ?>css/yaml.css" rel="stylesheet" type="text/css" />
    <!--[if lte IE 7]>
    <link href="/<?= Bootstrap::getBasePath() ?>css/yaml/core/iehacks.css" rel="stylesheet" type="text/css" />
    <![endif]-->

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="/<?= Bootstrap::getBasePath() ?>css/ui-lightness/jquery-ui-1.9.0.custom.min.css">
    <link rel="stylesheet" href="/<?= Bootstrap::getBasePath() ?>css/jquery.loadmask.css" />
    <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

    <!-- All JavaScript at the bottom, except this Modernizr build.
Modernizr enables HTML5 elements & feature detects for optimal performance.
Create your own custom Modernizr build: www.modernizr.com/download/ -->
    <script src="/<?= Bootstrap::getBasePath() ?>js/libs/modernizr-2.5.3.min.js"></script>
    <script src="/<?= Bootstrap::getBasePath() ?>js/libs/tiny_mce/tiny_mce.js"></script>
</head>
<body>
<header>
    <div class="ym-wrapper">
        <div class="ym-wbox">
            <h1><?= $this->title ?></h1>
            <p><?= $this->pageDescription ?></p>
        </div>
    </div>
</header>
<div id="main">