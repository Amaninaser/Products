<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Rules\WordsFilter;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::when($request->name, function ($query, $value) {
            $query->where(function ($query) use ($value) {
                $query->where('categories.name', 'LIKE', "%{$value}%")
                    ->orWhere('categories.description', 'LIKE', "%{$value}%");
            });
        })
            ->when($request->parent_id, function ($query, $value) {
                $query->where('categories.parent_id', '=', $value);
            })

            ->with('parent')
            ->get();


        $parents = Category::orderBy('name', 'asc')->get();
        return view('admin.categories.index', [
            'categories' => $categories,
            'parents' => $parents,
        ]);
    }

    public function create()
    {
        $parents = Category::orderBy('name', 'asc')->get();
        return view('admin.categories.create', [
            'parents' => $parents,
            'title' => 'Add Category',
            'category' => new Category(),
        ]);
    }
    public function store(Request $request)
    {
        $request->validate(Category::validateRoles());
        $request->merge([
            'slug' => Str::slug($request->post('name')),
        ]);
        $data = $request->all();
        $category = Category::create($data);
        return redirect()->route('admin.categories.index')
            ->with('success', "Product ($category->name) created!");
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $parents = Category::where('id', '<>', $id)->orderBy('name', 'asc')->get();

        return view('admin.categories.edit', [
            'id' => $id,
            'category' => $category,
            'parents' => $parents,
        ]);
    }
    public function update(Request $request, $id)
    {

        $category = Category::findOrFail($id);
       $request->validate(Category::validateRoles());

        $data = $request->all();

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', "Category ($category->name) Update!");
    }
    public function destroy($id)
    {

        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()
            ->route('admin.categories.index')
            ->with('success', "Category  ($category->name) Deleted!");
    }


    public function storeProduct(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $prod = $category->prods()->create([
            'name' => 'prod Name',
            'price' => 10,
        ]);
    }
}
