<?php namespace App\Serch\Handlers;

use App\Serch\Handlers\SerchInterface;

interface SerchPeopleTelefonoInterface extends SerchInterface
{
	public function getOperador($origenData = "");
	public function getTipoTelefono($origenData = "");
}