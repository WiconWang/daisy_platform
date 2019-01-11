<?php
use Illuminate\Database\Seeder;
use App\Models\System\MessageModel as Models;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Models::truncate();
        factory(Models::class, 30)->create();
    }
}
