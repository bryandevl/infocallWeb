<?php namespace App\Master\Handlers\Repositories;

use App\Master\Handlers\SourceLogInterface;
use App\Master\Models\SourceLog;

class SourceLogRepository implements SourceLogInterface
{
	protected $_keyCache;

	public function __construct()
	{
		$this->_keyCache = \Config::get("serch.keycache.source_code");
	}
	public function getLatestByCache()
	{
		$sourceLog = \Cache::get($this->_keyCache);
        if (!$sourceLog) {
            $sourceLog = \Cache::remember(
                $this->_keyCache,
                1*60*60,
                function () {
                    return SourceLog::latest()->first()->toArray();
                }
            );
        }
        return $sourceLog;
	}
}