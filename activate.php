<?php

if (get_subtype_id('object', 'market_item')) {
	update_subtype('object', 'market_item', 'MarketItem');
} else {
	add_subtype('object', 'market_item', 'MarketItem');
}
