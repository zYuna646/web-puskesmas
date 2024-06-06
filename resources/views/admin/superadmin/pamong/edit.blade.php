@extends('layout.admin')

@section('main')
<section class="max-w-screen-lg mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
  <div class="bg-white p-6 rounded-xl mt-32">
    <h2 class="text-xl font-semibold mb-4">Tambah Pamong</h2>
    <form action="{{ route('admin.dpl.store') }}" method="POST">
      @csrf
      <div class="mb-4">
        <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Dosen</label>
        <select name="dosen_id" id="lokasi"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          required>
          @foreach ($data['dosen'] as $item)
          <option value="{{ $item->id }}">{{ $item->nidn . ' - ' . $item->name }}</option>
          @endforeach
          <!-- Ganti dengan data lokasi yang sesuai -->
        </select>
      </div>
      <div class="mb-4">
        <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
        <select multiple="multiple" class="js-example-basic-multiple w-full" name="lokasi_id[]">
          @foreach ($data['lokasi'] as $item)
          <option value={{$item->id}}>{{$item->name}}</option>
          @endforeach
        </select>
      </div>
      <x-button_md class="w-full" type="submit" type="submit">
        Kirim
      </x-button_md>
    </form>
  </div>
</section>
<script>
  $(document).ready(function () {
        function initializeSelect2() {
            $('.js-example-basic-multiple').select2();
        }

        initializeSelect2(); // Initialize on page load

        let repeaterIndex = 2; // Start index for repeater items

        // Function to add repeater item
        $('#add_repeater').click(function () {
            const repeaterItem = `<div class="p-6 bg-slate-100 rounded-md repeater_item">
                <label for="mahasiswa_${repeaterIndex}" class="block text-sm font-medium text-gray-700 mb-2">Mahasiswa ${repeaterIndex}</label>
                <select id="mahasiswa_${repeaterIndex}"
                     name="lokasi_id[]"
                    class="js-example-basic-single w-full "
                    required>
                    @foreach ($data['lokasi'] as $item)
                    <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                </select>
                <button type="button" class="remove_repeater text-white inline-flex items-center gap-x-2 w-fit bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 col-span-12 mt-4">
                    <span><i class="fas fa-trash"></i></span> Hapus
                </button>
            </div>`;

            $('#repeater_wrapper').append(repeaterItem);
            initializeSelect2(); // Initialize Select2 for the newly added element
            repeaterIndex++;
        });

        // Function to remove repeater item
        $(document).on('click', '.remove_repeater', function () {
            $(this).closest('.repeater_item').remove();
        });
    });
</script>
<script>
  $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
@endsection