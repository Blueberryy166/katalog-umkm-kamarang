<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Toko / Usaha
            $table->string('slug')->unique();
            $table->string('owner_name'); // Nama Pemilik
            $table->string('phone')->nullable(); // No WhatsApp opsional (bisa null jika tidak punya WA)
            $table->text('address')->nullable();
            $table->string('dusun')->nullable(); // e.g. Dusun Manis, Dusun Pahing, Dusun Kliwon, Dusun Wage
            $table->decimal('latitude', 10, 8)->nullable(); // Koordinat Latitude GPS Google Maps
            $table->decimal('longitude', 11, 8)->nullable(); // Koordinat Longitude GPS Google Maps
            $table->text('maps_url')->nullable();
            $table->text('description')->nullable();
            $table->string('logo_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained('umkms')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('price_max', 12, 2)->nullable(); // Estimasi harga maksimal (contoh 10000 - 20000)
            $table->string('unit')->default('pcs'); // pcs, pouch, box, kg, botol, pack
            $table->json('variants')->nullable(); // Opsi varian produk (misal: rasa, ukuran, variasi)
            $table->text('short_description')->nullable();
            $table->longText('full_description')->nullable();
            $table->string('main_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->string('pirt_number')->nullable(); // P-IRT or Halal Cert No
            $table->string('stock_status')->default('available'); // available, preorder, out_of_stock
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamps();
        });

        Schema::create('village_infos', function (Blueprint $table) {
            $table->id();
            $table->string('village_name')->default('Desa Kamarang');
            $table->string('district')->default('Kecamatan Greged');
            $table->string('regency')->default('Kabupaten Cirebon');
            $table->string('province')->default('Jawa Barat');
            $table->integer('total_population')->default(3114);
            $table->integer('total_families')->default(1015);
            $table->integer('total_umkm')->default(0);
            $table->longText('history')->nullable();
            $table->longText('vision_mission')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('village_head_name')->nullable();
            $table->text('village_head_speech')->nullable();
            $table->string('kkm_team_name')->default('KKM Kelompok 26 Universitas Muhammadiyah Cirebon 2026');
            $table->timestamps();
        });

        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('image_path')->nullable();
            $table->string('link_url')->nullable();
            $table->string('button_text')->nullable();
            $table->integer('order_num')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('village_infos');
        Schema::dropIfExists('products');
        Schema::dropIfExists('umkms');
        Schema::dropIfExists('categories');
    }
};
