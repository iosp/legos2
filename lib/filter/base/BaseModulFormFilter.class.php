<?php

/**
 * Modul filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseModulFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                => new sfWidgetFormFilterInput(),
      'gruppe_modul_list'   => new sfWidgetFormPropelChoice(array('model' => 'Gruppe', 'add_empty' => true)),
      'benutzer_modul_list' => new sfWidgetFormPropelChoice(array('model' => 'Benutzer', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'                => new sfValidatorPass(array('required' => false)),
      'gruppe_modul_list'   => new sfValidatorPropelChoice(array('model' => 'Gruppe', 'required' => false)),
      'benutzer_modul_list' => new sfValidatorPropelChoice(array('model' => 'Benutzer', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('modul_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addGruppe_ModulListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(Gruppe_ModulPeer::MODUL_ID, ModulPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(Gruppe_ModulPeer::GRUPPE_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(Gruppe_ModulPeer::GRUPPE_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addBenutzer_ModulListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(Benutzer_ModulPeer::MODUL_ID, ModulPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(Benutzer_ModulPeer::BENUTZER_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(Benutzer_ModulPeer::BENUTZER_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Modul';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'name'                => 'Text',
      'gruppe_modul_list'   => 'ManyKey',
      'benutzer_modul_list' => 'ManyKey',
    );
  }
}
