<?php
/**
 * MarketItem class
 * 
 * @property string $status Status of the item (null, 'available', 'sold')
 */
class MarketItem extends ElggObject {

	/**
	 * Set subtype
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "market_item";
	}
}