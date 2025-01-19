@extends('client.index')

@section('style')
    <style>
        input[type="checkbox"] {
            display: block;
        }

        .hidenInput {
            display: none;
        }
    </style>
@endsection
@section('main')
    <!-- Breadcrumb Section Start -->
    <div class="section">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Giỏ hàng</h1>
                    <ul>
                        <li>
                            <a href="/">Trang chủ </a>
                        </li>
                        <li class="active"> Giỏ hàng</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Area End -->

    </div>
    <!-- Breadcrumb Section End -->

    <!-- Shopping Cart Section Start -->
    <div class="section section-margin">
        <div class="container">

            <div class="row">
                <div class="col-12">

                    <!-- Cart Table Start -->
                    <div class="cart-table table-responsive">
                        <table class="table table-bordered">

                            <!-- Table Head Start -->
                            <thead>
                                <tr>
                                    <th>
                                        <input id="checkAllTable" class="checkCart" type="checkbox">
                                    </th>
                                    <th class="pro-thumbnail">Ảnh</th>
                                    <th class="pro-title">Tên sản phẩm</th>
                                    <th class="pro-price">Giá</th>
                                    <th class="pro-quantity">Số lượng</th>
                                    <th class="pro-subtotal">Tổng giá</th>
                                    <th class="pro-remove">Xóa</th>
                                </tr>
                            </thead>
                            <!-- Table Head End -->

                            <!-- Table Body Start -->
                            <tbody>
                                @if (!empty($processedItems))
                                    @foreach ($processedItems as $item)
                                        <tr class="remove-cart">
                                            @if ($item->productVariant->quantity != 0)
                                            <td>
                                                <input type="checkbox" id="checked-{{ $item->id }}" class="checkBoxItem"
                                                    data-id="{{ $item->productVariant->id }}"
                                                    data-total="{{ $item->total_price }}"
                                                    data-quantity="{{ $item->quantity }}">
                                            </td>
                                            @else
                                                <td class="out-of-stock" style="text-align: center; color: #ff0000;">Hết hàng</td>
                                            @endif
                                            <td><a href="{{ route('shops.show', $item->productVariant->product->slug) }}"><img
                                                        style="width: 45%" class="img-fluid"
                                                        src="{{ Storage::url($item->productVariant->product->img_thumb) }}"
                                                        alt="Product" /></a></td>
                                            <td class="pro-title"><a
                                                    href="{{ route('shops.show', $item->productVariant->product->slug) }}">{{ $item->productVariant->product->name }}
                                                    <br> {{ $item->productVariant->size->name }} /
                                                    {{ $item->productVariant->color->name }}</a></td>
                                            <td class="pro-price">
                                                <span>{{ number_format($item->productVariant->price_sale, 0, ',', '.') . ' đ' }}</span>
                                            </td>
                                            <td class="pro-quantity">
                                                <div class="quantity">
                                                    <div class="cart-plus-minus">
                                                        <input class="cart-plus-minus-box" value="{{$item->quantity }}"
                                                            type="text">
                                                        <div class="dec qtybutton">-</div>
                                                        <div class="inc qtybutton">+</div>
                                                        <div class="dec qtybutton"><i class="fa fa-minus"></i></div>
                                                        <div class="inc qtybutton"><i class="fa fa-plus"></i></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="pro-subtotal"><span
                                                    id="total-{{ $item->id }}">{{ number_format($item->total_price, 0, ',', '.') . 'đ' }}
                                                    đ</span></td>
                                            <td class="pro-remove"><span data-id="{{ $item->id }}"
                                                    data-quantity="{{ $item->productVariant->quantity }}"
                                                    class="deleteCart"><i class="pe-7s-trash"
                                                        style="font-size: 1.5rem;"></i></span></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr id="cart-null">
                                        <td colspan="7">
                                            <p>Giỏ hàng của bạn hiện đang trống.</p>
                                        </td>
                                    </tr>
                                @endif
                                <tr id="cart-null">
                                </tr>
                            </tbody>
                            <!-- Table Body End -->

                        </table>
                    </div>
                    <!-- Cart Table End -->


                </div>
            </div>

            <div class="row">
                <div class="col-lg-5 ms-auto col-custom">

                    <!-- Cart Calculation Area Start -->
                    <div class="cart-calculator-wrapper">

                        <!-- Cart Calculate Items Start -->
                        <div class="cart-calculate-items">

                            <!-- Cart Calculate Items Title Start -->
                            <h3 class="title">Tổng đơn</h3>
                            <!-- Cart Calculate Items Title End -->

                            <!-- Responsive Table Start -->
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <td>Tổng cộng</td>
                                        <td><span style="font-weight:600 " class="totalAll">0 đ</span></td>
                                    </tr>
                                    <tr>
                                        <td>Phí vận chuyển</td>
                                        <td>30.000 đ</td>
                                    </tr>
                                    <tr class="total">
                                        <td>Đơn giá</td>
                                        <td class="total-amount">0 đ</td>
                                    </tr>
                                </table>
                            </div>
                            <!-- Responsive Table End -->

                        </div>
                        <div class="checkout-button-container text-center mt-4">
                            <a class="btn btn-dark btn-hover-primary rounded-0 w-100" href="{{ route('checkout') }}">Thanh
                                toán</a>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('plugins/js/updateQuatityCart.js') }}"></script>
    <script src="{{ asset('plugins/js/checkall.js') }}"></script>
@endsection
