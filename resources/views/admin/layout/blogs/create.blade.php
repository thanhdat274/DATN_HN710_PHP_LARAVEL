@extends('admin.dashboard')

@section('content')
    <div class="breadcrumbs mb-5">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Thêm bài viết</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Bảng điều khiển</a></li>
                                <li><a href="{{ route('admin.blogs.index') }}">Danh sách bài viết</a></li>
                                <li class="active">Thêm bài viết</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data" method="post">
        @csrf
    <div class="content mb-5">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Thêm bài viết</strong>
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-primary">
                        <i class="fa fa-arrow-left mr-1"></i> Quay lại
                    </a>
                </div>
            </div>
            <div class="row">

                <div class="col-xs-8 col-sm-8">
                    <div class="card">
                        <div class="card-header">
                            <strong>Nội dung</strong>
                        </div>
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="name" class=" form-control-label">Tên bài viết</label><input
                                    type="text" id="name" name="title"
                                    placeholder="Nhập tên bài viết" class="form-control"
                                    value="{{ old('title') }}" >
                                @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div style="display: flex; justify-content: space-between">
                                    <label for="name" class="form-control-label">Nội dung</label>
                                    <a href="#" class="mutiimg" data-target="content">Thêm nhiều ảnh</a>
                                </div>
                                <textarea name="content" class="ckedit form-control" id="content">{{ old('content') }}</textarea>
                                @error('content')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-4 col-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title ">Danh mục và ảnh</strong>
                            </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name" class=" form-control-label">Danh mục bài viết</label>
                                <select name="category_blog_id" class="form-control select2">
                                    <option value="">--Vui lòng chọn--</option>
                                    @foreach ($ctgrbl as $bl)
                                    <option value="{{$bl->id}}" {{ old('category_blog_id') == $bl->id ? 'selected' : '' }}>{{$bl->name}}</option>
                                    @endforeach
                                </select>
                                @error('category_blog_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="img_avt" class="form-control-label">Ảnh đại diện</label>
                                <!-- Khung chứa hình ảnh -->
                                <div style="width: 100%; height: auto;">
                                    <img id="img-preview"
                                        src="https://tse4.mm.bing.net/th?id=OIP.EkljFHN5km7kZIZpr96-JwAAAA&pid=Api&P=0&h=220"
                                        alt="Ảnh đại diện"
                                        class="img-thumbnail"
                                        style="width: 100%; height: auto; object-fit: cover; cursor: pointer;">
                                </div>
                                <!-- Input file ẩn -->
                                <input type="file" id="img_avt" name="img_avt" class="form-control d-none" accept="image/*">
                                @error('img_avt')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mb-1 ml-3">Thêm mới</button>

            </div>
        </div>
    </div>
</form>


@endsection
@section('script')
<script src="{{asset('plugins/plugin/ckfinder_2/ckfinder.js')}}"></script>
<script src="{{asset('plugins/plugin/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('plugins/js/finder.js')}}"></script>

<script>
    // Ảnh đại diện
    jQuery('#img-preview').on('click', function() {
            jQuery('#img_avt').click();
        });

        // Hiển thị hình ảnh đã chọn
        jQuery('#img_avt').on('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    jQuery('#img-preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
</script>
@endsection
