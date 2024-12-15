<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder3 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'      => 'Download Laporan Penjualan',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Detail Penjualan',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Print Penjualan',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Pembayaran Penjualan',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Status Penjualan',
                'guard_name'    => 'web'
            ],

            // Purchase Report Permission
            [
                'name'      => 'Laporan Purchase',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Download Laporan Purchase',
                'guard_name'    => 'web'
            ],

            // Return Report Permission
            [
                'name'      => 'Laporan Return',
                'guard_name'    => 'web',
            ],
            [
                'name'      => 'Download Laporan Return',
                'guard_name'    => 'web'
            ],

            // Due Report Permission
            [
                'name'      => 'Laporan Hutang',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Download Laporan Hutang',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Detail Hutang',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Print Laporan Hutang',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'List Credit Hutang',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Status Hutang',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Download Credit Hutang',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Pembayaran Hutang',
                'guard_name'    => 'web'
            ],

            // Expense Report Permission
            [
                'name'      => 'Download Laporan Pengeluaran',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Daftar Laporan Pengeluaran',
                'guard_name'    => 'web'
            ],

            // Profit Loss Permission
            [
                'name'      => 'Profit Loss Report',
                'guard_name'    => 'web'
            ],

            // Top Product Permission
            [
                'name'      => 'Top Product',
                'guard_name'    => 'web'
            ],

            // Stock Alert Permission
            [
                'name'      => 'Peringatan Stock',
                'guard_name'    => 'web'
            ],

            // Stock Adjustment Report Permission
            [
                'name'      => 'Laporan Stock Adjustment',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Download Stock Adjustment',
                'guard_name'    => 'web'
            ],

            // Stock Transfer Report Permission
            [
                'name'      => 'Laporan Stock Transfer',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Download Stock Transfer',
                'guard_name'    => 'web'
            ],


            // Attendance Report Permission
            [
                'name'      => 'Absensi Harian',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Absensi Bulanan',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Total Absensi',
                'guard_name'    => 'web'
            ],

            //  Permission 
            [
                'name'      => 'Daftar Permission',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Permission',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Permission',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Permission',
                'guard_name'    => 'web'
            ],

            // User Role Permission
            [
                'name'      => 'Daftar Role',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Role',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Role',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Role',
                'guard_name'    => 'web'
            ],

            // Users Permission
            [
                'name'      => 'Daftar Users',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Users',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Users',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Users',
                'guard_name'    => 'web'
            ],

            // Settings Permission
            [
                'name'      => 'Setting',
                'guard_name'    => 'web'
            ]
        ];
        Permission::insert($data);
    }
}
