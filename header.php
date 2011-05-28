<?php require_once(dirname(__FILE__).'/users/users.php');

if (!isset($TITLE)) {
	$TITLE = null;
}
if (!isset($SECTION)) {
	$SECTION = null;
}

if (!isset($current_user)) {
	$current_user = User::get();
}

?><!DOCTYPE HTML>
<html version="HTML+RDFa 1.1" lang="en"
	xmlns:og="http://opengraphprotocol.org/schema/"
	xmlns:fb="http://developers.facebook.com/schema/"
>
<head>
<title><?php if (isset($TITLE)) { echo htmlentities($TITLE).' | '; } ?>Show Slow</title>
<?php if ($homePageMetaTags && $SECTION == 'home') { echo $homePageMetaTags; } ?>
<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo assetURL('favicon.ico')?>"> 
<link rel="apple-touch-icon" href="<?php echo assetURL('showslow_iphone_icon.png')?>" /> 

<style type="text/css">
/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.8.1
*/
body{font:13px/1.231 arial,helvetica,clean,sans-serif;*font-size:small;*font:x-small;}select,input,button,textarea,button{font:99% arial,helvetica,clean,sans-serif;}table{font-size:inherit;font:100%;}pre,code,kbd,samp,tt{font-family:monospace;*font-size:108%;line-height:100%;}

body {
	margin:0;
	background-color: #98993D;
}

#header {
	padding: 1px;
	height: 60px;
	border-bottom: 2px solid black;
	margin: 0;
}

#header a {
	color: #403300;
}

#menu {
	background-color: #261F00;
	border-bottom: 2px solid black;
}

#menu a {
	color: #FFDE4C;
	padding: 0.6em;
	text-decoration: none;
	font-weight: bold;
	white-space: nowrap;
}

#menu a:hover {
	background-color: #7F6F26;
	color: black;
}

#menu a.current {
	background-color: #7F6F26;
	color: white;
}

#menu td {
	padding: 0.1em 0.1em;
}

#footer {
	border-top: 2px solid black;
	padding: 5px;
	font-size: smaller;
}

#title {
	color: black; 
	text-decoration: none;
	padding: 0 0.5em;
}

#main {
	padding: 1px 1em 1em 1em;
	background: white;
}

#poweredby {
	float: right;
}

#navbox {
	float: right;
	margin-right: 1em;
}

td, th { white-space: nowrap; }

.score {
	text-align: right;
	padding: 0 10px 0 10px;
}

