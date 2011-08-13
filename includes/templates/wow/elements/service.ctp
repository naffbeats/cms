<ul class="service-bar">
<li class="service-cell service-home"><a href="<?php echo CLIENT_FILES_PATH; ?>/" tabindex="50" accesskey="1" title="Battle.net Home"> </a></li>
<li class="service-cell service-welcome">
<a href="?login" onclick="return Login.open()">Log in</a> or <a href="<?php echo CLIENT_FILES_PATH; ?>/account/creation/tos.html">Create an Account</a>
</li>
<li class="service-cell service-account"><a href="<?php echo CLIENT_FILES_PATH; ?>/account/management/" class="service-link" tabindex="50" accesskey="3">Account</a></li>
<li class="service-cell service-support service-support-enhanced">
<a href="#support" class="service-link service-link-dropdown" tabindex="50" accesskey="4" id="support-link" onclick="return false" style="cursor: progress" rel="javascript">Support<span class="no-support-tickets" id="support-ticket-count"></span></a>
<div class="support-menu" id="support-menu" style="display:none;">
<div class="support-primary">
<ul class="support-nav">
<li>
<a href="http://eu.blizzard.com/support/" tabindex="55" class="support-category">
<strong class="support-caption">Knowledge Center</strong>
Browse our support articles
</a>
</li>
<li>
<a href="https://eu.battle.net/support/ticket/submit" tabindex="55" class="support-category">
<strong class="support-caption">Ask a Question</strong>
Create a new support ticket
</a>
</li>
<li>
<a href="https://eu.battle.net/support/ticket/status" tabindex="55" class="support-category">
<strong class="support-caption">Your Support Tickets</strong>
View your active tickets (login required).
</a>
</li>
</ul>
<span class="clear"><!-- --></span>
</div>
<div class="support-secondary"></div>
<!--[if IE 6]> <iframe id="support-shim" src="javascript:false;" frameborder="0" scrolling="no" style="display: block; position: absolute; top: 0; left: 9px; width: 297px; height: 400px; z-index: -1;"></iframe>
<script type="text/javascript">
//<![CDATA[
(function(){
var doc = document;
var shim = doc.getElementById('support-shim');
shim.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)';
shim.style.display = 'block';
})();
//]]>
</script>
<![endif]-->
</div>
</li>
<li class="service-cell service-explore">
<a href="#explore" tabindex="50" accesskey="5" class="dropdown" id="explore-link" onclick="return false" style="cursor: progress" rel="javascript">Explore</a>
<div class="explore-menu" id="explore-menu" style="display:none;">
<div class="explore-primary">
<ul class="explore-nav">
<li>
<a href="<?php echo CLIENT_FILES_PATH; ?>/" tabindex="55">
<strong class="explore-caption">Battle.net Home</strong>
Connect. Play. Unite.
</a>
</li>
<li>
<a href="<?php echo CLIENT_FILES_PATH; ?>/account/management/" tabindex="55">
<strong class="explore-caption">Account</strong>
Manage your Account
</a>
</li>
<li>
<a href="http://eu.blizzard.com/support/" tabindex="55">
<strong class="explore-caption">Support</strong>
Get Support and explore the knowledgebase.
</a>
</li>
<li>
<a href="https://eu.battle.net/account/management/get-a-game.html" tabindex="55">
<strong class="explore-caption">Buy Games</strong>
Digital Games for Download
</a>
</li>
</ul>
<div class="explore-links">
<h2 class="explore-caption">More</h2>
<ul>
<li><a href="<?php echo CLIENT_FILES_PATH; ?>/what-is/" tabindex="55">What is Battle.net?</a></li>
<li><a href="http://eu.battle.net/realid/" tabindex="55">What is Real ID?</a></li>
<li><a href="https://eu.battle.net/account/parental-controls/index.html" tabindex="55">Parental Controls</a></li>
<li><a href="http://eu.battle.net/security/" tabindex="55">Account Security</a></li>
<li><a href="http://eu.battle.net/games/classic" tabindex="55">Classic Games</a></li>
<li><a href="https://eu.battle.net/account/support/index.html" tabindex="55">Account Support</a></li>
</ul>
</div>
<span class="clear"><!-- --></span>
<!--[if IE 6]> <iframe id="explore-shim" src="javascript:false;" frameborder="0" scrolling="no" style="display: block; position: absolute; top: 0; left: 9px; width: 409px; height: 400px; z-index: -1;"></iframe>
<script type="text/javascript">
//<![CDATA[
(function(){
var doc = document;
var shim = doc.getElementById('explore-shim');
shim.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)';
shim.style.display = 'block';
})();
//]]>
</script>
<![endif]-->
</div>
<ul class="explore-secondary">
<li class="explore-game explore-game-sc2">
<a href="http://eu.battle.net/sc2/" tabindex="55">
<strong class="explore-caption">StarCraft II</strong>
<span>Community Site</span> <span>Forum Discussions</span> <span>Character Profiles and more…</span>
</a>
</li>
<li class="explore-game explore-game-wow">
<a href="<?php echo CLIENT_FILES_PATH; ?>/wow/" tabindex="55">
<strong class="explore-caption">World of Warcraft</strong>
<span>Community Site</span> <span>Forum Discussions</span> <span>Character Profiles and more…</span>
</a>
</li>
<li class="explore-game explore-game-d3">
<a href="http://eu.battle.net/games/d3" tabindex="55">
<strong class="explore-caption">Diablo III</strong>
<span>Under Development, visit the Announcement Site</span>
</a>
</li>
</ul>
</div>
</li>
</ul>
<div id="warnings-wrapper">
<!--[if lt IE 8]>
<div id="browser-warning" class="warning warning-red">
<div class="warning-inner2">
You are using an outdated web browser.<br />
<a href="http://eu.blizzard.com/support/article/browserupdate">Upgrade</a> or <a href="http://www.google.com/chromeframe/?hl=en-GB" id="chrome-frame-link">install Google Chrome Frame</a>.
<a href="#close" class="warning-close" onclick="App.closeWarning('#browser-warning', 'browserWarning'); return false;"></a>
</div>
</div>
<![endif]-->
<!--[if lte IE 8]>
<script type="text/javascript" src="<?php echo CLIENT_FILES_PATH; ?>/wow/static/local-common/js/third-party/CFInstall.min.js?v27"></script>
<script type="text/javascript">
//<![CDATA[
$(function() {
var age = 365 * 24 * 60 * 60 * 1000;
var src = 'https://www.google.com/chromeframe/?hl=en-GB';
if ('http:' == document.location.protocol) {
src = 'http://www.google.com/chromeframe/?hl=en-GB';
}
document.cookie = "disableGCFCheck=0;path=/;max-age="+age;
$('#chrome-frame-link').bind({
'click': function() {
App.closeWarning('#browser-warning');
CFInstall.check({
mode: 'overlay',
url: src
});
return false;
}
});
});
//]]>
</script>
<![endif]-->
<noscript>
<div id="javascript-warning" class="warning warning-red">
<div class="warning-inner2">
JavaScript must be enabled to use this site.
</div>
</div>
</noscript>
</div>
</div>