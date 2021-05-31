<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


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
            ->leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])
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
        $clean = $this->validateReguest($request);

        $category = new Category();
        $category->name = $clean['name'];
        $category->slug = Str::slug($clean['name']);
        $category->parent_id = $request->post('parent_id', 1);
        $category->description = $clean['description'];
        $category->sataus = $request->post('sataus');
        $category->save();
        session()->put('sataus', 'Category added from sataus!');
        session()->flash('success', 'Category added!');
        return redirect(route('admin.categories.index'));
    }

    public function edit($id)
    {
        // $category = Category::where('id', '=', $id)->first();
        $category = Category::findOrFail($id);
        /* if($category == null){
            abort(404);
        }*/
        $parents = Category::where('id', '<>', $id)->orderBy('name', 'asc')->get();

        return view('admin.categories.edit', [
            'id' => $id,
            'category' => $category,
            'parents' => $parents,
        ]);
    }
    public function update(Request $request, $id)
    {
        $this->validateReguest($request);

        $category = Category::find($id);
        if ($category == null) {
            abort(404);
        }
        $this->validateReguest($request);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->parent_id = $request->post('parent_id', 1);
        $category->description = $request->input('description');
        $category->sataus = $request->input('sataus');
        $category->save();
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category Update!');
    }
    public function destroy($id)
    {
        //Method 1
        // $category = Category::find($id);
        //$category->delete();

        //Method 2
        // Category::where('id', '=', $id)->delete();

        //Method 3
        Category::destroy($id);
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category Deleted!');
    }

    protected function validateReguest(Request $request)
    {
        return $request->validate([
            'name' => 'required|alpha|max:255|min:3|unique:categories,name',
            'description' => 'nullable|min:5',
            'parent_id' => [
                'nullable',
                'exists:categories,id'
            ],
            'image' => [
                'image',
                'max:1048576',
                'dimensions:min_width=200,min_heigth=200'
            ],
            'sataus' => [
                'required',
                'in:active,inactive'
            ],
        ]);
    }
}
