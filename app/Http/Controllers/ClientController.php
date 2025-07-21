<?php 
namespace App\Http\Controllers;

use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Attribute;

class ClientController extends Controller
{
    private Brand $brand;

    private Category $category;

    private Product $product;

    private Variant $variant;

    private Attribute $attribute;

    private AttributeValue $attributeValue;
    public function __construct()
    {
        $this->brand = new Brand();
        $this->category = new Category();
        $this->product = new Product();
        $this->variant = new Variant();
        $this->attribute = new Attribute();
        $this->attributeValue = new AttributeValue();
    }
    public function index()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $products = Product::all();
        return view('clients.layouts.home', compact('brands', 'categories', 'products'));
    }
}