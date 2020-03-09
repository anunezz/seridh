<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Models\Recommendation;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

ini_set('memory_limit', '-1');
set_time_limit(0);
ini_set('max_execution_time', 0);

class RecommendationExport implements FromCollection,WithHeadings,ShouldAutoSize,WithTitle
{
    private static $ALIGNMENT = '\\PhpOffice\\PhpSpreadsheet\\Style\\Alignment';
    private static $FILL      = '\\PhpOffice\\PhpSpreadsheet\\Style\\Fill';
    private static $BORDER 	  = '\\PhpOffice\\PhpSpreadsheet\\Style\\Border';

    public function collection()
    {
        return Recommendation::all();
    }

    public function headings(): array
    {
        return [
            'Texto de recomendación',
            'Entidad Emisora',
            'Orden de Gobierno',
            'Poder de Gobierno',
            'Autoridad encargada de atender',
            'Población',
            'Acción Solicitada',
            'ODS (acrónimo)',
            'Derecho(s)',
            'Tema(s)',
            'Nombre oficial del reporte',
            'Año de registro (yyyy)',
            'Vigente (Si/No)',
            'Dirigida al Estado (Si/No)',
            'Publicado (Si/No)',
            'Folio de Documento(s)',
            'Tipo de indicador',
            'Nivel de atención ',
            'Clasificación'
        ];
    }

    public function title(): string
    {
        return 'Recomendaciones';
    }

    /*public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->styleCells(
                    'A1:H1',
                    [
                        'font' => [
                            'bold' => true,
                            'name' =>  'Montserrat',
                            'size' =>  14
                        ],
                        'alignment' => [
                            'horizontal' => static::$ALIGNMENT::HORIZONTAL_CENTER,
                            'vertical' => static::$ALIGNMENT::VERTICAL_CENTER,
                        ],
                        'fill' => [
                            'fillType' => static::$FILL::FILL_SOLID,
                            'startColor' => [
                                'argb' => 'FFCCD1D1',
                            ],
                        ]
                    ]
                );
            },
        ];
    }*/
}

