<?php namespace App\Validata\Handlers;

interface ValidataInterface
{
	public function saveBD($entity = [], $entityId = null);
}