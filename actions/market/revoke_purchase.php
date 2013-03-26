<?php

$guid = get_input('guid');

$item = get_entity($guid);

if (elgg_instanceof($item, 'object', 'market_item')) {
	$buyer = elgg_get_entities_from_relationship(array(
		'relationship' => 'buyer',
		'relationship_guid' => $guid,
		'inverse_relationship',
	));

	if (isset($buyer[0])) {
		$user_guid = $buyer[0]->getGUID();

		$result = $item->removeRelationship($user_guid, 'buyer');

		if ($result) {
			$item->status = 'available';
			$item->save();

			system_message(elgg_echo('market:purchase:revoke:success'));
			forward(REFERER);
		}
	}
}

register_error(elgg_echo('market:error:revoke_failed'));
forward(REFERER);
