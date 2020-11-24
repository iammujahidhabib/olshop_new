@extends('template.admin.template')

@section('content')
{{-- <style>
    .conIMG {
        position: absolute;
        width: 100%;
        max-width: 400px;
    }

    .conIMG img {
        width: 100%;
        height: auto;
    }
    .conIMG .btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        background-color: #555;
        color: white;
        font-size: 16px;
        padding: 12px 24px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        text-align: center;
    }
</style> --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="col"><h2>Table Prodouct</h2></div>
                        <div class="col">
                            <button id="buttonProductModal" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> Product</button>
                        </div>
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
                                                    <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Tanggal Daftar: activate to sort column descending" aria-sort="ascending">ID</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Nama: activate to sort column ascending">Product Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Price</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="No Telpon: activate to sort column ascending">Stock</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="showProduct"></tbody>
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
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="productModalLabel">Create Product</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="/product-save" method="POST" id="formProduct" enctype="multipart/form-data">
                    {{-- {{ csrf_field() }} --}}
                    @csrf
                    <div class="form-group form-input">
                        <label for="inp-product">Product Name</label>
                        <input type="text" class="form-control" id="inp-product" name="product" placeholder="Product Name" required>
                    </div>
                    <div class="form-group form-input">
                        <label for="inp-category">Category</label>
                        <select class="form-control" name="id_category" id="inp-category" required>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group form-input">
                        <label for="inp-price">Price</label>
                        <input type="number" class="form-control" id="inp-price" name="price" placeholder="70000" required>
                    </div>
                    <div class="form-group form-input">
                        <label for="inp-stock">Stock</label>
                        <input type="number" class="form-control" id="inp-stock" name="stock" placeholder="12" required>
                    </div>
                    <div class="form-group form-input">
                        <label for="inp-stock">Description Product</label>
                        <textarea name="desc" class="form-control" id="inp-desc" required></textarea>
                    </div>
                    <div class="form-group form-input">
                        <label for="inp-picture">Picture</label>
                        <input type="file" class="form-control" id="inp-picture" name="picture" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <input type="submit" value="Save" class="btn btn-primary">
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="editProductModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="userCrudModal">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="row">
                    <div class="col-6">
                        <div id="loopPicture" style="width: 100%;height: 500px; overflow: scroll"></div>
                    </div>
                    <div class="col-6">
                    <form action="/product-update" method="POST" id="formEditProduct" enctype="multipart/form-data">
                        {{-- {{ csrf_field() }} --}}
                        @csrf
                        <div class="form-group form-input">
                            <label for="ed-product">Product Name</label>
                            <input type="hidden" name="id" id="ed-id" required>
                            <input type="text" class="form-control" id="ed-product" name="product" placeholder="Product Name" required>
                        </div>
                        <div class="form-group form-input">
                            <label for="ed-product">Category</label>
                            <select class="form-control" name="id_category" id="ed-category" required>
                                <option></option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group form-input">
                            <label for="ed-price">Price</label>
                            <input type="number" class="form-control" id="ed-price" name="price" placeholder="70000" required>
                        </div>
                        <div class="form-group form-input">
                            <label for="ed-stock">Stock</label>
                            <input type="number" class="form-control" id="ed-stock" name="stock" placeholder="12" required>
                        </div>
                        <div class="form-group form-input">
                            <label for="ed-stock">Description Product</label>
                            <textarea name="desc" class="form-control" id="ed-desc" required></textarea>
                        </div>
                        <div class="form-group form-input">
                            <label for="ed-picture"><b><i class="fa fa-plus"></i></b> Picture</label>
                            <input type="file" class="form-control-file" id="ed-picture" name="picture">
                            <div class="invalid-feedback"></div>
                        </div>
                        <input type="submit" value="Save" class="btn btn-primary">
                    </form>
                </div>
            </div>
                </div>

            </div>
        </div>
    </div>
    {{-- {{ URL::asset('storage/images/x0mJMtrOhFBcrmCewvlPyLGYDvJ4bMu83DZlLdfW.png') }}; --}}

    <script type="text/javascript">
    function dataProduct() {
            $.ajax({
                type  : 'GET',
                url   : '/product/all',
                async : false,
                dataType : 'JSON',
                success : function(data){
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<tr>'+
                                '<td>'+data[i].id+'</td>'+
                                '<td>'+data[i].product+'</td>'+
                                '<td>'+data[i].price+'</td>'+
                                '<td>'+data[i].stock+'</td>'+
                                '<td>'+
                                    '<button id="btnDetailProduct" data-id="'+data[i].id+'" class="btn btn-secondary">Detail</button> '+
                                    '<button id="btnEditProduct" data-id="'+data[i].id+'" data-toggle="modal" data-target="#editProductModal" class="btn btn-info">Edit</button> '+
                                    '<button id="btnDeleteProduct" data-id="'+data[i].id+'" class="btn btn-danger">Delete</button></td>'+
                            '</tr>';
                }
                    $('#showProduct').html(html);
                }
                // $('#provinsi').html(url);
                // return false;
            });
    }
    function save() {
            $('input').blur();
            event.preventDefault();

            // let _action = $('#formCategory').attr("action");
            var formData = new FormData($('#formProduct')[0]);
            $.ajax({
                // url= _action,
                url:'/product-save',
                type: "POST",
                dataType: "JSON",
                async: true,
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success:function(data){
                    if (data.status == "success") {
                        $("#formProduct")[0].reset();
                        Swal.fire({
                            type: 'success',
                            title: 'Done!',
                            text: 'Product created.'
                        })
                        .then (function() {
                            $('#productModal').modal('hide');
                            dataProduct();
                        });
                        console.log(data.response);
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Opps!',
                            text: 'Try again!'
                        });
                    }
                },error:(xhr, status, error) => {
                    const {responseJSON:response,} = xhr;
                    if(response.errors) {
                        for(var form_data in response.errors) {
                            $(`#inp-${form_data}`).addClass('is-invalid');
                            $(`#inp-${form_data}`).parents('.form-input').find('.invalid-feedback').html(response.errors[form_data][0]);
                        }
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: response.message,
                            icon: "error",
                            heightAuto: false
                        });
                    }
                }
            });
        }

        function update() {
            $('input').blur();
            event.preventDefault();

            // let _action = $('#formCategory').attr("action");
            var formData = new FormData($('#formEditProduct')[0]);
            $.ajax({
                // url= _action,
                url:'/product-update/',
                type: "POST",
                dataType: "JSON",
                async: true,
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success:function(data){
                    if (data.status == "success") {
                        $("#formEditProduct")[0].reset();
                        Swal.fire({
                            type: 'success',
                            title: 'Done!',
                            text: 'Product updated.'
                        })
                        .then (function() {
                            $('#editProductModal').modal('hide');
                            dataProduct();
                        });
                        // console.log(data.response);
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Opps!',
                            text: 'Try again!'
                        });
                    }
                },error:(xhr, status, error) => {
                    const {responseJSON:response,} = xhr;
                    if(response.errors) {
                        for(var form_data in response.errors) {
                            $(`#ed-${form_data}`).addClass('is-invalid');
                            $(`#ed-${form_data}`).parents('.form-input').find('.invalid-feedback').html(response.errors[form_data][0]);
                        }
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: response.message,
                            icon: "error",
                            heightAuto: false
                        });
                    }
                }
            });
        }
    $(document).ready(function() {
        // console.log(flagsUrl);
        dataProduct();

        $("#buttonProductModal").click(function() {
            $('#productModal').modal('show');
        });

        $("#formProduct").submit(function(){
            save();
        });

        $("#formEditProduct").submit(function(){
            update();
        });
        $(document).on('click','#btnEditProduct',function() {
            event.preventDefault();
            var id = $(this).attr('data-id');
            $.ajax({
                url: '/product-edit/'+id,
                type: "get",
                dataType: "json",
                success:(data) => {
                    $('#ed-id').val(data.product.id);
                    $('#ed-category').val(data.product.id_category);
                    $('#ed-product').val(data.product.product);
                    $('#ed-price').val(data.product.price);
                    $('#ed-stock').val(data.product.stock);
                    $('#ed-desc').val(data.product.desc);
                    console.log(data.pictureProduct.length);
                    var imgHTML='';
                    // if(data.pictureProduct.length > 1){
                        // imgHTML +=`<img id="pic-picture" class="img-fluid">`;
                    // }else{
                    for(var i=0;i < data.pictureProduct.length;i++){
                        imgHTML +=`<img id="pic-picture" class="img-fluid" src="{{ asset('storage') }}/${data.pictureProduct[i].picture}">
                        <hr>`;
                    }
                    // }
                    // var alt=data.pictureProduct[0].picture;
                    // var newAlt=alt.slice(7);
                    // console.log(newAlt);
                    // $('#pic-picture').attr({src:`{{ asset('storage') }}/${data.pictureProduct[0].picture}`,alt:newAlt});
                    $('#loopPicture').html(imgHTML);
                    $('#editProductModal').modal('show');
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

        $(document).on('click','#btnDetailProduct',function(){
            var id = $(this).attr('data-id');
            window.location.href='/product-detail/'+id;
        })

            $('#btnDeleteProduct').click(function(){
                if(!confirm("Do you really want to do this?")) {
                    return false;
                }

                event.preventDefault();
                var id = $(this).attr('data-id');

                $.ajax(
                    {
                    url: '/product-delete/'+id,
                    type: 'get',
                    dataType: "json",
                    data: {
                            id: id
                    },
                    success: function (data){
                        if(data.response == 'success'){
                            Swal.fire(
                                'Remind!',
                                'Product deleted!',
                                'success'
                            )
                            .then (function() {
                                dataProduct()
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
    });
    </script>
@endsection
