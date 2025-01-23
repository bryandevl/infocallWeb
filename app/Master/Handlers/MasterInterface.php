<?php namespace App\Master\Handlers;

interface MasterInterface
{
	public function saveBD($entity = [], $entityId = null);
	public function saveByAPI($infoApi = []);
}