<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Color;
use App\Models\Config;
use App\Models\ColorSwatch;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ColorSwatchController extends Controller
{
    // ADMIN: INDEX
    public function adminIndex(Site $site){
        return view('dashboard.color-swatches.index', [
            'color_swatches' => $site->allColorSwatches()
        ]);
    }

    // ADMIN: SHOW SINGLE COLOR SWATCH
    public function adminShow(ColorSwatch $color_swatch){
        return view('dashboard.color-swatches.show', [
            'color_swatch' => $color_swatch,
        ]);
    }

    // ADMIN: USE THIS SWATCH
    public function use(ColorSwatch $color_swatch, Config $config){
        $config->updateColorSwatch($color_swatch->id);
        return redirect('dashboard/color-swatches')->with('messsge', 'Color swatch updated!');
    }

    // ADMIN: CREATE
    public function create(){
        return view('dashboard.color-swatches.create');
    }

    // ADMIN: STORE
    public function store(Request $request, ColorSwatch $color_swatch){
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $color_swatch = $color_swatch->createColorSwatch($request);
        return redirect('dashboard/color-swatches/'.$color_swatch->hex.'/edit');
    }

    // ADMIN: SHOW EDIT FORM
    public function edit(ColorSwatch $color_swatch){
        return view('dashboard.color-swatches.edit', [
            'color_swatch' => $color_swatch
        ]);
    }

    // ADMIN: UPDATE COLOR SWATCH
    public function update(Request $request, Site $site){
        $color_swatch = $site->getColorSwatch($request->hex);
        $request->validate([
            'name' => ['required', Rule::unique('color_swatches', 'name')->ignore($color_swatch->id)],
            'description' => 'required'
        ]);
        $color_swatch->saveText($request);
        $color_swatch->updateExistingColors($request);
        $color_swatch->addNewColors($request);
        $color_swatch->deleteColorIds($request);
        $color_swatch->reorderSwatchColors($request);
        return redirect('dashboard/color-swatches/'.$color_swatch->hex)->with('message', 'Color swatch updated!');
    }

    // ADMIN: DELETE SWATCH AND ASSOCIATED COLORS
    public function destroy(ColorSwatch $color_swatch){
        $color_swatch->delete();
        return redirect('dashboard/color-swatches')->with('message', 'Color swatch deleted!');
    }

}
