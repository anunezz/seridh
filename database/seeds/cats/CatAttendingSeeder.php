<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CatAttendingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attendings=[
            ['id' => 1, 'name' => 'Auditoría Superior de la Federación', 'acronym' => 'ASF', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'Cámara de Diputados', 'acronym' => 'DIPUTADOS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'Cámara de Senadores', 'acronym' => 'SENADO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'name' => 'Comisión Ejecutiva de Atención a Víctimas', 'acronym' => 'CEAV', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'name' => 'Comisión Federal de Electricidad', 'acronym' => 'CFE', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'name' => 'Comisión Mexicana de Ayuda a Refugiados', 'acronym' => 'COMAR', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'name' => 'Comisión Nacional contra las Adicciones', 'acronym' => 'CONADIC', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'name' => 'Comisión Nacional de los Derechos Humanos', 'acronym' => 'CNDH', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'name' => 'Comisión Nacional de los Salarios Mínimos', 'acronym' => 'CONASAMI', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 10, 'name' => 'Comisión Nacional de Tribunales Superiores de Justicia de los Estados Unidos Mexicanos', 'acronym' => 'CONATRIB', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 11, 'name' => 'Comisión Nacional de Vivienda', 'acronym' => 'CONAVI', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 12, 'name' => 'Comisión Nacional del Agua', 'acronym' => 'CONAGUA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 13, 'name' => 'Comisión Nacional para el Conocimiento y Uso de la Biodiversidad', 'acronym' => 'CONABIO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 14, 'name' => 'Comisión Nacional para la Prevención y el Control del VIH y el SIDA', 'acronym' => 'CENSIDA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 15, 'name' => 'Comisión Nacional para Prevenir y Erradicar la Violencia contra las Mujeres', 'acronym' => 'CONAVIM', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 16, 'name' => 'Comisión para el Diálogo con los Pueblos Indígenas de México', 'acronym' => 'CDPIM', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 17, 'name' => 'Conferencia Nacional de Gobernadores', 'acronym' => 'CONAGO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 18, 'name' => 'Conferencia Nacional de Procuración de Justicia', 'acronym' => 'CNPJ', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 19, 'name' => 'Conferencia Permanente de Congresos Locales', 'acronym' => 'COPECOL', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 20, 'name' => 'Consejería Jurídica del Ejecutivo Federal', 'acronym' => 'CJEF', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 21, 'name' => 'Consejo de la Judicatura Federal', 'acronym' => 'CJF', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 22, 'name' => 'Consejo Nacional de Evaluación de la Política de Desarrollo Social', 'acronym' => 'CONEVAL', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 23, 'name' => 'Consejo Nacional de Población', 'acronym' => 'CONAPO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 24, 'name' => 'Consejo Nacional para Prevenir la Discriminación', 'acronym' => 'CONAPRED', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 25, 'name' => 'Fiscalía General de la República', 'acronym' => 'FGR', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 26, 'name' => 'Instituto de Seguridad y Servicios Sociales de los Trabajadores del Estado', 'acronym' => 'ISSSTE', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 27, 'name' => 'Instituto del Fondo Nacional de la Vivienda para los Trabajadores','acronym' => 'INFONAVIT', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 28, 'name' => 'Instituto Federal de Telecomunicaciones', 'acronym' => 'IFT', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 29, 'name' => 'Instituto Mexicano del Seguro Social', 'acronym' => 'IMSS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 30, 'name' => 'Instituto Nacional de Economía Social', 'acronym' => 'INAES', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 31, 'name' => 'Instituto Nacional de Estadística y Geografía', 'acronym' => 'INEGI', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 32, 'name' => 'Instituto Nacional de las Mujeres', 'acronym' => 'INMUJERES', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 33, 'name' => 'Instituto Nacional de Lenguas Indígenas', 'acronym' => 'INALI', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 34, 'name' => 'Instituto Nacional de los Pueblos Indígenas', 'acronym' => 'INPI', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 35, 'name' => 'Instituto Nacional de Migración', 'acronym' => 'INM', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 36, 'name' => 'Instituto Nacional Electoral', 'acronym' => 'INE', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 37, 'name' => 'Instituto Nacional para la Educación de los Adultos', 'acronym' => 'INEA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 38, 'name' => 'Procuraduría Agraria', 'acronym' => 'PA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 39, 'name' => 'Procuraduría Federal de Protección al Ambiente', 'acronym' => 'PROFEPA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 40, 'name' => 'Secretaría de Agricultura y Desarrollo Rural', 'acronym' => 'SADER', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 41, 'name' => 'Secretaría de Bienestar', 'acronym' => 'BIENESTAR', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 42, 'name' => 'Secretaría de Comunicaciones y Transportes', 'acronym' => 'SCT', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 43, 'name' => 'Secretaría de Cultura', 'acronym' => 'CULTURA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 44, 'name' => 'Secretaría de Desarrollo Agrario, Territorial y Urbano', 'acronym' => 'SEDATU', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 45, 'name' => 'Secretaría de Economía', 'acronym' => 'SEECO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 46, 'name' => 'Secretaría de Educación Pública', 'acronym' => 'SEP', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 47, 'name' => 'Secretaría de Energía', 'acronym' => 'SENER', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 48, 'name' => 'Secretaría de Gobernación', 'acronym' => 'SEGOB', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 49, 'name' => 'Secretaría de Hacienda y Crédito Público', 'acronym' => 'SHCP', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 50, 'name' => 'Secretaría de la Defensa Nacional', 'acronym' => 'SEDENA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 51, 'name' => 'Secretaría de la Función Pública', 'acronym' => 'SFP', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 52, 'name' => 'Secretaría de Marina', 'acronym' => 'SEMAR', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 53, 'name' => 'Secretaría de Medio Ambiente y Recursos Naturales', 'acronym' => 'SEMARNAT', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 54, 'name' => 'Secretaría de Relaciones Exteriores', 'acronym' => 'SRE', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 55, 'name' => 'Secretaría de Salud', 'acronym' => 'SSA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 56, 'name' => 'Secretaría de Seguridad y Protección Ciudadana', 'acronym' => 'SSPC', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 57, 'name' => 'Secretaría de Turismo', 'acronym' => 'SECTUR', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 58, 'name' => 'Secretaría del Trabajo y Previsión Social', 'acronym' => 'STPS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 59, 'name' => 'Sistema Nacional de Protección de Niñas, Niños y Adolescentes', 'acronym' => 'SIPINNA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 60, 'name' => 'Sistema Nacional de Seguridad Pública', 'acronym' => 'SNSP', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 61, 'name' => 'Sistema Nacional para el Desarrollo Integral de la Familia', 'acronym' => 'SNDIF', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 62, 'name' => 'Suprema Corte de Justicia de la Nación', 'acronym' => 'SCJN', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 63, 'name' => 'Tribunal Agrario', 'acronym' => 'TA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 64, 'name' => 'Tribunal Electoral del Poder Judicial de la Federación', 'acronym' => 'TEPJF', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 65, 'name' => 'No aplica', 'acronym' => 'NA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 66, 'name' => 'Archivo General de la Nación', 'acronym' => 'AGN', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 67, 'name' => 'Gobierno del Estado Libre y Soberano de Campeche', 'acronym' => 'CAMPECHE', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 68, 'name' => 'Gobierno del Estado Libre y Soberano de Chiapas', 'acronym' => 'CHIAPAS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 69, 'name' => 'Gobierno del Estado Libre y Soberano de Chihuahua', 'acronym' => 'CHIHUAHUA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 70, 'name' => 'Gobierno del Estado Libre y Soberano de Morelos', 'acronym' => 'MORELOS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 71, 'name' => 'Gobierno del Estado Libre y Soberano de Nuevo León', 'acronym' => 'NL', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 72, 'name' => 'Gobierno del Estado Libre y Soberano de Oaxaca', 'acronym' => 'OAXACA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 73, 'name' => 'Gobierno del Estado Libre y Soberano de Puebla', 'acronym' => 'PUEBLA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 74, 'name' => 'Gobierno del Estado Libre y Soberano de Sinaloa', 'acronym' => 'SINALOA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 75, 'name' => 'Gobierno del Estado Libre y Soberano de Tabasco', 'acronym' => 'TABASCO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 76, 'name' => 'Gobierno del Estado Libre y Soberano de Veracruz', 'acronym' => 'VERACRUZ', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 77, 'name' => 'Gobierno del Estado Libre y Soberano de Yucatán', 'acronym' => 'YUCATAN', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 78, 'name' => 'Secretaría Ejecutiva del Sistema Nacional Anticorrupción', 'acronym' => 'SESNA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 79, 'name' => 'Comisión Nacional de Búsqueda', 'acronym' => 'CNB', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 80, 'name' => 'Consejo Nacional para el Desarrollo y la Inclusión de las Personas con Discapacidad', 'acronym' => 'CONADIS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 81, 'name' => 'Instituto Nacional de Ciencias Penales', 'acronym' => 'INACIPE', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 82, 'name' => 'Instituto Nacional de Transparencia, Acceso a la Información y Protección de Datos Personales', 'acronym' => 'INAI', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 83, 'name' => 'Servicio de Administración Tributaria', 'acronym' => 'SAT', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ];
        DB::table('cat_attendings')->insert($attendings);
    }
}
