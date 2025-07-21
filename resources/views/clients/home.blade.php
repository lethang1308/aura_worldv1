<style>
    body {
        font-family: Arial, sans-serif;
        background: #f8f9fa;
        margin: 0;
        padding: 30px;
    }
    h2 {
        color: #2c3e50;
        margin-top: 32px;
        border-bottom: 2px solid #3498db;
        padding-bottom: 4px;
    }
    ul {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        padding: 16px 24px;
        margin-bottom: 24px;
        list-style: none;
    }
    ul li {
        padding: 6px 0;
        border-bottom: 1px solid #eee;
    }
    ul li:last-child {
        border-bottom: none;
    }
</style>
@php
    use App\Models\Brand;
    use App\Models\Category;
    use App\Models\Product;
    use App\Models\Attribute;
    use App\Models\AttributeValue;
    use App\Models\Variants;
    $brands = Brand::all();
    $categories = Category::all();
    $products = Product::all();
    $attributes = Attribute::all();
    $attributeValues = AttributeValue::all();
    $variants = Variants::all();
@endphp

<h2>Brands</h2>
<ul>
    @foreach($brands as $brand)
        <li>{{ $brand->name }}</li>
    @endforeach
</ul>

<h2>Categories</h2>
<ul>
    @foreach($categories as $category)
        <li>{{ $category->category_name }}</li>
    @endforeach
</ul>

<h2>Products</h2>
<ul>
    @foreach($products as $product)
        <li>{{ $product->name }}</li>
    @endforeach
</ul>

<h2>Attributes</h2>
<ul>
    @foreach($attributes as $attribute)
        <li>{{ $attribute->name }}</li>
    @endforeach
</ul>

<h2>Attribute Values</h2>
<ul>
    @foreach($attributeValues as $value)
        <li>{{ $value->value }}</li>
    @endforeach
</ul>

<h2>Variants</h2>
<ul>
    @foreach($variants as $variant)
        <li>ID: {{ $variant->id }} | Product: {{ $variant->product_id }} | Price: {{ $variant->price }}</li>
    @endforeach
</ul>