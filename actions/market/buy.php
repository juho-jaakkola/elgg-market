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
		if ($item->addRelationship($user_guid, 'buyer')) {
			$item->status = 'sold';

			if ($item->save()) {
				$owner = $item->getOwnerEntity();

				$subject = elgg_echo('market:item_bought:subject');
				$message = elgg_echo('market:item_bought:message', array(
					$owner->getName(),
					$user->getName(),
					$item->title,
					$item->getURL()
				));

				notify_user(
					$owner->getGUID(),
					$user_guid,
					$subject,
					$message
				);

				// TODO Add to river?

				system_message(elgg_echo('market:purchase:success'));
			} else {
				register_error(elgg_echo('market:error:purchase_failed'));
			}
		}
	}
} else {
	register_error('noaccess');
	forward(REFERER);
}

forward($item->getURL());
