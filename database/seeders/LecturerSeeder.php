<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lecturers')->insert([
            ['lecturer_number' => '0516127501', 'lecturer_name' => 'Ir. Sri Winiarti, S.T., M.Cs.',],
            ['lecturer_number' => '0523077902', 'lecturer_name' => 'Dr. Ardiansyah, S.T., M.Cs.',],
            ['lecturer_number' => '0510077302', 'lecturer_name' => 'Dr. Murinto, S.Si., M.Kom.',],
            ['lecturer_number' => '0506079301', 'lecturer_name' => 'Faisal Fajri Rahani S.Si., M.Cs.',],
            ['lecturer_number' => '0014107301', 'lecturer_name' => 'Ali Tarmuji, S.T., ',],
            ['lecturer_number' => '0512078304', 'lecturer_name' => 'Ir. Herman Yuliansyah, S.T., M.Eng., Ph.D.',],
            ['lecturer_number' => '0529056601', 'lecturer_name' => 'Dr. Ir. Ardi Pujiyanta, M.T.',],
            ['lecturer_number' => '0504116601', 'lecturer_name' => 'Drs. Wahyu Pujiyono, M.Kom'],
            ['lecturer_number' => '0020077901', 'lecturer_name' => 'Bambang Robi\'in, S.T., M.T'],
            ['lecturer_number' => '0507087202', 'lecturer_name' => 'Rusydi Umar, S.T., M.T., Ph.D.'],
            ['lecturer_number' => '0528058401', 'lecturer_name' => 'Jefree Fahana, S.T., M.Kom'],
            ['lecturer_number' => '0019087601', 'lecturer_name' => 'Nur Rochmah DPA, S.T., M.Kom'],
            ['lecturer_number' => '0511098401', 'lecturer_name' => 'Lisna Zahrotun, S.T., M.Cs'],
            ['lecturer_number' => '0509038402', 'lecturer_name' => 'Guntur Maulana Z., B.Sc., M.Kom'],
            ['lecturer_number' => null, 'lecturer_name' => 'Sheraton Pawestri, S.Kom., M.Cs.'],
            ['lecturer_number' => '0521127303', 'lecturer_name' => 'Taufiq Ismail, S.T., M.Cs'],
            ['lecturer_number' => '0523068801', 'lecturer_name' => 'Supriyanto, S.T., M.T'],
            ['lecturer_number' => '0015118001', 'lecturer_name' => 'Fiftin Noviyanto, S.T., M.Cs'],
            ['lecturer_number' => '0515069001', 'lecturer_name' => 'Miftahurrahma Rosyda, S.Kom., M.Eng'],
            ['lecturer_number' => '0505118901', 'lecturer_name' => 'Ir. Ahmad Azhari, S.Kom., M.Eng'],
            ['lecturer_number' => '0526018502', 'lecturer_name' => 'Arfiani Nur Khusna, S.T., M.Kom'],
            ['lecturer_number' => '0407016801', 'lecturer_name' => 'Drs. Tedy Setiadi, M.Kom'],
            ['lecturer_number' => '0519108901', 'lecturer_name' => 'Murein Miksa Mardhia, S.T., M.T.'],
            ['lecturer_number' => '0504088601', 'lecturer_name' => 'Dwi Normawati, S.T., M.T'],
            ['lecturer_number' => '0006027001', 'lecturer_name' => 'Eko Aribowo, S.T., M.Kom.'],
            ['lecturer_number' => '0522018302', 'lecturer_name' => 'Anna Hendri S.Kom., M.Cs'],
            ['lecturer_number' => '0509048901', 'lecturer_name' => 'Nuril Anwar, S.T., M.Kom'],
            ['lecturer_number' => '0514079201', 'lecturer_name' => 'Dinan Yulianto, S.T., M.Eng'],
            ['lecturer_number' => '0510088001', 'lecturer_name' => 'Prof. Dr. Ir. Imam Riadi, M.Kom.'],
            ['lecturer_number' => '0520098702', 'lecturer_name' => 'Ika Arfiani, S.T., M.Cs'],
            ['lecturer_number' => '0505038301', 'lecturer_name' => 'Andri Pranolo, S.Kom., M.Cs., Ph.D.'],
            ['lecturer_number' => '0530077601', 'lecturer_name' => 'Dewi Soyusiawaty, S.T., M.T'],
            ['lecturer_number' => '0506016701', 'lecturer_name' => 'Mushlihudin, S.T., M.T.'],
            ['lecturer_number' => null, 'lecturer_name' => 'LPSI'],
            ['lecturer_number' => null, 'lecturer_name' => 'LPP'],
        ]);
    }
}
