<?php
if (!$items) return;

foreach ($items as $item)
	echo '<div class="featured">
	            <a href="' . CLIENT_FILES_PATH . '/wow/' . LOCALE . '/blog/' . $item['id'] . '#blog">
	               <span class="featured-img" style="background-image: url(\'' . CLIENT_FILES_PATH . '/cms/blog_thumbnail/' . $item['image'] . '\');"><span class="featured-img-frame"></span></span>
	               <span class="featured-desc">' . $item['title'] . '</span>
	            </a>
	        </div>' . NL;
?>