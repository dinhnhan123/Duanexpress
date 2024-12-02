<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminFastMovingPartnerController;
use App\Http\Controllers\AdminImage2vexpressController;
use App\Http\Controllers\AdminImageController;
use App\Http\Controllers\AdminManagerPostCatHomeController;
use App\Http\Controllers\AdminMessageCustomerController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminSliderController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostCatHomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'show'])->name('home');
    Route::get('/admin', [AdminDashboardController::class, 'show'])->name('home');
    //user  
    Route::get('/admin/user/list', [AdminUserController::class, 'list']);
    Route::get('/admin/user/add', [AdminUserController::class, 'add']);
    Route::post('/admin/user/store', [AdminUserController::class, 'store']);
    Route::get('/admin/user/delete/{id}', [AdminUserController::class, 'delete'])->name('delete_user');
    Route::get('/admin/user/edit/{id}', [AdminUserController::class, 'edit'])->name('edit_user');
    Route::post('/admin/user/storeEdit/{id}', [AdminUserController::class, 'storeEdit'])->name('user.storeEdit');
    Route::get('/admin/user/action', [AdminUserController::class, 'action']);
    //end user

    //page
    Route::group(['prefix' => 'laravel-filemanager'], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
    Route::get('admin/page/add', [AdminPageController::class, 'add']);
    Route::post('admin/page/store', [AdminPageController::class, 'store']);
    Route::get('admin/page/list', [AdminPageController::class, 'list']);
    //delete page
    Route::get('admin/page/delete/{id}', [AdminPageController::class, 'delete'])->name('page.delete');
    //update page
    Route::get('admin/page/edit/{id}', [AdminPageController::class, 'edit'])->name('page.edit');
    //Xử lý form khi edit 
    Route::post('admin/page/update/{id}', [AdminPageController::class, 'update']);
    //action page
    Route::get('admin/page/action', [AdminPageController::class, 'action']);
    //end page
    //POST
    Route::get('admin/post/add', [AdminPostController::class, 'addPost']);
    Route::post('admin/post/store', [AdminPostController::class, 'store']);
    Route::get('admin/post/list', [AdminPostController::class, 'listPost']);
    Route::get('admin/post/action', [AdminPostController::class, 'action']);
    Route::get('admin/post/delete/{id}', [AdminPostController::class, 'delete'])->name('admin.post.delete');
    Route::get('admin/post/edit/{id}', [AdminPostController::class, 'edit'])->name('admin.post.edit');
    Route::post('admin/post/editStorePost/{id}', [AdminPostController::class, 'editStorePost']);
    //post category
    Route::get('admin/post/cat/add', [AdminPostController::class, 'addCat']);
    Route::post('admin/post/cat/catStore', [AdminPostController::class, 'catStore']);
    Route::get('admin/post/cat/list', [AdminPostController::class, 'listCat']);
    Route::get('admin/post/cat/catAction', [AdminPostController::class, 'catAction']);
    Route::get('admin/post/cat/catDelete/{id}', [AdminPostController::class, 'catDelete'])->name('post.cat.catDelete');
    Route::get('admin/post/cat/catEdit/{id}', [AdminPostController::class, 'catEdit'])->name('post.cat.catEdit');
    Route::post('admin/post/cat/catEditStore/{id}', [AdminPostController::class, 'catEditStore']);
    //end post category
    //upload ImagePost 
    Route::post('/uploadImagePost', [AdminImageController::class, 'uploadImagePost'])->name('uploadImagePost');
    Route::post('/updateUploadImagePost', [AdminImageController::class, 'updateUploadImagePost'])->name('updateUploadImagePost');
    //END POST
    //Slider 
    Route::get('admin/slider/add', [AdminSliderController::class, 'add']);
    Route::post('admin/slider/store', [AdminSliderController::class, 'store'])->name('slider.store');
    Route::get('admin/slider/list', [AdminSliderController::class, 'list']);
    Route::get('admin/slider/delete/{id}', [AdminSliderController::class, 'delete'])->name('slider.delete');
    Route::get('admin/slider/action', [AdminSliderController::class, 'action']);
    Route::get('admin/slider/edit/{id}', [AdminSliderController::class, 'edit'])->name('slider.edit');
    Route::post('admin/slider/update/{id}', [AdminSliderController::class, 'update'])->name('slider.update');
    //upload ảnh slider 
    Route::post('/uploadImageSlider', [AdminImageController::class, 'uploadImageSlider'])->name('uploadImageSlider');
    //update upload ảnh slider 
    Route::post('/updateImageSlider', [AdminImageController::class, 'updateImageSlider'])->name('updateImageSlider');
    //END SLIDER

    //Image2vexpress
    Route::get('admin/Image2vexpress/add', [AdminImage2vexpressController::class, 'add']);
    Route::post('admin/Image2vexpress/store', [AdminImage2vexpressController::class, 'store'])->name('Image2vexpress.store');
    Route::get('admin/Image2vexpress/list', [AdminImage2vexpressController::class, 'list']);
    Route::get('admin/Image2vexpress/delete/{id}', [AdminImage2vexpressController::class, 'delete'])->name('Image2vexpress.delete');
    Route::get('admin/Image2vexpress/action', [AdminImage2vexpressController::class, 'action']);
    Route::get('admin/Image2vexpress/edit/{id}', [AdminImage2vexpressController::class, 'edit'])->name('Image2vexpress.edit');
    Route::post('admin/Image2vexpress/update/{id}', [AdminImage2vexpressController::class, 'update'])->name('Image2vexpress.update');
    //upload ảnh slider 
    Route::post('/uploadImage2vexpress', [AdminImageController::class, 'uploadImage2vexpress'])->name('uploadImage2vexpress');
    //update upload ảnh slider 
    Route::post('/updateImage2vexpress', [AdminImageController::class, 'updateImage2vexpress'])->name('updateImage2vexpress');
    //END Image2vexpress

    //fastMovingPartner
    Route::get('admin/fastMovingPartner/add', [AdminFastMovingPartnerController::class, 'add']);
    Route::post('admin/fastMovingPartner/store', [AdminFastMovingPartnerController::class, 'store'])->name('fastMovingPartner.store');
    Route::get('admin/fastMovingPartner/list', [AdminFastMovingPartnerController::class, 'list']);
    Route::get('admin/fastMovingPartner/delete/{id}', [AdminFastMovingPartnerController::class, 'delete'])->name('fastMovingPartner.delete');
    Route::get('admin/fastMovingPartner/action', [AdminFastMovingPartnerController::class, 'action']);
    Route::get('admin/fastMovingPartner/edit/{id}', [AdminFastMovingPartnerController::class, 'edit'])->name('fastMovingPartner.edit');
    Route::post('admin/fastMovingPartner/update/{id}', [AdminFastMovingPartnerController::class, 'update'])->name('fastMovingPartner.update');
    //upload ảnh fastMoving 
    Route::post('/uploadImageFastMovingPartner', [AdminImageController::class, 'uploadImageFastMovingPartner'])->name('uploadImageFastMovingPartner');
    //update upload fastMoving
    Route::post('/updateImageFastMovingPartner', [AdminImageController::class, 'updateImageFastMovingPartner'])->name('updateImageFastMovingPartner');
    //END fastMovingPartner

      //messageCustomer
      Route::get('admin/messageCustomer/add', [AdminMessageCustomerController::class, 'add']);
      Route::post('admin/messageCustomer/store', [AdminMessageCustomerController::class, 'store'])->name('messageCustomer.store');
      Route::get('admin/messageCustomer/list', [AdminMessageCustomerController::class, 'list']);
      Route::get('admin/messageCustomer/delete/{id}', [AdminMessageCustomerController::class, 'delete'])->name('messageCustomer.delete');
      Route::get('admin/messageCustomer/action', [AdminMessageCustomerController::class, 'action']);
      Route::get('admin/messageCustomer/edit/{id}', [AdminMessageCustomerController::class, 'edit'])->name('messageCustomer.edit');
      Route::post('admin/messageCustomer/update/{id}', [AdminMessageCustomerController::class, 'update'])->name('messageCustomer.update');
      //upload ảnh fastMoving 
      Route::post('/uploadImageMessageCustomer', [AdminImageController::class, 'uploadImageMessageCustomer'])->name('uploadImageMessageCustomer');
      //update upload fastMoving
      Route::post('/updateImageMessageCustomer', [AdminImageController::class, 'updateImageMessageCustomer'])->name('updateImageMessageCustomer');
      //END messageCustomer

      //post cat homes 
      Route::get('admin/PostCatHome/add', [AdminManagerPostCatHomeController::class, 'add']);
      Route::post('admin/PostCatHome/store', [AdminManagerPostCatHomeController::class, 'store'])->name('admin.PostCatHome.store');
      Route::post('admin/PostCatHome/editStore/{id}', [AdminManagerPostCatHomeController::class, 'editStore'])->name('admin.PostCatHome.editStore');
      Route::get('admin/PostCatHome/list', [AdminManagerPostCatHomeController::class, 'list']);
      Route::get('admin/PostCatHome/action', [AdminManagerPostCatHomeController::class, 'action']);
      Route::get('admin/PostCatHome/delete/{id}', [AdminManagerPostCatHomeController::class, 'delete'])->name('admin.PostCatHome.delete');
      Route::get('admin/PostCatHome/edit/{id}', [AdminManagerPostCatHomeController::class, 'edit'])->name('admin.PostCatHome.edit');
      //upload ảnh postCatHome
      Route::post('/uploadImagePostCatHome', [AdminImageController::class, 'uploadImagePostCatHome'])->name('uploadImagePostCatHome');
      //update ảnh postCatHome
      Route::post('/updateImagePostCatHome', [AdminImageController::class, 'updateImagePostCatHome'])->name('updateImagePostCatHome');
      //end post cat homes
});
//Client 
// Home 
// Route::get('/',[HomeController::class,'home']);
// Route::get('/home',[HomeController::class,'home']);
//page 
// Route::get('/page/detail/{id}',[PageController::class,'detail'])->name('page.detail');
//post
// Route::get('/post/list',[PostController::class,'list'])->name('post.list');
// Route::get('/post/detail/{id}',[PostController::class,'detail'])->name('post.detail');
//postCatHome
// Route::get('/postCatHome/detail/{id}',[PostCatHomeController::class,'detail'])->name('postCatHome.detail');
//link thân thiện chuẩn seo 
Route::get('/',[HomeController::class,'home']);
Route::get('/trang-chu.html',[HomeController::class,'home']);

//page 
Route::get('/{slug}.html', [PageController::class, 'detail'])
    ->where('slug', '[a-zA-Z0-9-_]+') // Chỉ chấp nhận slug hợp lệ (chữ, số, - và _)
    ->name('page.detail');
//post
Route::get('/tin-tuc',[PostController::class,'list'])->name('post.list');
Route::get('tin-tuc/{slug}.html', [PostController::class, 'detail'])
    ->where('slug', '[a-zA-Z0-9-_]+')
    ->name('post.detail');
//postCatHome
Route::get('van-chuyen/{slug}.html', [PostCatHomeController::class, 'detail'])
    ->where('slug', '[a-zA-Z0-9-_]+')
    ->name('postCatHome.detail');

