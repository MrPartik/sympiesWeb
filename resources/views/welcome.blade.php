@extends('layouts.app')

@section('content')
    <style>
        /* Flex-related code */
        .flex {
            display: flex;
            flex-wrap: wrap;
            justify-content: center; /* Or space-between or space-around */
        }

        .flex > section {
            align-items: center;
            display: flex;
            flex: 1 1 0;
            flex-direction: column;
            text-align: center;
            max-width: 400px;
        }

        .flex > section > p {
            flex-grow: 1;
        }

        /* This rule ist just because of the responsive images */
        @media (max-width: 1600px) {
            .flex > section {
                max-width: 250px;
            }
        }

        .flex ul {
            display: flex;
            justify-content: space-between;
        }

        .flex aside {
            width: 100%;
        }

        .flex > section {
            background: #fff;
            padding: 1em;
            margin: 0.5em;
            border-radius: 4px;
        }
        a.quickview{
            background: #019123;
            color: white;
            width: 100%;
        }
        a.quickview:hover {
            background-color: #015315;
            background-size: 3em;
            background-position: 1.5em 50%;
        }

        .flex ul {
            list-style-type: none;
            padding: 0;
        }

        .flex li {
            background: #eee;
            font-weight: 700;
            font-size: 12px;
            padding: 0.3em 0.6em;
        }
    </style>
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Example Shop part
                    <small>Example 1.0</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-shop-cart"></i> Home</a></li>
                    <li class="active"><a href="#">Shop</a>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                   <ul class="flex">
                   @foreach($prodInfo->where('PROD_IS_APPROVED',1)->where('PROD_DISPLAY_STATUS',1) as $item)
                           <div class="col-xs-12 col-md-6">
                               <!-- First product box start here-->
                               <div class="prod-info-main prod-wrap clearfix">
                                   <div class="row">
                                       <div class="col-md-5 col-sm-12 col-xs-12">
                                           <div class="product-image" style="background: url('{{($item->PROD_IMG==null||!file_exists(explode(',',$item->PROD_IMG)[0]))?asset('uPackage.png'):asset(explode(',',$item->PROD_IMG)[0])}}') no-repeat center center;
                                               -webkit-background-size: cover;
                                               -moz-background-size: cover;
                                               -o-background-size: cover;
                                               background-size: cover;">

                                               {{--<span class="tag2 hot">HOT</span>--}}
                                               {{--<span class="tag2 sale">SALE</span>--}}
                                               {{--<span class="tag3 special">SPECIAL</span>--}}
                                           </div>
                                       </div>
                                       <div class="col-md-7 col-sm-12 col-xs-12">
                                           <div class="product-deatil">
                                               <h4 class="name">
                                                   <a href="#">
                                                       {{ $item->PROD_NAME}}
                                                   </a>
                                               </h4>
                                               <h5 style="margin-top:0">
                                                   <a href="#">
                                                       <span>Product Category</span>
                                                   </a>
                                               </h5>
                                               <p class="price-container">
                                                   <span>{{ number_format((($item->PROD_REBATE/100)* $item->PROD_BASE_PRICE)
                                                       +(($item->rTaxTableProfile->TAXP_TYPE==0)?($item->rTaxTableProfile->TAXP_RATE/100)* $item->PROD_BASE_PRICE:($item->rTaxTableProfile->TAXP_RATE)+ $item->PROD_BASE_PRICE)
                                                       +(($item->PROD_MARKUP/100)* $item->PROD_BASE_PRICE)+$item->PROD_BASE_PRICE,2,'.',',' ) }}
                                                   </span>
                                               </p>
                                               <span class="tag1"></span>
                                           </div>
                                           <div class="description">
                                               <p>{{($item->PROD_DESC=='')?'unknown description':($item->PROD_DESC)}} </p>
                                           </div>
                                           <div class="product-info smart-form">
                                               <div class="row">
                                                   <div class="col-md-12">
                                                       {{--<form method="post"  action="{{url('/cart/add',$item->PROD_ID)}}"  enctype="multipart/form-data">--}}
                                                           {{--{{csrf_field()}}--}}
                                                           {{--<input type="hidden" name="_method" value="POST" />--}}
                                                           {{--<input class="hidden" name="id" value="{{$item->PROD_ID}}" />--}}
                                                           {{--<input class="hidden" name="price" value="{{(($item->PROD_REBATE/100)* $item->PROD_BASE_PRICE)--}}
                                                       {{--+(($item->rTaxTableProfile->TAXP_TYPE==0)?($item->rTaxTableProfile->TAXP_RATE/100)* $item->PROD_BASE_PRICE:($item->rTaxTableProfile->TAXP_RATE)+ $item->PROD_BASE_PRICE)--}}
                                                       {{--+(($item->PROD_MARKUP/100)* $item->PROD_BASE_PRICE)--}}
                                                       {{--+$item->PROD_BASE_PRICE}}" />--}}
                                                           {{--<button type="submit" class="btn btn-success">Add to cart</button>--}}
                                                           {{--<a href="javascript:void(0);" class="btn btn-info">More info</a>--}}
                                                       {{--</form>--}}
                                                       <button type="submit" onclick="direct(parseFloat({{ number_format( (($item->PROD_REBATE/100)* $item->PROD_BASE_PRICE)
                                      +(($item->rTaxTableProfile->TAXP_TYPE==0)?($item->rTaxTableProfile->TAXP_RATE/100)* $item->PROD_BASE_PRICE:($item->rTaxTableProfile->TAXP_RATE)+ $item->PROD_BASE_PRICE)
                                      +(($item->PROD_MARKUP/100)* $item->PROD_BASE_PRICE)+$item->PROD_BASE_PRICE,2,'.','' ) }}).toFixed(2).split('.').join(''),'asd','asd')" class="btn btn-success">Buy</button>
                                                       <a href="javascript:void(0);" class="btn btn-info">More info</a>
                                                   </div>
                                                   {{--<div class="col-md-12">--}}
                                                       {{--<div class="rating">Rating:--}}
                                                           {{--<label for="stars-rating-5"><i class="fa fa-star text-danger"></i></label>--}}
                                                           {{--<label for="stars-rating-4"><i class="fa fa-star text-danger"></i></label>--}}
                                                           {{--<label for="stars-rating-3"><i class="fa fa-star text-danger"></i></label>--}}
                                                           {{--<label for="stars-rating-2"><i class="fa fa-star text-warning"></i></label>--}}
                                                           {{--<label for="stars-rating-1"><i class="fa fa-star text-warning"></i></label>--}}
                                                       {{--</div>--}}
                                                   {{--</div>--}}
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <!-- end product -->
                           </div>

                           {{--<section >--}}
                                    {{--<img src="{{($item->PROD_IMG==null||!file_exists($item->PROD_IMG))?asset('uPackage.png'):asset($item->PROD_IMG)}}" alt="" />--}}
                               {{--<h2> {{ $item->PROD_NAME}}</h2>--}}
                               {{--<p>{{($item->PROD_DESC=='')?'unknown description':$item->PROD_DESC}}</p>--}}
                               {{--<aside>--}}
                                   {{--<ul>--}}
                                       {{--<li>Price: ₱ {{ number_format( (($item->PROD_REBATE/100)* $item->PROD_BASE_PRICE)--}}
                                      {{--+(($item->rTaxTableProfile->TAXP_TYPE==0)?($item->rTaxTableProfile->TAXP_RATE/100)* $item->PROD_BASE_PRICE:($item->rTaxTableProfile->TAXP_RATE)+ $item->PROD_BASE_PRICE)--}}
                                      {{--+(($item->PROD_MARKUP/100)* $item->PROD_BASE_PRICE)+$item->PROD_BASE_PRICE,2,'.','' ) }} </li>--}}
                                       {{--<li>In Stock</li>--}}
                                   {{--</ul>--}}
                               {{--</aside>--}}
                                   {{--<form method="POST" action="/process.php">--}}
                                       {{--<script src="https://checkout.magpie.im/v2/checkout.js"--}}
                                               {{--class="magpie-button"--}}
                                               {{--data-name="My Online Store"--}}
                                               {{--data-key="pk_test_97jCFUDY81vkqsQCLLFXQQ"--}}
                                               {{--data-amount="450000"--}}
                                               {{--data-currency="php"--}}
                                               {{--data-icon="https://s3-us-west-2.amazonaws.com/client-objects/sample-app/red-store.jpg"--}}
                                               {{--data-description="Nike Jordans, Size 10, Male"--}}
                                               {{--data-billing="true"--}}
                                               {{--data-shipping="true"--}}
                                       {{-->--}}
                                       {{--</script>--}}
                                   {{--</form>--}}
                               {{--<br>--}}
                               {{--<div class="row" style="width: 100%">--}}
                                   {{--<div class="col-md-6"><button class="btn btn-info">Add to cart</button></div>--}}
                                   {{--<div class="col-md-6"><button class="btn btn-success">Direct Gift</button></div>--}}
                               {{--</div>--}}
                           {{--</section>--}}

                   @endforeach
                   </ul>
                   </div>

               </div>
            </section>

@endsection
@section('extrajs')

    <script>
        @if(session('success'))
        iziToast.success({
            title: 'OK',
            position:"topRight",
            message: '{{session('success')}}',
        });
        @elseif(session('error'))
        iziToast.error({
            title: 'Error',
            position:"topRight",
            message: '{{session('error')}}',
        });
        @endif

        function direct(amount1,description1,id1){
            amount = amount1;
            currency = 'php';
            description = description1;
            // Set what will appear in the Checkout form
            app.open({
                currency: currency,
                amount: amount,
                description: description,
                name: name,
                icon:sympies_logo,
                allowRememberMe: false,
                billng: true,
                shipping: true,

            });
        }
    </script>

@endsection