.gbox {
	background-color: #EFEFEF;
	background: -webkit-gradient(linear, left top, left bottom, from(#EFEFEF), to(#CFCFCF));
	background: -moz-linear-gradient(top, #EFEFEF, #CFCFCF);
	width: 101px;	
}

.moreinfo {
	width: 14px;
	height: 14px;
	background-image: url('<?php echo assetURL('info.png')?>');
}
.ccol {
	background-image: url('<?php echo assetURL('collecting.gif')?>')
}

.url {
	padding-left:10px;
}

.bar {
	height: 15px;
}

h2 {
	margin: 0.5em 0 0.3em 0;
}

<?php for($i=1; $i<=count($colorSteps); $i++) {?>
.c<?php echo $i; ?> {
	background: #<?php echo $colorSteps[$i-1]; ?>;
	background: -webkit-gradient(linear, left top, left bottom, from(#<?php echo $colorSteps[$i-1]; ?>), to(#<?php echo $colorStepShades[$i-1]; ?>));
	background: -moz-linear-gradient(top, #<?php echo $colorSteps[$i-1]; ?>, #<?php echo $colorStepShades[$i-1]; ?>);
}
<?php } ?>
</style>

<?php
if (isset($STYLES)) {
	foreach ($STYLES as $_style) {
		?><link rel="stylesheet" type="text/css" href="<?php echo $_style; ?>"/><?php
	}
}

if (isset($SCRIPTS)) {
	foreach ($SCRIPTS as $_script) {
		if (is_array($_script)) {
			if (array_key_exists('condition', $_script)) {
				?><!--[<?php echo $_script['condition'] ?>]><script type="text/javascript" src="<?php echo $_script['url']; ?>"></script><![endif]-->
<?php
			}
		} else {
			?><script type="text/javascript" src="<?php echo $_script; ?>"></script>
<?php
		}
	}
}

if ($kissMetricsKey) {
?><script type="text/javascript">
  var _kmq = _kmq || [];
  function _kms(u){
    setTimeout(function(){
      var s = document.createElement('script'); var f = document.getElementsByTagName('script')[0]; s.type = 'text/javascript'; s.async = true;
      s.src = u; f.parentNode.insertBefore(s, f);
    }, 1);
  }
  _kms('//i.kissmetrics.com/i.js');_kms('//doug1izaerwt3.cloudfront.net/<?php echo $kissMetricsKey ?>.1.js');
</script>
<?php
}

if ($showFeedbackButton) {?>
<script type="text/javascript">
var uservoiceOptions = {
  /* required */
  key: 'showslow',
  host: 'showslow.uservoice.com', 
  forum: '18807',
  showTab: true,  
  /* optional */
  alignment: 'right',
  background_color:'#f00', 
  text_color: 'white',
  hover_color: '#06C',
  lang: 'en'
};

function _loadUserVoice() {
  var s = document.createElement('script');
  s.setAttribute('type', 'text/javascript');
  s.setAttribute('src', ("https:" == document.location.protocol ? "https://" : "http://") + "cdn.uservoice.com/javascripts/widgets/tab.js");
  document.getElementsByTagName('head')[0].appendChild(s);
}
_loadSuper = window.onload;
window.onload = (typeof window.onload != 'function') ? _loadUserVoice : function() { _loadSuper(); _loadUserVoice(); };
</script>
<?php } ?>
<?php if ($googleAnalyticsProfile && !excludeGoogleAnalytics()) {?>
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', '<?php echo $googleAnalyticsProfile ?>']);
_gaq.push(['_setAllowAnchor', true]);
_gaq.push(['_setCustomVar', 1, 'User Type', <?php if (is_null($current_user)) { ?>'Anonymous'<?php }else{ ?>'Member'<?php } ?>, 2]);
_gaq.push(['_trackPageview']);
_gaq.push(['_trackPageLoadTime']);

(function() {
var ga = document.createElement('script');
ga.src = ('https:' == document.location.protocol ?
    'https://ssl' : 'http://www') +
    '.google-analytics.com/ga.js';
ga.setAttribute('async', 'true');
document.documentElement.firstChild.appendChild(ga);
})();
</script>
<?php }?>
</head>
<body class="yui-skin-sam">
<div id="header">
	<a href="<?php echo $showslow_base ?>"><img src="<?php echo assetURL('showslow_icon.png')?>" style="float: right; padding: 0.2em; margin-left: 1em; border: 0"/></a>
	<div id="poweredby">powered by <a href="http://www.showslow.org/">showslow</a></div>

	<?php include(dirname(__FILE__).'/users/navbox.php'); ?>

	<h1><a id="title" href="<?php echo $showslow_base ?>">Show Slow</a></h1>
	<div style="clear: both"></div>
</div>
<div id="menu">
<table><tr>
<?php if ($enableMyURLs) { ?><td><a <?php if ($SECTION == 'my') {?>class="current" <?php } ?>href="<?php echo $showslow_base ?>my.php">+ add URL</a></td><?php } ?>
<td><a <?php if ($SECTION == 'home') {?>class="current" <?php } ?>href="<?php echo $showslow_base ?>">Last measurements</td>
<td><a <?php if ($SECTION == 'all') {?>class="current" <?php } ?>href="<?php echo $showslow_base ?>all.php">URLs measured</a></td>
<?php
$compareParams = '';
if (is_array($defaultURLsToCompare)) {
	$compareParams = '?';

	if ($defaultRankerToCompare == 'pagespeed') {
		$compareParams .= 'ranker=pagespeed&';
	}

	$first = true;
	foreach ($defaultURLsToCompare as $_url) {
		if ($first) {
			$first = false;	
		}
		else {
			$compareParams.= '&';
		}
		$compareParams.='url[]='.urlencode($_url);
	}
}
?>
<td><a <?php if ($SECTION == 'compare') {?>class="current" <?php } ?>href="<?php echo $showslow_base ?>details/compare.php<?php echo $compareParams?>">Compare rankings</a></td>
<?php 
foreach ($customLists as $list_id => $list) {
	if (array_key_exists('hidden', $list) && $list['hidden']) {
		continue;
	}

	?><td><a <?php if ($SECTION == 'custom_list_'.$list_id) {?>class="current" <?php } ?>href="<?php echo $showslow_base ?>list.php?id=<?php echo $list_id; ?>"><?php echo $list['title'] ?></td><?php
}

foreach ($additionalMenuItems as $menu_item) {
	?><td><a href="<?php echo htmlentities($menu_item['url']) ?>"><?php echo htmlentities($menu_item['title']) ?></td><?php
}
?>
<td><a <?php if ($SECTION == 'configure') {?>class="current" <?php } ?>href="<?php echo $showslow_base ?>configure.php">Configuring ranking tools</a></td>
<td><a href="https://github.com/sergeychernyshev/showslow/downloads">Download ShowSlow</a></td>
</tr></table>
</div>
<div id="main">
