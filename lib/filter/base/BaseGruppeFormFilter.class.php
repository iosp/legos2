<?php

/**
 * Gruppe filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseGruppeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'beschreibung'         => new sfWidgetFormFilterInput(),
      'benutzer_gruppe_list' => new sfWidgetFormPropelChoice(array('model' => 'Benutzer', 'add_empty' => true)),
      'gruppe_modul_list'    => new sfWidgetFormPropelChoice(array('model' => 'Modul', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'                 => new sfValidatorPass(array('required' => false)),
      'beschreibung'         => new sfValidatorPass(array('required' => false)),
      'benutzer_gruppe_list' => new sfValidatorPropelChoice(array('model' => 'Benutzer', 'required' => false)),
      'gruppe_modul_list'    => new sfValidatorPropelChoice(array('model' => 'Modul', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('gruppe_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addBenutzer_GruppeListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(Benutzer_GruppePeer::GRUPPE_ID, GruppePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(Benutzer_GruppePeer::BENUTZER_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(Benutzer_GruppePeer::BENUTZER_ID, $value));
    }

    $criteria->add($criterion);
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

    $criteria->addJoin(Gruppe_ModulPeer::GRUPPE_ID, GruppePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(Gruppe_ModulPeer::MODUL_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(Gruppe_ModulPeer::MODUL_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Gruppe';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'name'                 => 'Text',
      'beschreibung'         => 'Text',
      'benutzer_gruppe_list' => 'ManyKey',
      'gruppe_modul_list'    => 'ManyKey',
    );
  }
}
