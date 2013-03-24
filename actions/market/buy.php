<?php

$guid = get_input('guid');

$item = get_entity($guid);

if (elgg_instanceof($item, 'object', 'market_item')) {
	if ($item->status == 'sold') {
		register_error(elgg_echo('market:error:already_sold'));
		forward(REFERER);
	} else {
		$user_guid = elgg_get_logged_in_user_guid();
		
		// "$user_guid is a buyer of $item"
		$item->addRelationship($user_guid, 'buyer');
		$item->status = 'sold';
		$item->save;
		
		// TODO Add to river?
		
		// TODO Notify item owner
		
		system_message(elgg_echo('market:buy:success'));
	}
} else {
	register_error('noaccess');
	forward(REFERER);
}

forward($item->getURL());
