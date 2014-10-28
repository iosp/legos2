<?php

/**
 * TaxibotAlert filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTaxibotAlertFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'alert' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'alert' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('taxibot_alert_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotAlert';
  }

  public function getFields()
  {
    return array(
      'id'    => 'Number',
      'alert' => 'Text',
    );
  }
}
