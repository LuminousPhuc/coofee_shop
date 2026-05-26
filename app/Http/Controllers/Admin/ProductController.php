<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\OptionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('id')->paginate(12);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $optionGroups = OptionGroup::with('optionValues')->get();
        
        $localImages = [];
        $imagePath = public_path('img/products');
        if (file_exists($imagePath)) {
            $files = scandir($imagePath);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $localImages[] = 'img/products/' . $file;
                }
            }
        }

        return view('admin.products.create', compact('categories', 'optionGroups', 'localImages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'name'          => 'required|string|max:255',
            'slug'          => 'nullable|string|max:255|unique:products,slug',
            'base_price'    => 'required|numeric|min:0',
            'image_url'     => 'nullable|string|max:500',
            'allow_topping' => 'sometimes|boolean',
            'is_active'     => 'sometimes|boolean',
            'is_bestseller' => 'sometimes|boolean',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['allow_topping'] = $request->has('allow_topping') ? 1 : 0;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['is_bestseller'] = $request->has('is_bestseller') ? 1 : 0;

        $product = Product::create($data);

        if ($request->filled('option_groups')) {
            $product->optionGroups()->sync($request->input('option_groups'));
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $optionGroups = OptionGroup::with('optionValues')->get();
        $selectedGroups = $product->optionGroups->pluck('id')->toArray();
        
        $localImages = [];
        $imagePath = public_path('img/products');
        if (file_exists($imagePath)) {
            $files = scandir($imagePath);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $localImages[] = 'img/products/' . $file;
                }
            }
        }

        return view('admin.products.edit', compact('product', 'categories', 'optionGroups', 'selectedGroups', 'localImages'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'name'          => 'required|string|max:255',
            'slug'          => "required|string|max:255|unique:products,slug,{$product->id}",
            'base_price'    => 'required|numeric|min:0',
            'image_url'     => 'nullable|string|max:500',
            'allow_topping' => 'sometimes|boolean',
            'is_active'     => 'sometimes|boolean',
            'is_bestseller' => 'sometimes|boolean',
        ]);

        $data['allow_topping'] = $request->has('allow_topping') ? 1 : 0;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['is_bestseller'] = $request->has('is_bestseller') ? 1 : 0;

        $product->update($data);
        $product->optionGroups()->sync($request->input('option_groups', []));

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }

    public function bulkCreate()
    {
        $categories = Category::all();
        $optionGroups = OptionGroup::with('optionValues')->get();
        
        $localImages = [];
        $imagePath = public_path('img/products');
        if (file_exists($imagePath)) {
            $files = scandir($imagePath);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $localImages[] = 'img/products/' . $file;
                }
            }
        }

        return view('admin.products.bulk_create', compact('categories', 'optionGroups', 'localImages'));
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*.name' => 'required|string|max:255',
            'products.*.category_id' => 'required|exists:categories,id',
            'products.*.base_price' => 'required|numeric|min:0',
            'products.*.image_url' => 'nullable|string|max:500',
            'products.*.allow_topping' => 'nullable|boolean',
            'products.*.is_active' => 'nullable|boolean',
            'products.*.is_bestseller' => 'nullable|boolean',
            'products.*.option_groups' => 'nullable|array',
        ]);

        $createdCount = 0;
        foreach ($request->input('products') as $index => $prodData) {
            $prodData['slug'] = Str::slug($prodData['name']);
            // Generate unique slug if duplicate
            $slugCount = Product::where('slug', 'like', $prodData['slug'] . '%')->count();
            if ($slugCount > 0) {
                $prodData['slug'] = $prodData['slug'] . '-' . ($slugCount + 1);
            }

            $prodData['allow_topping'] = isset($prodData['allow_topping']) ? 1 : 0;
            $prodData['is_active'] = isset($prodData['is_active']) ? 1 : 0;
            $prodData['is_bestseller'] = isset($prodData['is_bestseller']) ? 1 : 0;

            $product = Product::create($prodData);

            if (isset($prodData['option_groups'])) {
                $product->optionGroups()->sync($prodData['option_groups']);
            }
            $createdCount++;
        }

        return redirect()->route('admin.products.index')
            ->with('success', "Đã thêm thành công {$createdCount} sản phẩm!");
    }
}
