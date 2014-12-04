<?php

/**
 * TaxibotPartsMission filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTaxibotPartsMissionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'mission_id'         => new sfWidgetFormPropelChoice(array('model' => 'TaxibotMission', 'add_empty' => true)),
      'start'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'end'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'left_engine_fuel'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'right_engine_fuel'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'left_engine_hours'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'right_engine_hours' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'type'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'mission_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TaxibotMission', 'column' => 'id')),
      'start'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'end'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'left_engine_fuel'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'right_engine_fuel'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'left_engine_hours'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'right_engine_hours' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'type'               => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('taxibot_parts_mission_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotPartsMission';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'mission_id'         => 'ForeignKey',
      'start'              => 'Date',
      'end'                => 'Date',
      'left_engine_fuel'   => 'Number',
      'right_engine_fuel'  => 'Number',
      'left_engine_hours'  => 'Number',
      'right_engine_hours' => 'Number',
      'type'               => 'Text',
    );
  }
}
