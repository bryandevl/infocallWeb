<?php namespace App\Helpers;

use App\Validata\Models\ValidataLog;
use App\Validata\Models\ValidataLogDetailSource;
use App\Helpers\CoreHelper;

class ValidataHelper
{
	public static function getFullNameRelative($relative = []) {
		$fullName = "";
		$people = [];
		$people[] = strtoupper($relative["nombres_familiar"]);
		$people[] = strtoupper($relative["paterno_familiar"]);
		$people[] = strtoupper($relative["materno_familiar"]);
		$fullName = implode(" ", $people);
		return $fullName;
	}

	public static function getFullNameGeneral($general = []) {
		$fullName = "";
		$people = [];
		if (isset($general["documento"])) {
			$people[] = strtoupper($general["nombres"]);
			$people[] = strtoupper($general["paterno"]);
			$people[] = strtoupper($general["materno"]);
		} else {
			if (isset($general["ruc"])) {
				return $general["razonsocial"];
			}
		}
		
		$fullName = implode(" ", $people);
		return $fullName;
	}

	public static function getLatestAddressByDocument($address = []) {
		$latestAddress = "";
		if (count($address) > 0) {
			array_multisort(
				array_map(
					'strtotime',
					array_column($address,'fecha_data')
				),
	            SORT_DESC, 
	            $address
	        );
	        foreach ($address as $key => $value) {
	        	if ($value["direccion"]!="") {
	        		return strtoupper($value["direccion"].", ".$value["descripcion_ubigeo"]);
	        	}
	        }
		}
		return $latestAddress;
	}

	public static function getRatingBySbsLatest($sbsLatest = null) {
		$rating = [];
		if (!is_null($sbsLatest)) {
			$rating = [
				"normal_rating"     =>  (int)$sbsLatest['normal_rating'],
	            "cpp_rating"        =>  (int)$sbsLatest['cpp_rating'],
	            "deficient_rating"  =>  (int)$sbsLatest['deficient_rating'],
	            "uncertain_rating"  =>  (int)$sbsLatest['uncertain_rating'],
	            "lost_rating"       =>  (int)$sbsLatest['lost_rating']
	        ];
	        arsort($rating);
		}
        return $rating;
	}
	
	public static function saveTraceLogDetailSource($logDetailSourceId = null, $result = []) {
		if (isset($result["rst"])) {
			if ((int)$result["rst"] == 1) {
				if (isset($result["trace"])) {
					$trace = $result["trace"];
					$trace["validata_log_detail_id"] = $logDetailSourceId;
					ValidataLogDetailSource::insert($trace);
				}
			}
		}
	}

	public static function getViewButtonStatusSbs($row, $monthYear, $sbsTwoYears = []) {
		$view = "validata.reporte-sbs.gui._gui_circle_blank_rating_grid";
		//dd($monthYear);
		if (isset($sbsTwoYears[$monthYear])) {
			$i = 0;
			foreach ($sbsTwoYears[$monthYear] as $key => $value) {
				if ($i == 0) {
					switch ($key) {
						case 'normal_rating':
							if ($row == 0) {
								$view = "validata.reporte-sbs.gui._gui_circle_normal_rating_grid";
							}
							break;
						case 'cpp_rating':
							if ($row == 2) {
								$view = "validata.reporte-sbs.gui._gui_circle_cpp_rating_grid";
							}
							break;
						case 'deficient_rating':
							
							break;
						case 'uncertain_rating':
							if ($row == 3) {
								$view = "validata.reporte-sbs.gui._gui_circle_uncertain_rating_grid";
							}
							break;
						case 'lost_rating':
							if ($row == 1) {
								$view = "validata.reporte-sbs.gui._gui_circle_lost_rating_grid";
							}
							break;
						default:
							# code...
							break;
					}
				}
				$i++;
			}
			//print_r($sbsTwoYears[$monthYear]); dd();
		}
		return $view;
	}

	public static function getButtonClassLatest($rating = []) {
		$classBtnLatest = "btn-unrate";
		$i = 0;
		foreach ($rating as $key => $value) {
			if ($i == 0) {
				switch ($key) {
					case 'normal_rating':
						$classBtnLatest = "btn-normal";
						break;
					case 'cpp_rating':
						$classBtnLatest = "btn-cpp";
						break;
					case 'deficient_rating':
						$classBtnLatest = "btn-deficient";
						break;
					case 'uncertain_rating':
						$classBtnLatest = "btn-uncertain";
						break;
					case 'lost_rating':
						$classBtnLatest = "btn-lost";
						break;
					default:
						# code...
						break;
				}
			}
			$i++;
		}
		return $classBtnLatest;
	}

	public static function getCondicionPeopleByClassBtn($classBtnRating = "") {
		$condicion = "SCAL";

		switch ($classBtnRating) {
			case "btn-normal":
				$condicion = "NOR";
                break;
            case "btn-cpp":
            	$condicion = "CPP";
            	break;
            case "btn-deficient":
            	$condicion = "DEF";
            	break;
            case "btn-uncertain":
            	$condicion = "DUD";
            	break;
            case "btn-lost":
            	$condicion = "PER";
            	break;
            default:
            	# code...
            	break;
        }
        return $condicion;
	}
}