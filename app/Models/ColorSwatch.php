<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ColorSwatch extends Model
{
    use HasFactory;

    // Set route key name
    public function getRouteKeyName(){
        return 'hex';
    }


    // MODEL RELATIONSHIPS

    // Relationship to colors
    public function colors(){
        return $this->hasMany(Color::class, 'color_swatch_id');
    }


    // ACCESSORS

    // Accessor for retrieving and formatting 'created_at'
    public function getUpdatedAtAttribute($value){
        return Carbon::parse($this->attributes['updated_at'])->format('d/m/Y');
    }


    // Boolean checkers

    // Is this color swatch in use?
    public function inUse(){
        if($this->id == Config::where('id', 1)->first()->color_swatch_id){
            return true;
        }
        return false;
    }


    // RETRIEVAL METHODS

    // Find unique hex for color swatches
    public function uniqueHex($site, string $field = 'hex', int $length = 11){
        return $site->uniqueHex('color_swatches');
    }


    // DATA HANDLING CALL METHODS

    // Create color swatch (insert)
    public function createColorSwatch($request){
        $color_swatch = self::compileCreationData($request);
        $color_swatch->save();
        return $color_swatch;
    }

    // Save color swatch text (update)
    public function saveText($request){
        $this->name = $request->name;
        $this->description = $request->description;
        $this->save();
        return $this;
    }

    // Update existing colors
    public function updateExistingColors($request){
        $color_swatch = $this;
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
            // Update color
            Color::where('id', $color->id)->update($data);
        }
    }

    // Add new colors
    public function addNewColors($request){
        $color_swatch = $this;
        $number_of_existing_colors = count($color_swatch->colors);
        $number_of_new_colors = $request->countNewColors;

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
                    
            // Create color
            Color::create($data);
            $x++;
        }
    }

    // Delete these color IDs
    public function deleteColorIds($request){
        if(!empty($request->idsToBeDeleted)){
            $delete_list = $request->idsToBeDeleted;

            // Replace multiple commas
            $delete_list = preg_replace('/,+/', ',', $delete_list);

            // Trim commas from list
            $delete_list = trim($delete_list, ',');

            // Explode list to array
            $delete_list = explode(',', $delete_list);

            // If ID in delete array then delete color
            foreach($delete_list as $key => $delete_color){
                $color = Color::where(['color_swatch_id' => $request->color_swatch_id, 'fill_id' => $delete_color]);
                $color->delete();
            }
        }
    }


    // Reorder swatch colors
    public function reorderSwatchColors($request){
        $color_swatch = $this;
        $colors = Color::where('color_swatch_id', $color_swatch->id)->orderBy('id', 'ASC')->get();
        foreach($colors as $key => $color){
            $color['fill_id'] = $key + 1;
            $color->save();
        }
    }





    // DATA HANDLERS

    // Compile creation data
    public function compileCreationData($request){
        $site = new Site();
        $color_swatch = ColorSwatch::create([
            'hex' => self::uniqueHex($site),
            'user_id' => auth()->user()->id,
            'name' => ucfirst($request->name),
            'slug' => Str::slug($request->name),
            'description' => $request->description
        ]);
        
        if($request->hasFile('image')){
            $color_swatch->image = $site->handleImageUpload($request, 'color_swatches', $color_swatch->hex);
            $color_swatch->save();
        }

        $color_swatch->addDefaultColors($color_swatch->id);

        return $color_swatch;
    }

    // Add default colors to new swatch
    public function addDefaultColors($color_swatch_id){
        $default_colors = [0 => ['code' => 'FFA400', 'name' => 'Orange Web'], 1 => ['code' => '188FA7', 'name' => 'Blue Munsell'], 2 => ['code' => 'D6FF79', 'name' => 'Mindaro']];
        $x = 0;
        $number_of_colors = 3;
        while($x < $number_of_colors){
            $colors[$x] = [
                'color_swatch_id' => $color_swatch_id,
                'fill_id' => $x + 1,
                'code' => $default_colors[$x]['code'],
                'name' => $default_colors[$x]['name'],
                'created_at' => now(),
                'updated_at' => now()
            ];
            $x++;
        }
        Color::insert($colors);
    }

}
