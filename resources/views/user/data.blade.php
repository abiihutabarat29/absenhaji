@extends('layouts.app')
@section('content')
    <x-datatable link="javascript:void(0)" menu="{{ $menu }}">
        <th style="width:5%">No</th>
        <th style="width:20%">Kelompok</th>
        <th>Nama User</th>
        <th style="width:30%">Email</th>
        <th class="text-center" style="width: 15%">Action</th>
    </x-datatable>
@endsection
@section('modal')
    <x-modal size="">
        <x-dropdown name="kelompok_id" label="Kelompok" opsi="true">
            @foreach ($kelompok as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
            @endforeach
        </x-dropdown>
        <x-input type="text" name="name" label="Nama" opsi="true"></x-input>
        <x-input type="email" name="email" label="Email" opsi="true"></x-input>
        <x-inputPassword type="password" name="password" label="Password"></x-inputPassword>
        <x-inputPassword type="password" name="repassword" label="Konfirmasi Password"></x-inputPassword>
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
                    url: '{{ route('user.index') }}'
                },
                columns: [{
                        "data": null,
                        "orderable": false,
                        "searchable": false,
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "kelompok",
                        name: "kelompok",
                    }, {
                        data: "name",
                        name: "name",
                    },
                    {
                        data: "email",
                        name: "email",
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
            var createHeading = "Tambah User";
            createModel(createHeading);

            // Edit
            var editUrl = "{{ route('user.index') }}";
            var editHeading = "Edit User";
            var field = ['kelompok_id', 'name', 'email', 'password'];
            editModel(editUrl, editHeading, field);

            // Save
            saveBtn("{{ route('user.store') }}", myTable);

            // Delete
            var fitur = "User";
            var editUrl = "{{ route('user.index') }}";
            var deleteUrl = "{{ route('user.store') }}";
            Delete(fitur, editUrl, deleteUrl, myTable)
        });
    </script>
@endsection
