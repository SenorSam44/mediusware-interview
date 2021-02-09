@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>

    <div class="card">
        <form action="{{route('product.filter')}}" method="get" class="card-header">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" id="title_input" placeholder="Product Title" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="variant" id="" class="w-100 form-control">
                        @foreach($variants as $variant)
                            <option>{{$variant}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="text" name="price_from" aria-label="First name" placeholder="From" class="form-control">
                        <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date" placeholder="Date" class="form-control">
                </div>
                <div class="col-md-1">
                    <button id="search_btn" type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <div class="table-response">
                <table class="table">
                    <thead>
                    <tr class="row">
                        <th class="col-1">#</th>
                        <th class="col-1">Title</th>
                        <th class="col-6">Description</th>
                        <th class="col-3">Variant</th>
                        <th class="col-1">Action</th>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($products as $product)
                    <tr class="row">
                        <td class="col-1">{{$product->id}}</td>
                        <td class="col-1">{{$product->title}} <br> {{$product->created_at}}</td>
                        <td class="col-6">{{$product->description}}</td>
                        <td class="col-3">
                            <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">

                                <dt class="col-sm-3 pb-0">
                                    @foreach($product_variants=\App\Models\ProductVariant::where('product_id', $product->id)->get() as $product_variant)
                                        {{$product_variant->variant}}/
                                    @endforeach
                                </dt>
                                <dd class="col-sm-9">
                                    <dl class="row mb-0">
                                        @foreach($product_variant_prices as $product_variant_price)
                                        <dt class="col-sm-4 pb-0">Price : {{ number_format($product_variant_price->price,2) }}</dt>
                                        <dd class="col-sm-8 pb-0">InStock : {{ number_format($product_variant_price->stock,2) }}</dd>
                                        @endforeach
                                    </dl>
                                </dd>
                            </dl>
                            <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                        </td>
                        <td class="col-1">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('product.edit', 1) }}" class="btn btn-success">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

        </div>

        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <p>Showing 1 to {{$products->currentPage()}} out of {{$products->total()}}</p>
                </div>
                <div class="col-md-2 d-flex justify-content-center">
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
{{--    <script>--}}
{{--        $.ajaxSetup({--}}
{{--            headers: {--}}
{{--                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--            }--}}
{{--        });--}}

{{--        $().ready(function (){--}}
{{--            $('#title_input').on('keyup', function (){--}}
{{--                var title=$('#title_input').val();--}}
{{--                $.ajax({--}}
{{--                    url:"{{url('/product/filter')}}",--}}
{{--                    type: "GET",--}}
{{--                    data:{ 'title': title },--}}
{{--                    success: function (data) {--}}
{{--                        // alert(data);--}}
{{--                        var output = '';--}}
{{--                        if(data.length > 0)--}}
{{--                        {--}}
{{--                            for(var count = 0; count < data.length; count++)--}}
{{--                            {--}}
{{--                                output += '<tr>';--}}
{{--                                output += '<td>'+data[count].title+'</td>';--}}
{{--                                // output += '<td>'+data[count].Gender+'</td>';--}}
{{--                                // output += '<td>'+data[count].Address+'</td>';--}}
{{--                                // output += '<td>'+data[count].City+'</td>';--}}
{{--                                // output += '<td>'+data[count].PostalCode+'</td>';--}}
{{--                                // output += '<td>'+data[count].Country+'</td>';--}}
{{--                                output += '</tr>';--}}
{{--                            }--}}
{{--                        }--}}
{{--                        else--}}
{{--                        {--}}
{{--                            output += '<tr>';--}}
{{--                            output += '<td colspan="6">No Data Found</td>';--}}
{{--                            output += '</tr>';--}}
{{--                        }--}}
{{--                        $('tbody').html(output);--}}
{{--                    },--}}
{{--                    error: function (data, textStatus, errorThrown) {--}}
{{--                        console.log(data);--}}

{{--                    },--}}
{{--                });--}}
{{--            })--}}
{{--        });--}}
{{--    </script>--}}

@endsection
