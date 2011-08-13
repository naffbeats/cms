    <div id="homepage">
        <div id="left">
		<?php echo $this->c('Document')->releaseJs('home_content'); ?>

	<?php if ($this->issetRegion('carousel')) echo $this->region('carousel'); ?>


			<div class="homepage-news-wrapper">
  <div class="featured-news">
	  	<div class="featured-news-inner">
			<?php if ($this->issetRegion('featured')) echo $this->region('featured'); ?>

	        <span class="clear"></span>
        </div>
    </div>

		        <div id="news-updates">
		        	<div id="news-updates-inner">




    <?php if ($this->issetRegion('news')) echo $this->region('news'); ?>

								<div class="blog-paging">
									

	<a
		class="ui-button button1 button1-next float-right "
			href="?page=2"
		
		
		
		
		
		
		>
		<span>
			<span>Next</span>
		</span>
	</a>



	<span class="clear"><!-- --></span>
							</div>
					</div>
		        </div>
            </div>
        </div>

		<div id="right" class="ajax-update">
			<div id="sidebar-promo" class="sidebar-module">
 






	<div class="bnet-offer">
		<!--  -->
		<div class="bnet-offer-bg">
				<a href="https://eu.battle.net/account/creation/wow/signup/" target="_blank" id="ad2555187" class="bnet-offer-image" onclick="BnetAds.trackEvent('2555187', 'Trial-EU', 'wow', true);">
				<img src="http://eu.media1.battle.net/cms/ad_300x250/278A4B1NC79Q1309451833883.jpg" width="300" height="250" alt=""/>
			</a>
		</div>
		<script type="text/javascript">
			//<![CDATA[
				if(typeof (BnetAds.addEvent) != "undefined" )
					BnetAds.addEvent(window, 'load', function(){ BnetAds.trackEvent('2555187', 'Trial-EU', 'wow'); } );
				else
					BnetAds.trackEvent('2555187', 'Trial-EU', 'wow');
			//]]>
		</script>
	</div>
			</div>



	<div class="sidebar-module" id="sidebar-sotd">
		<div class="sidebar-title">
			<h3 class="title-sotd">Screenshot of the Day</h3>
		</div>

		<div class="sidebar-content loading"></div>
	</div>
	<div class="sidebar-module" id="sidebar-forums">
		<div class="sidebar-title">
			<h3 class="title-forums">Popular Topics</h3>
		</div>

		<div class="sidebar-content loading"></div>
	</div>

        <script type="text/javascript">
        //<![CDATA[
		$(function() {
			App.sidebar(['sotd','forums']);
		});
        //]]>
        </script>
		</div>

	<span class="clear"><!-- --></span>
    </div>