<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CatSubCategorySubRightsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subCategorySubrights= [
            ['id' =>  1, 'sub_rights_id' => 1, 'name' =>  'Derecho a no ser sometido a ejecuciones sumarias, extrajudiciales o arbitrarias', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  2, 'sub_rights_id' => 1, 'name' =>  'Derecho a no ser sometido a pena de muerte', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  3, 'sub_rights_id' => 2, 'name' =>  'Derecho a no ser sometido a tortura', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  4, 'sub_rights_id' => 2, 'name' =>  'Derecho a no ser sometido a tratos o penas crueles, inhumanos y/o degradantes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  5, 'sub_rights_id' => 2, 'name' =>  'Derecho a no ser sometido con uso excesivo de la fuerza', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  6, 'sub_rights_id' => 3, 'name' =>  'Derecho a no ser sometido a desaparición forzada', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  7, 'sub_rights_id' => 3, 'name' =>  'Derecho a no ser sometido a detención arbitraria', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  8, 'sub_rights_id' => 3, 'name' =>  'Derecho a la información detallada sobre la causa de la detención', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  9, 'sub_rights_id' => 3, 'name' =>  'Derecho a ser presentado ante un juez en un plazo razonable', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  10, 'sub_rights_id' => 3, 'name' =>  'Derecho a una compensación adecuada en caso de detención arbitraria', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  11, 'sub_rights_id' => 3, 'name' =>  'Derecho al control judicial de la detención', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  12, 'sub_rights_id' => 3, 'name' =>  'Derecho a la libertad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  13, 'sub_rights_id' => 4, 'name' =>  'Derecho al acceso a la justicia y la protección judicial', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  14, 'sub_rights_id' => 4, 'name' =>  'Derecho a ser juzgado en audiencia pública por un juez o tribunal competente, independiente e imparcial', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  15, 'sub_rights_id' => 4, 'name' =>  'Derecho a la igualdad entre las partes durante un proceso legal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  16, 'sub_rights_id' => 4, 'name' =>  'Derecho a una defensa adecuada', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  17, 'sub_rights_id' => 4, 'name' =>  'Derecho a contar con un traductor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  18, 'sub_rights_id' => 4, 'name' =>  'Derecho a la presunción de inocencia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  19, 'sub_rights_id' => 4, 'name' =>  'Derecho a ser notificado sin demora de los cargos que se le imputan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  20, 'sub_rights_id' => 4, 'name' =>  'Derecho a no ser juzgado por un delito que no está en la ley', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  21, 'sub_rights_id' => 4, 'name' =>  'Derecho a no declarar en su contra y a no declararse culpable', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  22, 'sub_rights_id' => 4, 'name' =>  'Derecho de ser juzgado y recibir sentencia dentro de un plazo razonable', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  23, 'sub_rights_id' => 4, 'name' =>  'Derecho de no ser juzgado dos veces por el mismo delito', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  24, 'sub_rights_id' => 4, 'name' =>  'Derecho a la libertad bajo caución', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  25, 'sub_rights_id' => 4, 'name' =>  'Derecho a la aplicación del principio de legalidad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  26, 'sub_rights_id' => 4, 'name' =>  'Derecho a la prohibición de la obstaculización de la labor de la justicia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  27, 'sub_rights_id' => 4, 'name' =>  'Derecho a la no aplicación retroactiva de la ley en su perjuicio', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  28, 'sub_rights_id' => 4, 'name' =>  'Derecho a estar presente en el proceso judicial', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  29, 'sub_rights_id' => 4, 'name' =>  'Derecho a que fallos y sentencias sean sometidos a control judicial', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  30, 'sub_rights_id' => 5, 'name' =>  'Derecho a votar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  31, 'sub_rights_id' => 5, 'name' =>  'Derecho a postularse a un cargo público', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  32, 'sub_rights_id' => 5, 'name' =>  'Derecho a acceder en condiciones de igualdad a cargos públicos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  33, 'sub_rights_id' => 5, 'name' =>  'Derecho de participación en la dirección de asuntos públicos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  34, 'sub_rights_id' => 6, 'name' =>  'Derecho a la libertad de expresión', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  35, 'sub_rights_id' => 6, 'name' =>  'Derecho al acceso a la información', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  36, 'sub_rights_id' => 7, 'name' =>  'Derecho a la libertad de pensamiento', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  37, 'sub_rights_id' => 7, 'name' =>  'Derecho a la libertad de conciencia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  38, 'sub_rights_id' => 7, 'name' =>  'Derecho a la libertad de religión', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  39, 'sub_rights_id' => 8, 'name' =>  'Derecho a la libertad de asociación pacífica', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  40, 'sub_rights_id' => 8, 'name' =>  'Derecho a la libertad de reunión y manifestación pacífica', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  41, 'sub_rights_id' => 8, 'name' =>  'Derecho a la protesta social pacífica', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  42, 'sub_rights_id' => 9, 'name' =>  'Derecho a la libre circulación', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  43, 'sub_rights_id' => 9, 'name' =>  'Derecho a la libertad de residencia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  44, 'sub_rights_id' => 9, 'name' =>  'Derecho a ingresar y salir del país', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  45, 'sub_rights_id' => 9, 'name' =>  'Derecho a no ser sometido a desplazamiento forzado', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  46, 'sub_rights_id' => 10, 'name' =>  'Derecho a no ser objeto de injerencias arbitrarias o ilegales en la vida privada, familiar o correspondencia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  47, 'sub_rights_id' => 10, 'name' =>  'Derecho a no ser objeto de revisiones o cateos ilegales', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  48, 'sub_rights_id' => 11, 'name' =>  'Derecho a la protección de la familia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  49, 'sub_rights_id' => 11, 'name' =>  'Derecho a la libertad de matrimonio', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  50, 'sub_rights_id' => 11, 'name' =>  'Derecho a fundar una familia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  51, 'sub_rights_id' => 11, 'name' =>  'Derecho a la igualdad de los cónyuges', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  52, 'sub_rights_id' => 13, 'name' =>  'Derecho a no ser sometido a discriminación por género/sexo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  53, 'sub_rights_id' => 13, 'name' =>  'Derecho a no ser sometido a discriminación por raza/etnia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  54, 'sub_rights_id' => 13, 'name' =>  'Derecho a no ser sometido a discriminación por religión', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  55, 'sub_rights_id' => 13, 'name' =>  'Derecho a no ser sometido a discriminación por discapacidad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  56, 'sub_rights_id' => 13, 'name' =>  'Derecho a no ser sometido a discriminación por orientación sexual, identidad de género, características sexuales o corporales', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  57, 'sub_rights_id' => 14, 'name' =>  'Derecho a no ser sometido a esclavitud', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  58, 'sub_rights_id' => 14, 'name' =>  'Derecho a no ser sometido a servidumbre', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  59, 'sub_rights_id' => 14, 'name' =>  'Derecho a no ser sometido a trabajo forzoso u obligatorio', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  60, 'sub_rights_id' => 14, 'name' =>  'Derecho a no ser sometido al tráfico ilícito de personas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  61, 'sub_rights_id' => 14, 'name' =>  'Derecho a no ser sometido a la trata de personas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  62, 'sub_rights_id' => 19, 'name' =>  'Derecho a ganarse la vida mediante un trabajo libremente escogido', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  63, 'sub_rights_id' => 19, 'name' =>  'Derecho a la protección contra la explotación laboral', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  64, 'sub_rights_id' => 20, 'name' =>  'Derecho a un salario equitativo e igual por trabajo de igual valor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  65, 'sub_rights_id' => 20, 'name' =>  'Derecho a una remuneración que garantice condiciones de vida dignas para los trabajadores y sus familias', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  66, 'sub_rights_id' => 20, 'name' =>  'Derecho a la seguridad y la higiene en el trabajo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  67, 'sub_rights_id' => 20, 'name' =>  'Derecho al descanso', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  68, 'sub_rights_id' => 21, 'name' =>  'Derecho a formar sindicatos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  69, 'sub_rights_id' => 21, 'name' =>  'Derecho a afiliarse al sindicato de su elección', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  70, 'sub_rights_id' => 21, 'name' =>  'Derecho de los sindicatos a funcionar libremente', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  71, 'sub_rights_id' => 21, 'name' =>  'Derecho de huelga', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  72, 'sub_rights_id' => 23, 'name' =>  'Derecho a la educación primaria obligatoria y gratuita', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  73, 'sub_rights_id' => 23, 'name' =>  'Derecho a la educación secundaria obligatoria y gratuita', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  74, 'sub_rights_id' => 23, 'name' =>  'Derecho a la libre elección de la educación', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  75, 'sub_rights_id' => 23, 'name' =>  'Derecho a la libertad a establecer escuelas privadas y enviar a sus hijos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  76, 'sub_rights_id' => 23, 'name' =>  'Derecho a la educación de calidad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  77, 'sub_rights_id' => 24, 'name' =>  'Derecho a servicios públicos de salud', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  78, 'sub_rights_id' => 26, 'name' =>  'Derecho a no ser objeto de desalojos forzados', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  79, 'sub_rights_id' => 31, 'name' =>  'Derecho a participar en la vida cultural', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  80, 'sub_rights_id' => 31, 'name' =>  'Derecho a beneficiarse del progreso científico y sus aplicaciones', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  81, 'sub_rights_id' => 31, 'name' =>  'Derecho a libertad para investigación científica y la actividad creativa', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  82, 'sub_rights_id' => 32, 'name' =>  'Derecho a no ser sometido a violencia, malos tratos y/o abandono', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  83, 'sub_rights_id' => 32, 'name' =>  'Derecho a la nutrición infantil', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  84, 'sub_rights_id' => 32, 'name' =>  'Derecho a la salud infantil', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  85, 'sub_rights_id' => 32, 'name' =>  'Derecho a ser registrado, al nombre y a la nacionalidad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  86, 'sub_rights_id' => 32, 'name' =>  'Derecho a no ser sometido a explotación, pornografía y abuso infantil', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  87, 'sub_rights_id' => 32, 'name' =>  'Derecho a no ser objeto de trabajo infantil', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  88, 'sub_rights_id' => 32, 'name' =>  'Derechos de las niñas, niños y adolescentes con discapacidad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  89, 'sub_rights_id' => 32, 'name' =>  'Derechos de los niños, niñas y adolescentes en conflicto con la ley', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  90, 'sub_rights_id' => 32, 'name' =>  'Derechos de la niñez en situación de calle', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  91, 'sub_rights_id' => 32, 'name' =>  'Derecho a expresar su opinión en los asuntos que les afectan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  92, 'sub_rights_id' => 32, 'name' =>  'Derecho a la aplicación del principio del interés superior de la niñez', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  93, 'sub_rights_id' => 32, 'name' =>  'Derechos de la niñez migrante', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  94, 'sub_rights_id' => 32, 'name' =>  'Derechos de la niñez indígena', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  95, 'sub_rights_id' => 33, 'name' =>  'Derecho a una vida libre de violencia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  96, 'sub_rights_id' => 33, 'name' =>  'Derechos sexuales y reproductivos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  97, 'sub_rights_id' => 33, 'name' =>  'Derechos políticos de las mujeres', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  98, 'sub_rights_id' => 33, 'name' =>  'Derecho a la protección en el trabajo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  99, 'sub_rights_id' => 33, 'name' =>  'Derecho a la igualdad de género', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  100, 'sub_rights_id' => 34, 'name' =>  'Derecho a un recurso de inconformidad en caso de expulsión', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  101, 'sub_rights_id' => 34, 'name' =>  'Derecho a no ser objeto de deportación arbitraria', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  102, 'sub_rights_id' => 34, 'name' =>  'Derecho a no ser objeto de expulsión masiva', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  103, 'sub_rights_id' => 34, 'name' =>  'Derecho a la protección consular (notificación)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  104, 'sub_rights_id' => 35, 'name' =>  'Derecho de asilo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  105, 'sub_rights_id' => 35, 'name' =>  'Derecho de reunificación familiar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  106, 'sub_rights_id' => 35, 'name' =>  'Derecho a la aplicación del principio de no devolución', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  107, 'sub_rights_id' => 35, 'name' =>  'Derecho a la revisión en caso de expulsión', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  108, 'sub_rights_id' => 35, 'name' =>  'Derecho a solicitar el reconocimiento de la condición de refugiado', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  109, 'sub_rights_id' => 35, 'name' =>  'Derecho a solicitar asilo político', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  110, 'sub_rights_id' => 36, 'name' =>  'Derecho a la autodeterminación', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  111, 'sub_rights_id' => 36, 'name' =>  'Derecho a la consulta previa, libre e informada', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  112, 'sub_rights_id' => 36, 'name' =>  'Derecho a conservar y aplicar sus sistemas normativos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  113, 'sub_rights_id' => 36, 'name' =>  'Derecho a conservar y aplicar sus sistemas electorales y de organización política', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  114, 'sub_rights_id' => 36, 'name' =>  'Derecho a disponer sobre los recursos naturales', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  115, 'sub_rights_id' => 36, 'name' =>  'Derecho de reconocimiento de propiedad ancestral y posesión de tierras', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  116, 'sub_rights_id' => 36, 'name' =>  'Derecho al acceso a la justicia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  117, 'sub_rights_id' => 36, 'name' =>  'Derecho a preservar, expresar y desarrollar libremente su cultura', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  118, 'sub_rights_id' => 36, 'name' =>  'Derecho a ejercer libertad de conciencia, de religión y práctica espiritual', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  119, 'sub_rights_id' => 36, 'name' =>  'Derecho de reconocimiento a la práctica de su medicina tradicional', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  120, 'sub_rights_id' => 36, 'name' =>  'Derecho a la educación intercultural y bilingüe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  121, 'sub_rights_id' => 36, 'name' =>  'Derecho a determinar su propio concepto desarrollo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  122, 'sub_rights_id' => 37, 'name' =>  'Derecho a no ser objeto de incomunicación y aislamiento', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  123, 'sub_rights_id' => 37, 'name' =>  'Derecho al acceso a la salud', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  124, 'sub_rights_id' => 37, 'name' =>  'Derecho a condiciones dignas y salubres de detención', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  125, 'sub_rights_id' => 37, 'name' =>  'Derecho de las personas procesadas a estar separadas de las condenadas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  126, 'sub_rights_id' => 37, 'name' =>  'Derecho a no ser objeto de la aplicación arbitraria del sistema disciplinario', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  127, 'sub_rights_id' => 37, 'name' =>  'Derecho a no ser objeto de discriminación post carcelaria', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  128, 'sub_rights_id' => 37, 'name' =>  'Derecho a la separación entre hombres y mujeres en centros de detención', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  129, 'sub_rights_id' => 38, 'name' =>  'Derecho a la habilitación y rehabilitación', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  130, 'sub_rights_id' => 38, 'name' =>  'Derecho a la educación inclusiva', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  131, 'sub_rights_id' => 38, 'name' =>  'Derecho a trabajar en igualdad de condiciones con las demás personas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  132, 'sub_rights_id' => 38, 'name' =>  'Derecho a la accesibilidad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  133, 'sub_rights_id' => 38, 'name' =>  'Derecho a la participación en la vida política', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  134, 'sub_rights_id' => 38, 'name' =>  'Derecho a la participación en la vida cultural, las actividades recreativas, el esparcimiento y el deporte', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  135, 'sub_rights_id' => 38, 'name' =>  'Derecho de acceso a la información y las comunicaciones', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  136, 'sub_rights_id' => 38, 'name' =>  'Derecho a la protección contra la explotación, la violencia y el abuso', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  137, 'sub_rights_id' => 38, 'name' =>  'Derecho a vivir de forma independiente y a ser incluido en la comunidad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  138, 'sub_rights_id' => 38, 'name' =>  'Derecho a la movilidad personal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  139, 'sub_rights_id' => 38, 'name' =>  'Derechos de las mujeres con discapacidad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  140, 'sub_rights_id' => 38, 'name' =>  'Derechos de las niñas, niños y adolescentes con discapacidad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  141, 'sub_rights_id' => 38, 'name' =>  'Derecho a la seguridad y protección en situaciones de riesgo y emergencias humanitarias.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  142, 'sub_rights_id' => 39, 'name' =>  'Derecho a la protección de las personas adultas mayores', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  143, 'sub_rights_id' => 40, 'name' =>  'Derecho a gozar y ejercer sus derechos en comunidad con los demás miembros de su grupo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  144, 'sub_rights_id' => 42, 'name' =>  'Derecho a la memoria', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>  145, 'sub_rights_id' => 42, 'name' =>  'Derecho a la reparación integral del daño', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ];

        DB::table('cat_subcategory_subrights')->insert($subCategorySubrights);
    }
}
