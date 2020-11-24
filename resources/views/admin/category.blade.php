@extends('template.admin.template')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="col"><h2>Table Category</h2></div>
                        <div class="col"><button id="btnCategoryModal" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> Category</button></div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6"></div>
                                    <div class="col-sm-12 col-md-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="example2" class="example2 table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="ID: activate to sort column descending" aria-sort="ascending">ID</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Category: activate to sort column ascending">Category</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="showCategory">
                                                {{-- @foreach($category as $post)
                                                <tr id="row_{{$post->id_category}}">
                                                    <td>{{ $post->id_category  }}</td>
                                                    <td>{{ $post->category }}</td>
                                                    <td><a href="javascript:void(0)" data-id="{{ $post->id }}" onclick="editPost(event.target)" class="btn btn-info">Edit</a>
                                                    <a href="javascript:void(0)" data-id="{{ $post->id }}" class="btn btn-danger" onclick="deletePost(event.target)">Delete</a></td>
                                                </tr>
                                                @endforeach --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Create Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="formCategory" action="/category/save" method="POST" enctype="multipart/form-data">
                    {{-- {{ csrf_field() }} --}}
                    @csrf
                    <div class="form-group">
                        <label for="inp-category">Category</label>
                        <input type="text" id="inp-category" class="form-control" name="category" placeholder="Category" required>
                        {{-- @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif --}}
                    </div>
                    <input type="submit" value="Create" class="btn btn-primary btn-sm float-right">
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade" id="editCategoryModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="editCategory"  method="POST" enctype="multipart/form-data">
                        {{-- {{ csrf_field() }} --}}
                        @csrf
                        <div class="form-group">
                            <label for="ed-category">Category</label>
                            <input type="hidden" id="ed-id" name="id" required>
                            <input type="text" id="ed-category" class="form-control" name="category" placeholder="Category" required>
                            {{-- @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif --}}
                        </div>
                        <input type="submit" value="Create" class="btn btn-primary btn-sm float-right">
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        function dataCategory() {
            // var url= {{}}
            $.ajax({
                type  : 'GET',
                url   : '/category/all',
                async : false,
                dataType : 'JSON',
                success : function(data){
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<tr>'+
                                '<td>'+data[i].id+'</td>'+
                                '<td>'+data[i].category+'</td>'+
                                '<td>'+
                                    '<button id="btnEditCategory" data-id="'+data[i].id+'" data-toggle="modal" data-target="#editCategoryModal" class="btn btn-info">Edit</button> '+
                                    '<button id="btnDeleteCategory" data-id="'+data[i].id+'" class="btn btn-danger">Delete</button></td>'+
                            '</tr>';
                }
                    $('#showCategory').html(html);
                }
                // $('#provinsi').html(url);
                // return false;
            });
        }

        function openCategoryModal() {
            $("#categoryModal").show();
        }

        function save() {
            $('input').blur();
            event.preventDefault();

            // let _action = $('#formCategory').attr("action");
            var formData = new FormData($('#formCategory')[0]);
            $.ajax({
                // url= _action,
                url:'/category-save',
                type: "POST",
                dataType: "JSON",
                async: true,
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success:function(data){
                    if (data.status == "success") {
                        $("#formCategory")[0].reset();
                        Swal.fire({
                            type: 'success',
                            title: 'Done!',
                            text: 'Category created.'
                        })
                        .then (function() {
                            $('#categoryModal').modal('hide');
                            dataCategory();
                        });
                        console.log(data.response);
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Opps!',
                            text: 'Try again!'
                        });
                    }
                },error:function(){
                    Swal.fire({
                        type: 'error',
                        title: 'Opps!',
                        text: 'server error!'
                    });
                }
            });
        }

        function update() {
            $('input').blur();
            event.preventDefault();

            // let _action = $('#formCategory').attr("action");
            var formData = new FormData($('#editCategory')[0]);
            $.ajax({
                // url= _action,
                url:'/category-update',
                type: "POST",
                dataType: "JSON",
                async: true,
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success:function(data){
                    if (data.status == "success") {
                        $("#editCategory")[0].reset();
                        Swal.fire({
                            type: 'success',
                            title: 'Done!',
                            text: 'Category updated.'
                        })
                        .then (function() {
                            $('#editCategoryModal').modal('hide');
                            dataCategory();
                        });
                        console.log(data.response);
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Opps!',
                            text: 'Try again!'
                        });
                    }
                },error:function(){
                    Swal.fire({
                        type: 'error',
                        title: 'Opps!',
                        text: 'server error!'
                    });
                }
            });
        }

        $(document).ready(function() {

            dataCategory();

            $("#btnCategoryModal").click(function() {
                $('#categoryModal').modal('show');
            });

            $(document).on('click','#btnEditCategory',function() {
                event.preventDefault();
                var id = $(this).attr('data-id');
                $.ajax({
                    url: '/category-edit/'+id,
                    type: "get",
                    dataType: "json",
                    success:(data) => {
                        $('#ed-id').val(data.id);
                        $('#ed-category').val(data.category);
                        $('#editModalCategory').modal('show');
                    },
                    error:() => {
                        Swal.fire({
                            title: "Error",
                            text: "Error on System..!",
                            type: "warning",
                        });
                    }
                });
            });

            $('#btnDeleteCategory').click(function(){
                if(!confirm("Do you really want to do this?")) {
                    return false;
                }

                event.preventDefault();
                var id = $(this).attr('data-id');

                $.ajax(
                    {
                    url: '/category-delete/'+id,
                    type: 'get',
                    dataType: "json",
                    data: {
                            id: id
                    },
                    success: function (data){
                        if(data.response == 'success'){
                            Swal.fire(
                                'Remind!',
                                'Category deleted!',
                                'success'
                            )
                            .then (function() {
                                dataCategory()
                            });
                        }else{
                            Swal.fire({
                                title: "Error",
                                text: "Error on System..!",
                                type: "warning",
                            });
                        }
                    },
                    error:() => {
                        Swal.fire({
                            title: "Error",
                            text: "Error on System..!",
                            type: "warning",
                        });
                    }
                });
                return false;
            });

            $("#formCategory").submit(function(){
                save();
            });

            $("#editCategory").submit(function(){
                update();
            });

        });
    </script>
@endsection
