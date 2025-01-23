<?php namespace App\Serch\Handlers\Repositories;

use App\Serch\Handlers\SerchLogInterface;
use App\Serch\Models\SerchLog;

class SerchLogRepository implements SerchLogInterface
{
	protected $_keyCache;

	public function __construct()
	{
		$this->_keyCache = \Config::get("serch.keycache.serch_code");
	}
	public function getLatestByCache()
	{
		$serchLog = \Cache::get($this->_keyCache);
        if (!$serchLog) {
            $serchLog = \Cache::remember(
                $this->_keyCache,
                1*60*60,
                function () {
                    return SerchLog::latest()->first()->toArray();
                }
            );
        }
        return $serchLog;
	}
}