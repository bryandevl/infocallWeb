<?php namespace App\Core\Handlers;

use App\Core\Handlers\CoreInterface;

interface SbsInterface extends CoreInterface
{
  public function saveBD(array $entity = [], $entityId = null); 
}