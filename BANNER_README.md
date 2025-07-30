# CRUD Banner System

## Tổng quan
Hệ thống quản lý banner cho website e-commerce với đầy đủ chức năng CRUD (Create, Read, Update, Delete) cho admin và hiển thị banner cho client.

## Tính năng

### Admin Panel
- ✅ Quản lý danh sách banner
- ✅ Thêm banner mới
- ✅ Chỉnh sửa banner
- ✅ Xem chi tiết banner
- ✅ Xóa banner (soft delete)
- ✅ Thùng rác (trash)
- ✅ Khôi phục banner từ thùng rác
- ✅ Xóa vĩnh viễn banner
- ✅ Tìm kiếm và lọc banner
- ✅ Upload ảnh banner
- ✅ Quản lý trạng thái (active/inactive)
- ✅ Sắp xếp thứ tự hiển thị

### Client Side
- ✅ Hiển thị banner chính dạng carousel (đầu trang)
- ✅ Hiển thị banner phụ dạng card (cuối trang)
- ✅ Chỉ hiển thị banner có trạng thái active
- ✅ Sắp xếp theo thứ tự
- ✅ Hỗ trợ link click
- ✅ Responsive design
- ✅ Hiệu ứng hover cho banner phụ

## Cấu trúc Database

### Bảng `banners`
```sql
- id (primary key)
- title (string) - Tiêu đề banner
- description (text, nullable) - Mô tả banner
- image (string) - Đường dẫn ảnh
- link (string, nullable) - Link khi click vào banner
- status (enum: active/inactive) - Trạng thái
- type (enum: main/secondary) - Loại banner
- sort_order (integer) - Thứ tự hiển thị
- created_at, updated_at, deleted_at (timestamps)
```

## Cài đặt và Sử dụng

### 1. Chạy Migration
```bash
php artisan migrate
```

### 2. Chạy Migration mới (nếu chưa có trường type)
```bash
php artisan migrate --path=database/migrations/2025_01_15_000000_add_type_to_banners_table.php
```

### 3. Chạy Seeder (tùy chọn)
```bash
php artisan db:seed --class=BannerSeeder
```

### 4. Tạo symbolic link cho storage
```bash
php artisan storage:link
```

### 5. Truy cập Admin Panel
- URL: `/admin/banners`
- Đăng nhập với tài khoản admin
- Menu: Banner > Danh sách

### 6. Truy cập Client Side
- URL: `/clients`
- Banner chính sẽ hiển thị ở đầu trang (carousel)
- Banner phụ sẽ hiển thị ở cuối trang (2 banner cạnh nhau)

## Routes

### Admin Routes
```
GET    /admin/banners              - Danh sách banner
GET    /admin/banners/create       - Form tạo banner
POST   /admin/banners              - Lưu banner mới
GET    /admin/banners/{id}         - Chi tiết banner
GET    /admin/banners/{id}/edit    - Form chỉnh sửa
PUT    /admin/banners/{id}         - Cập nhật banner
DELETE /admin/banners/{id}         - Xóa banner
PATCH  /admin/banners/{id}/restore - Khôi phục banner
GET    /admin/banners/trash        - Thùng rác
DELETE /admin/banners/{id}/force-delete - Xóa vĩnh viễn
```

### Client Routes
```
GET    /clients                    - Trang chủ (hiển thị banner)
```

## Files đã tạo

### Models
- `app/Models/Banner.php`

### Controllers
- `app/Http/Controllers/BannerController.php`
- `app/Http/Controllers/ClientBannerController.php`

### Views (Admin)
- `resources/views/admins/banners/bannerlist.blade.php`
- `resources/views/admins/banners/bannercreate.blade.php`
- `resources/views/admins/banners/banneredit.blade.php`
- `resources/views/admins/banners/bannerdetail.blade.php`
- `resources/views/admins/banners/bannertrash.blade.php`

### Views (Client)
- `resources/views/clients/components/banners.blade.php` - Banner chính (carousel)
- `resources/views/clients/components/secondary-banner.blade.php` - Banner phụ (card)

### Database
- `database/migrations/2025_07_30_105556_create_banners_table.php`
- `database/migrations/2025_01_15_000000_add_type_to_banners_table.php`
- `database/seeders/BannerSeeder.php`

### Routes
- Đã thêm vào `routes/web.php`

## Tính năng nâng cao

### Validation
- Tiêu đề: bắt buộc, tối đa 255 ký tự
- Ảnh: bắt buộc, định dạng JPG/JPEG/PNG/WEBP, tối đa 2MB
- Link: tùy chọn, phải là URL hợp lệ
- Trạng thái: bắt buộc, chỉ nhận giá trị active/inactive
- Loại banner: bắt buộc, chỉ nhận giá trị main/secondary
- Thứ tự: tùy chọn, số nguyên >= 0

### Image Management
- Upload ảnh vào `storage/app/public/images/banners/`
- Tự động xóa ảnh cũ khi cập nhật
- Xem trước ảnh khi upload
- Hỗ trợ nhiều định dạng ảnh

### Search & Filter
- Tìm kiếm theo tiêu đề
- Lọc theo trạng thái
- Sắp xếp theo thứ tự và ngày tạo

### Soft Delete
- Xóa mềm banner (không xóa vĩnh viễn)
- Thùng rác để quản lý banner đã xóa
- Khôi phục banner từ thùng rác

## Ghi chú
- Banner chỉ hiển thị khi có trạng thái 'active'
- Banner được sắp xếp theo sort_order và ngày tạo
- Banner chính (type='main') hiển thị ở đầu trang dạng carousel
- Banner phụ (type='secondary') hiển thị ở cuối trang dạng card (tối đa 2 banner)
- Ảnh banner được lưu trong storage với symbolic link
- Hệ thống hỗ trợ responsive design
- Carousel tự động chuyển slide
- Banner phụ có hiệu ứng hover đẹp mắt
- Có thể click vào banner để chuyển đến link (nếu có) 