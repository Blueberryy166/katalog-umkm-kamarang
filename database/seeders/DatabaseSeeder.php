<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Umkm;
use App\Models\User;
use App\Models\VillageInfo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@kamarang.desa.id'],
            [
                'name' => 'Administrator Desa Kamarang',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Village Info
        VillageInfo::truncate();
        VillageInfo::create([
            'village_name' => 'Desa Kamarang',
            'district' => 'Kecamatan Greged',
            'regency' => 'Kabupaten Cirebon',
            'province' => 'Provinsi Jawa Barat',
            'total_population' => 3114,
            'total_families' => 1015,
            'total_umkm' => 0,
            'history' => 'Desa Kamarang merupakan salah satu desa tertua di wilayah Kecamatan Greged, Kabupaten Cirebon, Provinsi Jawa Barat yang memiliki kekayaan sejarah dan budaya luhur. Dengan luas wilayah sekitar 147,83 Ha, sebagian besar masyarakat Desa Kamarang bermata pencaharian sebagai petani, wiraswasta, dan pengrajin olahan rumahan yang berdaya saing tinggi.',
            'vision_mission' => "VISI:\nMewujudkan Desa Kamarang yang Mandiri, Sejahtera, dan Berdaya Saing melalui Penguatan Ekonomi Berbasis UMKM dan Pemanfaatan Teknologi Informasi.\n\nMISI:\n1. Mendorong kemandirian ekonomi keluarga melalui hilirisasi produk hasil tani dan olahan lokal.\n2. Memperluas jangkauan promosi produk UMKM desa secara digital.\n3. Meningkatkan kapasitas dan literasi digital pelaku usaha mikro desa.",
            'contact_phone' => '082119876543',
            'contact_email' => 'desakamarang.greged@gmail.com',
            'village_head_name' => 'Kuwu Desa Kamarang',
            'village_head_speech' => 'Selamat datang di Website Resmi Katalog dan Pemasaran Digital Produk UMKM Desa Kamarang. Website ini merupakan buah karya kolaborasi program Kuliah Kerja Mahasiswa (KKM) Kelompok 26 Universitas Muhammadiyah Cirebon bersama Pemerintah Desa dan Pelaku UMKM Kamarang untuk memajukan perekonomian desa.',
            'kkm_team_name' => 'KKM Kelompok 26 Universitas Muhammadiyah Cirebon 2026',
        ]);

        // 3. Categories
        Category::truncate();
        Category::create([
            'name' => 'Makanan Ringan',
            'slug' => 'makanan-ringan',
            'icon' => 'cookie-bite',
            'description' => 'Aneka keripik renyah, peyek, dan camilan olahan rumahan warga Desa Kamarang.',
        ]);

        Category::create([
            'name' => 'Olahan Pangan',
            'slug' => 'olahan-pangan',
            'icon' => 'bowl-rice',
            'description' => 'Produk olahan pangan bermutu tinggi hasil olahan dan racikan warga Desa Kamarang.',
        ]);

        Category::create([
            'name' => 'Minuman',
            'slug' => 'minuman',
            'icon' => 'glass-water',
            'description' => 'Gula aren murni, seduhan herbal alami, dan aneka minuman segar khas desa.',
        ]);

        // 4. UMKMs (Dikosongkan sesuai permintaan)
        Umkm::truncate();

        // 5. Products (Dikosongkan sesuai permintaan)
        Product::truncate();

        // 6. Sliders
        Slider::truncate();
        Slider::create([
            'title' => 'Katalog Produk & Pemasaran Digital UMKM Desa Kamarang',
            'subtitle' => 'Mendukung Pertumbuhan Ekonomi Sirkular & Potensi Usaha Unggulan Warga Desa Kamarang, Kec. Greged, Kab. Cirebon',
            'image_path' => 'images/banners/hero_village.jpg',
            'link_url' => '/katalog',
            'button_text' => 'Jelajahi Katalog Produk',
            'order_num' => 1,
            'is_active' => true,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
