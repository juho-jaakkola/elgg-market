<?php

/**
 * Get page components to list all market items.
 * 
 * @return array
 */
function market_get_page_content_list () {
	elgg_register_title_button();

	$items = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'market_item',
		'full_view' => false,
		'list_class' => 'market-list',
		'gallery_class' => 'market-gallery',
	));

	$params = array(
		'title' => elgg_echo('market:all'),
		'filter' => '',
		'content' => $items
	);

	return $params;
}

/**
 * Get page components to view a market item.
 *
 * @param int $guid GUID of a market item entity.
 */
function market_get_page_content_read ($guid = NULL) {

	$return = array();

	$item = get_entity($guid);

	// no header or tabs for viewing an individual market item
	$return['filter'] = '';

	if (!elgg_instanceof($item, 'object', 'market_item')) {
		register_error(elgg_echo('noaccess'));
		$_SESSION['last_forward_from'] = current_page_url();
		forward('');
	}

	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$owner_guid = elgg_get_page_owner_guid();

		if ($item->status != 'sold' &&  $user_guid != $owner_guid) {
			elgg_register_menu_item('title', array(
				'name' => 'buy',
				'href' => "action/market/buy?guid=$guid",
				'text' => elgg_echo('market:buy'),
				'is_action' => true,
				'class' => 'elgg-button elgg-button-action'
			));
		}

		if ($item->status == 'sold' && $user_guid == $owner_guid) {
			elgg_register_menu_item('title', array(
				'name' => 'revoke',
				'href' => "action/market/revoke_purchase?guid=$guid",
				'text' => elgg_echo('market:purchase:revoke'),
				'is_action' => true,
				'class' => 'elgg-button elgg-button-action'
			));
		}
	}
	$return['title'] = $item->title;

	$container = $item->getContainerEntity();
	$crumbs_title = $container->name;
	
	// TODO Add "owner" page
	//elgg_push_breadcrumb($crumbs_title, "market/owner/$container->username");
	elgg_push_breadcrumb($item->title);

	$return['content'] = elgg_view_entity($item, array('full_view' => true));
	$return['content'] .= elgg_view_comments($item);

	return $return;
}

function market_get_page_content_save ($guid = null) {
	$item = get_entity($guid);
	
	if ($guid) {
		$title = elgg_echo('market:edit');
		elgg_push_breadcrumb($item->title, $item->getURL());
		elgg_push_breadcrumb(elgg_echo('market:edit'));
	} else {
		$title = elgg_echo('market:add');
		elgg_push_breadcrumb(elgg_echo('market:add'));
	}

	$body_vars = market_prepare_form_vars($item);

	$form_vars = array(
		'enctype' => 'multipart/form-data',
		'class' => 'elgg-form-alt',
	);

	$form = elgg_view_form('market/save', $form_vars, $body_vars);

	$params = array(
		'title' => $title,
		'content' => $form,
		'filter' => '',
	);

	return $params;
}

function market_prepare_form_vars ($item = null) {
	// input names => defaults
	$values = array(
		'title' => NULL,
		'description' => NULL,
		'guid' => NULL,
		'access_id' => ACCESS_LOGGED_IN,
		'tags' => NULL,
		'container_guid' => NULL,
		'price' => NULL,
	);

	$images = array('image1', 'image2', 'image3', 'image4');

	if ($item) {
		foreach (array_keys($values) as $field) {
			if (isset($item->$field)) {
				$values[$field] = $item->$field;
			}
		}

		foreach ($images as $image) {
			$prefix = "market/" . $item->guid;
			$file = new ElggFile();
			$file->owner_guid = $item->owner_guid;
			$file->setFilename("{$prefix}_{$image}_original.jpg");

			if (file_exists($file->getFilenameOnFilestore())) {
				$values[$image] = $file->getFilename();
			} else {
				$values[$image] = NULL;
			}
		}
	}

	if (elgg_is_sticky_form('market')) {
		$sticky_values = elgg_get_sticky_values('market');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('market');

	return $values;
}
