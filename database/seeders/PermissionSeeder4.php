<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder4 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // HRM Setting Permission
            [
                'name'      => 'HRM Setting',
                'guard_name'    => 'web'
            ],

            // Country Permission
            [
                'name'      => 'Daftar Negara',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Negara',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Negara',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Negara',
                'guard_name'    => 'web'
            ],

            
            // Currency Permission
            [
                'name'      => 'Daftar Mata Uang',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Mata Uang',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Mata Uang',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Mata Uang',
                'guard_name'    => 'web'
            ],

            // Bank Permission
            [
                'name'      => 'Daftar Bank',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Bank',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Bank',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Bank',
                'guard_name'    => 'web'
            ],

            // Printer Permission
            [
                'name'      => 'Daftar Printer',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Printer',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Printer',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Printer',
                'guard_name'    => 'web'
            ],

            // Taxrate Permission
            [
                'name'      => 'Daftar Pajak',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Pajak',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Pajak',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Pajak',
                'guard_name'    => 'web'
            ],

            // Box Permission
            [
                'name'      => 'Daftar Box',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Box',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Box',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Box',
                'guard_name'    => 'web'
            ],

            // Unit Permission
            [
                'name'      => 'Daftar Unit',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Unit',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Unit',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Unit',
                'guard_name'    => 'web'
            ],

            // Brand Permission
            [
                'name'      => 'Daftar Brand',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Brand',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Brand',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Brand',
                'guard_name'    => 'web'
            ],

            // Store Permission
            [
                'name'      => 'Tambah Toko',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Toko',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Pilih Toko',
                'guard_name'    => 'web'
            ], 

            // POS Permission
            [
                'name'      => 'POS',
                'guard_name'    => 'web'
            ], 

            // Dashboard Permission
            [
                'name'     => 'Aktivitas Terbaru',
                'guard_name'    => 'web'
            ],
            [
                'name'     => 'Penjualan 30',
                'guard_name'    => 'web'
            ], 
            [
                'name'     => 'Pengeluaran dan Pendapatan',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Check Int Check Out',
                'guard_name' => 'web'
            ],
            [
                'name'      => "Return Penjualan",
                'guard_name'=> "web"
            ],
            [
                'name'      => "Print Return Sales",
                'guard_name'=> 'web'
            ],
            [
                'name'      => "Detail Return Sales",
                'guard_name'=> 'web'
            ]
        ];
        Permission::insert($data);
    }
}
