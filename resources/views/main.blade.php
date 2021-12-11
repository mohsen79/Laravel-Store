@extends('layouts.app')
@section('content')
    <div class="container">
        @if (Route::has('cart.index'))
            @if (Cart::exist())
                <a href="cart" class="btn btn-warning float-right blink_cart fixed-top">Cart <span
                        class='fa fa-cart-plus'></span></a>
            @endif
        @endif
        <div class="row">
            <div class="col-lg-10 col-sm-10 col-md-10">
                <div class="menu">
                    <ul class="ul">
                        {{-- @foreach ($categories as $category)
                            <a href="/?cat={{ $category->id }}">
                                <li>{{ $category->name }}
                                    @if ($category->child()->count())
                                        <ul>
                                            @php
                                                $name = $category->child->pluck('name');
                                                $id = $category->child->pluck('id');
                                                foreach ($name as $key => $value) {
                                                    echo "<li><a href='/?cat={$id[$key]}'>$name[$key]</a></li>";
                                                }
                                            @endphp
                                        </ul>
                                    @endif
                                </li>
                            </a>
                        @endforeach --}}
                        <nav class="navbar navbar-expand-sm navbar-dark">
                            <ul class="navbar-nav">
                                <!-- Dropdown -->
                                @if (isset($_GET['cat']))
                                    <li class="nav-item dropdown">
                                        <a class="nav-link text-dark" href="/">
                                            All
                                        </a>
                                    </li>
                                @endif
                                @foreach ($categories as $category)

                                    <li class="nav-item dropdown">

                                        <a class="nav-link @if ($category->child()->count()) dropdown-toggle @endif text-dark"
                                            href="/?cat={{ $category->id }}"
                                            id="navbardrop" data-toggle="dropdown">
                                            {{ $category->name }}
                                        </a>
                                        @if ($category->child()->count())
                                            <ul>
                                                @php
                                                    $name = $category->child->pluck('name');
                                                    $id = $category->child->pluck('id');
                                                @endphp
                                                <div class="dropdown-menu">
                                                    @foreach ($name as $key => $value)

                                                        <a class="dropdown-item"
                                                            href="/?cat=<?php echo $id[$key]; ?>">{{ $name[$key] }}</a>
                                                    @endforeach

                                                </div>
                                            </ul>
                                        @endif

                                    </li>
                                @endforeach

                            </ul>
                        </nav>
                    </ul>
                </div>
                <div class="col-lg-8 container mt-3">
                    <div class="form-group text-center">
                        @if (Route::getFacadeRoot()->current()->uri() == '/')
                            <form>
                                <input type="text" name="search" class="form-control" placeholder="search what you want">
                                <button class="btn btn-primary mt-2">search</button>
                            </form>
                        @endif
                        @if (Route::getFacadeRoot()->current()->uri() == 'product/filter')
                            <form action="/product/filter" method="post">
                                @csrf
                                <input type="text" name="search" class="form-control" placeholder="search what you want">
                                <button class="btn btn-primary mt-2">search</button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-lg-6">
                                <div class="card m-1">
                                    <div class="card-header">
                                        <h3>{{ $product->title }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <img src="{{ $product->image }}" alt="{{ $product->alt }}" class="rounded"
                                            style="width:700px;max-width:100%;max-height:300px">
                                        <a href="/information/{{ $product->id }}"
                                            class="btn btn-info btn-block mt-2">Information</a>
                                        <div class="bg-warning text-center m-1">Price : {{ $product->price }}$</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="col-lg-12" style="margin-top:200px;border-radius:5px;padding:10px;height:500px">
                    <form action="/product/filter" class="form-group" method="post" id="filter">
                        @csrf
                        <div class="form-check">
                            <label for="inventory" style="font-size:23px" name="inventory">Inventory</label>
                            <input type="checkbox" class="form-check-input m-2" name="inventory" id="inventory"
                                onclick="event.preventDefault();document.getElementById('filter').submit()"
                                {{ request()->has('inventory') ? 'checked' : '' }}>
                        </div>
                        <div class="form-check">
                            <label for="brand" style="font-size:23px">Brand</label>
                            <select class="form-control" name="brand"
                                onchange="event.preventDefault();document.getElementById('filter').submit()">
                                <option value="">{{ request('brand') }}</option>
                                <option value="">All</option>
                                @foreach (App\Models\Product::all() as $product)
                                    <option value="{{ $product->brand }}">{{ $product->brand }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check">
                            <label for="color" style="font-size:23px">Color</label>
                            <select class="form-control" name="color"
                                onchange="event.preventDefault();document.getElementById('filter').submit()">
                                <option value="">{{ request('color') }}</option>
                                <option value="">All</option>
                                @php
                                    $attribute = App\Models\Attribute::all();
                                @endphp
                                @foreach (App\Models\Attribute::all()->where('name', 'color') as $attr)
                                    @foreach ($attr->values as $val)
                                        <option value="{{ $val->value }}">{{ $val->value }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <p><label for="range_weight">Price: </label> <input type="range" name="range" class="slider"
                                    min="0" max="1000" value="0">
                                <span class="slider_label"></span>
                            </p>
                            <button name="btn" class="btn btn-primary">filter the amount</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{ isset($_GET['cat']) ? '' : $products->links() }}
    </div>
    <script>
        $(function() {
            $('.slider').on('input change', function() {
                $(this).next($('.slider_label')).html(this.value);
            });
            $('.slider_label').each(function() {
                var value = $(this).prev().attr('value');
                $(this).html(value);
            });
        });

    </script>

    <style>
        .blink_cart {
            animation: blinker 1.5s linear infinite;
        }

        @keyframes blinker {
            80% {
                opacity: 0;
            }
        }

        @font-face {
            font-family: 'Dosis';
            font-style: normal;
            font-weight: 700;
        }

        body {
            font-family: "Dosis", Helvetica, Arial, sans-serif;
            background: #ecf0f1;
            color: #34495e;
            padding-top: 40px;
            text-shadow: white 1px 1px 1px;
        }


        input[type="range"] {
            display: block;
            -webkit-appearance: none;
            background-color: #bdc3c7;
            width: 200px;
            height: 5px;
            border-radius: 5px;
            margin: 30px auto;
            outline: 0;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            background-color: #e74c3c;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid white;
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }

        ​ input[type="range"]::-webkit-slider-thumb:hover {
            background-color: white;
            border: 2px solid #e74c3c;
        }

        input[type="range"]::-webkit-slider-thumb:active {
            transform: scale(1.6);
        }

        .menu {
            max-width: 80%;
            width: 700px;
            height: 50px;
        }

        a:link {
            text-decoration: none;
        }

        a {
            color: rgb(19, 19, 9);

        }

        a:hover {
            color: white;
        }


        li {
            color: rgb(19, 19, 12);
            max-width: 100px;
            width: 120px;
            text-align: center;
            list-style: none;
            float: left;
            padding: 1%;
        }

        li:hover {
            background: rgb(70, 70, 252);
            transition: all ease 0.5s;
        }

        /* 
                                                            li>ul {
                                                                max-width: 100px;
                                                                display: none;
                                                                position: fixed;
                                                                z-index: 3;

                                                            }

                                                            li>ul>li {
                                                                max-width: 100px;
                                                                height: 40px;
                                                                line-height: 40px;
                                                                margin-left: -46px;
                                                                clear: both;
                                                                background: rgb(70, 70, 252);
                                                            }

                                                            li:hover ul {
                                                                display: block;
                                                                transition: all ease 0.5s;
                                                            }

                                                            li>ul>li:hover {
                                                                background: lightblue;
                                                            } */

        @media only screen and (max-width:700px) {
            li>ul>li {
                max-width: 100px;
                height: 40px;
                line-height: 40px;
                margin-left: -43px;
                clear: both;
                background: rgb(70, 70, 252);
            }
        }

    </style>
@endsection
