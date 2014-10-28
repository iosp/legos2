<?php

/**
 * DusFlugzeugkategorieAusnahmeRegistrierung filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseDusFlugzeugkategorieAusnahmeRegistrierungFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'flugzeugregistrierung' => new sfWidgetFormFilterInput(),
      'gueltig_von'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'cat'                   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'flugzeugregistrierung' => new sfValidatorPass(array('required' => false)),
      'gueltig_von'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'cat'                   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('dus_flugzeugkategorie_ausnahme_registrierung_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DusFlugzeugkategorieAusnahmeRegistrierung';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'flugzeugregistrierung' => 'Text',
      'gueltig_von'           => 'Date',
      'cat'                   => 'Number',
    );
  }
}
