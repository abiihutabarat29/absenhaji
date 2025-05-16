@extends('layouts.app')
@section('content')
    <x-datatable link="javascript:void(0)" menu="{{ $menu }}">
        <th style="width:5%">No</th>
        <th>Nama</th>
        <th class="text-center" style="width:10%">Peserta</th>
        <th class="text-center" style="width: 15%">Action</th>
    </x-datatable>
@endsection
@section('modal')
    <x-modal size="">
        <x-input type="text" name="name" label="Nama" opsi="true"></x-input>
    </x-modal>
    <x-delete></x-delete>
@endsection
@section('script')
    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            var myTable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 50, 100, 200, 500],
                lengthChange: true,
                autoWidth: true,
                scrollCollapse: true,
                paging: true,
                ajax: {
                    url: '{{ route('kelompok.index') }}'
                },
                columns: [{
                        "data": null,
                        "orderable": false,
                        "searchable": false,
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, {
                        data: "name",
                        name: "name",
                    },
                    {
                        data: "jlh_peserta",
                        name: "jlh_peserta",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });

            // Create
            var createHeading = "Tambah Kelompok";
            createModel(createHeading);

            // Edit
            var editUrl = "{{ route('kelompok.index') }}";
            var editHeading = "Edit Kelompok";
            var field = ['name'];
            editModel(editUrl, editHeading, field);

            // Save
            saveBtn("{{ route('kelompok.store') }}", myTable);

            // Delete
            var fitur = "Kelompok";
            var editUrl = "{{ route('kelompok.index') }}";
            var deleteUrl = "{{ route('kelompok.store') }}";
            Delete(fitur, editUrl, deleteUrl, myTable)
        });
    </script>
@endsection
