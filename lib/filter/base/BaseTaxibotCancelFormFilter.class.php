<?php

/**
 * TaxibotCancel filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTaxibotCancelFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'alert' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'time'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'alert' => new sfValidatorPass(array('required' => false)),
      'time'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('taxibot_cancel_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotCancel';
  }

  public function getFields()
  {
    return array(
      'id'    => 'Number',
      'alert' => 'Text',
      'time'  => 'Date',
    );
  }
}
