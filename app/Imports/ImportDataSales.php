<?php

namespace App\Imports;

use App\Models\DataSales;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Helpers\CleanNoHP;

// // =================
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Support\Collection;
// use Illuminate\Support\Facades\Hash;
// use Maatwebsite\Excel\Concerns\Importable;
// use Maatwebsite\Excel\Concerns\RegistersEventListeners;
// use Maatwebsite\Excel\Concerns\SkipsErrors;
// use Maatwebsite\Excel\Concerns\SkipsFailures;
// use Maatwebsite\Excel\Concerns\SkipsOnError;
// use Maatwebsite\Excel\Concerns\SkipsOnFailure;
// use Maatwebsite\Excel\Concerns\ToCollection;
// // use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithBatchInserts;
// use Maatwebsite\Excel\Concerns\WithChunkReading;
// use Maatwebsite\Excel\Concerns\WithEvents;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use Maatwebsite\Excel\Concerns\WithValidation;
// use Maatwebsite\Excel\Events\AfterImport;
// use Maatwebsite\Excel\Validators\Failure;
// use Throwable;

// =================

class ImportDataSales implements ToModel, WithStartRow

// // ==============
// ToCollection,
// WithHeadingRow,
// SkipsOnError,
// WithValidation,
// SkipsOnFailure,
// WithChunkReading,
// ShouldQueue,
// WithEvents

{

    use CleanNoHP;


    public function model(array $row)
    {
        // dd($row);
        return new DataSales([
            //
            'id_member' => $row[1],
            'order_id' => $row[2],
            'no_hp' => $this->cek($row[3]),
            'tanggal' => $row[4],
            'batch' => $row[5],
            'poin' => $row[6],
            'recipient' => $row[7],
            'source' => $row[8],
            // 'created_at' => $row[8],
            // 'created_at' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int)$row[8])->format('F Y'),

        ]);
    }

    public function startRow(): int
    {
        return 2;
    }


}
