# Hệ thống làm bài kiểm tra

## Overview

Hệ thống cho phép thành viên/khách có thể làm bài test - kiểm tra ở trên hệ thống. Hệ thống sẽ tự động chấm điểm và hiển
thị kết quả sau khi làm xong bài test. Hệ thống cũng sẽ hiển thị bảng xếp hạng của tất cả thành viên đã tham gia làm bài
test.

## Database Schema

![image](https://i.ibb.co/HKRnGvX/quiz-system.png)

## Tính năng

#### Tính năng Admin

- Quản lý các admin khác
- Quản lý các bài test
- Quản lý câu hỏi và lựa chọn
- Hiện thị kết quả và bảng xếp hạng của bài test

#### Tính năng người dùng

- Đăng ký đăng nhập
- Làm bài test
- Xem kết quả sau khi làm bài test, bảng xếp hạng
- Xem lịch sử làm bài test và bảng xêp hạng của toàn hệ thống

#### Điều kiện tiên quyết

- Composer dependency manager -  quản lý các thư viện , package dùng trong framework laravel 
- PHP 8+ - Ngôn ngữ lập trình chính của Laravel
- Laravel 10.18+ -framework
- Livewire 3 - package cho phép tạo ra các component UI mà không cần viết javascript -> lấy dữ liệu và binding dữ liệu từ server ra view 
- Tailwind CSS - là thư viện css
- Alpine JS - thư viện javascript tương tác với dom
- Mysql Database lưu trữ data 

#### Installation

1- Clone the project

```
git clone **https://github.com/duwscan/quiz-system.git**
```

2- Install the dependencies

```
composer install
```

3- Configure the environment: (Copy file .env.example rồi đổt thành env)

```
cp .env.example .env
```

4- Generate the application key:

```
php artisan key:generate
```

5- Migrate the database:

```
php artisan migrate --seed
```

6- Start the development server:

```
tab 1
php artisan serve
tab 2
npm install
npm run dev
```

