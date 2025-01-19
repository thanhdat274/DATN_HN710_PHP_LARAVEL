@extends('client.index')
@section('style')
    <style>
        .blog-thumb {
            width: 100%;
            height: auto;
            aspect-ratio: 1;
            position: relative;
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .blog-thumb {
                width: 90%;
            }

            .blog-p {
                width: 90%;
            }
        }

        .blog-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        .hidden-category {
            display: none;
        }

        #toggleCategories {
            text-decoration: underline;
            font-size: 0.8rem;
        }
    </style>
@endsection
@section('main')
    <div class="section">
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Bài viết</h1>
                    <ul>
                        <li>
                            <a href="/">Trang chủ </a>
                        </li>
                        <li class="active"> Bài viết</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="section section-margin">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12 order-2 order-lg-1">
                    <aside class="sidebar_widget mt-10 mt-lg-0">
                        <div class="widget_inner aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                            <div class="widget-list mb-10">
                                <h3 class="widget-title mb-4">Tìm kiếm</h3>
                                <form action="{{route('blogs.search')}}" method="get">
                                    <div class="search-box">
                                        <input type="text" class="form-control" name="searchBlog" placeholder="Tìm kiếm bài viết" value="{{ $input ?? '' }}">
                                        <button class="btn btn-dark btn-hover-primary" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="widget-list mb-10">
                                <h3 class="widget-title">Danh mục bài viết</h3>
                                <div class="sidebar-body">
                                    <ul class="sidebar-list" id="categoryList">
                                        @foreach ($categoryBlog as $index => $item)
                                            <li class="{{ $index >= 5 ? 'hidden-category' : '' }}">
                                                <a href="{{ route('blogs.category', $item->id) }}">
                                                    {{ $item->name }} ({{ $item->blogs_count }})
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <p id="toggleCategories" class="mt-3">Xem thêm</p>
                                </div>
                            </div>

                            <div class="widget-list">
                                <h3 class="widget-title mb-4">Top bài viết hot</h3>
                                <div class="sidebar-body product-list-wrapper mb-n6">
                                    @foreach ($hotblogs as $item)
                                        <div class="single-product-list product-hover mb-6">
                                            <div class="thumb">
                                                <a href="{{ route('blogs.show', $item) }}" class="image">
                                                    <img class="first-image" src="{{ Storage::url($item->img_avt) }}"
                                                        alt="Blog Post">
                                                    <img class="second-image" src="{{ Storage::url($item->img_avt) }}"
                                                        alt="Blog Post">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h5 class="title mt-4"><a
                                                        href="{{ route('blogs.show', $item) }}">{!! Str::limit(strip_tags($item->content), 36, '...') !!}</a>
                                                </h5>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
                <div class="col-lg-9 order-1 order-lg-2 overflow-hidden">
                    <div class="row mb-n8">
                        {{-- do du lieu  --}}
                        @if ($blogs->isEmpty())
                            <h1 class="text-center mt-5">Hiện không có bài viết nào!</h1>
                        @else
                            @foreach ($blogs as $item)
                                <div class="col-md-6 col-lg-4 mb-8" data-aos="fade-up" data-aos-delay="200">
                                    <div class="blog-single-post-wrapper">
                                        <div class="blog-thumb">
                                            <a href="{{ route('blogs.show', $item) }}"><img
                                                    src="{{ Storage::url($item->img_avt) }}" alt="Blog Post"></a>
                                        </div>

                                        <div class="blog-content">
                                            <div class="post-meta">
                                                <span>Tác giả : {{ $item->user->name }}</span>
                                                <span>{{ $item->created_at->format('d-m-Y') }}</span>
                                            </div>
                                            <h3 class="title"><a
                                                    href="{{ route('blogs.show', $item) }}">{{ $item->title }}</a></h3>
                                            <p class="blog-p">{!! Str::limit(strip_tags($item->content), 63, '...') !!}</p>
                                            <!-- Cắt nội dung -->
                                            <a href="{{ route('blogs.show', $item->id) }}" class="link">Xem bài</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mb-2 mb-lg-0">
                <div class="col" data-aos="fade-up" data-aos-delay="300">
                    <nav class="mt-8 pt-8 border-top d-flex justify-content-center">
                        <ul class="pagination">

                            <li class="page-item {{ $blogs->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $blogs->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                </a>
                            </li>

                            @for ($page = 1; $page <= $blogs->lastPage(); $page++)
                                <li class="page-item {{ $page == $blogs->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $blogs->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor

                            <li class="page-item {{ $blogs->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $blogs->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">»</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#toggleCategories").on("click", function() {
                var isHidden = $(".hidden-category").is(":hidden");

                if (isHidden) {
                    $(".hidden-category").slideDown();
                    $(this).text("Ẩn bớt");
                } else {
                    $(".hidden-category").slideUp();
                    $(this).text("Xem thêm");
                }
            });
        });
    </script>
@endsection
