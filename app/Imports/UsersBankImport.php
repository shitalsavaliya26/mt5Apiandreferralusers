<?php

namespace App\Imports;

use App\Models\UserBank;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersBankImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $userBank = new UserBank([
            'name' => $row['name'],
            'branch' => $row['branch'],
            'account_holder' => $row['account_holder'],
            'account_number' => $row['account_number'],
            'swift_code' => $row['swift_code'],
            'bank_country_id' => $row['bank_country_id'],
        ]);
    }
}
