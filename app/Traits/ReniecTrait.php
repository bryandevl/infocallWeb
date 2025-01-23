<?php namespace App\Traits;

use DB;

trait ReniecTrait {
    public function relativesByQuery($stringDnis = "", $type = "CONYUGES") {

        $tableName = "";
        $fuenteName = "";
        $subQueryParentezco = "";
        $subQueryId = "";

        switch ($type) {
            case "CONYUGES":
                $tableName = "reniec_conyuges";
                $fuenteName = "RENICE_CONYGUGES";
                $subQueryParentezco = "IFNULL(rc.parentezco, '')";
                $subQueryId = "rc.id AS id";
                break;
            case "HERMANOS":
                $tableName = "reniec_hermanos";
                $fuenteName = "RENIEC_HERMANOS";
                $subQueryParentezco = "'HERMANO'";
                $subQueryId = "rc.id AS id";
                break;
            case "FAMILIARES":
                $tableName = "reniec_familiares";
                $fuenteName = "RENIEC_FAMILIARES";
                $subQueryParentezco = "IFNULL(rc.tipo, '')";
                $subQueryId = "'' AS id";
                break;
            default:
                break;
        }
        $queryRelatives = "
                SELECT
                    {$subQueryId},
                    IF((rc.created_at IS NULL OR DATE(rc.created_at < '2021-08-19')), rc.documento, rc.doc_parent) AS docParent,
                    IF((rc.created_at IS NULL OR DATE(rc.created_at < '2021-08-19')), LPAD(rc.doc_parent, 8, 0), LPAD(rc.documento, 8, 0)) AS documento,
                    IFNULL(rc.nombre, '') AS nombre,
                    {$subQueryParentezco} AS parentezco,
                    '{$fuenteName}' AS fuente
                FROM {$tableName} AS rc
                    WHERE IF((rc.created_at IS NULL OR DATE(rc.created_at < '2021-08-19')), rc.documento, rc.doc_parent) IN ({$stringDnis})";

        $queryRelativesList = DB::select($queryRelatives);
        
        $queryRelativesResultList = [];
        foreach ($queryRelativesList as $key => $value) {
            if (!isset($queryRelativesResultList[$value->docParent])) {
                $queryRelativesResultList[$value->docParent] = [];
            }
            $queryRelativesResultList[$value->docParent][] = $value;
        }
        return $queryRelativesResultList;
    }
	public function getReniecRelationships() {
		return [
            "movistar" => function($q) {
                $q->select(
                    "movistar.documento",
                    "movistar.nombre",
                    "movistar.numero",
                    "movistar.origen_data",
                    "movistar.fecha_data",
                    "movistar.plan",
                    "movistar.fecha_activacion",
                    "movistar.modelo",
                    DB::raw("'MOVISTAR' AS operadora"),
                    DB::raw("IF(CHAR_LENGTH(numero) < 9, 'FIJO', 'CELULAR') AS tipoTelefono")
                );
            },
            "movistar_fijo" => function($q) {
                $q->select(
                    "movistar_fijo.documento",
                    "movistar_fijo.nombre",
                    "movistar_fijo.numero",
                    "movistar_fijo.origen_data",
                    "movistar_fijo.fecha_data",
                    "movistar_fijo.plan",
                    "movistar_fijo.fecha_activacion",
                    "movistar_fijo.modelo",
                    DB::raw("'MOVISTAR' AS operadora"),
                    DB::raw("IF(CHAR_LENGTH(numero) < 9, 'FIJO', 'CELULAR') AS tipoTelefono")
                );
            },
            "claro" => function($q) {
                $q->select(
                    "claro.documento",
                    "claro.nombre",
                    "claro.numero",
                    "claro.origen_data",
                    "claro.fecha_data",
                    "claro.plan",
                    "claro.fecha_activacion",
                    "claro.modelo",
                    DB::raw("'CLARO' AS operadora"),
                    DB::raw("IF(CHAR_LENGTH(numero) < 9, 'FIJO', 'CELULAR') AS tipoTelefono")
                );
            },
            "entel" => function($q) {
                $q->select(
                    "entel.documento",
                    "entel.nombre",
                    "entel.numero",
                    "entel.origen_data",
                    "entel.fecha_data",
                    "entel.plan",
                    "entel.fecha_activacion",
                    "entel.modelo",
                    DB::raw("'ENTEL' AS operadora"),
                    DB::raw("IF(CHAR_LENGTH(numero) < 9, 'FIJO', 'CELULAR') AS tipoTelefono")
                );
            },
            "bitel" => function($q) {
                $q->select(
                    "bitel.documento",
                    "bitel.nombre",
                    "bitel.numero",
                    "bitel.origen_data",
                    "bitel.fecha_data",
                    "bitel.plan",
                    "bitel.fecha_activacion",
                    "bitel.modelo",
                    DB::raw("'BITEL' AS operadora"),
                    DB::raw("IF(CHAR_LENGTH(numero) < 9, 'FIJO', 'CELULAR') AS tipoTelefono")
                );
            },
            "essalud",
            /*"conyugesNew",
            "conyugesOld",
            "hermanos",
            "hermanosOld",
            "familiares",
            "familiaresOld",*/
            "correos"
        ];
	}
}