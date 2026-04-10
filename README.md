# Hệ thống Quản trị Người dùng Phân quyền (Secure RBAC)

Hệ thống quản trị người dùng được xây dựng dựa trên framework Laravel 11, tuân thủ các tiêu chuẩn thiết kế phần mềm doanh nghiệp (Enterprise Design Patterns). Dự án tập trung vào tính bảo mật, phân quyền dựa trên vai trò (Role-Based Access Control) và trải nghiệm người dùng hiện đại.

## 🚀 Tính năng chính

- **Xác thực & Bảo mật:** Hệ thống đăng nhập an toàn, quản lý phiên làm việc (Session) và bảo vệ chống tấn công CSRF.
- **Phân quyền người dùng (RBAC):**
  - **Admin:** Toàn quyền quản lý hệ thống, truy cập trang quản trị.
  - **User:** Truy cập trang Dashboard cá nhân.
- **Quản lý User (Chỉ Admin):**
  - Danh sách người dùng với giao diện hiện đại.
  - CRUD (Thêm, Sửa, Xóa) người dùng chuyên nghiệp.
  - **Thay đổi quyền nhanh (Inline Update):** Cho phép Admin đổi vai trò của User ngay tại danh sách mà không cần chuyển trang.
- **Giao diện (UI/UX):**
  - Thiết kế Premium Dark Mode sử dụng Vanilla CSS.
  - Badge phân biệt vai trò và thông báo trạng thái trực quan.
  - Xác nhận (Confirm) khi thực hiện các hành động nhạy cảm như xóa dữ liệu.
- **Kiến trúc mã nguồn:** Sử dụng **Service Pattern** để tách biệt logic nghiệp vụ, giúp mã nguồn sạch (Clean Code) và dễ bảo trì.

## 🛠 Công nghệ sử dụng

- **Backend:** PHP 8.2+, Laravel 11
- **Database:** SQLite (Dễ dàng triển khai và di động)
- **Frontend:** Laravel Blade, Vanilla CSS
- **Kiến trúc:** Service-Controller Pattern, Middleware-based Authorization

## 📦 Hướng dẫn cài đặt

Để triển khai dự án trên môi trường cục bộ, vui lòng làm theo các bước sau:

1. **Clone dự án:**
   ```bash
   git clone [link-repository-cua-ban]
   cd "Design a Secure Role-Based User Management System"
   ```

2. **Cài đặt các phụ thuộc (Dependencies):**
   ```bash
   composer install
   ```

3. **Cấu hình môi trường:**
   Sao chép file `.env.example` thành `.env` và tạo file database:
   ```bash
   cp .env.example .env
   touch database/database.sqlite
   ```

4. **Tạo mã khóa ứng dụng:**
   ```bash
   php artisan key:generate
   ```

5. **Khởi tạo Database và Dữ liệu mẫu:**
   ```bash
   php artisan migrate --seed
   ```

6. **Khởi chạy ứng dụng:**
   ```bash
   php artisan serve
   ```
   Truy cập tại: [http://127.0.0.1:8000](http://127.0.0.1:8000)

## 🔑 Tài khoản thử nghiệm

Dữ liệu mẫu đã được thiết lập sẵn trong hệ thống:

| Vai trò | Email | Mật khẩu |
| :--- | :--- | :--- |
| **Administrator** | `admin@example.com` | `password` |
| **Regular User** | `user@example.com` | `password` |

## 🛡 Bảo mật & Quy tắc doanh nghiệp

- File cơ sở dữ liệu và các thông tin nhạy cảm đã được cấu hình trong `.gitignore` để không bị đẩy lên GitHub.
- Cơ chế bảo vệ Admin: Hệ thống ngăn chặn việc Admin tự xóa chính mình hoặc tự hạ quyền của bản thân để tránh mất quyền quản trị.
