<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Sensor;
use App\Models\Project;
use App\Models\Video;
use App\Models\Product;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User - only if not exists
        \App\Models\User::updateOrCreate(
            ['email' => 'davepalola1@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => null,
            ]
        );

        // Create Sample User - only if not exists
        \App\Models\User::updateOrCreate(
            ['email' => 'user@sensorhub.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]
        );

        // Create Sample Sensors
        $sensors = [
            [
                'name' => 'DHT11 Temperature & Humidity Sensor',
                'slug' => 'dht11-temperature-humidity-sensor',
                'image' => '/images/DHT11 Temperature & Humidity Sensor.jpeg',
                'description' => 'The DHT11 is a basic, ultra low-cost digital temperature and humidity sensor. It uses a capacitive humidity sensor and a thermistor to measure the surrounding air, and sends a digital signal on the data pin.',
                'how_it_works' => 'The DHT11 consists of two main components: a capacitive humidity sensor and a temperature sensor (thermistor). It measures humidity by detecting changes in electrical conductivity between two electrodes as moisture is absorbed by the substrate. Temperature is measured using an NTC (Negative Temperature Coefficient) thermistor.',
                'use_cases' => 'Weather stations, Home automation, HVAC systems, Greenhouse monitoring, Smart agriculture',
                'components_needed' => 'Arduino Uno, DHT11 Sensor, Jumper Wires, Breadboard, 10k Ohm Resistor',
                'is_active' => true,
            ],
            [
                'name' => 'Ultrasonic Sensor (HC-SR04)',
                'slug' => 'ultrasonic-sensor-hc-sr04',
                'image' => '/images/Ultrasonic Sensor (HC-SR04).jpeg',
                'description' => 'The HC-SR04 is an ultrasonic distance sensor that uses sonar to determine distance. It can measure distances from 2cm to 400cm with high accuracy and stable readings.',
                'how_it_works' => 'The sensor transmits an ultrasonic wave (sound above human hearing range) and receives the echo back. By measuring the time between transmission and reception, and knowing the speed of sound, we can calculate the distance to the object.',
                'use_cases' => 'Robot navigation, Parking sensors, Water level measurement, Object detection, Security systems',
                'components_needed' => 'Arduino Board, HC-SR04 Sensor, Jumper Wires, Breadboard',
                'is_active' => true,
            ],
            [
                'name' => 'PIR Motion Sensor',
                'slug' => 'pir-motion-sensor',
                'image' => '/images/PIR Motion Sensor.jpeg',
                'description' => 'PIR (Passive Infrared) sensors detect motion by measuring changes in infrared light emitted by objects in their field of view. Perfect for detecting human or animal movement.',
                'how_it_works' => 'PIR sensors have two slots of pyroelectric material. When a warm body passes by, it first intercepts one half, causing a positive differential change. When it leaves, a negative differential change occurs. These pulses trigger the motion detection.',
                'use_cases' => 'Security systems, Automatic lighting, Smart home automation, Intrusion detection, Energy saving systems',
                'components_needed' => 'Arduino, PIR Sensor (HC-SR501), LED, Jumper Wires, Breadboard',
                'is_active' => true,
            ],
            [
                'name' => 'MQ-2 Gas Sensor',
                'slug' => 'mq-2-gas-sensor',
                'image' => '/images/MQ-2 Gas Sensor.jpeg',
                'description' => 'The MQ-2 gas sensor is sensitive to LPG, i-butane, propane, methane, alcohol, Hydrogen, and smoke. It\'s commonly used in gas leakage detecting equipment for home and industrial use.',
                'how_it_works' => 'The sensor contains a heating element and a sensing element made of tin dioxide (SnO2). When gas is present, the conductivity of the sensing material changes, which can be measured as an analog voltage output.',
                'use_cases' => 'Gas leak detection, Air quality monitoring, Industrial safety, Home safety systems, Fire detection',
                'components_needed' => 'Arduino, MQ-2 Sensor, Jumper Wires, Breadboard, Buzzer (optional)',
                'is_active' => true,
            ],
        ];

        foreach ($sensors as $sensor) {
            Sensor::updateOrCreate(
                ['slug' => $sensor['slug']],
                $sensor
            );
        }

        // Create Sample Projects
        $projects = [
            [
                'title' => 'Smart Weather Station with DHT11',
                'slug' => 'smart-weather-station-dht11',
                'description' => 'Build a complete weather monitoring system using the DHT11 sensor to track temperature and humidity in real-time with LCD display.',
                'difficulty' => 'Beginner',
                'sensor_id' => 1,
                'components_needed' => 'Arduino Uno, DHT11 Sensor, LCD 16x2 Display, Jumper Wires, Breadboard, Potentiometer',
                'instructions' => '1. Connect DHT11 data pin to Arduino pin 2\n2. Connect LCD to Arduino I2C pins\n3. Install DHT library\n4. Upload the code\n5. Monitor readings on LCD',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Distance Measuring Device with HC-SR04',
                'slug' => 'distance-measuring-device-hc-sr04',
                'description' => 'Create a digital distance meter that can measure objects from 2cm to 4 meters with LED indicators for different distance ranges.',
                'difficulty' => 'Beginner',
                'sensor_id' => 2,
                'components_needed' => 'Arduino Uno, HC-SR04 Ultrasonic Sensor, LEDs (3 colors), Resistors, Jumper Wires',
                'instructions' => '1. Connect Trig pin to Arduino pin 9\n2. Connect Echo pin to Arduino pin 10\n3. Connect LEDs to pins 3, 4, 5\n4. Upload code and test',
                'is_featured' => true,
                'is_active' => true,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['slug' => $project['slug']],
                $project
            );
        }

        // Create Sample Videos
        $videos = [
            [
                'title' => 'DHT11 Sensor Tutorial - Complete Guide',
                'slug' => 'dht11-sensor-tutorial',
                'youtube_link' => 'https://www.youtube.com/watch?v=G6AXDKN98f8',
                'youtube_id' => 'G6AXDKN98f8',
                'sensor_id' => 1,
                'category' => 'Tutorial',
                'description' => 'Learn how to use the DHT11 temperature and humidity sensor with Arduino',
                'is_active' => true,
            ],
            [
                'title' => 'HC-SR04 Ultrasonic Sensor Project',
                'slug' => 'hc-sr04-ultrasonic-sensor-project',
                'youtube_link' => 'https://www.youtube.com/watch?v=dtF0rxfZF2Y',
                'youtube_id' => 'dtF0rxfZF2Y',
                'sensor_id' => 2,
                'category' => 'Project',
                'description' => 'Build a distance measuring device using ultrasonic sensor',
                'is_active' => true,
            ],
        ];

        foreach ($videos as $video) {
            Video::updateOrCreate(
                ['slug' => $video['slug']],
                $video
            );
        }

        // Create Sample Products
        $products = [
            [
                'name' => 'Arduino Uno R3',
                'slug' => 'arduino-uno-r3',
                'description' => 'The Arduino Uno is a microcontroller board based on the ATmega328P. Perfect for beginners and experienced makers.',
                'price' => 25.99,
                'link' => 'https://shopee.com/search?keyword=arduino%20uno',
                'category' => 'Microcontrollers',
                'is_active' => true,
            ],
            [
                'name' => 'Sensor Kit 37 in 1',
                'slug' => 'sensor-kit-37-in-1',
                'description' => 'Complete sensor kit with 37 different sensors for Arduino projects. Great value for beginners.',
                'price' => 35.50,
                'link' => 'https://shopee.com/search?keyword=arduino%20sensor%20kit',
                'category' => 'Sensor Kits',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }
    }
}
