<div class="lg:col-span-8 col-span-12 w-full flex flex-col gap-y-4">
    <div class="grid grid-cols-12 p-10 bg-white rounded-xl border border-slate-200 shadow-sm">
        <div class="col-span-2">
            <img src="/images/avatar/avatar.jpg" alt="" class="w-20 rounded-full">
        </div>
        <div class="col-span-12 mt-4">
            <h4 class="font-semibold text-lg">{{ $peserta->mahasiswa->name }} ({{ $peserta->mahasiswa->nim }})</h4>
        </div>

        <div class="col-span-12 flex gap-x-2 items-center text-color-primary-500 mt-2">
            <span class=""><i class="fas fa-book text-sm"></i></span>
            <p class="text-sm font-semibold">{{ $peserta->lowongan->program->name }}</p>
        </div>
        <div class="col-span-12 mt-4 flex flex-col gap-y-2">
            <div class="flex flex-col">
                <span class="text-xs text-slate-500">NIM: </span>
                <p class="text-sm">{{ $peserta->mahasiswa->nim }}</p>
            </div>
            <div class="flex flex-col">
                <span class="text-xs text-slate-500">Periode Kegiatan: </span>
                <p class="text-sm">{{ \Carbon\Carbon::parse($peserta->lowongan->tanggal_mulai)->format('d M Y') }} -
                    {{ \Carbon\Carbon::parse($peserta->lowongan->tanggal_selesai)->format('d M Y') }} </p>
            </div>

        </div>

    </div>
    <div class="flex flex-col gap-y-2 max-h-[42rem] overflow-y-auto">

        @foreach ($peserta->weeklyLog as $index => $item)
        @php
        $statusColor = '';
        $statusIcon = '';
        switch ($item->status) {
        case 'terima':
        $statusColor = 'success';
        $statusIcon = 'check-circle';
        break;
        case 'proses':
        $statusColor = 'warning';
        $statusIcon = 'spinner';
        break;
        case 'tolak':
        $statusColor = 'danger';
        $statusIcon = 'times-circle';
        break;
        case 'belum':
        $statusColor = 'gray';
        $statusIcon = 'clock';
        break;
        default:
        $statusColor = 'primary';
        $statusIcon = 'exclamation-circle';
        break;
        }
        @endphp
        <div class="grid grid-cols-12 p-10 bg-white rounded-xl border border-slate-200 shadow-sm">
            <div class="flex lg:flex-row flex-col gap-y-4 gap-x-6 w-full col-span-12">
                <span
                    class="inline-flex items-center justify-center w-12 h-12 text-sm font-semibold text-{{ $statusColor }}-500 bg-{{ $statusColor }}-100 border border-{{ $statusColor }}-500 rounded-full">
                    <i class="fas fa-{{ $statusIcon }} text-lg"></i>
                </span>
                <div class="flex flex-col gap-y-2">
                    <h4 class="text-xl font-semibold">Log Book Minggu Ke-{{ $index + 1 }}</h4>
                    <p class="text-sm">
                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->isoFormat('dddd D MMMM YYYY') }} -
                        {{ \Carbon\Carbon::parse($item->tanggal_selesai)->isoFormat('dddd D MMMM YYYY') }}</p>
                    <a href="{{ route('dosen.weekly_review', ['id' => $item->id]) }}"
                        class="text-white h-fit w-fit bg-gray-500 hover:bg-{{ $statusColor }}-600 focus:ring-4 focus:ring-{{ $statusColor }}-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                        Periksa Laporan
                    </a>
                </div>
            </div>
        </div>
        @endforeach
        <div class="p-8 bg-white w-full rounded-xl broder border-gray-200 shadow flex flex-col gap-y-4">

            <div class="flex lg:flex-row flex-col gap-y-4  gap-x-4">
                <span
                    class="inline-flex items-center justify-center  h-12 w-12 text-sm font-semibold text-color-primary-500 bg-color-primary-100 border border-color-primary-500 rounded-full ">
                    <i class="fas fa-exclamation text-lg"></i>
                </span>
                <div class="flex flex-col text-color-primary-500">
                    <p class="font-semibold">Mahasiswa Sudah Mengopload Rancangan</p>
                    <p class="text-sm">Lihat Detail Rancangan Mahasiswa, Dan Berikan Feedback Yang Sesuai </p>
                </div>
            </div>
            <div class="flex flex-col gap-y-2">
                <form action="" class="flex items-center w-full gap-x-2">
                    <div class="relative w-full ">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <span>
                                <i class="fas fa-link text-lg text-slate-500"></i>
                            </span>
                        </div>
                        <input type="text" id="input-group-1"
                            class="bg-gray-50 border block border-gray-300 text-gray-900  text-xs rounded-md w-full ps-12 p-4  "
                            placeholder="https://kampusmerdeka.kemdikbud.go.id/program/magang-mandiri/browse/185c2258-bf50-4211-b460-4ed6f1db081c/95ff7b3f-1a14-40f3-b142-0cdc24aa5d9a"
                            disabled>
                    </div>
                    <a
                        class="text-white bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-3.5 me-2">
                        Lihat
                    </a>
                </form>
            </div>
            <hr>
            <div>
                <form action="">
                    <div class="mb-4">
                        <label for="solusi" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
                            Kirim FeedBack ( Isi Bagian Ini Jika Memilih Menolak Rancangan )
                        </label>
                        <textarea name="solusi" id="solusi" placeholder="Feedback racangan kegiatan"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs "></textarea>
                    </div>
                    <div>
                        <a
                            class="text-white w-fit h-fit bg-color-success-500 hover:bg-color-success-600 focus:ring-4 focus:ring-color-success-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2">
                            Setujui
                        </a>
                        <a
                            class="text-white w-fit h-fit bg-color-danger-500 hover:bg-color-danger-600 focus:ring-4 focus:ring-color-danger-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2">
                            Tolak
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>