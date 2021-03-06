<?php
/**
 * View for market objects
 *
 * @package Market
 */

$full = elgg_extract('full_view', $vars, FALSE);
$item = elgg_extract('entity', $vars, FALSE);

if (!$item) {
	return TRUE;
}

$owner = $item->getOwnerEntity();
$container = $item->getContainerEntity();
$categories = elgg_view('output/categories', $vars);

$icon = elgg_view_entity_icon($item, 'medium');

$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = elgg_view('output/url', array(
	'href' => "market/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($item->time_created);

$comments_count = $item->countComments();
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $item->getURL() . '#market-comments',
		'text' => $text,
		'is_trusted' => true,
	));
} else {
	$comments_link = '';
}

$price = elgg_echo('market:price') . ": {$item->price}€";

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'market',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full) {
	$params = array(
		'entity' => $item,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	$body = elgg_view('market/layout', $vars);

	echo elgg_view('object/elements/full', array(
		'summary' => $summary,
		'icon' => $owner_icon,
		'body' => $body,
	));
} elseif (elgg_in_context('gallery')) {
	echo elgg_view('market/gallery', $vars);
} else {
	// brief view
	$excerpt = elgg_get_excerpt($item->description);
	$content = "<p>$excerpt</p><p><strong>$price</strong></p>";

	$params = array(
		'entity' => $item,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $content,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($icon, $list_body);
}
