<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [

            // Kategory Permission
            [
                'name'      => 'Daftar Kategori',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Kategori',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Kategori',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Kategori',
                'guard_name'    => 'web'
            ],

            // Subkategori Permission
            [
                'name'      => 'Daftar Subkategori',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Subkategori',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Subkategori',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Subkategori',
                'guard_name'    => 'web'
            ],

            // Supplier Permission
            [
                'name'      => 'Daftar Supplier',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Supplier',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Supplier',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Supplier',
                'guard_name'    => 'web'
            ],

            // Customer Permission
            [
                'name'      => 'Daftar Customer',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Customer',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Customer',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Customer',
                'guard_name'    => 'web'
            ],

            // Variant Permission
            [
                'name'      => 'Daftar Variasi Produk',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Variasi Produk',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Variasi Produk',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Variasi Produk',
                'guard_name'    => 'web'
            ],

            // Product Permission
            [
                'name'      => 'Daftar Produk',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Produk',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Produk',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Produk',
                'guard_name'    => 'web'
            ],

            // Barcode Permission
            [
                'name'      => 'Produk Label',
                'guard_name'    => 'web'
            ],

            // Purchase Order Permission
            [
                'name'      => 'Daftar Purchase',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Purchase',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Detail Purchase',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Print Purchase',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Return',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Daftar Return',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Detail Return',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Print Return',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Pembayaran Return',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Status Purchase',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Pembayaran Purchase',
                'guard_name'    => 'web'
            ],

            // Stock Adjustment Permission
            [
                'name'      => 'Daftar Adjustment',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Adjustment',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Detail Adjustment',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Print Adjustment',
                'guard_name'    => 'web'
            ],

            // Stock Transfer Permission
            [
                'name'      => 'Daftar Stock Transfer',
                'guard_name'    => 'web'
            ]
        ];

        Permission::insert($data);
    }
}
