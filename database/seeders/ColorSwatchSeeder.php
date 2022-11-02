<?php

namespace Database\Seeders;

use App\Models\ColorSwatch;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ColorSwatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $color_swatches = [
            [
                'hex' => Str::random(11),
                'user_id' => 1,
                'name' => 'Lisbon Streets',
                'slug' => 'lisbon-streets',
                'description' => 'Vibrant and artistic flavours provide enthusiasm and positivity.',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'hex' => Str::random(11),
                'user_id' => 1,
                'name' => 'Delhi Colors',
                'slug' => 'delhi-colors',
                'description' => 'Blues & oranges, freedom, youth, confidence & security.',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'hex' => Str::random(11),
                'user_id' => 1,
                'name' => 'Waterfall Bridge',
                'slug' => 'waterfall-bridge',
                'description' => 'Earthy tones promoting trust, optimism and loyalty.',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'hex' => Str::random(11),
                'user_id' => 1,
                'name' => 'Cherry Blossum',
                'slug' => 'cherry-blossum',
                'description' => 'A soft, calm and creative palette. Clean and professional.',
                'created_at' => now(), 
                'updated_at' => now()
            ]
        ];

        ColorSwatch::insert($color_swatches);


        File::deleteDirectory(public_path('images/color_swatches'));
        $color_swatches = ColorSwatch::all();
        foreach($color_swatches as $color_swatch){
            $source_path = public_path('import_images/color_swatches/'.$color_swatch->id);
            $destination_path = public_path('images/color_swatches/'.$color_swatch->hex);
            File::copyDirectory($source_path, $destination_path);
            
            $image_name = Str::random(11).'.jpg';

            $old_file = $destination_path.'/swatch.jpg';
            $new_file = $destination_path.'/'.$image_name;
            
            
            // Rename file
            File::move($old_file, $new_file);

            $color_swatch->image = $image_name;
            $color_swatch->save();
        }
    }   
}
