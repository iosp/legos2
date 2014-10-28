<?php

/**
 * TaxibotTractor filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTaxibotTractorFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tractor_id'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name'          => new sfWidgetFormFilterInput(),
      'creation_date' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'pcm_hours'     => new sfWidgetFormFilterInput(),
      'dcm_hours'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'tractor_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'name'          => new sfValidatorPass(array('required' => false)),
      'creation_date' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'pcm_hours'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'dcm_hours'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('taxibot_tractor_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotTractor';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'tractor_id'    => 'Number',
      'name'          => 'Text',
      'creation_date' => 'Date',
      'pcm_hours'     => 'Number',
      'dcm_hours'     => 'Number',
    );
  }
}
