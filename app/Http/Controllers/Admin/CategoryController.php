<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    const PATH_VIEW = 'admin.layout.categories.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('viewAny', Category::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $categories = Category::withCount(['products' => function ($query) {
            $query->whereNull('deleted_at');
        }])->orderBy('id', 'desc')->get();
        $trashedCount = Category::onlyTrashed()->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('categories', 'trashedCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Category::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        if (Gate::denies('create', Category::class)) {
            return redirect()->route('admin.categories.index')->with('warning', 'Bạn không có quyền!');
        }
        $data = $request->all();
        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Thêm mới thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if (Gate::denies('view', $category)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }

        $products = Product::with(['variants' => function ($query) {
            $query->whereHas('size', function ($q) {
                $q->whereNull('deleted_at');
            })->whereHas('color', function ($q) {
                $q->whereNull('deleted_at');
            });
        }])->where('category_id', $category->id)
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc')
            ->get();

        $productCount = $products->count();

        return view(self::PATH_VIEW . __FUNCTION__, compact('category', 'productCount', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        if (Gate::denies('update', $category)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        return view(self::PATH_VIEW . __FUNCTION__, compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if (Gate::denies('update', $category)) {
            return redirect()->route('admin.categories.index')->with('warning', 'Bạn không có quyền!');
        }
        $data = $request->all();
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if (Gate::denies('delete', $category)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }

        $productCount = Product::whereNotNull('category_id')->where('category_id', $category->id)->count();

        if ($productCount == 0) {

            $category->delete();

            return redirect()->route('admin.categories.index')->with('success', 'Xóa thành công');
        } else {
            return back()->with('error', 'Danh mục này đang được sử dụng trong các sản phẩm. Không thể xóa!');
        }
    }
    /**
     * Hiển thị danh sách danh mục đã bị xóa mềm.
     */
    public function trashed()
    {
        if (Gate::denies('viewTrashed', Category::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $trashedCategories = Category::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view(self::PATH_VIEW . 'trashed', compact('trashedCategories'));
    }

    /**
     * Khôi phục danh mục đã bị xóa mềm.
     */
    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        if (Gate::denies('restore', $category)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $category->restore();
        return redirect()->route('admin.categories.trashed')->with('success', 'Khôi phục thành công');
    }

    /**
     * Xóa vĩnh viễn danh mục đã bị xóa mềm.
     */
    public function forceDelete($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        if (Gate::denies('forceDelete', $category)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $category->forceDelete();
        return redirect()->route('admin.categories.trashed')->with('success', 'Danh mục đã bị xóa vĩnh viễn');
    }
}
