<?php

/**
 * TaxibotActivity form.
 *
 * @package    legos2
 * @subpackage form
 * @author     Karsten Spiekermann
 */
class TaxibotActivityForm extends BaseTaxibotActivityForm {
	public function configure() {
		$this->setWidget ( 'on_position', new sfWidgetFormInputText ( array (), array (
				'value' => $this->getObject ()->getOnPosition ( 'd.m.Y H:i:s' ),
				'size' => 15 
		) ) );
		$this->setWidget ( 'completed', new sfWidgetFormInputText ( array (), array (
				'value' => $this->getObject ()->getCompleted ( 'd.m.Y H:i:s' ),
				'size' => 15 
		) ) );
	}
}
