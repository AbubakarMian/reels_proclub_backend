<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $category = Category::orderBy('created_at', 'ASC')->paginate(10);
        return view('category.index', compact('category'));
    }

    public function create()
    {
        $control = 'create';
        return view('category.create', compact('control'));
    }

    public function save(Request $request)
    {
        $category = new Category();
        $this->add_or_update($request, $category);

        return redirect('admin/category');
    }



    public function edit($id)
    {
        $control = 'edit';
        $category = Category::find($id);
        return view('category.create', compact(
            'control',
            'category',
        ));
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $this->add_or_update($request, $category);
        return Redirect('admin/category');
    }


    public function add_or_update(Request $request, $category)
    {

        $category->name = $request->name;
        $category->description = $request->description;
        // dd($request->all());

        if ($request->cropped_image) {
            $category->avatar = $request->cropped_image;
        }


        $category->save();
        return redirect()->back();
    }

    public function delete($id)
    {
        $category = Category::find($id);
        if ($category) {
            Category::destroy($id);
            $new_value = 'Activate';
        } else {
            Category::withTrashed()->find($id)->restore();
            $new_value = 'Delete';
        }
        $response = Response::json([
            "status" => true,
            'action' => Config::get('constants.ajax_action.delete'),
            'new_value' => $new_value
        ]);
        return $response;
    }

    public function crop_image(Request $request)
    {
        $folderPath = public_path('images/');
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $imageName = uniqid() . '.png';
        $imageFullPath = $folderPath.$imageName;
        $su = file_put_contents($imageFullPath, $image_base64);
        $image_path = asset('/images/' .$imageName);
        return response()->json(['success'=>'Crop Image Uploaded Successfully','image'=>$image_path]);
    }
}