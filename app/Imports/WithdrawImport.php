<?php

namespace App\Imports;

use App\Models\Withdraw;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Session;
use Maatwebsite\Excel\Concerns\WithValidation;

class WithdrawImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return RedirectResponse|\Illuminate\Routing\Redirector
     *
     */
    public function model(array $row)
    {

        $withdrawRequest = Withdraw::create([
            'user_id' => (!empty($row['user_id'])) ? $row['user_id'] : $row['id'],
            'amount'  => $row['amount'],
            'remarks' => $row['remarks'],
            'status'  => $row['status']
        ]);

        return $withdrawRequest;
    }

    public function rules(): array
    {
        return [
            '*.id' => 'required',
             '*.amount' => 'required',
             '*.remarks' => 'required',
             '*.status' => 'required',
        ];
    }
}
