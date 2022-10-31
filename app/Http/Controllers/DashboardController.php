<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Color;
use App\Models\Config;
use App\Models\ColorSwatch;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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



    // COLOR SWATCH: INDEX
    public function colorSwatchIndex(){
        return view('dashboard.color-swatches.index', [
            'color_swatches' => ColorSwatch::get()
        ]);
    }

    // COLOR SWATCH: SHOW SINGLE COLOR SWATCH
    public function colorSwatchShow($hex = null){
        $color_swatch = ColorSwatch::where('hex', $hex)->first();
        return view('dashboard.color-swatches.show', [
            'color_swatch' => $color_swatch,
            // 'colors' => Color::where('color_swatch_id', $color_swatch->id)->orgerBy('fill_id', 'ASC')->get()
        ]);
    }

    // COLOR SWATCH: USE THIS SWATCH
    public function colorSwatchUse($hex = null){
        $color_swatch = ColorSwatch::where('hex', $hex)->first();
        $config = Config::where('id', 1)->first();
        $config->color_swatch_id = $color_swatch->id;
        $config->save();
        return redirect('dashboard/color-swatches')->with('messsge', 'Color swatch updated!');
    }

    // COLOR SWATCH: SHOW EDIT FORM
    public function colorSwatchEdit($hex = null){
        $color_swatch = ColorSwatch::where('hex', $hex)->first();
        return view('dashboard.color-swatches.edit', [
            'color_swatch' => $color_swatch
        ]);
    }

    // COLOR SWATCH: UPDATE COLOR SWATCH
    public function colorSwatchUpdate(Request $request, $hex = null){
        
        $debug = [];


        // Get color swatch
        $color_swatch = ColorSwatch::where('hex', $hex)->first();

        $debug['color_swatch_id'] = $color_swatch->id;

        
        // Validate form fields
        $form_fields = $request->validate([
            'name' => ['required', Rule::unique('color_swatches', 'name')->ignore($color_swatch->id)],
            'description' => 'required'
        ]);

        // Save swatch details
        $color_swatch->name = $request->name;
        $color_swatch->description = $request->description;
        $color_swatch->save();
        
        if($color_swatch->save()){
            $debug['swatch_info_saved'] = true;
        }else{
            $debug['swatch_info_saved'] = false;
        }


        // UPDATE EXISTING COLOR
        $debug['existing_color'] = count($color_swatch->colors);
        foreach($color_swatch->colors as $key => $color){
            // Labels for validation
            $code_label = 'code_' . $color->fill_id;
            $name_label = 'name_' . $color->fill_id;
            // Validate form fields
            $form_fields = $request->validate(
                [
                    $code_label => 'required|max:6|min:6',
                    $name_label => 'required|min:2',
                ],
                [   
                    $code_label.'.required' => 'Please enter a color code.',
                    $code_label.'.max' => 'The color code can only contain 6 charachters.',
                    $code_label.'.min' => 'The color code must be 6 charachters.',
                    $name_label.'.required' => 'Please enter a name for this color.',
                    $name_label.'.min' => 'The color name must contain at least 2 characters.'
                ]
            );
            // Compile data for update query
            $i = $key + 1;
            $data = [
                'code' => $request->$code_label,
                'name' => $request->$name_label,
                'updated_at' => now()
            ];
            $debug['existing_colors_data'][$key] = $data;
            // Update color
            Color::where('id', $color->id)->update($data);
        }


        // ADD NEW COLORS
        $number_of_existing_colors = count($color_swatch->colors);
        $number_of_new_colors = $request->countNewColors;

        $debug['number_of_new_colors'] = $number_of_new_colors;
        $debug['new_colors_data'] = 'empty';

        $x = 1;
        while($x <= $number_of_new_colors){
            $new_color_number = $number_of_existing_colors + $x;
            // Labels for validation
            $code_label = 'code_' . $new_color_number;
            $name_label = 'name_' . $new_color_number;

            // Validate form fields
            $form_fields = $request->validate(
                [
                    $code_label => 'required|max:6|min:6',
                    $name_label => 'required|min:2',
                ],
                [   
                    $code_label.'.required' => 'Please enter a color code.',
                    $code_label.'.max' => 'The color code can only contain 6 charachters.',
                    $code_label.'.min' => 'The color code must be 6 charachters.',
                    $name_label.'.required' => 'Please enter a name for this color.',
                    $name_label.'.min' => 'The color name must contain at least 2 characters.'
                ]
            );

            // Compile data for create query
            $data = [
                'color_swatch_id' => $color_swatch->id,
                'fill_id' => $number_of_existing_colors + $x,
                'code' => $request->$code_label,
                'name' => $request->$name_label,
                'updated_at' => now()
            ];
                
            $debug['new_colors_data'][$x] = 's';

            // Create color
            Color::create($data);
            $x++;
        }


        // DELETE COLORS
        $debug['delete_ids'] = 'empty';

        // If there are IDs to delete...
        if(!empty($request->idsToBeDeleted)){
            $delete_list = $request->idsToBeDeleted;

            // Replace multiple commas
            $delete_list = preg_replace('/,+/', ',', $delete_list);

            // Trim commas from list
            $delete_list = trim($delete_list, ',');

            $debug['delete_ids'] = $delete_list;

            // Explode list to array
            $delete_list = explode(',', $delete_list);

            // If ID in delete array then delete color
            foreach($delete_list as $key => $delete_color){
                $color = Color::where(['color_swatch_id' => $request->color_swatch_id, 'fill_id' => $delete_color]);
                if($color->delete()){
                    $debug['deleted_success'][$key] = $delete_color;
                }else{
                    $debug['deleted_error'][$key] = $delete_color;
                }
            }
        }


        // REORDER COLORS
        $colors = Color::where('color_swatch_id', $color_swatch->id)->orderBy('id', 'ASC')->get();
        foreach($colors as $key => $color){
            $color['fill_id'] = $key + 1;
            $color->save();
        }
        

        //dd($debug);

        return redirect('dashboard/color-swatches/'.$hex)->with('message', 'Color swatch updated!');
    }

    // COLOR SWATCH: DELETE SWATCH AND ASSOCIATED COLORS
    public function colorSwatchDestroy($hex = null){
        $color_swatch = ColorSwatch::where('hex', $hex)->first();
        $color_swatch->delete();
        return redirect('dashboard/color-swatches')->with('message', 'Color swatch deleted!');
    }

    // COLOR SWATCH: DELETE A COLOR FROM A SWATCH
    public function colorSwatchDestroyColor(Request $request, $hex = null){
        
        $colors = Color::where('color_swatch_id', $request->color_swatch_id)->get();
        
        foreach($colors as $color){
            if($color->fill_id > $request->color_fill_id){
                Color::where('id', $color->id)->update(['fill_id' => ($color->fill_id - 1)]);
            }
        }

        $color = Color::where('id', $request->color_id);
        $color->delete();

        return back()->with('message', 'Color removed from swatch!');

    }
}
