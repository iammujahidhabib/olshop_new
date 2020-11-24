@extends('template.admin.template')

@section('content')
<style>
    .label{
        font-size: 14pt;
        font-weight: 600;
    }
    /* .carousel-inner > .carousel-item > img {
        position: absolute;
        top: 0;
        left: 0;
        min-width: 100%;
        height: 500px;
    } */
    /* .carousel .carousel-item > img {
        position: absolute;
        top: 0;
        left: 0;
        max-width: 100%;
        height: 100%;
    } */
</style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="col"><h2>Detail Prodouct</h2></div>
                        <div class="col">
                            <button id="buttonProductModal" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> Product</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col">
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                </ol>
                                <div class="carousel-inner" id="showPicture">
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                  </a>
                                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                  </a>
                            </div>
                        </div>
                        <hr>
                        <div class="col" id="showProduct"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    function dataProduct() {
        var id='{{ request()->id }}';
        // {{ request()->id }}
        console.log(id);
        $.ajax({
            type  : 'GET',
            url   : '/product-edit/'+id,
            async : false,
            dataType : 'JSON',
            success : function(data){
                var html = '';
                var olHTML = '';
                var imgHTML = '';
                var i;
                console.log(data.product);
                    html += `
                        <div class="row">
                            <div class="col-md-4 label">Product Name</div>
                            <div class="col-md-6">${data.product.product}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 label">Category</div>
                            <div class="col-md-6">${data.product.id_category}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 label">Price</div>
                            <div class="col-md-6">${data.product.price}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 label">Stock</div>
                            <div class="col-md-6">${data.product.stock}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 label">Description</div>
                            <div class="col-md-6">${data.product.desc}</div>
                        </div>`;
                $('#showProduct').html(html);
                console.log(data.pictureProduct[1]);
                for(var i=0;i < data.pictureProduct.length;i++){
                    if(i == 0){
                        olHTML +=`<li data-target="#carouselExampleIndicators" data-slide-to="${i}" class="active"></li>`;
                        imgHTML +=` <div class="carousel-item active">
                                    <img class="d-block" src="{{ asset('storage') }}/${data.pictureProduct[i].picture}" alt="${i} slide" style="margin: auto;max-width:100%;max-height: 300px;height:100%;width:auto;">
                                </div>`;
                    }else{
                        olHTML +=`<li data-target="#carouselExampleIndicators" data-slide-to="${i}"></li>`;
                        imgHTML +=` <div class="carousel-item">
                                    <img class="d-block" src="{{ asset('storage') }}/${data.pictureProduct[i].picture}" alt="${i} slide" style="margin: auto;max-width:100%;max-height: 300px;width:auto;">
                                </div>`;
                    }
                }
                $('.carousel-indicators').html(olHTML);
                $('#showPicture').html(imgHTML);
                }
        });

    }
    $(document).ready(function() {
        dataProduct();

        // $("#buttonProductModal").click(function() {
        //     $('#productModal').modal('show');
        // });

        // $("#formProduct").submit(function(){
        //     save();
        // });

        // $("#formEditProduct").submit(function(){
        //     update();
        // });
    });
    </script>
@endsection
