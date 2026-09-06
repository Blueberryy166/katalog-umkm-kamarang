<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UmkmAndProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_pages_do_not_show_admin_login_link()
    {
        $responseHome = $this->get(route('home'));
        $responseHome->assertStatus(200);
        $responseHome->assertDontSee('Login Pengelola');
        $responseHome->assertDontSee('Admin Panel');
        $responseHome->assertDontSee(route('admin.login'));

        $responseCatalog = $this->get(route('catalog.index'));
        $responseCatalog->assertStatus(200);
        $responseCatalog->assertDontSee(route('admin.login'));

        $responseUmkm = $this->get(route('umkm.index'));
        $responseUmkm->assertStatus(200);
        $responseUmkm->assertDontSee(route('admin.login'));
    }

    public function test_visiting_slash_admin_redirects_guest_to_login()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    }

    public function test_umkm_without_whatsapp_can_be_created_and_displayed()
    {
        $admin = User::first();
        $this->actingAs($admin);

        $response = $this->post(route('admin.umkms.store'), [
            'name' => 'UMKM Makmur Jaya',
            'owner_name' => 'Bapak Suparman',
            'phone' => '', // kosong / no WA
            'dusun' => 'Dusun Manis',
            'address' => 'Jl. Desa Kamarang No. 12',
            'description' => 'Usaha keripik singkong tradisional tanpa WA.',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.umkms.index'));
        $this->assertDatabaseHas('umkms', [
            'name' => 'UMKM Makmur Jaya',
            'phone' => null,
        ]);

        $umkm = Umkm::where('name', 'UMKM Makmur Jaya')->first();
        $this->assertFalse($umkm->has_whatsapp);
        $this->assertNull($umkm->whatsapp_link);

        // Check UMKM detail page
        $resDetail = $this->get(route('umkm.show', $umkm->slug));
        $resDetail->assertStatus(200);
        $resDetail->assertSee('Pemesanan Langsung di Lokasi Usaha');
    }

    public function test_product_with_price_range_and_variants()
    {
        $admin = User::first();
        $this->actingAs($admin);

        $umkm = Umkm::create([
            'name' => 'UMKM Keripik Barokah',
            'owner_name' => 'Ibu Fatimah',
            'phone' => '081234567890',
            'dusun' => 'Dusun Pahing',
        ]);

        $category = Category::first();

        $response = $this->post(route('admin.products.store'), [
            'umkm_id' => $umkm->id,
            'category_id' => $category->id,
            'name' => 'Keripik Singkong Renyah',
            'price' => 10000,
            'price_max' => 20000,
            'unit' => 'pouch 250gr',
            'variants' => ['Original Gurih', 'Pedas Level 1', 'Balado Manis'],
            'stock_status' => 'available',
            'short_description' => 'Keripik gurih aneka rasa.',
        ]);

        $response->assertRedirect(route('admin.products.index'));

        $product = Product::where('name', 'Keripik Singkong Renyah')->first();
        $this->assertNotNull($product);
        $this->assertEquals('Rp 10.000 - 20.000', $product->formatted_price);
        $this->assertTrue($product->has_variants);
        $this->assertCount(3, $product->variants);
        $this->assertTrue($product->has_whatsapp);

        $waUrl = $product->getWhatsappUrlWithVariant('Pedas Level 1');
        $this->assertStringContainsString('6281234567890', $waUrl);
        $this->assertStringContainsString('Pedas+Level+1', $waUrl);

        // Check Product detail page
        $resDetail = $this->get(route('catalog.show', $product->slug));
        $resDetail->assertStatus(200);
        $resDetail->assertSee('Rp 10.000 - 20.000');
        $resDetail->assertSee('Original Gurih');
        $resDetail->assertSee('Pedas Level 1');
        $resDetail->assertSee('Balado Manis');
        $resDetail->assertSee('Pesan via WhatsApp');
    }

    public function test_umkm_with_coordinates_and_google_maps_integration()
    {
        $admin = User::first();
        $this->actingAs($admin);

        $response = $this->post(route('admin.umkms.store'), [
            'name' => 'UMKM Madu Murni Kamarang',
            'owner_name' => 'Pak Ahmad',
            'phone' => '085712345678',
            'dusun' => 'Dusun Kliwon',
            'address' => 'Jl. Blok Kliwon RT 03 RW 02 Desa Kamarang',
            'latitude' => -6.84667744,
            'longitude' => 108.54561525,
            'description' => 'Produksi madu lebah murni desa.',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.umkms.index'));

        $umkm = Umkm::where('name', 'UMKM Madu Murni Kamarang')->first();
        $this->assertNotNull($umkm);
        $this->assertTrue($umkm->has_coordinates);
        $this->assertEquals(-6.84667744, $umkm->latitude);
        $this->assertEquals(108.54561525, $umkm->longitude);
        $this->assertStringContainsString('-6.84667744,108.54561525', $umkm->google_maps_url);
        $this->assertStringContainsString('output=embed', $umkm->google_maps_embed_url);
        $this->assertStringContainsString('destination=-6.84667744,108.54561525', $umkm->google_maps_direction_url);

        // Check UMKM detail page renders Google Maps embed and direction button
        $resDetail = $this->get(route('umkm.show', $umkm->slug));
        $resDetail->assertStatus(200);
        $resDetail->assertSee('Peta & Alamat UMKM', false);
        $resDetail->assertSee('Petunjuk Arah');
        $resDetail->assertSee('output=embed', false);
    }

    public function test_banner_slider_rendered_on_homepage()
    {
        $slider = \App\Models\Slider::create([
            'title' => 'Promo Spesial Keripik Kamarang',
            'subtitle' => 'Olahan renyah langsung dari dapur desa.',
            'image_path' => 'images/banners/hero_village.jpg',
            'link_url' => '/katalog',
            'button_text' => 'Beli Sekarang',
            'order_num' => 1,
            'is_active' => true,
        ]);

        $this->assertNotEmpty($slider->image_url);

        $responseHome = $this->get(route('home'));
        $responseHome->assertStatus(200);
        $responseHome->assertSee('Promo Spesial Keripik Kamarang');
        $responseHome->assertSee('Beli Sekarang');
        $responseHome->assertSee($slider->image_url, false);
    }
}
