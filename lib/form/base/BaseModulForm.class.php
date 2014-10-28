<?php

/**
 * Modul form base class.
 *
 * @method Modul getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseModulForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'name'                => new sfWidgetFormInputText(),
      'gruppe_modul_list'   => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Gruppe')),
      'benutzer_modul_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Benutzer')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'gruppe_modul_list'   => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Gruppe', 'required' => false)),
      'benutzer_modul_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Benutzer', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('modul[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Modul';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['gruppe_modul_list']))
    {
      $values = array();
      foreach ($this->object->getGruppe_Moduls() as $obj)
      {
        $values[] = $obj->getGruppeId();
      }

      $this->setDefault('gruppe_modul_list', $values);
    }

    if (isset($this->widgetSchema['benutzer_modul_list']))
    {
      $values = array();
      foreach ($this->object->getBenutzer_Moduls() as $obj)
      {
        $values[] = $obj->getBenutzerId();
      }

      $this->setDefault('benutzer_modul_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveGruppe_ModulList($con);
    $this->saveBenutzer_ModulList($con);
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
    $c->add(Gruppe_ModulPeer::MODUL_ID, $this->object->getPrimaryKey());
    Gruppe_ModulPeer::doDelete($c, $con);

    $values = $this->getValue('gruppe_modul_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Gruppe_Modul();
        $obj->setModulId($this->object->getPrimaryKey());
        $obj->setGruppeId($value);
        $obj->save();
      }
    }
  }

  public function saveBenutzer_ModulList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['benutzer_modul_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(Benutzer_ModulPeer::MODUL_ID, $this->object->getPrimaryKey());
    Benutzer_ModulPeer::doDelete($c, $con);

    $values = $this->getValue('benutzer_modul_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Benutzer_Modul();
        $obj->setModulId($this->object->getPrimaryKey());
        $obj->setBenutzerId($value);
        $obj->save();
      }
    }
  }

}
