<?php namespace App\Master\Handlers\Repositories;

use App\Master\Handlers\FinanceEntityListInterface;
use App\Master\Models\FinanceEntity;

class FinanceEntityList implements FinanceEntityListInterface
{
	protected $_keyCache;

	public function __construct()
	{
		$this->_keyCache = \Config::get("master.keycache.list.financeEntity");
	}
	public function list($where = [])
	{
		$list = FinanceEntity::select("*");
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

	public function getActiveByCache()
	{
		$whereTmp = [
			"equals" => ["status" => 1],
			"raw" => []
		];

		$listTmp = \Cache::get($this->_keyCache);
		if (!$listTmp) {
			$listTmp = $this->list($whereTmp)->get();
			$listTmp = $listTmp->toArray();
			\Cache::remember(
				$this->_keyCache,
				1*60*60,
				function() use ($listTmp) {
					return $listTmp;
				}
			);
		}
		return $listTmp;
	}
}