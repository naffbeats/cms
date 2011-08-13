<div class="search-bar">
<form action="<?php echo CLIENT_FILES_PATH; ?>/wow/<?php echo LOCALE; ?>/search" method="get" autocomplete="off">
<div>
<input type="text" class="search-field input" name="q" id="search-field" maxlength="200" tabindex="40" alt="Search characters, items, forums and more…" value="Search characters, items, forums and more…" />
<input type="submit" class="search-button" value="" tabindex="41" />
</div>
</form>
</div>
<h1 id="logo"><a href="<?php echo CLIENT_FILES_PATH; ?>/wow/<?php echo LOCALE; ?>/">World of Warcraft</a></h1>
<div class="header-plate">
<ul class="menu" id="menu">
<li class="menu-home">
<a href="<?php echo CLIENT_FILES_PATH; ?>/wow/<?php echo LOCALE; ?>/" class="menu-active">
<span>Home</span>
</a>
</li>
<li class="menu-game">
<a href="<?php echo CLIENT_FILES_PATH; ?>/wow/<?php echo LOCALE; ?>/game/">
<span>Game</span>
</a>
</li>
<li class="menu-community">
<a href="<?php echo CLIENT_FILES_PATH; ?>/wow/<?php echo LOCALE; ?>/community/">
<span>Community</span>
</a>
</li>
<li class="menu-media">
<a href="<?php echo CLIENT_FILES_PATH; ?>/wow/<?php echo LOCALE; ?>/media/">
<span>Media</span>
</a>
</li>
<li class="menu-forums">
<a href="<?php echo CLIENT_FILES_PATH; ?>/wow/<?php echo LOCALE; ?>/forum/">
<span>Forums</span>
</a>
</li>
<li class="menu-services">
<a href="<?php echo CLIENT_FILES_PATH; ?>/wow/<?php echo LOCALE; ?>/services/">
<span>Services</span>
</a>
</li>
</ul>
<div class="user-plate ajax-update">
<a href="?login" class="card-login"
onclick="BnetAds.trackImpression('Battle.net Login', 'Character Card', 'New'); return Login.open('<?php echo CLIENT_FILES_PATH; ?>/login/login.frag');">
<strong>Log in now</strong> to enhance and personalize your experience!
</a>
<div class="card-overlay"></div>
</div>
</div>