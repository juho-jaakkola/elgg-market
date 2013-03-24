<?php

elgg_register_event_handler('init', 'system', 'market_init');

function market_init () {
	$actions_path = elgg_get_plugins_path() . 'market/actions/market/';
	elgg_register_action('market/save', $actions_path . 'save.php');
	elgg_register_action('market/buy', $actions_path . 'buy.php');

	elgg_register_library('elgg:market', elgg_get_plugins_path() . 'market/lib/market.php');

	elgg_register_page_handler('market', 'market_page_handler');

	elgg_register_entity_url_handler('object', 'market_item', 'market_url_handler');
	
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'market_entity_menu_setup');

	elgg_register_menu_item('site', array(
		'name' => 'market',
		'text' => elgg_echo('market'),
		'href' => 'market/all'
	));
}

function market_page_handler ($page) {
	elgg_load_library('elgg:market');
	
	switch ($page[0]) {
		case 'add':
			gatekeeper();
			$params = market_get_page_content_save();
			break;
		case 'edit':
			gatekeeper();
			$params = market_get_page_content_save($page[1]);
			break;
		case 'view':
			$params = market_get_page_content_read($page[1]);
			break;
		case 'all':
		default:
			$params = market_get_page_content_list();
			break;
	}
	
	$body = elgg_view_layout('content', $params);
	
	echo elgg_view_page($params['title'], $body);
}

/**
 * Format and return the URL for market items.
 *
 * @param ElggObject $entity Market item object
 * @return string URL of market item.
 */
function market_url_handler($entity) {
	if (!$entity->getOwnerEntity()) {
		// default to a standard view if no owner.
		return FALSE;
	}

	$friendly_title = elgg_get_friendly_title($entity->title);

	return "market/view/{$entity->guid}/$friendly_title";
}

function market_entity_menu_setup ($hook, $type, $return, $params) {
	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'market') {
		return $return;
	}

	if ($entity->status == 'sold') {
		$status_text = elgg_echo('market:status:sold');
		$options = array(
			'name' => 'status',
			'text' => "<span style=\"color: red;\">$status_text</span>",
			'href' => false,
			'priority' => 150,
		);
		$return[] = ElggMenuItem::factory($options);
	}

	return $return;
}
