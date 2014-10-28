<?php

/**
 * Subclass for representing a row from the 'gruppe' table.
 *
 * Hier sind alle Benutzergruppen des Systems gespeichert
 *
 * @package lib.model
 */
class Gruppe extends BaseGruppe {
	public function __toString() {
		return $this->getName ();
	}
}
