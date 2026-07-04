<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        // --- Users ---
        if (DB::table('users')->count() === 0) {
            DB::table('users')->insert([
                [
                    'name' => 'Admin User',
                    'email' => 'admin@example.com',
                    'phone' => '0123456789',
                    'password' => Hash::make('password'),
                    'role' => 'admin',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Trial User',
                    'email' => 'user@example.com',
                    'phone' => '0987654321',
                    'password' => Hash::make('password'),
                    'role' => 'user',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        // --- Categories ---
        if (DB::table('categories')->count() === 0) {
            DB::table('categories')->insert([
                ['id' => 1, 'name' => 'Cà phê', 'slug' => 'ca-phe', 'is_active' => true],
                ['id' => 2, 'name' => 'Trà sữa', 'slug' => 'tra-sua', 'is_active' => true],
                ['id' => 3, 'name' => 'Americano', 'slug' => 'americano', 'is_active' => true],
                ['id' => 4, 'name' => 'Espresso', 'slug' => 'espresso', 'is_active' => true],
                ['id' => 5, 'name' => 'Matcha', 'slug' => 'matcha', 'is_active' => true],
                ['id' => 6, 'name' => 'Trà trái cây', 'slug' => 'tra-trai-cay', 'is_active' => true],
                ['id' => 7, 'name' => 'Sinh tố', 'slug' => 'sinh-to', 'is_active' => true],
            ]);
        }

        // --- Products ---
        if (DB::table('products')->count() === 0) {
            $products = [
                ['id' => 1, 'category_id' => 2, 'name' => 'Trà Sữa Sương Sáo', 'slug' => 'tra-sua-suong-sao', 'base_price' => 35000, 'image_url' => '/img/products/trasua_suong-sao.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 2, 'category_id' => 6, 'name' => 'Trà Đào Cam Sả', 'slug' => 'tra-dao-cam-sa', 'base_price' => 39000, 'image_url' => '/img/products/tra-dao-cam-sa_400x400.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => true],
                ['id' => 3, 'category_id' => 1, 'name' => 'Cà Phê Đen Đá', 'slug' => 'ca-phe-den-da', 'base_price' => 22000, 'image_url' => '/img/products/cafe-den-da.jpg', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 4, 'category_id' => 4, 'name' => 'Espresso Đá', 'slug' => 'ca-phe-latte-may', 'base_price' => 45000, 'image_url' => '/img/products/espresso_da.jpg.png', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 5, 'category_id' => 2, 'name' => 'Trà Sữa Hồng Trà', 'slug' => 'tra-sua-hong-tra', 'base_price' => 45000, 'image_url' => '/img/products/trasua_hongtra_nong.jpg.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 6, 'category_id' => 2, 'name' => 'Trà Sữa Bassic', 'slug' => 'tra-sua-bassic', 'base_price' => 43000, 'image_url' => '/img/products/tra_sua.jpg', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 7, 'category_id' => 6, 'name' => 'Trà Đào', 'slug' => 'tra-dao', 'base_price' => 23000, 'image_url' => '/img/products/tra_dao.jpg', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => true],
                ['id' => 8, 'category_id' => 6, 'name' => 'Trà Vải', 'slug' => 'tra-vai', 'base_price' => 22000, 'image_url' => '/img/products/tra-vai.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => true],
                ['id' => 9, 'category_id' => 6, 'name' => 'Trà Vải Dâu', 'slug' => 'tra-vai-dau', 'base_price' => 34000, 'image_url' => '/img/products/tra-vai-dau.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 10, 'category_id' => 6, 'name' => 'Trà Phúc Kiến Sen', 'slug' => 'tra-phuc-kien-sen', 'base_price' => 23000, 'image_url' => '/img/products/tra-phuc-kien-sen_400x400.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 11, 'category_id' => 6, 'name' => 'Trà Dâu', 'slug' => 'tra-dau', 'base_price' => 23000, 'image_url' => '/img/products/tra-dau.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 12, 'category_id' => 7, 'name' => 'Sinh Tố Xoài', 'slug' => 'sinh-to-xoai', 'base_price' => 45000, 'image_url' => '/img/products/sinh-to-xoai.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 13, 'category_id' => 7, 'name' => 'Sinh Tố Mãn Cầu', 'slug' => 'sinh-to-man-cau', 'base_price' => 45000, 'image_url' => '/img/products/sinh-to-man-cau.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 14, 'category_id' => 7, 'name' => 'Sinh Tố Chuối', 'slug' => 'sinh-to-chuoi', 'base_price' => 43000, 'image_url' => '/img/products/sinh-to-chuoi.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 15, 'category_id' => 7, 'name' => 'Sinh Tố Bơ', 'slug' => 'sinh-to-bo', 'base_price' => 45000, 'image_url' => '/img/products/sinh-to-bo.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 16, 'category_id' => 6, 'name' => 'Ô Long Tứ Qúy Sen', 'slug' => 'o-long-tu-quy-sen', 'base_price' => 23000, 'image_url' => '/img/products/oolong_tuquy_sen.jpg.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 17, 'category_id' => 7, 'name' => 'Frappe Vanilla Mocha', 'slug' => 'frappe-vanilla-mocha', 'base_price' => 45000, 'image_url' => '/img/products/new-frappe_vanilla_mocha.jpg.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 18, 'category_id' => 5, 'name' => 'Matcha Latte Yến Mạch', 'slug' => 'matcha-latte-yen-mach', 'base_price' => 34000, 'image_url' => '/img/products/matcha_latte_yenmach.jpg.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 19, 'category_id' => 5, 'name' => 'Matcha Latte basic', 'slug' => 'matcha-latte-basic', 'base_price' => 34000, 'image_url' => '/img/products/matcha_latte_tb_nong.jpg.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 20, 'category_id' => 5, 'name' => 'Matcha Latte Đặc Biệt', 'slug' => 'matcha-latte-dac-biet', 'base_price' => 31000, 'image_url' => '/img/products/matcha_latte_tb.jpg.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 21, 'category_id' => 5, 'name' => 'Matcha Latte Dâu', 'slug' => 'matcha-latte-dau', 'base_price' => 45000, 'image_url' => '/img/products/matcha-latte-dau.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 22, 'category_id' => 5, 'name' => 'Frappe Matcha', 'slug' => 'frappe-matcha', 'base_price' => 21000, 'image_url' => '/img/products/frappe_matcha.jpg.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 23, 'category_id' => 1, 'name' => 'Frappe Bạc Xỉu', 'slug' => 'frappe-bac-xiu', 'base_price' => 34000, 'image_url' => '/img/products/frappe_bacxiu.jpg.png', 'allow_topping' => true, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 24, 'category_id' => 4, 'name' => 'Espresso Basic', 'slug' => 'espresso-basic', 'base_price' => 25000, 'image_url' => '/img/products/espresso_nong.jpg.png', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 25, 'category_id' => 1, 'name' => 'Chocolate', 'slug' => 'chocolate', 'base_price' => 31000, 'image_url' => '/img/products/chocolate.jpg', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 26, 'category_id' => 1, 'name' => 'Chocolate Muối', 'slug' => 'chocolate-muoi', 'base_price' => 30000, 'image_url' => '/img/products/choco_nong.jpg.png', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 27, 'category_id' => 1, 'name' => 'Chocolate Đá', 'slug' => 'chocolate-da', 'base_price' => 43000, 'image_url' => '/img/products/choco_da.jpg.png', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 28, 'category_id' => 1, 'name' => 'Caramel', 'slug' => 'caramel', 'base_price' => 23000, 'image_url' => '/img/products/caramel.jpg', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 29, 'category_id' => 1, 'name' => 'Bạc Xỉu Foam Dừa', 'slug' => 'bac-xiu-foam-dua', 'base_price' => 34000, 'image_url' => '/img/products/bacxiu_foamdua.png', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 30, 'category_id' => 1, 'name' => 'Bạc Xỉu Caramel Muối', 'slug' => 'bac-xiu-caramel-muoi', 'base_price' => 31000, 'image_url' => '/img/products/bacxiu_caramelmuoi.png', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => true],
                ['id' => 31, 'category_id' => 1, 'name' => 'Bạc Xỉu', 'slug' => 'bac-xiu-3', 'base_price' => 39000, 'image_url' => '/img/products/bacxiu.png', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => true],
                ['id' => 32, 'category_id' => 3, 'name' => 'Ame Mơ', 'slug' => 'ame-mo', 'base_price' => 29000, 'image_url' => '/img/products/ame_mo.png', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => true],
                ['id' => 33, 'category_id' => 3, 'name' => 'Ame Đào', 'slug' => 'ame-dao', 'base_price' => 42000, 'image_url' => '/img/products/ame_dao.png', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 34, 'category_id' => 3, 'name' => 'Ame Classic', 'slug' => 'ame-classic', 'base_price' => 23000, 'image_url' => '/img/products/ame_classic.png', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 35, 'category_id' => 3, 'name' => 'Americano Chanh Leo', 'slug' => 'americano-chanh-leo', 'base_price' => 32000, 'image_url' => '/img/products/1779086774_americano-chanh-leo_400x400.png', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 36, 'category_id' => 5, 'name' => 'Matcha Latte Xoài', 'slug' => 'matcha-latte-xoai', 'base_price' => 34000, 'image_url' => '/img/products/1776006288_new-matcha-latte-xoai_400x400.png', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 37, 'category_id' => 5, 'name' => 'Matcha Latte Đào Dưa Lưới', 'slug' => 'matcha-latte-dao-dua-luoi', 'base_price' => 22000, 'image_url' => '/img/products/1776006020_new-matcha-latte-dao-dua-luoi_400x400.png', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 38, 'category_id' => 1, 'name' => 'So Co La Đá', 'slug' => 'so-co-la-da', 'base_price' => 34000, 'image_url' => '/img/products/1751597730_so-co-la-da_400x400.png', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 39, 'category_id' => 1, 'name' => 'Shan Tuyết Choco', 'slug' => 'shan-tuyet-choco', 'base_price' => 23000, 'image_url' => '/img/products/1767189135_shan-tuyet-choco-tchk_400x400.png', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => false],
                ['id' => 40, 'category_id' => 6, 'name' => 'Trà Shan Tuyết Cheese Foam', 'slug' => 'tra-shan-tuyetcheese-foam', 'base_price' => 43000, 'image_url' => '/img/products/1767189249_shan-tuyet-cheese-foam_400x400.png', 'allow_topping' => false, 'is_active' => true, 'is_bestseller' => false],
            ];

            foreach ($products as $product) {
                DB::table('products')->insert($product);
            }
        }

        // --- Option Groups ---
        if (DB::table('option_groups')->count() === 0) {
            DB::table('option_groups')->insert([
                ['id' => 1, 'name' => 'Kích cỡ', 'display_type' => 'radio'],
                ['id' => 2, 'name' => 'Nhiệt độ', 'display_type' => 'radio'],
                ['id' => 3, 'name' => 'Độ ngọt', 'display_type' => 'radio'],
                ['id' => 4, 'name' => 'Mức đá', 'display_type' => 'radio'],
            ]);
        }

        // --- Option Values ---
        if (DB::table('option_values')->count() === 0) {
            DB::table('option_values')->insert([
                ['id' => 1, 'group_id' => 1, 'name' => 'Size S', 'price_adjustment' => 0, 'is_default' => true],
                ['id' => 2, 'group_id' => 1, 'name' => 'Size M', 'price_adjustment' => 5000, 'is_default' => false],
                ['id' => 3, 'group_id' => 1, 'name' => 'Size L', 'price_adjustment' => 10000, 'is_default' => false],
                ['id' => 4, 'group_id' => 2, 'name' => 'Đá', 'price_adjustment' => 0, 'is_default' => true],
                ['id' => 5, 'group_id' => 2, 'name' => 'Nóng', 'price_adjustment' => 0, 'is_default' => false],
                ['id' => 6, 'group_id' => 3, 'name' => 'Bình thường', 'price_adjustment' => 0, 'is_default' => true],
                ['id' => 7, 'group_id' => 3, 'name' => 'Ít ngọt', 'price_adjustment' => 0, 'is_default' => false],
                ['id' => 8, 'group_id' => 3, 'name' => 'Không đường', 'price_adjustment' => 0, 'is_default' => false],
                ['id' => 9, 'group_id' => 4, 'name' => 'Bình thường', 'price_adjustment' => 0, 'is_default' => true],
                ['id' => 10, 'group_id' => 4, 'name' => 'Ít đá', 'price_adjustment' => 0, 'is_default' => false],
                ['id' => 11, 'group_id' => 4, 'name' => 'Đá để riêng', 'price_adjustment' => 0, 'is_default' => false],
            ]);
        }

        // --- Toppings ---
        if (DB::table('toppings')->count() === 0) {
            DB::table('toppings')->insert([
                ['id' => 1, 'name' => 'Hạt nổ', 'price' => 5000, 'is_available' => true],
                ['id' => 2, 'name' => 'Kem cheese', 'price' => 5000, 'is_available' => true],
                ['id' => 3, 'name' => 'Kem muối', 'price' => 5000, 'is_available' => true],
                ['id' => 4, 'name' => 'Kem trứng', 'price' => 5000, 'is_available' => true],
                ['id' => 5, 'name' => 'Thạch phô mai', 'price' => 5000, 'is_available' => true],
                ['id' => 6, 'name' => 'Trân châu đen', 'price' => 5000, 'is_available' => true],
                ['id' => 7, 'name' => 'Trân châu trắng', 'price' => 5000, 'is_available' => true],
            ]);
        }

        // --- Product Option Groups (pivot) ---
        if (DB::table('product_option_groups')->count() === 0) {
            $pivotData = [
                // Products with Temperature option (group 2): 1, 5, 6, 16, 18, 19, 20, 24, 25, 26, 28, 29, 30, 31, 39, 40
                // All products get Size (1), Sweetness (3), Ice (4)
                // Some also get Temperature (2)
            ];

            $withTemp = [1, 5, 6, 16, 18, 19, 20, 24, 25, 26, 28, 29, 30, 31, 39, 40];
            $withoutTemp = [2, 3, 4, 7, 8, 9, 10, 11, 12, 13, 14, 15, 17, 21, 22, 23, 27, 32, 33, 34, 35, 36, 37, 38];

            foreach ($withTemp as $pid) {
                foreach ([1, 2, 3, 4] as $gid) {
                    $pivotData[] = ['product_id' => $pid, 'group_id' => $gid];
                }
            }

            foreach ($withoutTemp as $pid) {
                foreach ([1, 3, 4] as $gid) {
                    $pivotData[] = ['product_id' => $pid, 'group_id' => $gid];
                }
            }

            foreach ($pivotData as $row) {
                DB::table('product_option_groups')->insert($row);
            }
        }

        // --- User Addresses ---
        if (DB::table('user_addresses')->count() === 0) {
            $user = DB::table('users')->where('email', 'user@example.com')->first();
            if ($user) {
                DB::table('user_addresses')->insert([
                    'user_id' => $user->id,
                    'recipient_name' => 'Nguyen Van A',
                    'recipient_phone' => '0912345678',
                    'address_line' => '123 Duong Le Loi, TP. HCM',
                    'is_default' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
