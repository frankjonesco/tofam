<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    // View dashboard
    public function index(){
        if(!auth()->id()){
            return redirect('login')->with('staticAlert', config('global.messages.unauthorized'));
        }

        return view('dashboard.index');
    }

    // Show create user form
    public function createUser(){
        return view('dashboard.users.create');
    }

    // Format size units
    function formatSizeUnits($bytes)
        {
            if ($bytes >= 1073741824)
            {
                $bytes = number_format($bytes / 1073741824, 2) . ' GB';
            }
            elseif ($bytes >= 1048576)
            {
                $bytes = number_format($bytes / 1048576, 2) . ' MB';
            }
            elseif ($bytes >= 1024)
            {
                $bytes = number_format($bytes / 1024, 2) . ' KB';
            }
            elseif ($bytes > 1)
            {
                $bytes = $bytes . ' bytes';
            }
            elseif ($bytes == 1)
            {
                $bytes = $bytes . ' byte';
            }
            else
            {
                $bytes = '0 bytes';
            }

            return $bytes;
    }

    // Check images
    public function checkImages(Site $site){

        $articles = $site->allArticles();

        foreach($articles as $key => $article){
            if($article['image']){
                $directory_path = public_path('images/articles/'.$article['hex'].'/'.$article['image']);
                $articles[$key]['image_size'] = File::size($directory_path);
                if($articles[$key]['image_size'] > 500000){
                    // echo self::formatSizeUnits($articles[$key]['image_size']).'<br>';
                }
            }
        }

        return view('dashboard.image-stuff');

    
    }

    public function cropIndex()
    {
      return view('croppie');
    }
   
    public function uploadCropImage(Request $request)
    {
        $image = $request->image;

        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);
        $image = base64_decode($image);
        $image_name= time().'.png';
        $path = public_path('upload/'.$image_name);

        file_put_contents($path, $image);
        return response()->json(['status'=>true]);
    }
}
