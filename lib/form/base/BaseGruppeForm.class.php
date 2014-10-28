<?php

/**
 * Gruppe form base class.
 *
 * @method Gruppe getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseGruppeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'name'                 => new sfWidgetFormInputText(),
      'beschreibung'         => new sfWidgetFormInputText(),
      'benutzer_gruppe_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Benutzer')),
      'gruppe_modul_list'    => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Modul')),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'                 => new sfValidatorString(array('max_length' => 255)),
      'beschreibung'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'benutzer_gruppe_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Benutzer', 'required' => false)),
      'gruppe_modul_list'    => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Modul', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('gruppe[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Gruppe';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['benutzer_gruppe_list']))
    {
      $values = array();
      foreach ($this->object->getBenutzer_Gruppes() as $obj)
      {
        $values[] = $obj->getBenutzerId();
      }

      $this->setDefault('benutzer_gruppe_list', $values);
    }

    if (isset($this->widgetSchema['gruppe_modul_list']))
    {
      $values = array();
      foreach ($this->object->getGruppe_Moduls() as $obj)
      {
        $values[] = $obj->getModulId();
      }

      $this->setDefault('gruppe_modul_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveBenutzer_GruppeList($con);
    $this->saveGruppe_ModulList($con);
  }

  public function saveBenutzer_GruppeList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['benutzer_gruppe_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(Benutzer_GruppePeer::GRUPPE_ID, $this->object->getPrimaryKey());
    Benutzer_GruppePeer::doDelete($c, $con);

    $values = $this->getValue('benutzer_gruppe_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Benutzer_Gruppe();
        $obj->setGruppeId($this->object->getPrimaryKey());
        $obj->setBenutzerId($value);
        $obj->save();
      }
    }
  }

  public function saveGruppe_ModulList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['gruppe_modul_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(Gruppe_ModulPeer::GRUPPE_ID, $this->object->getPrimaryKey());
    Gruppe_ModulPeer::doDelete($c, $con);

    $values = $this->getValue('gruppe_modul_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Gruppe_Modul();
        $obj->setGruppeId($this->object->getPrimaryKey());
        $obj->setModulId($value);
        $obj->save();
      }
    }
  }

}
