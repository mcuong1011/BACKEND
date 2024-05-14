### Requirement
1. Herd
2. Composer
#### Herd
Vào herd tìm mục php và tải bản 8.3 rồi mở terminal kiểm tra 
``
php -v
``
#### Composer
Sau khi tải thì mở terminal gõ 
``
composer -v
``
sẽ hiện ra phiên bản
### Installation
clone repo về , vào thư mục mở terminal gõ  
``composer install
``  
``composer require tymon/jwt-auth 
``  
``
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
``  

đổi tên file .env.example thành .env rồi 
``
php artisan migrate
``  
Để chạy server  
``
php artisan serve
``  
server được chạy ở http://localhost:8000
### Usage
Đăng ký tài khoản  
enpoint : http://localhost:8000/api/auth/register  
method : POST    
body (form-data) :  
{  
    "name": "tendangky",  
    "email": "emaildangky",  
    "password": "password",  
    "password_confirmation": "password"  
}  
Đăng nhập
enpoint : http://localhost:8000/api/auth/login  
method : POST  
body (form-data) :  
{  
    "email": "emaildangky",  
    "password": "password"  
}  
Sau khi đăng nhập sẽ nhận được token, dùng token để truy cập các api khác  
enpoint : http://localhost:8000/api/auth/me (Chỉ để test)
method : GET 
header :  
{  
    "Authorization": "Bearer {thaybangtokentulogin}"  
}  





