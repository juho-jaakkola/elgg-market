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
		$images = array('image1', 'image2', 'image3', 'image4');
		$sizes = array('tiny', 'small', 'medium', 'large', 'master', 'original');

		foreach ($images as $image) {
			foreach ($sizes as $size) {
				$file = new ElggFile();
				$file->owner_guid = $this->owner_guid;
				$file->setFilename("market/{$this->guid}_{$image}_{$size}.jpg");
				$file->delete();
			}
		}

		return parent::delete();
	}

	// TODO Override getIconURL method to return a specific one of the four images

}