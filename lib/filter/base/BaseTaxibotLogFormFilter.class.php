<?php

/**
 * TaxibotLog filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTaxibotLogFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'log_file'      => new sfWidgetFormFilterInput(),
      'tractor_id'    => new sfWidgetFormPropelChoice(array('model' => 'TaxibotTractor', 'add_empty' => true, 'key_method' => 'getTractorId')),
      'load'          => new sfWidgetFormFilterInput(),
      'date'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'load_validity' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'load_exceeded' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'log_file'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tractor_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TaxibotTractor', 'column' => 'tractor_id')),
      'load'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'date'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'load_validity' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'load_exceeded' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('taxibot_log_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotLog';
  }

  public function getFields()
  {
    return array(
      'log_id'        => 'Number',
      'log_file'      => 'Number',
      'tractor_id'    => 'ForeignKey',
      'load'          => 'Number',
      'date'          => 'Date',
      'load_validity' => 'Boolean',
      'load_exceeded' => 'Boolean',
    );
  }
}
