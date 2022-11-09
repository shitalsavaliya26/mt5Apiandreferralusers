<?php

namespace App\Imports;

use App\Models\TopupFund;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Session;
use Maatwebsite\Excel\Concerns\WithValidation;

class TopupImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return RedirectResponse|\Illuminate\Routing\Redirector
     *
     */
    public function model(array $row)
    {
       
        $topupRequest = TopupFund::create([
            'user_id' => (!empty($row['user_id'])) ? $row['user_id'] : $row['id'],
            'amount' => $row['amount'],
            'remarks' => $row['remarks'],
            'processing_fees' => $row['processing_fees'],
            'reciept_topup' => $row['topup_receipt'],
            'reciept_process' => $row['processing_fees'],
            'status' => $row['status'],
        ]);

        return $topupRequest;
    }

    public function rules(): array
    {
        return [
            '*.id' => 'required',
             '*.amount' => 'required',
             '*.remarks' => 'required',
             '*.processing_fees' => 'required',
             '*.reciept_topup' => 'required',
             '*.reciept_process' => 'required',
             '*.status' => 'required',
        ];
    }
}
