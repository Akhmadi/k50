<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EventUserExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    use Exportable;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return [
            'Мероприятие',
            'Имя',
            'Фамилия',
            'Телефон',
            'Эл.почта',
            'Компания',
            'Должность',
            'Выбранный пакет',
        ];
    }

    public function collection()
    {
        return $this->data;
    }

    public function AutoSize(){
        return true;
    }
}

