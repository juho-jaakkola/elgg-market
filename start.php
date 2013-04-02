<?php

elgg_register_event_handler('init', 'system', 'market_init');

function market_init () {
	$actions_path = elgg_get_plugins_path() . 'market/actions/market/';
	elgg_register_action('market/save', $actions_path . 'save.php');
	elgg_register_action('market/buy', $actions_path . 'buy.php');
	elgg_register_action('market/revoke_purchase', $actions_path . 'revoke_purchase.php');

	elgg_register_library('elgg:market', elgg_get_plugins_path() . 'market/lib/market.php');

	elgg_register_page_handler('market', 'market_page_handler');

	elgg_extend_view('css/elgg', 'market/css');

	// Register an icon handler for market items
	elgg_register_page_handler('marketicon', 'market_icon_handler');

	// Register URL handlers for market items
	elgg_register_entity_url_handler('object', 'market_item', 'market_url_handler');
	elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'market_icon_url_override');

	elgg_register_plugin_hook_handler('register', 'menu:entity', 'market_entity_menu_setup');

	elgg_register_menu_item('site', array(
		'name' => 'market',
		'text' => elgg_echo('market'),
		'href' => 'market/all'
	));
}

function market_page_handler ($page) {
	elgg_load_library('elgg:market');

	elgg_push_breadcrumb(elgg_echo('market'), 'market/all');

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
			market_register_toggle();
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

/**
 * Override the default entity icon for market items
 *
 * @return string Relative URL
 */
function market_icon_url_override($hook, $type, $returnvalue, $params) {
	$item = $params['entity'];
	$size = $params['size'];

	if (!elgg_instanceof($item, 'object', 'market_item')) {
		return $return;
	}

	$icontime = $item->icontime;

	if ($icontime) {
		// return thumbnail
		return "marketicon/$item->guid/$size/$icontime.jpg";
	}

	// TODO
	//return "mod/market/graphics/default{$size}.gif";
}

/**
 * Handle market main image.
 *
 * @param array $page
 * @return void
 */
function market_icon_handler($page) {
	if (isset($page[0])) {
		set_input('guid', $page[0]);
	}
	if (isset($page[1])) {
		set_input('size', $page[1]);
	}

	$plugin_dir = elgg_get_plugins_path();
	include("$plugin_dir/market/icon.php");
	return true;
}


/**
 * Adds a toggle to extra menu for switching between list and gallery views
 */
function market_register_toggle() {
	$url = elgg_http_remove_url_query_element(current_page_url(), 'list_type');

	if (get_input('list_type', 'list') == 'list') {
		$list_type = "gallery";
		$icon = elgg_view_icon('grid');
	} else {
		$list_type = "list";
		$icon = elgg_view_icon('list');
	}

	if (substr_count($url, '?')) {
		$url .= "&list_type=" . $list_type;
	} else {
		$url .= "?list_type=" . $list_type;
	}

	elgg_register_menu_item('extras', array(
		'name' => 'market_list',
		'text' => $icon,
		'href' => $url,
		'title' => elgg_echo("market:list:$list_type"),
		'priority' => 1000,
	));
}