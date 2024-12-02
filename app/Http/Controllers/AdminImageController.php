<?php

namespace App\Http\Controllers;

use App\Models\FastMovingPartner;
use App\Models\Image;
use App\Models\Image2vexpress;
use App\Models\messageCustomer;
use App\Models\Post;
use App\Models\PostCatHome;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminImageController extends Controller
{
    //upload add 1 ảnh trong post
    function  uploadImagePost(Request $request)
    {
        if ($request->hasFile('imagePost')) {
            $file = $request->file('imagePost');
            $name_file = $file->getClientOriginalName();
            //Hàm $file->move() trong Laravel trả về một đối tượng Symfony\Component\HttpFoundation\File\File đại diện cho tệp đã được di chuyển.
            // trả về một đối tượng Symfony\Component\HttpFoundation\File\File nên phải getPathname() để lấy đường dẫn tuyệt đối
            $file->move('uploads', $name_file);
            $image_url = "uploads/{$name_file}";
            $image = Image::create([
                'image_url' => $image_url
            ]);
            return response()->json(['image_url' => $image->image_url, 'image_id' => $image->id]);
        }
    }
     //update upload 1 ảnh trong post
     public function updateUploadImagePost(Request $request)
     {
         $post_id = $request->post_id;
         $post = Post::find($post_id);
         $image_id_old = $post->image->id;
         $image_url_old = $post->image->image_url;
         $file_path = public_path($image_url_old);
         if ($request->hasFile('UpdateImagePost')) {
             $file = $request->file('UpdateImagePost');
             $name_file = $file->getClientOriginalName();
             $file->move('uploads', $name_file);
             $image_url = "uploads/{$name_file}";
             $image = Image::create([
                 'image_url' => $image_url
             ]);
             Post::find($post_id)->update([
                 'image_id' => $image->id
             ]);
             $success = Image::find($image_id_old)
                 ->delete();
             if ($success > 0) {
                 if (File::exists($file_path)) {
                     File::delete($file_path);
                 }
             }
 
             //   
 
             return response()->json(['image_url' => $image->image_url, 'image_id' => $image->id]);
         }
     }

    //upload ảnh cho slider
    function uploadImageSlider(Request $request){
        if($request->hasFile('imageSlider')){
         $file = $request->file('imageSlider');
         $name_file = $file->getClientOriginalName();
         $file->move('uploads',$name_file);
         $image_url = "uploads/{$name_file}";
         $image = Image::create([
             'image_url' => $image_url
         ]);
         $result = "<img src=\"" . asset($image->image_url) . "\" id=\"image-slider\"> ";
         return response()->json(['result' => $result,'image_id_slider' => $image->id]);
        }
     }
     //update upload ảnh slider 
     function updateImageSlider(Request $request){
        $data_id_slider = $request->input('data_id_slider') ;
        $slider = Slider::find($data_id_slider);
         $image_id_old =  $slider->image->id;
         $image_url_old = $slider->image->image_url; 
         $file_path = public_path($image_url_old);
       if($request->hasFile('updateImageSlider')){
         $file = $request->file('updateImageSlider');
         $name_file = $file->getClientOriginalName();
         $file->move('uploads',$name_file);
         $image_url = "uploads/{$name_file}";
         $image = Image::create([
             'image_url' =>  $image_url
         ]);
         $slider->update([
             'image_id' => $image->id
         ]);
         //khi mình cập nhập slider bằng ảnh mới rồi thì khi xóa ảnh cũ slider sẽ không bị xóa
         $success = Image::where('id',$image_id_old)
                     ->delete();
         if($success>0){
            if(File::exists($file_path)){
             File::delete($file_path);
            }
         }
         $result = "<img src=\"" . asset($image->image_url) . "\" id=\"image-slider\" data-id-slider=\"$data_id_slider\">";
         return response()->json(['result'=>$result]);
       }
     }

      //upload ảnh cho image2vexpress
    function uploadImage2vexpress(Request $request){
        if($request->hasFile('imageV2express')){
         $file = $request->file('imageV2express');
         $name_file = $file->getClientOriginalName();
         $file->move('uploads',$name_file);
         $image_url = "uploads/{$name_file}";
         $image = Image::create([
             'image_url' => $image_url
         ]);
         $result = "<img src=\"" . asset($image->image_url) . "\" id=\"image-imageV2express\"> ";
         return response()->json(['result' => $result,'image_id_imageV2express' => $image->id]);
        }
     }
     //update upload ảnh image2vexpress
     function updateImage2vexpress(Request $request){
        $data_id_slider = $request->input('data_id_slider') ;
        $slider = Image2vexpress::find($data_id_slider);
         $image_id_old =  $slider->image->id;
         $image_url_old = $slider->image->image_url; 
         $file_path = public_path($image_url_old);
       if($request->hasFile('updateImage2Vexpress')){
         $file = $request->file('updateImage2Vexpress');
         $name_file = $file->getClientOriginalName();
         $file->move('uploads',$name_file);
         $image_url = "uploads/{$name_file}";
         $image = Image::create([
             'image_url' =>  $image_url
         ]);
         $slider->update([
             'image_id' => $image->id
         ]);
         //khi mình cập nhập slider bằng ảnh mới rồi thì khi xóa ảnh cũ slider sẽ không bị xóa
         $success = Image::where('id',$image_id_old)
                     ->delete();
         if($success>0){
            if(File::exists($file_path)){
             File::delete($file_path);
            }
         }
         $result = "<img src=\"" . asset($image->image_url) . "\" id=\"image-slider\" data-id-slider=\"$data_id_slider\">";
         return response()->json(['result'=>$result]);
       }
     }

     //upload  1 ảnh cho fastMoving
     function uploadImageFastMovingPartner(Request $request){
        if($request->hasFile('imageFastMoving')){
            $file = $request->file('imageFastMoving');
            $name_file = $file->getClientOriginalName();
            $file->move('uploads',$name_file);
            $image_url = "uploads/{$name_file}";
            $image = Image::create([
                'image_url' => $image_url
            ]);
            $result = "<img src=\"" . asset($image->image_url) . "\" id=\"image-imageFastMoving\"> ";
            return response()->json(['result' => $result,'image_id_fastMoving' => $image->id]);
           }
     }

      //update upload ảnh fastMoving
      function updateImageFastMovingPartner(Request $request){
        $data_id_slider = $request->input('data_id_slider') ;
        $slider = FastMovingPartner::find($data_id_slider);
         $image_id_old =  $slider->image->id;
         $image_url_old = $slider->image->image_url; 
         $file_path = public_path($image_url_old);
       if($request->hasFile('updateImageFastMovingPartner')){
         $file = $request->file('updateImageFastMovingPartner');
         $name_file = $file->getClientOriginalName();
         $file->move('uploads',$name_file);
         $image_url = "uploads/{$name_file}";
         $image = Image::create([
             'image_url' =>  $image_url
         ]);
         $slider->update([
             'image_id' => $image->id
         ]);
         //khi mình cập nhập slider bằng ảnh mới rồi thì khi xóa ảnh cũ slider sẽ không bị xóa
         $success = Image::where('id',$image_id_old)
                     ->delete();
         if($success>0){
            if(File::exists($file_path)){
             File::delete($file_path);
            }
         }
         $result = "<img src=\"" . asset($image->image_url) . "\" id=\"image-slider\" data-id-slider=\"$data_id_slider\">";
         return response()->json(['result'=>$result]);
       }
     }

     //upload  1 ảnh cho messageCustomer
     function uploadImageMessageCustomer(Request $request){
        if($request->hasFile('imageMessageCustomer')){
            $file = $request->file('imageMessageCustomer');
            $name_file = $file->getClientOriginalName();
            $file->move('uploads',$name_file);
            $image_url = "uploads/{$name_file}";
            $image = Image::create([
                'image_url' => $image_url
            ]);
            $result = "<img src=\"" . asset($image->image_url) . "\" id=\"image-imageMessageCustomer\"> ";
            return response()->json(['result' => $result,'image_id_MessageCustomer' => $image->id]);
           }
     }

     //update upload ảnh messageCustomer
     function updateImageMessageCustomer(Request $request){
        $data_id_slider = $request->input('data_id_slider') ;
        $slider = messageCustomer::find($data_id_slider);
         $image_id_old =  $slider->image->id;
         $image_url_old = $slider->image->image_url; 
         $file_path = public_path($image_url_old);
       if($request->hasFile('updateImageMessageCustomer')){
         $file = $request->file('updateImageMessageCustomer');
         $name_file = $file->getClientOriginalName();
         $file->move('uploads',$name_file);
         $image_url = "uploads/{$name_file}";
         $image = Image::create([
             'image_url' =>  $image_url
         ]);
         $slider->update([
             'image_id' => $image->id
         ]);
         //khi mình cập nhập slider bằng ảnh mới rồi thì khi xóa ảnh cũ slider sẽ không bị xóa
         $success = Image::where('id',$image_id_old)
                     ->delete();
         if($success>0){
            if(File::exists($file_path)){
             File::delete($file_path);
            }
         }
         $result = "<img src=\"" . asset($image->image_url) . "\" id=\"image-slider\" data-id-slider=\"$data_id_slider\">";
         return response()->json(['result'=>$result]);
       }
     }

     //upload 1 ảnh cho postCatHome
     function uploadImagePostCatHome(Request $request){
        if($request->hasFile('imagePostCatHome')){
            $file = $request->file('imagePostCatHome');
            $name_file = $file->getClientOriginalName();
            $file->move('uploads',$name_file);
            $image_url = "uploads/{$name_file}";
            $image = Image::create([
                'image_url' => $image_url
            ]);
            $result = "<img src=\"" . asset($image->image_url) . "\" id=\"image-imagePostCatHome\"> ";
            return response()->json(['result' => $result,'image_id_postCatHome' => $image->id]);
           }
     }
     //update 1 ảnh cho postCatHome
     function updateImagePostCatHome(Request $request){
        $data_id_slider = $request->input('data_id_slider') ;
        $slider = PostCatHome::find($data_id_slider);
         $image_id_old =  $slider->image->id;
         $image_url_old = $slider->image->image_url; 
         $file_path = public_path($image_url_old);
       if($request->hasFile('updateImagePostCatHome')){
         $file = $request->file('updateImagePostCatHome');
         $name_file = $file->getClientOriginalName();
         $file->move('uploads',$name_file);
         $image_url = "uploads/{$name_file}";
         $image = Image::create([
             'image_url' =>  $image_url
         ]);
         $slider->update([
             'image_id' => $image->id
         ]);
         //khi mình cập nhập slider bằng ảnh mới rồi thì khi xóa ảnh cũ slider sẽ không bị xóa
         $success = Image::where('id',$image_id_old)
                     ->delete();
         if($success>0){
            if(File::exists($file_path)){
             File::delete($file_path);
            }
         }
         $result = "<img src=\"" . asset($image->image_url) . "\" id=\"image-slider\" data-id-slider=\"$data_id_slider\">";
         return response()->json(['result'=>$result]);
       }
     }
}
