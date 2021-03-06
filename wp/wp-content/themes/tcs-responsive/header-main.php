<?php
/**
 * @file
 * Copyright (C) 2015 TopCoder Inc., All Rights Reserved.
 * @author TCSASSEMBLER, ecnu_haozi
 * @version 1.2
 *
 * This header-main page.
 *
 * Changed in 1.1
 * Add a configurable variable 'myFiltersURL' to support "My filters" feature.
 *
 * Changed in 1.2 (topcoder new community site - Removal proxied API calls)
 * Removed LC related constants
 */

session_start();
/***
 * since staging or localhost could not use tcsso cookie,
 * then create dummy "tcsso" cookie at first time, only ON localhost OR staging server.
 * please remove/disable line below on Prod
 */
//setcookie("tcsso", "22760600|22554c24d30b15fd79289dd053a9a98e5ff385535dd6cc9b45e645fbabb0a4" );

/***
 * if receive ?auth=logout, then kill cookie and any other sessions
 */
if (isset($_GET['auth']) && $_GET['auth'] == 'logout') {
  unset($_COOKIE['tcsso']);
  setcookie('tcsso', '', time() - 3600, '/', '.topcoder.com');
  unset($_COOKIE['tcjwt']);
  setcookie('tcjwt', '', time() - 3600, '/', '.topcoder.com');

  /***
   * kill any other sessions or cookie here
   */
  unset($coder);
  session_destroy();
  /***
   * then send back user to where they came
   */
  if ($_SERVER['HTTP_REFERER']) {
    echo "redirecting ... <script>location.href = '" . $_SERVER['HTTP_REFERER'] . "';</script>";
  }
  exit;

}
if (basename(get_permalink()) == "challenges") {
?>
<!DOCTYPE html>
<html lang="en" data-ng-app="tc">
<head>
  <meta charset="utf-8">
  <meta name="fragment" content="!">
  <title ng-bind="pageTitle"></title>
  <meta name="description" content="">
<?php
} else if (basename(get_permalink()) == "angular-challenge-details") {
?>
<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/Article" ng-app="challengeDetails"  ng-controller="CDCtrl as CD">
<head>
  <meta charset="utf-8">
  <meta name="fragment" content="!">
  <title>{{CD.challenge.challengeName}}</title>
  <meta name="description" content="{{CD.challenge.detailedRequirements | htmlToText | limitTo: 155}}">

  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="{{CD.challenge.challengeName}}">
  <meta itemprop="description" content="{{CD.challenge.detailedRequirements | htmlToText }}">

  <!-- Twitter Card data -->
  <meta name="twitter:site" content="@topcoder">
  <meta name="twitter:title" content="{{CD.challenge.challengeName}}">
  <meta name="twitter:description" content="{{CD.challenge.detailedRequirements | htmlToText | limitTo: 200}}">
  <meta name="twitter:creator" content="@topcoder">

  <!-- Open Graph data -->
  <meta property="og:title" content="{{CD.challenge.challengeName}}" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="{{CD.challenge.url}}" />
  <meta property="og:description" content="{{CD.challenge.detailedRequirements | htmlToText}}" />
  <meta property="og:site_name" content="topcoder" />
  <meta property="article:published_time" content="{{CD.challenge.postingDate}}" />

<?php
} else if (basename(get_permalink()) == "account") {
?>
<!DOCTYPE html>
<html lang="en" ng-app="tc.profileBuilder" ng-controller="profileBuilderCtrl as PB">
<head>
  <meta charset="utf-8">
  <meta name="fragment" content="!">
  <title ng-bind="PB.pageTitle"></title>
  <meta name="description" content="TopCoder Profile Builder">
<?php
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="fragment" content="!">
  <title><?php wp_title(' - ', TRUE, 'right'); ?></title>
  <meta name="description" content="">
<?php
}
?>
  <meta name="author" content="@topcoder" >
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />
  <meta name="apple-mobile-web-app-capable" content="yes" />

  <!-- Favicons -->
  <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" />

  <?php $ver = (get_option('jsCssVersioning') == 1); $v = get_option('jsCssCurrentVersion'); ?>
  <!-- External JS -->
  <!--[if lt IE 9]>
  <script src="<?php THEME_URL ?>/js/html5shiv.js" type="text/javascript"></script>
  <script src="<?php THEME_URL ?>/js/respond.min.js" type="text/javascript"></script>
  <script src="<?php THEME_URL ?>/js/modernizr.js" type="text/javascript"></script>
  <link rel = "stylesheet" href = "<?php THEME_URL ?>/css/ie.css<?php if ($ver) { echo " ? v = $v"; } ?>" / >
  <![endif]-->
  <script type="text/javascript">
    var wpUrl = "<?php bloginfo('wpurl')?>";
    var tcApiRUL = '<?php echo TC_API_URL; ?>';
    var myFiltersURL = '<?php echo MY_FILERS_URL ?>';
    var siteURL = '<?php bloginfo('siteurl');?>';
    var communityURL = '<?php echo community_URL(); ?>';
    var base_url = '<?php bloginfo( 'stylesheet_directory' ); ?>';
    var stylesheet_dir = '<?php echo THEME_URL . '/css'; ?>';
    var autoRegister = '<?php echo get_query_var('autoRegister'); ?>';
    var timezone_string = "<?php echo get_option('timezone_string');?>";
    var challengeType;
    var cbApiURL = '<?php echo CB_URL; ?>';
  </script>

<?php

wp_head();


$urlLogout = add_query_arg('auth', 'logout', get_bloginfo('wpurl'));

fixIERoundedCorder();
