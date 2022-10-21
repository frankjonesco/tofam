<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $title = $this->faker->sentence();
        $slug = Str::slug($title);

        $tags = [
            'business', 'leisure', 'shopping', 'dining', 'sport', 'finance', 'cosmetics', 'celebrity', 'international', 'manufactoring', 'engineering', 'electronics', 'medicine', 'psychology', 'poslitics', 'social', 'comedy', 'health', 'beauty', 'skincare', 'nature', 'food', 'environment', 'fashion', 'tv', 'music', 'law', 'science', 'animals', 'culture', 'photgraphy', 'stocks', 'history', 'travel', 'cinema', 'art', 'commerce', 'trade'
        ];

        $num = mt_rand(1, 4);
        $tags = Arr::random($tags, $num);

        $tags = implode(',', $tags);



        

        return [
            'hex' => Str::random(11),
            'user_id' => User::pluck('id')->random(),
            'category_id' => Category::pluck('id')->random(),
            'title' => $title,
            'slug' => $slug,
            'caption' => $this->faker->sentence(),
            'teaser' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(5),
            'tags' => $tags,
            'status' => 'public'
        ];
    }
}
