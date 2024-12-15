<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder2 extends Seeder
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
                'name'      => 'Update Status Stock Transfer',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Stock Transfer',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Detail Stock Transfer',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Print Stock Transfer',
                'guard_name'    => 'web'
            ],

            //  Expense Category Permission
            [
                'name'      => 'Daftar Kategori Pengeluaran',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Kategori Pengeluaran',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Kategori Pengeluaran',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Kategori Pengeluaran',
                'guard_name'    => 'web'
            ],

            //  Expense Subcategory Permission
            [
                'name'      => 'Daftar Subkategori Pengeluaran',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Subkategori Pengeluaran',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Subkategori Pengeluaran',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Subkategori Pengeluaran',
                'guard_name'    => 'web'
            ],

            //  Expense Permission
            [
                'name'      => 'Daftar Pengeluaran',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Pengeluaran',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Pengeluaran',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Pengeluaran',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Detail Pengeluaran',
                'guard_name'    => 'web'
            ],


            // ENTRY HRM PERMISSION

            // Department Permission
            [
                'name'      => 'Daftar Department',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Department',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Department',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Department',
                'guard_name'    => 'web'
            ],

            // Designation Permission
            [
                'name'      => 'Daftar Designation',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Designation',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Designation',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Designation',
                'guard_name'    => 'web'
            ],

            // Allowance Permission
            [
                'name'      => 'Daftar Tunjangan',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Tunjangan',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Tunjangan',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Tunjangan',
                'guard_name'    => 'web'
            ],

            // Cutting Permission
            [
                'name'      => 'Daftar Potongan',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Potongan',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Potongan',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Potongan',
                'guard_name'    => 'web'
            ],

            // Employee Permission
            [
                'name'      => 'Daftar Pegawai',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Tambah Pegawai',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Pegawai',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Hapus Pegawai',
                'guard_name'    => 'web'
            ],

            // Attendance Permission
            [
                'name'      => 'Absensi Hari ini',
                'guard_name'    => 'web'
            ],

            // Salary Permission
            [
                'name'      => 'Generate Slip',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Daftar Slip Gaji',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Detail Slip Gaji',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Update Status Pengajian',
                'guard_name'    => 'web'
            ],
            [
                'name'      => 'Print Slip Gaji',
                'guard_name'    => 'web'
            ],

            // Sell Permission
            [
                'name'      => 'Daftar Penjualan',
                'guard_name'    => 'web'
            ]
        ];
        Permission::insert($data);
    }
}
