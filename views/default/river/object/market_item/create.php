<?php
/**
 * Market river view.
 */

$item = $vars['item']->getObjectEntity();

$images = array('image1', 'image2', 'image3', 'image4');

$thumbs = '';
foreach ($images as $image) {
	$prefix = "market/" . $item->guid;
	$file = new ElggFile();
	$file->owner_guid = $item->owner_guid;
	$file->setFilename("{$prefix}_{$image}_original.jpg");

	if (file_exists($file->getFilenameOnFilestore())) {
		$thumbs .= elgg_view('output/img', array(
			'src' => "marketicon/$item->guid/medium/$image/$item->icontime.jpg",
			'alt' => $item->title,
			'class' => 'mrs'
		));
	}
}

$excerpt = elgg_get_excerpt($item->description, 500);

$message = "<div class=\"mbm\">$excerpt</div>$thumbs";

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'message' => $message,
));