<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManager;
use Illuminate\Http\Request;
use App\Models\GalleryImage;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    public function storeImage(Request $request)
    {
        $request->validate([
            'caption' => 'required|max:225',
            'category' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg,bmp'
        ], [
            'category.required' => 'please select a category'
        ]);
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image_name = rand(1000,9999) . time() . '.' . $file->getClientOriginalExtension();
            $thumbPath = public_path('user_images/thumb');
            $file->move(public_path('user_images'), $image_name);
        }
            GalleryImage::create([
               'user_id'=>Auth::user()->id, 
               'caption'=>$request->caption,
               'category'=>$request->category,
               'image'=>$image_name,
            ]);

            return redirect()->route('image-store')->with('success','Image successfully uploaded');
    }


    public function welcome(Request $request) {
        $data = GalleryImage::all();
    
        return view('welcome', compact('data'));
    }
}
