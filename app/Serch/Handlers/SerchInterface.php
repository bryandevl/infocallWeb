<?php namespace App\Serch\Handlers;

interface SerchInterface
{
	public function getByApi($document = "");
	public function getByBD($document = "");
	public function saveBD($entity = [], $entityId = null);
}