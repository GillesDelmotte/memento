<?php

namespace memento\Http\Controllers;

use Illuminate\Http\Request;
use memento\FilesUpload;
use memento\User;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $user = User::where('id', auth()->id())->first();
        $image = $request['image'];
        $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        \Image::make($request['image'])->save(public_path('images/profile/').$name);

        if($user->image_id != NULL){
            $FilesUpload = FilesUpload::where('user_id', auth()->id())->first();
            $FilesUpload->image_name = $name;
            $FilesUpload->save();
        }else{
            $FilesUpload = FilesUpload::create(['user_id' => Auth()->id(), 'image_name' => $name]);
            $user->image_id = $FilesUpload->id;
            $user->save();
        }
        
    }
}
