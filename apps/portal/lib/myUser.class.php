<?php
class myUser extends sfBasicSecurityUser {
	public function getUserGroup()
	{
		$group = $this->getAttribute ( 'group', null, 'benutzer' );
		return  $group[1];
	}
}

abstract class USER_GROUP{
	const ADMIN =  'admin';
	const EDITOR =  'editor';
	const VIEWER =  'viewer';
}

