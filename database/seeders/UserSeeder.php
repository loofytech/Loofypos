<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Loofytech";
        $user->email = "loofytech0@gmail.com";
        $user->password = Hash::make("12345678");
        $user->save();

        $stores = ["Loofytech Store Metro", "Loofytech Store Karang"];
        foreach ($stores as $key => $store) {
            $s = new Store();
            $s->store_name = $store;
            $s->store_slug = Str::slug($store, '-');
            $s->store_location = "-6.113217299575007, 106.57268208984235";
            $s->user_id = $user->id;
            $s->save();
        }
    }
}
