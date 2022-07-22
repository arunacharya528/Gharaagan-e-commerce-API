<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Discount;
use App\Models\ProductCategory;
use App\Models\ProductInventory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $productDescription =
            <<<EOD
            <h2>The &lt;!DOCTYPE&gt; Declaration</h2>
            <p>The&nbsp;<code>&lt;!DOCTYPE&gt;</code>&nbsp;declaration represents the document type, and helps browsers to display web pages correctly.</p>
            <p>It must only appear once, at the top of the page (before any HTML tags).</p>
            <p>The&nbsp;<code>&lt;!DOCTYPE&gt;</code>&nbsp;declaration is not case sensitive.</p>
            <p>The&nbsp;<code>&lt;!DOCTYPE&gt;</code>&nbsp;declaration for HTML5 is:</p>
            <div>
            <div>&lt;!DOCTYPE&nbsp;html&gt;</div>
            </div>
            <hr />
            <h2>HTML Headings</h2>
            <p>HTML headings are defined with the&nbsp;<code>&lt;h1&gt;</code>&nbsp;to&nbsp;<code>&lt;h6&gt;</code>&nbsp;tags.</p>
            <table style="border-collapse: collapse; width: 100.056%;" border="1">
            <tbody>
            <tr>
            <td style="width: 47.9577%;">This</td>
            <td style="width: 47.9577%;">Is</td>
            </tr>
            <tr>
            <td style="width: 47.9577%;">Some</td>
            <td style="width: 47.9577%;">data</td>
            </tr>
            <tr>
            <td style="width: 47.9577%;">and</td>
            <td style="width: 47.9577%;">this</td>
            </tr>
            <tr>
            <td style="width: 47.9577%;">is</td>
            <td style="width: 47.9577%;">awesome</td>
            </tr>
            </tbody>
            </table>
            <p>&nbsp;</p>
            EOD;
        return [
            'name' => $this->faker->word(),
            'description' => $productDescription,
            'summary' => $this->faker->sentence(),
            'category_id' => $this->faker->randomElement(ProductCategory::pluck('id')),
            'brand_id' => $this->faker->randomElement(Brand::pluck('id')),
        ];
    }
}
