<?php

/**
 * TaxibotTrail filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTaxibotTrailFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'latitude'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'longitude'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'time'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'mission_id' => new sfWidgetFormPropelChoice(array('model' => 'TaxibotMission', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'latitude'   => new sfValidatorPass(array('required' => false)),
      'longitude'  => new sfValidatorPass(array('required' => false)),
      'time'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'mission_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TaxibotMission', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('taxibot_trail_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotTrail';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'latitude'   => 'Text',
      'longitude'  => 'Text',
      'time'       => 'Date',
      'mission_id' => 'ForeignKey',
    );
  }
}
