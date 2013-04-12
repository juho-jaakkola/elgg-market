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
		'href' => $item->getIconURL('original'),
		'class' => 'elgg-lightbox'
	));
}

$images = array('image2', 'image3', 'image4');

$thumbnails = '';
foreach ($images as $image) {
	$prefix = "market/" . $item->guid;
	$file = new ElggFile();
	$file->owner_guid = $item->owner_guid;
	$file->setFilename("{$prefix}_{$image}_original.jpg");
	$file->open("read");

	if (file_exists($file->getFilenameOnFilestore())) {
		$thumbnail = elgg_view('output/img', array(
			'src' => "marketicon/$item->guid/small/$image/$item->icontime.jpg",
			'alt' => $item->title,
		));

		$thumbnails .= elgg_view('output/url', array(
			'text' => $thumbnail,
			'href' => "marketicon/$item->guid/original/$image/$item->icontime.jpg",
			'class' => 'elgg-lightbox',
		));
	}
}

echo <<<HTML
	<div class="elgg-image-block market-item">
		<div class="elgg-image">
			<div>$icon</div>
			<div>$thumbnails</div>
			<div class="market-block">$price</div>
		</div>
		<div class="elgg-body">$description</div>
	</div>
	<div class="clearfloat">
HTML;
