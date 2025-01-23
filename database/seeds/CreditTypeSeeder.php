<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CreditTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('credit_type')->truncate();
        DB::table('credit_type')->insert([
            [
                'flag_type'     => 'LINEA_TC',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Lineas de credito en tarjetas de credito de consumo")
            ],
            [
                'flag_type'     => 'SALDO_TC',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Tarjetas de credito")
            ],
            [
                'flag_type'     => 'SALDO_TC',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Tarjetas de credito contratadas por compra")
            ],
            [
                'flag_type'     => 'SALDO_TC',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Tarjetas de credito contratadas por disponibilidad en efectivo")
            ],
            [
                'flag_type'     => 'SALDO_TC',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Tarjetas de credito por compra")
            ],
            [
                'flag_type'     => 'SALDO_TC',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Tarjetas de credito por disponibilidad en efectivo")
            ],
            [
                'flag_type'     => 'SALDO_TC',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Tarjetas de creditos")
            ],
            [
                'flag_type'     => 'SALDO_DISEF',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Tarjetas de credito contratadas por disponibilidad en efectivo")
            ],
            [
                'flag_type'     => 'SALDO_DISEF',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Tarjetas de credito por disponibilidad en efectivo")
            ],
            [
                'flag_type'     => 'SALDO_CONS_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Tarjetas de credito contratadas por otros conceptos")
            ],
            [
                'flag_type'     => 'SALDO_CONS_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Tarjetas de credito por otros conceptos")
            ],
            [
                'flag_type'     => 'SALDO_CONS_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Otros prestamos")
            ],
            [
                'flag_type'     => 'SALDO_CONS_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Otros prestamos no revolventes")
            ],
            [
                'flag_type'     => 'SALDO_CONS_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Pignoraticios")
            ],
            [
                'flag_type'     => 'SALDO_CONS_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Prestamos")
            ],
            [
                'flag_type'     => 'SALDO_CONS_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Préstamos a cuota fija")
            ],
            [
                'flag_type'     => 'SALDO_CONS_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Préstamos no revolventes otorgados bajo convenios no elegibles")
            ],
            [
                'flag_type'     => 'SALDO_CONS_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Préstamos no revolventes para libre disponibilidad")
            ],
            [
                'flag_type'     => 'SALDO_CONS_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Préstamos no revolventes que cuenten con convenios de descuento por planilla y que no sean elegibles")
            ],
            [
                'flag_type'     => 'SALDO_CONS_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Prestamos no revolventes que cuentes con convenios de descuento por planilla y que sean elegibles")
            ],
            [
                'flag_type'     => 'SALDO_CONS_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Préstamos revolventes")
            ],
            [
                'flag_type'     => 'SALDO_HIP_VEH',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Otros créditos hipotecarios otorgados con recursos del Fondo MIVIVIENDA")
            ],
            [
                'flag_type'     => 'SALDO_HIP_VEH',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Préstamos con hipoteca inscrita")
            ],
            [
                'flag_type'     => 'SALDO_HIP_VEH',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Préstamos del Fondo Mi-Vivienda")
            ],
            [
                'flag_type'     => 'SALDO_HIP_VEH',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Préstamos Mivivienda otorgados con recusos de Instituciones Financieras")
            ],
            [
                'flag_type'     => 'SALDO_HIP_VEH',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Préstamos no revolventes para automóviles")
            ],
            [
                'flag_type'     => 'SALDO_CAST_REF',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Créditos castigados")
            ],
            [
                'flag_type'     => 'SALDO_CAST_REF',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Créditos castigados que vienen siendo amortizados")
            ],
            [
                'flag_type'     => 'SALDO_CAST_REF',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Créditos refinanciados")
            ],
            [
                'flag_type'     => 'SALDO_CAST_REF',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("Créditos refinanciados y reestructurados reclasificados como vigentes")
            ],
        ]);
    }
}
