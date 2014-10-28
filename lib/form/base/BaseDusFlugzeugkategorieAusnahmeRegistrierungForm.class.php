<?php

/**
 * DusFlugzeugkategorieAusnahmeRegistrierung form base class.
 *
 * @method DusFlugzeugkategorieAusnahmeRegistrierung getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseDusFlugzeugkategorieAusnahmeRegistrierungForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'flugzeugregistrierung' => new sfWidgetFormInputText(),
      'gueltig_von'           => new sfWidgetFormDateTime(),
      'cat'                   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'flugzeugregistrierung' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'gueltig_von'           => new sfValidatorDateTime(array('required' => false)),
      'cat'                   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('dus_flugzeugkategorie_ausnahme_registrierung[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DusFlugzeugkategorieAusnahmeRegistrierung';
  }


}
