<?php namespace App\Traits;

use DB;

trait LogTrait {
	public function listLog($request) {
		$logList = 
			DB::table("serch_log AS vl")
                ->select([
                    "vl.*",
                    DB::raw("
                        IFNULL(
                        (SELECT count(vld.id)
                            FROM serch_log_detail AS vld
                            WHERE vld.serch_log_id = vl.id
                            AND vld.deleted_at IS NULL),
                        0)+ vl.duplicate_total_on_period AS 'total'"),
                    DB::raw("
                        IFNULL(
                        (SELECT count(vld.id)
                            FROM serch_log_detail AS vld
                            WHERE status='REGISTER' AND vld.serch_log_id = vl.id
                            AND vld.deleted_at IS NULL),
                        0) AS 'total_pending'"),
                    DB::raw("
                        IFNULL(
                        (SELECT count(vld.id)
                            FROM serch_log_detail AS vld
                            WHERE status='PROCESS' AND vld.serch_log_id = vl.id
                            AND vld.deleted_at IS NULL),
                        0) AS 'total_process'"),
                    DB::raw("
                        IFNULL(
                        (SELECT count(vld.id)
                            FROM serch_log_detail AS vld
                            WHERE status='FAILED' AND vld.serch_log_id = vl.id
                            AND vld.deleted_at IS NULL),
                        0) AS 'total_failed'"),
                    DB::raw("
                        IFNULL(
                        (SELECT count(vld.id)
                            FROM serch_log_detail AS vld
                            WHERE status='ONQUEUE' AND vld.serch_log_id = vl.id
                            AND vld.deleted_at IS NULL),
                        0) AS 'total_onqueue'"),
                    DB::raw("
                        IFNULL(
                        (SELECT count(vld.id)
                            FROM serch_log_detail AS vld
                            WHERE status='REPEAT' AND vld.serch_log_id = vl.id
                            AND vld.deleted_at IS NULL),
                        0) AS 'total_repeat'"),
                    DB::raw("
                        IFNULL(
                        (SELECT count(vld.id)
                            FROM serch_log_detail AS vld
                            WHERE status='NOTDATA' AND vld.serch_log_id = vl.id
                            AND vld.deleted_at IS NULL),
                        0) AS 'total_notdata'"),
                ])->whereRaw("vl.deleted_at IS NULL");
        return $logList;
	}
}