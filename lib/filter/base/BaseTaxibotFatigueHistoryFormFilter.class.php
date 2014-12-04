<?php

/**
 * TaxibotFatigueHistory filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTaxibotFatigueHistoryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'aircraft_id'   => new sfWidgetFormPropelChoice(array('model' => 'Aircraft', 'add_empty' => true)),
      'date'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'milisecond'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'long_force_kn' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'lat_force_kn'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'veolcity'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tiller'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'break_event'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'mission_id'    => new sfWidgetFormPropelChoice(array('model' => 'TaxibotMission', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'aircraft_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Aircraft', 'column' => 'id')),
      'date'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'milisecond'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'long_force_kn' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'lat_force_kn'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'veolcity'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'tiller'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'break_event'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'mission_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TaxibotMission', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('taxibot_fatigue_history_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotFatigueHistory';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'aircraft_id'   => 'ForeignKey',
      'date'          => 'Date',
      'milisecond'    => 'Number',
      'long_force_kn' => 'Number',
      'lat_force_kn'  => 'Number',
      'veolcity'      => 'Number',
      'tiller'        => 'Number',
      'break_event'   => 'Boolean',
      'mission_id'    => 'ForeignKey',
    );
  }
}
