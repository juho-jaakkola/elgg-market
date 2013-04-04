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

	/**
	 * Override to delete the icons
	 * 
	 * @return boolean
	 */
	public function delete() {
		$sizes = array('tiny', 'small', 'medium', 'large', 'master', 'original');

		foreach ($sizes as $size) {
			$file = new ElggFile();
			$file->owner_guid = $this->owner_guid;
			$file->setFilename("market/{$this->guid}_image1_{$size}.jpg");
			$file->delete();
		}

		return parent::delete();
	}
	
}