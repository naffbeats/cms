    <div id="slideshow" class="slideshow">
	<div class="container">
		<?php
		if ($items)
		{
			$size = sizeof($items);
			for ($i = 0; $i < $size; ++$i) :
		?>
				<div class="slide" id="slide-<?php echo $i; ?>"	style="background-image: url('<?php echo CLIENT_FILES_PATH; ?>/cms/carousel_header/<?php echo $items[$i]['image']; ?>') <?php echo $i > 0 ? '; display:none;' : ''; ?>"> </div>
		<?php
			endfor;
		}
		?>
		</div>
		
		<div class="paging">
		<?php
		if ($items)
		{
			for ($i = 0; $i < $size; ++$i) :
		?>
					<a href="javascript:;" id="paging-<?php echo $i; ?>"
					    onclick="Slideshow.jump(<?php echo $i; ?>, this);"
						onmouseover="Slideshow.preview(<?php echo $i; ?>);"
						<?php echo $i == 0 ? 'class="current"' : ''; ?>>
					</a>
		<?php
			endfor;
		}
		?>
		</div>

		<div class="caption">
			<h3><a href="#" class="link"><?php echo $items ? $items[0]['title'] : ''; ?>		</a></h3>
			<?php echo $items ? $items[0]['desc'] : ''; ?>
		</div>

		<div class="preview"></div>
		<div class="mask"></div>

    </div>
        <script type="text/javascript">
        //<![CDATA[
        $(function() {
            Slideshow.initialize('#slideshow', [
			<?php
			if ($items)
			{
				for ($i = 0; $i < $size; ++$i):
			?>
			{
				image: "<?php echo CLIENT_FILES_PATH; ?>/cms/carousel_header/<?php echo $items[$i]['image']; ?>",
				desc: "<?php echo $items[$i]['desc']; ?>",
				title: "<?php echo $items[$i]['title']; ?>",
				url: "<?php echo $items[$i]['url']; ?>",
				id: "<?php echo $items[$i]['id']; ?>"
			}
			<?php
				if ($i < $size-1) echo ',';
				echo NL;
				endfor;
			}
			?>
            ]);

        });
        //]]>
        </script>