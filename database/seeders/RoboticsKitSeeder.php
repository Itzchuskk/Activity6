<?php
// database/seeders/RoboticsKitSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoboticsKit;

class RoboticsKitSeeder extends Seeder
{
    public function run(): void
    {
        RoboticsKit::firstOrCreate(['sku'=>'STARTER-BOT'],['name'=>'Starter Bot','price'=>99]);
        RoboticsKit::firstOrCreate(['sku'=>'AI-ROVER'],['name'=>'AI Rover','price'=>249]);
        RoboticsKit::firstOrCreate(['sku'=>'ARM-PRO'],['name'=>'Arm Pro','price'=>399]);
    }
}
