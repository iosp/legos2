<?php

/**
 * ExceedEvent filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseExceedEventFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'start_time' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'end_time'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'duration'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'mission_id' => new sfWidgetFormPropelChoice(array('model' => 'TaxibotMission', 'add_empty' => true, 'key_method' => 'getMissionId')),
    ));

    $this->setValidators(array(
      'start_time' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'end_time'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'duration'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'mission_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TaxibotMission', 'column' => 'mission_id')),
    ));

    $this->widgetSchema->setNameFormat('exceed_event_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExceedEvent';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'start_time' => 'Date',
      'end_time'   => 'Date',
      'duration'   => 'Date',
      'mission_id' => 'ForeignKey',
    );
  }
}
