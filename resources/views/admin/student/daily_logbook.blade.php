@extends('layout.admin')

@section('main')
    <section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 py-44 px-4 lg:px-12 gap-4">
        <div class="flex col-span-12 mb-2 mt-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('student.dashboard') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-color-primary-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{ route('student.weekly_logbook') }}"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-color-primary-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Log
                            Book</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="#"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-color-primary-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Harian</a>
                    </div>
                </li>
            </ol>
        </div>
        <div class="col-span-12 lg:col-span-4 w-full">
            <div class="w-full bg-white p-6 rounded-lg shadow broder border-gray-200">

                <div class="flex flex-col mt-4">
                    @php
                        $startDate = \Carbon\Carbon::parse($data->start_date);
                        $endDate = \Carbon\Carbon::parse($data->end_date);
                    @endphp
                    <p class="font-semibold text-lg">{{ $startDate->format('d') }} - {{ $endDate->format('d M Y') }}</p>
                    {{-- <span class="text-sm text-slate-500">Minggu Ke-10</span> --}}
                </div>
                <hr class="mb-4 mt-4">
                <div class="flex mt-4 justify-between">
                    @foreach ($data->daily as $dailyItem)
                        @php
                            // Mendapatkan inisial hari
                            $dayName = \Carbon\Carbon::parse($dailyItem->date)
                                ->locale('id')
                                ->isoFormat('dd');

                            $dayInitial = substr($dayName, 0, 1);

                            // Menentukan warna dan ikon berdasarkan status
                            $colorClass = '';
                            $iconClass = '';
                            switch ($dailyItem->status) {
                                case 'terima':
                                    $colorClass = 'bg-green-500';
                                    $iconClass = 'fas fa-check';
                                    break;
                                case 'proses':
                                    $colorClass = 'bg-yellow-500';
                                    $iconClass = 'fas fa-hourglass-half';
                                    break;
                                case 'tolak':
                                    $colorClass = 'bg-red-500';
                                    $iconClass = 'fas fa-times';
                                    break;
                                default:
                                    $colorClass = 'bg-gray-500';
                                    $iconClass = 'fas fa-minus';
                            }
                        @endphp

                        <div class="flex flex-col items-center justify-center">
                            <p>{{ $dayInitial }}</p>
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 text-sm font-semibold text-white rounded-full {{ $colorClass }}">
                                <i class="{{ $iconClass }} text-sm"></i>
                            </span>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-8 w-full flex flex-col gap-y-2">
            @foreach ($data->daily as $item)
                <div class="p-8 bg-white w-full rounded-xl border border-gray-200 shadow mb-4">
                    <button class="w-full flex justify-between items-center" onclick="openDetails(this)">
                        <div class="flex gap-x-4 items-center">
                            @php
                                $statusColor = '';
                                $iconClass = '';

                                switch ($item->status) {
                                    case 'terima':
                                        $statusColor = 'success';
                                        $iconClass = 'fas fa-check-circle';
                                        break;
                                    case 'proses':
                                        $statusColor = 'warning';
                                        $iconClass = 'fas fa-hourglass-half';
                                        break;
                                    case 'tolak':
                                        $statusColor = 'danger';
                                        $iconClass = 'fas fa-times-circle';
                                        break;
                                    case 'belum':
                                        $statusColor = 'primary';
                                        $iconClass = 'fas fa-question-circle';
                                        break;
                                    default:
                                        $statusColor = 'secondary';
                                        $iconClass = 'fas fa-exclamation-circle';
                                        break;
                                }
                            @endphp
                            <span
                                class="inline-flex items-center justify-center w-12 h-12 text-sm font-semibold text-white rounded-full bg-color-{{ $statusColor }}-500">
                                <i class="{{ $iconClass }} text-lg"></i>
                            </span>
                            <div class="flex flex-col justify-start items-start">
                                @php
                                    $dayName = \Carbon\Carbon::parse($item->date)
                                        ->locale('id')
                                        ->isoFormat('dddd');
                                @endphp
                                <p class="font-semibold">{{ $dayName }}</p>
                                <span class="text-sm text-slate-500">{{ $item->date }}</span>


                            </div>
                        </div>
                        <div>
                            <i class="fas fa-chevron-down text-lg"></i>
                        </div>
                    </button>

                    <div class="mt-4 flex-col gap-y-4 hidden detailContainer">
                        @if ($item->status != 'belum')
                            <div>
                                <label for="">Dokumentasi</label>
                                <form action="" class="flex items-center w-full gap-x-2">
                                    <div class="relative w-full ">
                                        <div
                                            class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                            <span>
                                                <i class="fas fa-link text-lg text-slate-500"></i>
                                            </span>
                                        </div>
                                        <input type="text" id="input-group-1"
                                            class="bg-gray-50 border block border-gray-300 text-gray-900  text-xs rounded-md w-full ps-12 p-4  "
                                            placeholder="https://kampusmerdeka.kemdikbud.go.id/program/magang-mandiri/browse/185c2258-bf50-4211-b460-4ed6f1db081c/95ff7b3f-1a14-40f3-b142-0cdc24aa5d9a"
                                            disabled value={{ $item->dokumentasi }}>
                                    </div>
                                    <a href="{{ $item->dokumentasi }}" target="_blank" rel="noopener noreferrer"
                                        class="text-white bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-3.5 me-2">
                                        Lihat
                                    </a>
                                </form>
                                <br>
                                <table id="table_config" class="w-full ">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Deskripsi</th>
                                            <th>Rencana</th>
                                            <th>Presentase</th>
                                            <th>Hambatan</th>
                                            <th>Solusi</th>
                                            <th>Jam Mulai</th>
                                            <th>Jam Selesai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($item->activity as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->desc }}</td>
                                                <td>{{ $data->rencana }}</td>
                                                <td>{{ $data->presentase }}%</td>
                                                <td>{{ $data->hambatan }}</td>
                                                <td>{{ $data->solusi }}</td>
                                                <td>{{ $data->jam_mulai }}</td>
                                                <td>{{ $data->jam_selesai }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif


                        <hr class="mt-4 mb-4">
                        @if ($item->status == 'belum')
                            <button type="button"
                                class="text-white h-fit w-fit bg-color-success-500 hover:bg-success-danger-600 focus:ring-4 focus:ring-color-danger-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                                onclick="window.location='{{ route('student.daily_logbookForm', ['id' => $item->id]) }}'">
                                Isi Log Book
                            </button>
                        @endif
                        @if ($item->status == 'tolak')
                            <div class="text-red-500 mb-2">
                                <strong>Alasan Penolakan:</strong> {{ $item->msg }}
                            </div>
                            <button type="button"
                                class="text-white h-fit w-fit bg-color-success-500 hover:bg-success-danger-600 focus:ring-4 focus:ring-color-danger-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                                onclick="window.location='{{ route('student.daily_logbookForm', ['id' => $item->id]) }}'">
                                Perbaiki Log Book
                            </button>
                        @endif

                    </div>

                </div>
            @endforeach
        </div>
    </section>
    <script>
        // Menggunakan kelas 'detailContainer' sebagai selektor umum untuk semua elemen yang ingin Anda kontrol
        const detailContainers = document.querySelectorAll('.detailContainer');

        // Fungsi openDetails menerima parameter elemen yang diklik
        const openDetails = (element) => {
            // Temukan kontainer detail yang sesuai dengan elemen yang diklik
            const detailContainer = element.nextElementSibling;

            // Periksa apakah detailContainer memiliki kelas 'hidden'
            if (detailContainer.classList.contains('hidden')) {
                // Jika memiliki kelas 'hidden', hapus kelas tersebut
                detailContainer.classList.remove('hidden');
                detailContainer.classList.add('flex');
            } else {
                // Jika tidak memiliki kelas 'hidden', tambahkan kelas tersebut
                detailContainer.classList.remove('flex');
                detailContainer.classList.add('hidden');
            }
        };
    </script>
    <script src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#table_config').DataTable();
        });
    </script>
@endsection
