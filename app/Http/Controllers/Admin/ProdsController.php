<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Prod;
use App\Models\ProdImage;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
public function index()
    {
        $prods = Prod::with('category')
            ->latest()
            ->orderBy('name', 'ASC')
            ->paginate(5);
        return view('admin.prods.index', [
            'prods' => $prods,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.prods.create', [
            'prod' => new Prod(),
            'categories' => Category::all(),
            'tags' => '',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Prod::validateRoles());
        $request->merge([
            'slug' => Str::slug($request->post('name')),
            'store_id' => 1,
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $data['image'] = $file->store('/images', [
                'disk' => 'uploads'
            ]);
        }

        /* $data = $request->all();
        $data['slug'] = Str::slug($data['name']);
        $prod = Prod::create($data); */

        /* $prod = new Prod($request->all());
           $prod->save();
        */

        $prod = Prod::create($data);
        $prod->tags()->attach($this->getTags($request));

        return redirect()->route('admin.prods.index')
            ->with('success', "Product ($prod->name) created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prod = Prod::findOrFail($id);
        return view('admin.prods.show', [
            'prod' => $prod,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prod = Prod::findOrFail($id);
        $tags = $prod->tags()->pluck('name')->toArray();
        return view('admin.prods.edit', [
            'prod' => $prod,
            'categories' => Category::all(),
            'tags' => implode(', ',$tags),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $prod = Prod::findOrFail($id);
        $request->validate(Prod::validateRoles());
        $data = $request->all();
        $previous = false;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $data['image'] = $file->store('/images', [
                'disk' => 'uploads'
            ]);
            $previous = $prod->image;
        }
        $prod->update($data);
        if ($previous) {
            Storage::disk('uploads')->delete($previous);
        }
        //$prod->fill($request->all())->save();
        $prod->tags()->sync($this->getTags($request));

        if($request->hasFile('gallery')){
            foreach($request->file('gallery') as $file){
                $image_path = $file->store('/images',[
                    'disk' => 'uploads'
                ]);
               /* $prod->images()->create([
                    'image_path' => $image_path,
                ]);*/
              $image = new ProdImage([
                'image_path' => $image_path,
              ]);
              $prod->images()->save($image);
            }
        }
      
        return redirect()->route('admin.prods.index')
            ->with('success', "Product ($prod->name) updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prod = Prod::findOrFail($id);
        $prod->delete();
        if ($prod->image) {
            Storage::disk('uploads')->delete($prod->image);
            //unlink(public_path('image/' . $prod->image));
        }
        return redirect()->route('admin.prods.index')
            ->with('success', "Product ($prod->name) deleted!");
    }

public function getTags(Request $request)
    {          
        $tag_ids = [];
        $tags = $request->post('tags');
        $tags = json_decode($tags);
       // DB::table('prod_tag')->where('prod_id' , '=' , $prod->id)->delete();
        if (is_array($tags) && count($tags) > 0) {
            foreach ($tags as $tag) {
                $tag_name = $tag->value;

                $tagModel = Tag::firstOrCreate([
                    'name' => $tag_name
                ],[
                    'slug' => Str::slug($tag_name)
                ]);
            
               /* DB::table('prod_tag')->insert([
                    'prod_id' => $prod->id,
                    'tag_id' => $tagModel->id,
                ]);*/

                $tag_ids[] = $tagModel->id;
            }
        }

            //$prod->tags()->sync($prod_tags);
            return $tag_ids;
        }
    }

