<?php

namespace App\Imports;

use App\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $user = User::create([
                'name'  => $row['name'],
                'email' => $row['email'],
                'password' => Hash::make($row['password'])
            ]);

            UserDetail::create([
                'user_id' => $user->id
            ]);
        }
    }
}
