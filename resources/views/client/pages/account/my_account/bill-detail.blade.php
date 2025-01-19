@extends('client.index')

@section('main')
    <!-- my account wrapper start -->
    <div class="section">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Tài khoản của tôi</h1>
                    <ul>
                        <li>
                            <a href="index.html">Trang chủ</a>
                        </li>
                        <li class="active">Tài khoản của tôi</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Area End -->

    </div>
    <!-- Breadcrumb Section End -->

    <!-- My Account Section Start -->
    {{-- <div class="section section-margin">
        <div class="container"> --}}

            <div class="row" style="display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px;">
                <div class="col-lg-12" style="width: 100%; max-width: 1200px;">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->

                            <!-- My Account Tab Menu End -->

                            <!-- My Account Tab Content Start -->
                            <div class="container">
                                <div class="tab-content" id="myaccountContent">
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="orders" role="tabpanel">
                                        <div class="myaccount-content" style="padding: 20px;">
                                            <!-- Title and Back Link -->
                                            <div style="display: flex; justify-content: center; align-items: center; position: relative; margin-bottom: 20px;">
                                                <!-- Title -->
                                                <h3 style="font-size: 24px; font-weight: bold; text-align: center; margin: 0;">Chi tiết đơn hàng #{{ $order->order_code }}</h3>

                                                <!-- Close Icon -->
                                                <a href="{{ route('my_account') }}"
                                                   style="position: absolute; right: 0; text-decoration: none; color: #8ed4f7; font-weight: 500; font-size: 24px; display: flex; align-items: center; transition: color 0.3s ease;"
                                                   onmouseover="this.style.color='#0056b3'" onmouseout="this.style.color='#8ed4f7'">
                                                    <i class="fa fa-times-circle" style="font-size: 24px;"></i>
                                                </a>
                                            </div>



                                            <!-- Receiver Info -->
                                            <div class="bill-card-body">
                                                <div class="bill-info" style="display: flex; flex-direction: column; gap: 12px;">
                                                    <div class="info-row" style="display: flex; justify-content: space-between;">
                                                        <strong style="font-weight: 600;">Người nhận:</strong> <span>{{ $order->user_name }}</span>
                                                    </div>
                                                    <div class="info-row" style="display: flex; justify-content: space-between;">
                                                        <strong style="font-weight: 600;">Email:</strong> <span>{{ $order->user_email }}</span>
                                                    </div>
                                                    <div class="info-row" style="display: flex; justify-content: space-between;">
                                                        <strong style="font-weight: 600;">Điện thoại:</strong> <span>{{ $order->user_phone }}</span>
                                                    </div>
                                                    <div class="info-row" style="display: flex; justify-content: space-between;">
                                                        <strong style="font-weight: 600;">Địa chỉ:</strong>
                                                        <span>
                                                            {{ implode(', ', array_filter([
                                                                $addressData['addressDetail'],
                                                                $addressData['ward'],
                                                                $addressData['district'],
                                                                $addressData['province']
                                                            ], function($value) {
                                                                return !is_null($value) && $value !== '';
                                                            })) }}
                                                        </span>
                                                    </div>
                                                    <!-- Total Amount Before Discount -->
                                                    <div class="info-row" style="display: flex; justify-content: space-between;">
                                                        <strong style="font-weight: 600;">Tổng tiền trước khi giảm:</strong>
                                                        <span>
                                                            @php
                                                                $totalBeforeDiscount = $order->orderDetails->sum(function($detail) {
                                                                    return $detail->quantity * $detail->price;
                                                                });
                                                            @endphp
                                                            {{ number_format($totalBeforeDiscount, 0, ',', '.') }} VND
                                                        </span>
                                                    </div>
                                                    <!-- Voucher Discount -->
                                                    <div class="info-row" style="display: flex; justify-content: space-between;">
                                                        <strong style="font-weight: 600;">Giảm:</strong>
                                                        <span>
                                                            @if ($order->discount)
                                                                {{ $order->discount }}%
                                                            @else
                                                                Không áp dụng
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="info-row" style="display: flex; justify-content: space-between;">
                                                        <strong style="font-weight: 600;">Phí vận chuyển:</strong> <span>{{ number_format(30000, 0, ',','.') }} VNĐ</span>
                                                    </div>
                                                    <!-- Total Amount -->
                                                    <div class="info-row" style="display: flex; justify-content: space-between;">
                                                        <strong style="font-weight: 600;">Tổng tiền:</strong> <span>{{ number_format($order->total_amount, 0, ',', '.') }} VND</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Horizontal Divider -->
                                            <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">

                                        <div class="order-details-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax({{$order->orderDetails->count() ==1 ? 'auto' : '240px'}}, 1fr)); gap: 18px; padding: 15px;">
                                            @foreach ($order->orderDetails as $detail)
                                            @php
                                                $id = $detail->product_variant_id;
                                                $productVariantIds = \App\Models\ProductVariant::select('product_id')->where('id', $id)->first();
                                                $productImgThumb = \App\Models\Product::select('img_thumb')->where('id', $productVariantIds->product_id)->first();
                                            @endphp
                                            <div class="order-card" style="background-color: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);">
                                                <!-- Product Image -->
                                                <div class="product-image" style="position: relative; overflow: hidden; width: 100%; height: 200px;">
                                                    <img src="{{ Storage::url($productImgThumb->img_thumb ?? '') }}" alt="{{ $detail->product_name }}"
                                                        style="width: 100%; height: 100%; object-fit: contain; padding-top: 15px;">
                                                </div>

                                                <!-- Product Content -->
                                                <div class="product-content" style="padding: 15px; display: flex; flex-direction: column; justify-content: space-between;">
                                                    <!-- Product Name -->
                                                    <h2 style="font-size: 18px; font-weight: bold; color: #333; margin-bottom: 8px;text-align: center">{{ $detail->product_name }}</h2>

                                                    <!-- Product Info -->
                                                    <div class="product-info" style="margin-bottom: 10px;">
                                                        <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                                            <strong style="color: #555; font-weight: 600;">Kích cỡ:</strong>
                                                            <span style="color: #333;">{{ $detail->size_name }}</span>
                                                        </div>
                                                        <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                                            <strong style="color: #555; font-weight: 600;">Màu sắc:</strong>
                                                            <span style="color: #333;">{{ $detail->color_name }}</span>
                                                        </div>
                                                        <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                                            <strong style="color: #555; font-weight: 600;">Số Lượng:</strong>
                                                            <span style="color: #333;">x{{ $detail->quantity }}</span>
                                                        </div>
                                                        <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                                            <strong style="color: #555; font-weight: 600;">Giá:</strong>
                                                            <span style="color: #f91919; font-weight: 700;">{{ number_format($detail->price, 0, ',', '.') }} đ</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>


                                    </div>
                                </div>
                            </div> <!-- My Account Tab Content End -->

                    </div>
                    <!-- My Account Page End -->
                </div>
            </div>


        </div>
    </div>

@endsection
