# ☕ Coffee Shop Mini eCommerce

Hệ thống bán hàng và quản lý cửa hàng cà phê trực quan, tinh tế được phát triển trên nền tảng **Laravel** (MVC) với giao diện tối (Dark-mode) cao cấp, mang lại trải nghiệm mượt mà và tối ưu trên mọi thiết bị.

---

## 🌟 Các Tính năng Nổi bật

### 🛒 Dành cho Khách hàng
- **Trang chủ Cửa hàng:** Tìm kiếm sản phẩm thông minh, lọc nhanh sản phẩm theo danh mục và phân trang mượt mà.
- **Chi tiết Sản phẩm:** Lựa chọn linh hoạt các tùy chọn (Size, Mức đường, Mức đá) và thêm Toppings (Trân châu, Thạch...) với giá tiền điều chỉnh động theo thời gian thực.
- **Giỏ hàng:** Cho phép thêm, cập nhật số lượng, xóa và tính toán tổng số tiền cực kỳ chính xác.
- **Sổ địa chỉ:** Quản lý trực quan ngay tại trang cá nhân `/info`. Hỗ trợ thêm mới, chỉnh sửa, xóa và cài đặt địa chỉ giao hàng mặc định cực kỳ tiện lợi.
- **Thanh toán:** Quy trình đặt hàng nhanh chóng, cho phép lựa chọn địa chỉ đã lưu (tự động điền thông tin qua cơ chế điền tự động) hoặc nhập địa chỉ mới linh hoạt. Hỗ trợ thanh toán COD và Chuyển khoản ngân hàng.

### 🛡️ Dành cho Quản trị viên
- **Quản lý Đơn hàng:** Xem chi tiết các đơn hàng (đầy đủ thông tin khách hàng, chi tiết món đã chọn size/toppings) và cập nhật trạng thái đơn hàng nhanh chóng.
- **Quản lý Danh mục:** Thêm, sửa, xóa và tùy chỉnh trạng thái hiển thị của các danh mục đồ uống.
- **Quản lý Sản phẩm:** Thêm, sửa, xóa sản phẩm, liên kết danh mục, cấu hình giá bán, ảnh minh họa, các nhóm tùy chọn được phép áp dụng và quyền thêm topping.
- **Quản lý Thành viên:** Thay đổi quyền của người dùng (Admin, User, Staff, Customer) động dựa trên cấu hình phân quyền bảo mật.

---

## 🛠️ Hướng dẫn Cài đặt & Chạy ứng dụng

### 1. Cài đặt các thư viện phụ thuộc (Dependencies)
Sau khi tải hoặc clone dự án từ GitHub về máy, hãy mở terminal tại thư mục dự án và chạy các lệnh sau:

1. **Cài đặt thư viện PHP (Composer):**
   ```bash
   composer install
   ```
2. **Cài đặt thư viện Frontend (NPM):**
   ```bash
   npm install
   ```
3. **Biên dịch giao diện (Assets compilation):**
   ```bash
   npm run build
   ```

### 2. Tạo file cấu hình môi trường (`.env`)
1. Sao chép file cấu hình mẫu `.env.example` thành `.env`:
   ```bash
   cp .env.example .env
   ```
2. Mở file `.env` vừa tạo và điều chỉnh thông tin kết nối Cơ sở dữ liệu MySQL (XAMPP) của bạn:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306          # Thay đổi thành 3307 nếu MySQL của bạn chạy cổng 3307
   DB_DATABASE=coffee_shop
   DB_USERNAME=root      # Tài khoản mặc định của XAMPP thường là root
   DB_PASSWORD=          # Mật khẩu mặc định của XAMPP thường để trống
   DB_COLLATION=utf8mb4_unicode_ci
   ```
3. Khởi tạo khóa bảo mật (Application Key) cho ứng dụng:
   ```bash
   php artisan key:generate
   ```

### 3. Thiết lập Database & Dữ liệu mẫu
Dự án đã được đính kèm sẵn tệp tin cơ sở dữ liệu đầy đủ tại đường dẫn `database/sql/coffee_shop.sql`:
1. Khởi động MySQL trong **XAMPP Control Panel**.
2. Mở **phpMyAdmin** trên trình duyệt của bạn.
3. Tạo một database mới có tên là `coffee_shop` với bảng mã (Collation) là `utf8mb4_general_ci` hoặc `utf8mb4_unicode_ci`.
4. Chọn database `coffee_shop` vừa tạo, nhấp chọn tab **Import** (Nhập).
5. Chọn tệp tin **`database/sql/coffee_shop.sql`** trong thư mục dự án của bạn và nhấn nút **Import** ở cuối trang.
6. *(Tùy chọn)* Sau khi import thành công dữ liệu mẫu, bạn có thể chạy lệnh migrate để cập nhật cấu trúc đồng bộ (nếu có thay đổi mới):
   ```bash
   php artisan migrate
   ```

### 4. Khởi động ứng dụng
1. Khởi chạy local development server bằng lệnh sau:
   ```bash
   php artisan serve
   ```
2. Mở trình duyệt và truy cập: [http://127.0.0.1:8000/shop](http://127.0.0.1:8000/shop)
3. Truy cập trang thông tin và quản lý Sổ địa chỉ cá nhân: [http://127.0.0.1:8000/info](http://127.0.0.1:8000/info) (yêu cầu đăng nhập)

---

## 🔐 Tài khoản Kiểm thử Hệ thống (Demo Accounts)

Hệ thống đã cấu hình sẵn 2 tài khoản mẫu để bạn kiểm tra nhanh toàn bộ chức năng:

| Vai trò | Email đăng nhập | Mật khẩu |
| :--- | :--- | :--- |
| **Quản trị viên (Admin)** | `admin@example.com` | `password` |
| **Khách hàng (User/Customer)** | `user@example.com` | `password` |
