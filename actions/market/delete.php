<?php
/**
 * Delete market item
 *
 * @package Market
 */

$item_guid = get_input('guid');
$item = get_entity($item_guid);

if (elgg_instanceof($item, 'object', 'market_item') && $item->canEdit()) {
	if ($item->delete()) {
		system_message(elgg_echo('market:message:deleted_post'));
		forward('market/all');
	} else {
		register_error(elgg_echo('market:error:cannot_delete'));
	}
} else {
	register_error(elgg_echo('market:error:not_found'));
}

forward(REFERER);