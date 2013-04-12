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
	'market:purchase:revoke' => 'Peru kauppa',
	'market:image' => 'Lisää kuva',
	'market:price:view' => '<b>Hinta:</b> %s€',
	'market:price:currency' => '%s€',
	
	// River
	'river:create:object:market_item' => '%s lisäsi kirpputorille kohteen %s', 

	"market:list:gallery" => 'Gallerianäkymä',
	"market:list:list" => 'Listanäkymä',

	// Messages
	'market:save:success' => 'Kohde tallennettu',
	'market:purchase:success' => 'Olet ostanut tämän kohteen',
	'market:purchase:revoke:success' => 'Palautettiin kohde takaisin myyntiin',
	'market:message:deleted_post' => 'Kohde poistettu',
	'market:error:already_sold' => 'Tämä kohde on valitettavasti jo myyty!',
	'market:error:purchase_failed' => 'Ostaminen epäonnistui! Yritä uudelleen.',
	'market:error:revoke_failed' => 'Kaupan peruuttaminen epäonnistui!',
	'market:error:not_found' => 'Kohdetta ei löytynyt',
	'market:error:cannot_delete' => 'Kohteen poistaminen epäonnistui',

	// Notifications
	'market:item_bought:subject' => 'Myyntiin laittamasi kohde on ostettu',
	'market:item_bought:message' => 'Hei %s

%s on ostanut myyntiin laittamasi kohteen "%s".

Siirry kohteeseen tästä:
%s	
',
);

add_translation('fi', $finnish);
