<?php

$title = get_input('title');
$description = get_input('description');
$price = get_input('price');
$guid = get_input('guid');
$access_id = get_input('access');
//$ = get_input('');

elgg_make_sticky_form('market');

if ($guid) {
	$item = get_entity($guid);
	
	if (!elgg_instanceof($item, 'object', 'market_item') || !$item->canEdit()) {
		register_error(elgg_echo());
		forward(REFERER);
	}
} else {
	$item = new ElggObject();
	$item->subtype = 'market_item';
}

$item->title = $title;
$item->description = $description;
$item->access_id = $access_id;
$item->price = $price;
$item->save();

elgg_clear_sticky_form('market');

$images = array('image1');

foreach ($images as $image) {
	$has_uploaded_icon = (!empty($_FILES[$image]['type']) && substr_count($_FILES[$image]['type'], 'image/'));

	if ($has_uploaded_icon) {
		$icon_sizes = elgg_get_config('icon_sizes');

		$prefix = "market/" . $item->guid;

		$filehandler = new ElggFile();
		$filehandler->owner_guid = $item->owner_guid;
		$filehandler->setFilename("{$prefix}_{$image}.jpg");
		$filehandler->open("write");
		$filehandler->write(get_uploaded_file($image));
		$filehandler->close();
		$filename = $filehandler->getFilenameOnFilestore();

		$sizes = array('tiny', 'small', 'medium', 'large');

		$thumbs = array();
		foreach ($sizes as $size) {
			$thumbs[$size] = get_resized_image_from_existing_file(
				$filename,
				$icon_sizes[$size]['w'],
				$icon_sizes[$size]['h'],
				$icon_sizes[$size]['square']
			);
		}

		if ($thumbs['tiny']) {
			$thumb = new ElggFile();
			$thumb->owner_guid = $item->owner_guid;
			$thumb->setMimeType('image/jpeg');

			foreach ($sizes as $size) {
				$thumb->setFilename("{$prefix}_{$image}_{$size}.jpg");
				$thumb->open("write");
				$thumb->write($thumbs[$size]);
				$thumb->close();
			}

			$item->icontime = time();
		}
	}
}

//register_error(elgg_echo('market:error:cannot:save'));
system_message(elgg_echo('market:message:saved'));
forward($item->getURL());