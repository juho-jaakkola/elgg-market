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

if ($item->save()) {
	system_message('market:message:saved');
	forward($item->getURL());
} else {
	register_error(elgg_echo('market:error:cannot:save'));
	forward(REFERER);
}