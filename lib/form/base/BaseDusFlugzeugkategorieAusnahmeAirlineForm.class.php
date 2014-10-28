<?php

/**
 * DusFlugzeugkategorieAusnahmeAirline form base class.
 *
 * @method DusFlugzeugkategorieAusnahmeAirline getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseDusFlugzeugkategorieAusnahmeAirlineForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'flugzeugtyp_id' => new sfWidgetFormInputText(),
      'airline_id'     => new sfWidgetFormInputText(),
      'gueltig_von'    => new sfWidgetFormDateTime(),
      'cat'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'flugzeugtyp_id' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'airline_id'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'gueltig_von'    => new sfValidatorDateTime(array('required' => false)),
      'cat'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('dus_flugzeugkategorie_ausnahme_airline[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DusFlugzeugkategorieAusnahmeAirline';
  }


}
