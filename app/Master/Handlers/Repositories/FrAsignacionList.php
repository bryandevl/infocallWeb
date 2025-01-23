<?php namespace App\Master\Handlers\Repositories;

use App\Master\Handlers\FrAsignacionListInterface;
use App\FrAsignacion;

class FrAsignacionList implements FrAsignacionListInterface
{
	public function list($where = [])
	{
		$list = FrAsignacion::select(["cNUM_DOCUMENTO", "cACTIVO", "dFEC_MODIFICA"]);
		if (isset($where["equals"]) && count($where["equals"]) > 0) {
			foreach ($where["equals"] as $key => $value) {
				$list->where($key, $value);
			}
		}
		if (isset($where["raw"]) && count($where["raw"]) > 0) {
			foreach ($where["raw"] as $key => $value) {
				$list->whereRaw($value);
			}
		}
		return $list;
	}
}