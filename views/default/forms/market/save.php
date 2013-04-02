<?php

$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array(
	'name' => 'title',
	'value' => $vars['title'],
));

$description_label = elgg_echo('description');
$description_input = elgg_view('input/longtext', array(
	'name' => 'description',
	'value' => $vars['description'],
));

$price_label = elgg_echo('market:price');
$price_input = elgg_view('input/text', array(
	'name' => 'price',
	'value' => $vars['price'],
));

$tags_label = elgg_echo('tags');
$tags_input = elgg_view('input/tags', array(
	'name' => 'tags',
	'value' => $vars['tags'],
));

$access_label = elgg_echo('access');
$access_input = elgg_view('input/access', array(
	'name' => 'access_id',
	'value' => $vars['access_id'],
));

$image1_label = elgg_echo('market:image');
$image1_input = elgg_view('input/file', array('name' => 'image1'));

$submit_input = elgg_view('input/submit', array(
	'name' => 'submit',
));

$guid_input = elgg_view('input/hidden', array(
	'name' => 'guid',
	'value' => $vars['guid'],
));

/*
$_label = elgg_echo('market:');
$_input = elgg_view('input/', array(
	'name' => '',
	'value' => $vars[''],
));
*/

echo <<<FORM
<div>
	<label>$title_label</label>
	$title_input
</div>
<div>
	<label>$description_label</label>
	$description_input
</div>
<div>
	<label>$price_label</label>
	$price_input
</div>
<div>
	<label>$tags_label</label>
	$tags_input
</div>
<div>
	<label>$image1_label</label>
	$image1_input
</div>
<div>
	<label>$access_label</label>
	$access_input
</div>
<div>
	$guid_input
	$submit_input
</div>
FORM;
