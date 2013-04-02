<?php

$item = elgg_extract('entity', $vars);

$url = $item->getURL();
$icon = elgg_view_entity_icon($item, 'large', array('href' => false));
$title = elgg_get_excerpt($item->title, 30);
$price = elgg_echo('market:price:currency', array($item->price));

echo <<<HTML
	<a href="$url">
		<div class="market-gallery-item">
			$icon
			<div class="mbs">$title</div>
			<h3>$price</h3>
		</div>
	</a>
HTML;
