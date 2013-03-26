<?php

$finnish = array(
	'market' => 'Kirpputori',
	'market:all' => 'Kirpputori',
	'market:add' => 'Lisää uusi kohde',
	'market:edit' => 'Muokkaa',
	'market:price' => 'Hinta',
	'market:buy' => 'Osta tämä kohde',
	'market:buy:confirm' => 'Haluatko varmasti ostaa tämän kohteen?',
	"market:status:sold" => 'Myyty',

	// Messages
	'market:error:already_sold' => 'Tämä kohde on valitettavasti jo myyty!',
	'market:error:purchase_failed' => 'Ostaminen epäonnistui! Yritä uudelleen.',
	'market:purchase:success' => 'Olet ostanut tämän kohteen',

	// Notifications
	'market:item_bought:subject' => 'Myyntiin laittamasi kohde on ostettu',
	'market:item_bought:message' => 'Hei %s

%s on ostanut myyntiin laittamasi kohteen "%s".

Siirry kohteeseen tästä:
%s	
',
);

add_translation('fi', $finnish);
