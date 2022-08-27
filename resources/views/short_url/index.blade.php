@extends('layouts.app')

@section('title', 'Short URLs')

@section('content')
<!-- start page title -->
<br>
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">{{ __('Short URLs') }}</h4>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="col-6">
            <form method="POST" action="{{ route('short-url.store') }}">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="url" class="form-control" placeholder="Enter URL" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit">Generate Link</button>
                    </div>
                </div>
                <div class="text-danger" >
                    @if ($errors->has('url'))
                        {{ $errors->first('url') }}
                    @endif
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered data-table table-responsive">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Short URL</th>
                                    <th>URL</th>
                                    <th>Visitors</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('short-url.index') }}",
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    sortable: false,
                },
                {
                    data: 'short_url',
                    name: 'short_url',
                    searchable: true,
                    sortable: true,
                },
                {
                    data: 'url',
                    name: 'url',
                    searchable: true,
                    sortable: true,
                },
                {
                    data: 'visitors',
                    name: 'visitors',
                    searchable: true,
                    sortable: true,
                },
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ],
            order: [
                [ 1, 'asc' ]
            ],
        });


        //Delete url on confirm
        $('body').on('click','.delete-url',function()
        {
            var uuid = $(this).attr('data-id');
            let text = "Are you sure you want to delete?";
            if (confirm(text) == true) {
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:'/short-url/'+uuid+'/destroy',
                    async: false,
                    success: function (response) {
                        toastr["success"]("URL deleted successfully.")
                        $('#DataTables_Table_0').DataTable().draw();
                    }
                });
            } 
        });

        $('body').on('click','.url-redirected',function()
        {
            $('#DataTables_Table_0').DataTable().draw();
        });
        
    });
</script>
@endsection