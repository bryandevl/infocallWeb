<?php namespace App\Master\Handlers\Repositories;

use App\Master\Handlers\EmpresaListInterface;
use App\Master\Models\Empresa;

class EmpresaList implements EmpresaListInterface
{
	public function list($where = [])
	{
		$list = Empresa::select("*");
		if (count($where["equals"]) > 0) {
			foreach ($where["equals"] as $key => $value) {
				$list->where($key, $value);
			}
		}
		if (count($where["raw"]) > 0) {
			foreach ($where["raw"] as $key => $value) {
				$list->whereRaw($value);
			}
		}
		return $list;
	}
}