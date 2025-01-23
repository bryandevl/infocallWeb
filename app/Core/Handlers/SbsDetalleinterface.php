<?php namespace App\Core\Handlers;

use App\Core\Handlers\CoreInterface;

interface SbsDetalleInterface extends CoreInterface
{
 public function saveBD(array $entity = [], $entityId = null); 
}