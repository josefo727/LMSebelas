@extends('layouts.app')
@section('content')

<div class="admin-banner">
    <h3>Data Kelas</h3>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card" style="padding:10px;">
                <table class="table-m" id="main-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Creator</th>
                            <th>Jumlah siswa</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelas as $item)
                        <tr data-child-id="{{$item->id}}">
                            <td>{{$loop->iteration}}</td>
                            <td><a href="{{ route('admin.kelas', $item->id) }}" class="text text-info">{{$item->name}}</a></td>
                            <td>{{ ucwords($item->creator['name']) }}</td>
                            <td>{{$item->anggota_kelas_count}}</td>
                            <td class="actions-admin">
                                <a href="#" class="text text-info details-control"><button class="btn btn-info btn-action"><i class="zmdi zmdi-edit"></i> Edit</button></a> &nbsp; 
                                <a href="{{ route('delete.kelas', $item->id) }}" onClick="return confirm('Apa kamu yakin untuk melakukan operasi tersebut?')" class="text text-danger"><button class="btn btn-danger btn-action"><i class="zmdi zmdi-delete"></i> Delete</button></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/DataTables/datatables.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/material.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.material.min.css')}}" type="text/css" />
@endsection
@section('js')
    <script type="text/javascript" src="{{ asset('assets/DataTables/datatables.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/jquery.datatables.material.min.js') }}"></script>
@endsection
@section('script')
    <script type="text/javascript" >
    function format(id){
        var div = $('<div/>').text('Loading...');
        
        $.ajax({
            url : "{{ url('admin/ajax/getkelasmenu/') }}/"+id,
            success: function ( json ) {
                
                div.html(json)
            }
        });
        
        return div
    }
        $(document).ready(function(){
            var table = $('#main-table').DataTable( {
                columnDefs: [
                    {
                        targets: [ 0, 1, 2 ],
                        className: 'mdl-data-table__cell--non-numeric'
                    }
                ]
            } );
            
        $('#main-table').on('click', 'a.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(tr.data('child-id'))).show();
                tr.addClass('shown');
            }
        });
        })
    </script>
@endsection