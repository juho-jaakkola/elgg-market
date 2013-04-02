<?php

$item = elgg_extract('entity', $vars);

$description = elgg_view('output/longtext', array(
	'value' => $item->description,
));

$price = elgg_echo('market:price:view', array($item->price));

$icon = '';
if ($item->icontime) {
	$img = elgg_view('output/img', array(
		'src' => $item->getIconURL('large'),
		'alt' => $item->title,
	));

	$icon = elgg_view('output/url', array(
		'text' => $img,
		'href' => $item->getIconURL('master'),
		'class' => 'elgg-lightbox'
	));
}

echo <<<HTML
	<div class="elgg-image-block market-item">
		<div class="elgg-image">
			<div>$icon</div>
			<div class="market-block">$price</div>
		</div>
		<div class="elgg-body">$description</div>
	</div>
	<div class="clearfloat">
HTML;
