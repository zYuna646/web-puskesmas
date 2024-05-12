<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\DPL;
use App\Models\Lokasi;
use App\Models\Lowongan;
use App\Models\Mahasiswa;
use App\Models\ProgramTransaction;
use App\Models\Role;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DPLImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $tmp = null; // Initialize $tmp with null
        foreach ($rows as $index => $row) {
            try {
                if ($row['nidn']) {
                    $dosen = Dosen::where('nidn', $row['nidn'])->first();
                    $tmp = $dosen;
                } else {
                    $dosen = $tmp;
                }
                // Menambahkan tanda titik koma dan tanda kutip pada NIP
                if (!$dosen) {
                    continue; // Skip baris ini jika Guru sudah ada
                }
                $mahasiswa = Mahasiswa::where('nim', $row['nim'])->first();
                if (!$mahasiswa) {
                    continue;
                }
                $lowongan = Lowongan::where('code', $row['lowongan'])->first(); // Add missing semicolon
                if (!$lowongan) {
                    continue;
                }

                $programTransaction = ProgramTransaction::where('mahasiswa_id', $mahasiswa->id)->where('lowongan_id', $lowongan->id)->first();

                if (!$programTransaction) {
                    continue;
                }

                $dpl = DPL::where('dosen_id', $dosen->id)->first();
                if ($dpl) {
                    $dpl->mahasiswa()->attach($programTransaction->id);
                } else {
                    $dosen = DPL::create([
                        'dosen_id' => $dosen->id,
                        'lowongan_id' => $lowongan->id
                    ]);
                    $dosen->mahasiswa()->attach($programTransaction->id);
                }

            } catch (\Throwable $th) {
                // Handle the error here
                \Log::error('Error importing row: ' . $th->getMessage());
                dd($th); // Also log and dd here to ensure value is not null
            }
        }
    }
}
