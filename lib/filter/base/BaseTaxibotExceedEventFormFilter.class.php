<?php

/**
 * TaxibotExceedEvent filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTaxibotExceedEventFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'exceed_type'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'start_time'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'end_time'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'start_milisecond' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'end_milisecond'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'duration'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'mission_id'       => new sfWidgetFormPropelChoice(array('model' => 'TaxibotMission', 'add_empty' => true)),
      'latitude'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'longitude'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'exceed_type'      => new sfValidatorPass(array('required' => false)),
      'start_time'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'end_time'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'start_milisecond' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'end_milisecond'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'duration'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'mission_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TaxibotMission', 'column' => 'id')),
      'latitude'         => new sfValidatorPass(array('required' => false)),
      'longitude'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('taxibot_exceed_event_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotExceedEvent';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'exceed_type'      => 'Text',
      'start_time'       => 'Date',
      'end_time'         => 'Date',
      'start_milisecond' => 'Number',
      'end_milisecond'   => 'Number',
      'duration'         => 'Date',
      'mission_id'       => 'ForeignKey',
      'latitude'         => 'Text',
      'longitude'        => 'Text',
    );
  }
}
