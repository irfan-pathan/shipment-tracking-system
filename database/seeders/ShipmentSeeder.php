<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shipment;
use App\Models\StatusLog;
use Faker\Factory as Faker;

class ShipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {

            $shipment = Shipment::create([
                'tracking_number'   => 'TN' . strtoupper(uniqid()),
                'sender_name'       => $faker->name,
                'sender_address'    => $faker->address,
                'receiver_name'     => $faker->name,
                'receiver_address'  => $faker->address,
                'status'            => $faker->randomElement(['Pending', 'In Transit', 'Delivered']),
                'created_at'        => $faker->dateTimeBetween('-10 days', 'now'),
            ]);

            $statuses = ['Pending', 'In Transit', 'Delivered'];

            foreach ($statuses as $status) {

                StatusLog::create([
                    'shipment_id' => $shipment->id,
                    'status'      => $status,
                    'location'    => $faker->randomElement(['Mumbai', 'Delhi', 'Pune', 'Bangalore', 'Hyderabad']),
                    'created_at'  => $faker->dateTimeBetween(
                        $shipment->created_at,
                        'now'
                    ),
                ]);

                if ($status === $shipment->status) {
                    break;
                }
            }
        }
    }
}
