<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin Nayla',
            'email'    => 'admin@nayla.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'phone'    => '081234567890',
        ]);

        // Demo User
        User::create([
            'name'     => 'Pelanggan Demo',
            'email'    => 'user@nayla.com',
            'password' => Hash::make('user123'),
            'role'     => 'user',
            'phone'    => '089876543210',
        ]);

        // Categories
        $buahSegar = Category::create([
            'name'        => 'Buah Segar',
            'slug'        => 'buah-segar',
            'description' => 'Aneka buah segar pilihan langsung dari kebun terbaik.',
            'is_active'   => true,
        ]);

        $esBuah = Category::create([
            'name'        => 'Es Buah',
            'slug'        => 'es-buah',
            'description' => 'Es buah segar dengan berbagai pilihan rasa yang menyegarkan.',
            'is_active'   => true,
        ]);

        $buahImport = Category::create([
            'name'        => 'Buah Import',
            'slug'        => 'buah-import',
            'description' => 'Buah-buahan pilihan dari mancanegara dengan kualitas premium.',
            'is_active'   => true,
        ]);

        $buahPotong = Category::create([
            'name'        => 'Buah Potong',
            'slug'        => 'buah-potong',
            'description' => 'Buah segar yang sudah dipotong siap saji.',
            'is_active'   => true,
        ]);

        // Products — Buah Segar
        $buahSegarList = [
            ['name' => 'Mangga Harum Manis', 'price' => 25000, 'unit' => 'kg', 'stock' => 50, 'is_featured' => true,  'description' => 'Mangga harum manis pilihan, manis dan segar, cocok dikonsumsi langsung atau dijadikan jus.'],
            ['name' => 'Semangka Merah',      'price' => 8000,  'unit' => 'kg', 'stock' => 80, 'is_featured' => true,  'description' => 'Semangka merah segar dengan kadar air tinggi, manis dan menyegarkan.'],
            ['name' => 'Melon Hijau',          'price' => 12000, 'unit' => 'kg', 'stock' => 40, 'is_featured' => false, 'description' => 'Melon hijau dengan daging buah kuning manis dan aroma harum.'],
            ['name' => 'Pisang Ambon',         'price' => 18000, 'unit' => 'sisir', 'stock' => 30, 'is_featured' => false, 'description' => 'Pisang ambon manis segar, cocok untuk camilan sehari-hari.'],
            ['name' => 'Pepaya California',    'price' => 10000, 'unit' => 'kg', 'stock' => 60, 'is_featured' => true,  'description' => 'Pepaya california dengan daging tebal berwarna oranye cerah, manis dan bernutrisi.'],
            ['name' => 'Jeruk Manis',          'price' => 22000, 'unit' => 'kg', 'stock' => 45, 'is_featured' => false, 'description' => 'Jeruk manis segar kaya vitamin C, cocok dijadikan jus atau dimakan langsung.'],
            ['name' => 'Alpukat Mentega',      'price' => 30000, 'unit' => 'kg', 'stock' => 25, 'is_featured' => true,  'description' => 'Alpukat mentega dengan tekstur lembut dan creamy, sempurna untuk jus atau salad.'],
            ['name' => 'Jambu Biji Merah',     'price' => 15000, 'unit' => 'kg', 'stock' => 35, 'is_featured' => false, 'description' => 'Jambu biji merah segar, kaya vitamin C dan antioksidan.'],
        ];

        foreach ($buahSegarList as $item) {
            Product::create(array_merge($item, [
                'category_id' => $buahSegar->id,
                'slug'        => \Illuminate\Support\Str::slug($item['name']) . '-' . rand(100, 999),
                'is_active'   => true,
            ]));
        }

        // Products — Es Buah
        $esBuahList = [
            ['name' => 'Es Buah Spesial Nayla',  'price' => 15000, 'unit' => 'porsi', 'stock' => 100, 'is_featured' => true,  'description' => 'Es buah spesial andalan Toko Nayla dengan campuran 10 buah segar pilihan, santan, dan sirup cocopandan.'],
            ['name' => 'Es Buah Susu',            'price' => 18000, 'unit' => 'porsi', 'stock' => 80,  'is_featured' => true,  'description' => 'Es buah dengan tambahan susu kental manis, segar dan creamy di setiap suapannya.'],
            ['name' => 'Es Buah Kelapa Muda',     'price' => 20000, 'unit' => 'porsi', 'stock' => 60,  'is_featured' => false, 'description' => 'Es buah dengan air kelapa muda alami dan daging kelapa muda yang lembut.'],
            ['name' => 'Es Buah Diet',            'price' => 16000, 'unit' => 'porsi', 'stock' => 50,  'is_featured' => false, 'description' => 'Es buah rendah kalori tanpa gula tambahan, menggunakan pemanis alami stevia.'],
            ['name' => 'Es Buah Nata de Coco',    'price' => 17000, 'unit' => 'porsi', 'stock' => 70,  'is_featured' => true,  'description' => 'Es buah dengan tambahan nata de coco kenyal dan segar, paduan rasa yang sempurna.'],
        ];

        foreach ($esBuahList as $item) {
            Product::create(array_merge($item, [
                'category_id' => $esBuah->id,
                'slug'        => \Illuminate\Support\Str::slug($item['name']) . '-' . rand(100, 999),
                'is_active'   => true,
            ]));
        }

        // Products — Buah Import
        $buahImportList = [
            ['name' => 'Anggur Shine Muscat',    'price' => 75000,  'unit' => 'kg', 'stock' => 20, 'is_featured' => true,  'description' => 'Anggur shine muscat import premium dari Jepang, manis tanpa biji dengan aroma muscat yang khas.'],
            ['name' => 'Strawberry Australia',   'price' => 45000,  'unit' => 'box', 'stock' => 30, 'is_featured' => true,  'description' => 'Strawberry segar dari Australia, merah cerah, manis asam menyegarkan.'],
            ['name' => 'Apel Fuji Jepang',       'price' => 55000,  'unit' => 'kg', 'stock' => 25, 'is_featured' => false, 'description' => 'Apel fuji dari Jepang dengan tekstur renyah dan rasa manis yang khas.'],
            ['name' => 'Durian Musang King',     'price' => 150000, 'unit' => 'kg', 'stock' => 15, 'is_featured' => true,  'description' => 'Raja durian dari Malaysia, daging tebal creamy dengan rasa pahit manis yang ikonik.'],
            ['name' => 'Kiwi Selandia Baru',     'price' => 40000,  'unit' => 'kg', 'stock' => 35, 'is_featured' => false, 'description' => 'Kiwi hijau segar dari Selandia Baru, kaya vitamin C dan antioksidan tinggi.'],
        ];

        foreach ($buahImportList as $item) {
            Product::create(array_merge($item, [
                'category_id' => $buahImport->id,
                'slug'        => \Illuminate\Support\Str::slug($item['name']) . '-' . rand(100, 999),
                'is_active'   => true,
            ]));
        }

        // Products — Buah Potong
        $buahPotongList = [
            ['name' => 'Rujak Buah Segar',        'price' => 12000, 'unit' => 'porsi', 'stock' => 50, 'is_featured' => false, 'description' => 'Aneka buah segar yang dipotong dan disajikan dengan bumbu rujak pedas manis khas Nayla.'],
            ['name' => 'Buah Potong Campur',       'price' => 15000, 'unit' => 'box',   'stock' => 40, 'is_featured' => true,  'description' => 'Buah potong campur dalam box praktis, cocok untuk bekal atau camilan sehat.'],
            ['name' => 'Mangga Potong Pedas',      'price' => 10000, 'unit' => 'porsi', 'stock' => 60, 'is_featured' => false, 'description' => 'Mangga muda segar dipotong tipis dan dilumuri bumbu pedas asam khas.'],
            ['name' => 'Semangka Potong',          'price' => 8000,  'unit' => 'porsi', 'stock' => 70, 'is_featured' => false, 'description' => 'Semangka merah segar dipotong segitiga siap makan, menyegarkan.'],
        ];

        foreach ($buahPotongList as $item) {
            Product::create(array_merge($item, [
                'category_id' => $buahPotong->id,
                'slug'        => \Illuminate\Support\Str::slug($item['name']) . '-' . rand(100, 999),
                'is_active'   => true,
            ]));
        }
    }
}
