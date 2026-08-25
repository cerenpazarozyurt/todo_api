# 🚀 Laravel Todo API

Modern, güvenli ve RESTful prensiplere uygun olarak geliştirilmiş, katmanlı mimariye sahip bir Todo (Görev Yönetimi) API projesidir. Proje; kimlik doğrulama, merkezi hata yönetimi, veri bütünlüğü göz önünde bulundurularak tasarlanmıştır.

### 🛠️ Kullanılan Teknolojiler ve Araçlar
* **PHP** (8.2+)
* **Laravel** (11.x)
* **Laravel Sanctum** (Token-based Stateless Authentication)
* **MySQL** / Eloquent ORM
* **Postman** (API Testleri için)

### 📂 Proje Mimarisi ve Öne Çıkan Özellikler
1. **Merkezi Hata Yönetimi (Global Exception Handler):** Kod tekrarını önlemek ve tüm istemcilere tutarlı JSON formatında hata dönmek için hatalar `bootstrap/app.php` üzerinden merkezi olarak yönetilmektedir.
2. **Güvenli Kimlik Doğrulama (Stateless Auth):** Laravel Sanctum kullanılarak token tabanlı, mobil uygulama ve modern frontend mimarilerine uyumlu güvenli bir oturum altyapısı kurulmuştur.
3. **Form Request Validasyonu:** Gelen veriler Controller içine yığılmadan, ayrıştırılmış `Form Request` sınıfları ile katı kurallara göre doğrulanmaktadır.
4. **Ownership & IDOR Koruması:** Kullanıcıların yalnızca kendi oluşturdukları verilere erişebilmesi ve işlem yapabilmesi için sahiplik (`user_id`) kontrolleri uygulanmaktadır.


### 📌 API Endpoints Özeti
| Metot | Endpoint | Açıklama | Kimlik Doğrulama |
| :--- | :--- | :--- | :--- |
| **POST** | `/api/register` | Yeni kullanıcı kaydı oluşturur | Gerekli Değil |
| **POST** | `/api/login` | Sisteme giriş yapar ve Token üretir | Gerekli Değil |
| **GET** | `/api/todos` | Giriş yapan kullanıcının todolarını listeler | Bearer Token |
| **POST** | `/api/todos` | Yeni bir todo oluşturur | Bearer Token |
| **PUT** | `/api/todos/{id}` | Var olan todoyu günceller | Bearer Token |
| **PATCH** | `/api/todos/{id}/toggle` | Todonun tamamlanma durumunu tersine çevirir | Bearer Token |
| **DELETE** | `/api/todos/{id}` | Todoyu siler | Bearer Token |
