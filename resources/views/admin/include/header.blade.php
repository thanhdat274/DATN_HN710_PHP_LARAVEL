<!-- Header-->
<header id="header" class="header">
    <div class="top-left">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}"><img src="{{ asset('theme/admin/images/logo.png') }}" alt="Logo"></a>
            <a class="navbar-brand hidden" href="{{ route('admin.dashboard') }}"><img src="{{ asset('theme/admin/images/logo2.png') }}"
                    alt="Logo"></a>
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
        </div>
    </div>
   
    <div class="top-right">
        
        <div class="header-menu">
            <p id="notification-area" class="mt-3">
            </p>
            <div class="header-left">
                <button class="search-trigger"><i class="fa fa-search"></i></button>
                <div class="form-inline">
                    <form class="search-form">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                        <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                    </form>
                </div>

                <div class="dropdown for-notification">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="notification"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="count bg-danger coutNotiUnRead">{{ $unreadNotifications->count() }}</span>
                    </button>
                    <div class="dropdown-menu notification-menu" aria-labelledby="notification">
                        @if ($notifications->isEmpty())
                            <div class="empty-notification">
                                <p>Không có thông báo</p>
                            </div>
                        @else
                            @foreach ($notifications as $notification)
                                <a
                                    class="dropdown-item notification-item {{ $notification->read_at == null ? 'unread' : 'read' }}"
                                    href="{{ route('admin.order.detailNotication', ['order_id' => $notification->data['order_id'], 'noti_id' => $notification->id]) }}">
                                    <div class="notification-content">
                                        <p class="notification-message">{{ $notification->data['message'] }}</p>
                                        <p class="notification-meta">
                                            <strong>Tổng đơn:</strong> {{ number_format($notification->data['total_amount'], 0, ',', '.') }} đ
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                            <a href="{{ route('admin.notification') }}" class="view-all">
                                Xem tất cả thông báo
                            </a>
                        @endif
                    </div>

                </div>
                <div class="dropdown for-message">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="message"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-envelope"></i>
                      
                        
                        <span class="count bg-primary">{{$userCount}}</span>
                    </button>
                    @if($chat)
                    <div class="dropdown-menu" aria-labelledby="message" style="max-height: 300px; overflow-y: auto;">
                        <p class="red">Trò chuyện với</p>
                        @foreach($chat as $c)
                            <a class="dropdown-item media {{ $c->is_read == false ? 'is_readbb' : '' }}" href="{{route('admin.chat',$c)}}">
                                <span class="photo media-left" style="display: flex; align-items: center;">
                                    <img alt="avatar" src="{{$c->user->avata ? Storage::url($c->user->avatar) : asset('/theme/client/assets/images/logo/avata.jpg') }}" 
                                         style="border-radius: 50%; width: 25px; height: 25px; object-fit: cover;">
                                </span>
                                <div class="message media-body" style="display: flex; align-items: center;">
                                    <span class="name float-left" style="margin-left: 10px;color: black">{{$c->user->name}}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    
                   
                </div> 
                
                @endif
               
                
            </div>

            <div class="user-area dropdown float-right">
                <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if (Auth::check() && Auth::user()->avatar)
                        <img class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;" src="{{ Storage::url(Auth::user()->avatar) }}"
                            alt="User Avatar">
                    @else
                        <i class="bi bi-person-circle" style="font-size: 1.75rem;"></i>
                    @endif
                </a>


                <div class="user-menu dropdown-menu">
                    <a class="nav-link" href="{{ route('admin.accounts.myAccount') }}"><i class="fa fa-user"></i> Hồ sơ cá nhân</a>
                    <a class="nav-link" href="{{ route('admin.notification') }}"><i class="fa fa-bell"></i> Thông báo 
                        <span class="count">{{ $unreadNotifications->count() }}</span></a>
                    <a class="nav-link" href="{{ route('admin.accounts.showChangePasswordForm') }}"><i class="fa fa-cog"></i> Đổi mật khẩu</a>

                    <form action="{{ route('admin.logout') }}" method="post" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link"
                            style="background: none; border: none; padding: 0; margin: 0; color: inherit; cursor: pointer;">
                            <i class="fa fa-power-off"></i> Đăng xuất
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>
         @vite('resources/js/notification.js')
</header>


