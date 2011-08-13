<?php
if (!$items) return;

$first = false;
foreach ($items as $item)
{
	echo '    <div class="news-article' . (!$first ? ' first-child' : '')  . ' ">
    	<div class="news-article-inner">
	            <h3>
	                <a href="blog/' . $item['id'] . '#blog">' . $item['title'] . '</a>
	            </h3>
	            <div class="by-line">
	                by <a href="' . CLIENT_FILES_PATH . '/wow/' . LOCALE . '/search?f=article&amp;a=' . $item['author'] . '">' . $item['author'] . '</a>
                <span class="spacer"></span> ' . date('d/m/Y', $item['postdate']) . '
	                    <a href="blog/' . $item['id'] . '#comments" class="comments-link">
	                        4
	                    </a>
	            </div>

	        <div class="article-left" style="background-image: url(\'' . CLIENT_FILES_PATH . '/cms/blog_thumbnail/' . $item['image'] . '\');">
	            <a href="blog/' . $item['id'] . '"><span class="thumb-frame"></span></a>
	        </div>

	        <div class="article-right">
	            <div class="article-summary">
	                <p>' . $item['desc'] . '</p>

	                <a href="blog/' . $item['id'] . '#blog" class="more">
	                    	                    	More
	                </a>
	            </div>
	        </div>

	<span class="clear"><!-- --></span>
        </div>
    </div>' . NL;
	$first = true;
}