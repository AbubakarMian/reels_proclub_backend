<?php

namespace App\Libraries;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Response;
use DB;

// use Excel;
// use Excel;

trait Common
{
    public function prepare_excel($data , $field_not_required = []){
        $users = [];
        foreach ($data as $rec_key => $value){
            foreach ($value as $key=>$v){
                if(!in_array($key , $field_not_required)){
                    $users[$rec_key][str_replace("_"," ",$key)] = $v;
                }
            }
        }
        return $users;
    }

    // public function move_img_get_path($image,$root,$type,$image_name='')
    // {
    //     $uniqid = time();
    //     $extension = mb_strtolower($image->getClientOriginalExtension());
    //     $name = $uniqid . $image_name . '.' . $extension;//.$image->getClientOriginalName();
    //     $imgPath = public_path() . '/images/' . $type;
    //     $image->move($imgPath, $name);
    //     $remove_index = str_replace("index.php", "", $root);
    //     return $remove_index . '/images/' . $type . '/' . $name;
    // }
//     public function move_img_get_path($media, $root, $type, $media_name = '')
// {
//     $uniqid = time();
//     $extension = mb_strtolower($media->getClientOriginalExtension());
//     $name = $uniqid . $media_name . '.' . $extension;
//     $mediaPath = public_path() . '/media/' . $type;

//     // Check if the media is an image or a video
//     $isImage = strpos($media->getClientMimeType(), 'image') !== false;

//     if ($isImage) {
//         $mediaPath .= '/images/';
//     } else {
//         $mediaPath .= '/videos/';
//     }

//     $media->move($mediaPath, $name);
//     $remove_index = str_replace("index.php", "", $root);

//     return $remove_index . '/media/' . $type . '/' . ($isImage ? 'images/' : 'videos/') . $name;
// }
public function move_img_get_path($media, $root, $type, $media_name = '')
{
    try {
        // Generate a unique ID based on the current timestamp
        $uniqid = time();

        // Get the file extension in lowercase
        $extension = mb_strtolower($media->getClientOriginalExtension());

        // Create a unique filename by combining the unique ID, optional media name, and extension
        $name = $uniqid . $media_name . '.' . $extension;

        // Determine the subdirectory (either "images/" or "videos/") based on the file type
        $isImage = strpos($media->getClientMimeType(), 'image') !== false;
        $subdirectory = $isImage ? 'image' : 'video';

        // Construct the URL to the saved media file with the "public" segment
        $url = asset("media/{$type}/{$subdirectory}/{$name}");

        // Move the uploaded media file to the appropriate directory with the generated filename
        $media->move(public_path("media/{$type}/{$subdirectory}"), $name);

        return $url;
    } catch (\Exception $e) {
        // Handle any exceptions that may occur during the upload process
        // You can log the error or return an error response here
        return null;
    }
}





    public function move_img_get_path_thumnail($image, $root, $type, $image_name = '')
{
    $uniqid = time();

    if (is_string($image)) {
        // If $image is a string (path or URL), use it directly
        $imagePath = $image;
    } else if (is_a($image, 'Illuminate\Http\UploadedFile')) {
        // If $image is an UploadedFile object, process it
        $extension = mb_strtolower($image->getClientOriginalExtension());
        $name = $uniqid . $image_name . '.' . $extension;
        $imgPath = public_path() . '/images/' . $type;
        $image->move($imgPath, $name);
        $remove_index = str_replace("index.php", "", $root);
        $imagePath = $remove_index . '/images/' . $type . '/' . $name;
    } else {
        // Handle other cases (if needed)
        throw new \InvalidArgumentException('Invalid image provided.');
    }

    return $imagePath;
}
 
 
// public function moveVideoAndGetPaths($file, $root, $folder)
// {
//     if (!$file || !$file->isValid()) {
//         throw new \InvalidArgumentException('Invalid or empty file provided.', 400);
//     }

//     if (!file_exists($root) || !is_dir($root)) {
//         throw new \InvalidArgumentException('Destination root folder does not exist or is not a directory.', 400);
//     }

//     $destinationPath = $root . '/' . $folder;

//     if (!file_exists($destinationPath) || !is_dir($destinationPath)) {
//         throw new \InvalidArgumentException('Destination folder does not exist or is not a directory.', 400);
//     }

//     // $file_n = $request->file()->name();
//     // $file_n_arr = explode('.',$file_n);
//     // $exten = $file_n_arr[count($file_n_arr)-1];
//     // $filename = time().'.'.$exten;// . '.webm'; // Manually set the extension to "webm"

//     // $file_n = $request->file()->name();
//     $filename = time() . '.webm'; // Manually set the extension to "webm"
//     try {
//         $file->move($destinationPath, $filename);
//     } catch (\Exception $e) {
//         throw new \RuntimeException('Error moving the uploaded file: ' . $e->getMessage(), 500);
//     }

//     return $destinationPath . '/' . $filename;
// }

public function moveVideoAndGetPaths($file, $root, $folder)
{
    if (!$file || !$file->isValid()) {
        throw new \InvalidArgumentException('Invalid or empty file provided.', 400);
    }

    if (!file_exists($root) || !is_dir($root)) {
        throw new \InvalidArgumentException('Destination root folder does not exist or is not a directory.', 400);
    }

    // Determine the subfolder (e.g., "camera_videos/video/") based on the provided folder
    $subfolder = $folder;

    // Construct the destination path including the subfolder
    $destinationPath = $root . '/media/' . $subfolder;

    if (!file_exists($destinationPath) || !is_dir($destinationPath)) {
        throw new \InvalidArgumentException('Destination folder does not exist or is not a directory.', 400);
    }

    // Get the original file extension
    $originalExtension = $file->getClientOriginalExtension();

    // Generate a unique filename based on the current timestamp and original extension
    $filename = time() . '.' . $originalExtension;

    try {
        $file->move($destinationPath, $filename);
    } catch (\Exception $e) {
        throw new \RuntimeException('Error moving the uploaded file: ' . $e->getMessage(), 500);
    }

    // Construct the URL with the "public" segment and the subfolder
    $url = asset("media/{$subfolder}/{$filename}");

    return $url;
}




    // public function export_excel($report_name,$users){

    //     Excel::create($report_name, function ($excel) use ($users) {
    //         $excel->sheet('Sheet 1', function ($sheet) use ($users) {
    //             $sheet->fromArray($users);
    //         });
    //     })->export('xls');

    // }

    function get_embeddedyoutube_url($url) {
        return preg_replace(
            "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
            "//www.youtube.com/embed/$2",
            $url
        );
    }

        public function sort_asc_array($arr,$column){
            usort($arr, function ($a, $b) use ($column) {
                return $a[$column] <=> $b[$column];
            });
            return $arr;
        }























}
