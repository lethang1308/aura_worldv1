# VariantController - Hướng dẫn sử dụng

## Tổng quan
VariantController là một controller hoàn chỉnh để quản lý variants (biến thể sản phẩm) trong hệ thống e-commerce Laravel. Controller này cung cấp đầy đủ các chức năng CRUD và các tính năng bổ sung.

## Các chức năng chính

### 1. Quản lý danh sách variants (`index`)
- **Route**: `GET /variants`
- **Chức năng**: 
  - Hiển thị danh sách tất cả variants
  - Tìm kiếm theo tên sản phẩm, giá, trạng thái
  - Phân trang
  - Toggle trạng thái active/inactive
  - Xem chi tiết, chỉnh sửa, xóa

### 2. Tạo variant mới (`create`, `store`)
- **Route**: `GET /variants/create`, `POST /variants`
- **Chức năng**:
  - Form tạo variant với validation
  - Chọn sản phẩm từ dropdown
  - Nhập giá, số lượng tồn kho, trạng thái
  - Chọn nhiều attribute values
  - Validation client-side và server-side

### 3. Xem chi tiết variant (`show`)
- **Route**: `GET /variants/{id}`
- **Chức năng**:
  - Hiển thị thông tin chi tiết variant
  - Thông tin sản phẩm liên quan
  - Danh sách attributes
  - Timestamps

### 4. Chỉnh sửa variant (`edit`, `update`)
- **Route**: `GET /variants/{id}/edit`, `PUT /variants/{id}`
- **Chức năng**:
  - Form chỉnh sửa với dữ liệu hiện tại
  - Cập nhật thông tin variant
  - Thay đổi attributes
  - Validation đầy đủ

### 5. Xóa variant (`destroy`)
- **Route**: `DELETE /variants/{id}`
- **Chức năng**:
  - Xóa mềm (soft delete)
  - Xóa các variant attributes liên quan
  - Redirect với thông báo

### 6. Quản lý thùng rác (`trash`, `restore`, `forceDelete`)
- **Routes**: 
  - `GET /variants/trash` - Xem thùng rác
  - `PATCH /variants/{id}/restore` - Khôi phục
  - `DELETE /variants/{id}/force-delete` - Xóa vĩnh viễn

### 7. Cập nhật trạng thái (`updateStatus`)
- **Route**: `PATCH /variants/{id}/status`
- **Chức năng**: Toggle trạng thái active/inactive qua AJAX

### 8. API lấy attributes theo product (`getAttributeValuesByProduct`)
- **Route**: `GET /variants/product/{productId}/attributes`
- **Chức năng**: Trả về JSON với thông tin product và attributes

## Cấu trúc Database

### Bảng `variants`
```sql
- id (primary key)
- product_id (foreign key)
- price (decimal)
- stock_quantity (integer)
- status (enum: active, inactive)
- created_at, updated_at, deleted_at
```

### Bảng `variant_attributes` (pivot table)
```sql
- variant_attributes_id (primary key)
- variant_id (foreign key)
- attribute_value_id (foreign key)
- created_at, updated_at
```

## Models sử dụng

### Variants Model
```php
class Variants extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'product_id', 'price', 'stock_quantity', 'status'
    ];
    
    // Relationships
    public function product()
    public function attributesValue()
}
```

### VariantAttribute Model
```php
class VariantAttribute extends Model
{
    protected $fillable = [
        'variant_id', 'attribute_value_id'
    ];
}
```

## Views

### 1. `variantlist.blade.php`
- Danh sách variants với tìm kiếm
- Toggle trạng thái
- Actions dropdown
- Pagination

### 2. `variantcreate.blade.php`
- Form tạo variant
- Chọn product và attributes
- Validation client-side

### 3. `variantedit.blade.php`
- Form chỉnh sửa
- Hiển thị attributes hiện tại
- Validation

### 4. `variantdetail.blade.php`
- Thông tin chi tiết variant
- Product information
- Attributes display
- Timestamps

### 5. `varianttrash.blade.php`
- Danh sách variants đã xóa
- Khôi phục/xóa vĩnh viễn
- Pagination

## Validation Rules

### Store/Update
```php
'product_id' => 'required|exists:products,id',
'price' => 'required|numeric|min:0',
'stock_quantity' => 'required|integer|min:0',
'status' => 'required|in:active,inactive',
'attribute_values' => 'required|array|min:1',
'attribute_values.*' => 'exists:attributes_values,id',
```

## JavaScript Features

### 1. Status Toggle
```javascript
// Toggle trạng thái qua AJAX
fetch(`/variants/${variantId}/status`, {
    method: 'PATCH',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ status: status })
})
```

### 2. Form Validation
```javascript
// Validate attributes selection
const checkedAttributes = document.querySelectorAll('input[name="attribute_values[]"]:checked');
if (checkedAttributes.length === 0) {
    e.preventDefault();
    alert('Please select at least one attribute value.');
    return false;
}
```

## Routes

```php
// Variant routes
Route::get('/variants', [VariantController::class, 'index'])->name('variants.index');
Route::get('/variants/create', [VariantController::class, 'create'])->name('variants.create');
Route::post('/variants', [VariantController::class, 'store'])->name('variants.store');
Route::get('/variants/{id}', [VariantController::class, 'show'])->name('variants.show');
Route::get('/variants/{id}/edit', [VariantController::class, 'edit'])->name('variants.edit');
Route::put('/variants/{id}', [VariantController::class, 'update'])->name('variants.update');
Route::delete('/variants/{id}', [VariantController::class, 'destroy'])->name('variants.destroy');
Route::patch('/variants/{id}/status', [VariantController::class, 'updateStatus'])->name('variants.updateStatus');
Route::get('/variants/trash', [VariantController::class, 'trash'])->name('variants.trash');
Route::patch('/variants/{id}/restore', [VariantController::class, 'restore'])->name('variants.restore');
Route::delete('/variants/{id}/force-delete', [VariantController::class, 'forceDelete'])->name('variants.forceDelete');
Route::get('/variants/product/{productId}/attributes', [VariantController::class, 'getAttributeValuesByProduct'])->name('variants.getAttributeValuesByProduct');
```

## Tính năng đặc biệt

### 1. Soft Delete
- Sử dụng SoftDeletes trait
- Có thể khôi phục từ thùng rác
- Xóa vĩnh viễn có xác nhận

### 2. Transaction Support
- Sử dụng DB transactions cho create/update
- Rollback khi có lỗi
- Đảm bảo tính toàn vẹn dữ liệu

### 3. Search & Filter
- Tìm kiếm theo product name
- Filter theo price range
- Filter theo status
- Hiển thị filters đã áp dụng

### 4. AJAX Status Toggle
- Toggle trạng thái không reload page
- Hiển thị thông báo thành công
- Error handling

### 5. Responsive Design
- Bootstrap 5 responsive
- Mobile-friendly interface
- Modern UI với icons

## Cách sử dụng

1. **Truy cập danh sách variants**: `/variants`
2. **Tạo variant mới**: Click "Add Variant" hoặc `/variants/create`
3. **Xem chi tiết**: Click "View" trong dropdown actions
4. **Chỉnh sửa**: Click "Edit" trong dropdown actions
5. **Xóa**: Click "Delete" trong dropdown actions
6. **Quản lý thùng rác**: Click "Trash" button

## Lưu ý

- Đảm bảo có đủ dữ liệu products và attributes trước khi tạo variants
- Validation được thực hiện cả client-side và server-side
- Sử dụng CSRF protection cho tất cả forms
- Soft delete được sử dụng để bảo vệ dữ liệu
- Responsive design cho mobile và desktop 