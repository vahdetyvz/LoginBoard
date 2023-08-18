<?php
	namespace App\Models;

	use App\Models\User;
	use App\Models\School;
	use Illuminate\Support\Facades\Hash;
	use Maatwebsite\Excel\Concerns\ToModel;

	class UserImport implements ToModel
	{
		public function model(array $row)
		{
			return new User([
			   'fullname'     => $row[0],
			   'email'    => $row[1],
			   'password' => Hash::make($row[2]),
			   'phone'    => $row[3],
			   'school_id' => School::where(['number' => $row[4]])->first()->id
			]);
		}
	}