<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FinanceEntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('finance_entity')->truncate();
        DB::table('finance_entity')->insert([
            [
                'flag_type'     =>  'BANCO',
                'code'          =>  'BBVA',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("B B V A BANCO CONTINENTAL")
            ],
            [
                'flag_type'     =>  'BANCO',
                'code'          =>  'ABM',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("BANCO AZTECA DEL PERU S.A.")
            ],
            [
                'flag_type'     =>  'BANCO',
                'code'          =>  'CNC',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("BANCO CENCOSUD S.A.")
            ],
            [
                'flag_type'     =>  'BANCO',
                'code'          =>  'BANCOMER',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("BANCO DE COMERCIO")
            ],
            [
                'flag_type'     =>  'BANCO',
                'code'          =>  'BCP',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("BANCO DE CREDITO DEL PERU")
            ],
            [
                'flag_type'     =>  'BANCO',
                'code'          =>  'BN',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("BANCO DE LA NACION")
            ],
            [
                'flag_type'     =>  'BANCO',
                'code'          =>  'CMR',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("BANCO FALABELLA PERU S.A.")
            ]
        ]);
        DB::table('finance_entity')->insert([
            [
                'flag_type'     => 'BANCO',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("BANCO FINANCIERO CARTERA CREDITICIA A RECAUDO COBRANZA Y RECUPERACIONES S.A. C")
            ],
            [
                'flag_type'     => 'BANCO',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("BANCO FINANCIERO DEL PERU")
            ],
            [
                'flag_type'     => 'BANCO',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("BANCO INTERAMERICANO DE FINANZAS")
            ]
        ]);
        
        DB::table('finance_entity')->insert([    
            [
                'flag_type'     =>  'BANCO',
                'code'          =>  'IBK',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("BANCO INTERNACIONAL DEL PERU")
            ]
        ]);

        DB::table('finance_entity')->insert([
            [
                'flag_type'     => 'BANCO',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("BANCO RIPLEY PERU S.A.")
            ],
            [
                'flag_type'     => 'BANCO',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("HSBC BANK PERU S.A.")
            ],
            [
                'flag_type'     => 'BANCO',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("SCOTIABANK PERU S.A. A")
            ],
            [
                'flag_type'     => 'BANCO',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("SCOTIABANK PERU S.A. A")
            ],
            [
                'flag_type'     => 'FINANCIERA',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("CREDISCOTIA FINANCIERA S.A.")
            ],
            [
                'flag_type'     => 'FINANCIERA',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("EMPRESA FINANCIERA CONFIANZA S.A. - FINANCIERA CONFIANZA")
            ],
            [
                'flag_type'     => 'FINANCIERA',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("EMPRESA FINANCIERA CREDITOS.A.REQUIPA S.A. - FINANCIERA CREAR")
            ],
            [
                'flag_type'     => 'FINANCIERA',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("FINANCIERA EFECTIVA S.A.")
            ],
            [
                'flag_type'     => 'FINANCIERA',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("FINANCIERA PROEMPRESA S.A.")
            ],
            [
                'flag_type'     => 'FINANCIERA',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("FINANCIERA TFC S.A.")
            ],
            [
                'flag_type'     => 'FINANCIERA',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("FINANCIERA UNIVERSAL S.A.")
            ],
            [
                'flag_type'     => 'FINANCIERA',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("FINANCIERA UNO S.A.")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("CAJA MUNICIPAL DE AHORRO Y CREDITO CUSCO S.A.")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("CAJA MUNICIPAL DE AHORRO Y CREDITO DE AREQUIPA")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("CAJA MUNICIPAL DE AHORRO Y CREDITO DE SULLANA S.A.")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("CAJA MUNICIPAL DE AHORRO Y CREDITO DEL SANTA")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("CAJA MUNICIPAL DE AHORRO Y CREDITO HUANCAYO")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("CAJA MUNICIPAL DE AHORRO Y CREDITO ICA")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("CAJA MUNICIPAL DE AHORRO Y CREDITO MAYNAS")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("CAJA MUNICIPAL DE AHORRO Y CREDITO PAITA")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("CAJA MUNICIPAL DE AHORRO Y CREDITO PIURA")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("CAJA MUNICIPAL DE AHORRO Y CREDITO TACNA")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("CAJA MUNICIPAL DE AHORRO Y CREDITO TRUJILLO")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("CAJA MUNICIPAL DE CREDITO POPULAR DE LIMA")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("CAJA RURAL DE AHORRO Y CREDITO CHAVIN S.A.")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("CAJA RURAL DE AHORRO Y CREDITO LOS.A.NDES S.A.")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("CAJA RURAL DE AHORRO Y CREDITO SIPAN S.A.")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("EDPYME ACCESO CREDITICIO SOCIEDAD ANONIMA")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("EDPYME ALTERNATIVA S.A.")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("EDPYME INVERSIONES LA CRUZ S.A.")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("EDPYME MARCIMEX S.A.")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("EDPYME NUEVA VISION S.A.")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("MIBANCO BANCO DE LA MICRO EMPRESA S.A.")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("PRODUCTOS Y MERCADOS AGRICOLAS DE HUARAL CAJA RURAL DE A Y C")
            ],
            [
                'flag_type'     => 'CAJA_EDPYME_OTROS',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,
                'description'   =>  strtoupper("SERVICIO SOCIAL DEL DIRECTOR Y SUPERVISOR")
            ],
        ]);
    }
}
