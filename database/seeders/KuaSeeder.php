<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KuaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kuas = [
            [
                'name' => 'KANTOR URUSAN AGAMA CIAWI',
                'address' => 'Km.65.5 No, Jl. Raya Puncak No.76, Bendungan, Kec. Ciawi, Kabupaten Bogor, Jawa Barat 16720',
                'phone' => '(0251) 8242239',
                'email' => 'kua.ciawi@kemenag.go.id',
                'operating_hours' => 'Senin - Jumat: 08:00 - 16:00 WIB',
                'google_maps_link' => 'https://www.google.com/maps/dir//Kantor+Urusan+Agama+Kecamatan+Ciawi/@-6.6587222,106.8492878,17z/data=!4m5!4m4!1m0!1m2!1m1!1s0x2e69c86c2bc3e607:0x8062e1ad04f1145',
                'google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.112368648966!2d106.84928777494558!3d-6.658722193339006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c86c2bc3e607%3A0x8062e1ad04f1145!2sKantor%20Urusan%20Agama%20Kecamatan%20Ciawi!5e0!3m2!1sid!2sid!4v1696259882815!5m2!1sid!2sid',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'KANTOR URUSAN AGAMA BOGOR TENGAH',
                'address' => 'Jl. Kapten Muslihat No.15, Tanah Sareal, Kec. Tanah Sereal, Kota Bogor, Jawa Barat 16161',
                'phone' => '(0251) 8323045',
                'email' => 'kua.bogortengah@kemenag.go.id',
                'operating_hours' => 'Senin - Jumat: 08:00 - 16:00 WIB',
                'google_maps_link' => 'https://www.google.com/maps/dir//KUA+Bogor+Tengah',
                'google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.4!2d106.8!3d-6.6!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMzYnMDAuMCJTIDEwNsKwNDgnMDAuMCJF!5e0!3m2!1sid!2sid',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'KANTOR URUSAN AGAMA CIBINONG',
                'address' => 'Jl. Mayor Oking Jayaatmaja No.99, Ciriung, Kec. Cibinong, Kabupaten Bogor, Jawa Barat 16918',
                'phone' => '(0251) 8661210',
                'email' => 'kua.cibinong@kemenag.go.id',
                'operating_hours' => 'Senin - Jumat: 08:00 - 16:00 WIB',
                'google_maps_link' => 'https://www.google.com/maps/dir//KUA+Cibinong',
                'google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.5!2d106.85!3d-6.48!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMjgnNDguMCJTIDEwNsKwNTEnMDAuMCJF!5e0!3m2!1sid!2sid',
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($kuas as $kua) {
            \App\Models\Kua::create($kua);
        }
    }
}
