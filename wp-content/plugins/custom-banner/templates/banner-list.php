<?php
?>
<ul class="list-group list-group-flush mx-0 px-0">
<?php
	foreach ($atts as $banner) {
		$text = $banner->get_text();
		$url  = $banner->get_url();
?>
	<li class="list-group-item list-group-item-action my-0">
		<a href="<?php echo $url; ?>"><?php echo $text; ?></a>
	</li>
<?php
	}
?>
</ul>
