<?php namespace App\Core\Handlers;

interface CoreInterface
{
	public function saveBD(array $entity = [], $entityId = null);
}