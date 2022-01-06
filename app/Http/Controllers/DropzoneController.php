<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DropzoneController extends Controller
{
    public function upload (Request $request) {
        $path = storage_path('tmp/dropzone');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');
        $name = preg_replace('/[[:space:]]+/', '-', uniqid() . '-' . trim($file->getClientOriginalName()));

        $file->move($path, $name);
        
        //ulpoad image
        // $path = $request->file('file')->storeAs('public/dropzone', $name);

        return response()->json([
            'path'          => $path .'/' .$name,
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public static function delete (Request $request) {
        $path = storage_path('tmp/dropzone');
        if (file_exists($path.'/'.$request->filename)) {
            unlink($path.'/'.$request->filename);
        }
         return response()->json([
            'status' => 1,
            'filename' => $request->filename,
            'message' => 'File removed successfuly'
         ]);
    }

    public function getImages()
    {
        $images = Gallery::all()->toArray();
        foreach($images as $image){
            $tableImages[] = $image['filename'];
        }
        $storeFolder = public_path('uploads/gallery');
        $file_path = public_path('uploads/gallery/');
        $files = scandir($storeFolder);
        foreach ( $files as $file ) {
            if ($file !='.' && $file !='..' && in_array($file,$tableImages)) {       
                $obj['name'] = $file;
                $file_path = public_path('uploads/gallery/').$file;
                $obj['size'] = filesize($file_path);          
                $obj['path'] = url('public/uploads/gallery/'.$file);
                $data[] = $obj;
            }
            
        }
        //dd($data);
        return response()->json($data);
    }
}
