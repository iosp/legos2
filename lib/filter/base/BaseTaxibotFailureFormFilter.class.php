<?php

/**
 * TaxibotFailure filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTaxibotFailureFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'dates'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'taxibot_number'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'failure_family'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mode_of_operation' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mission'           => new sfWidgetFormPropelChoice(array('model' => 'TaxibotMission', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'              => new sfValidatorPass(array('required' => false)),
      'dates'             => new sfValidatorPass(array('required' => false)),
      'taxibot_number'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'failure_family'    => new sfValidatorPass(array('required' => false)),
      'mode_of_operation' => new sfValidatorPass(array('required' => false)),
      'mission'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TaxibotMission', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('taxibot_failure_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotFailure';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'name'              => 'Text',
      'dates'             => 'Text',
      'taxibot_number'    => 'Number',
      'failure_family'    => 'Text',
      'mode_of_operation' => 'Text',
      'mission'           => 'ForeignKey',
    );
  }
}
