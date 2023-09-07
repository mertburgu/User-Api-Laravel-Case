# Laravel Case

## Case İşlemleri

Aşağıda belirtilen route group’larına Authorization header'ında 'xxxxx' key'i
bulunmadan istek atıldığında,
kişinin isteğini geri çevirerek geldiği yere geri göndermeliyim.

Aynı zamanda bu istekte bulunan kişinin IP'sini, veritabanında tuttuğum 'Logs' adlı
tabloya kaydetmeliyim.

Eğer gereken koşullar sağlanır ve istekte sorun olmazsa, verilen route group'a ait
mantıklı controller’lar yazmalıyım.

Route'larda URL üzerinden ID parametresi aldığım takdirde, Model binding işl
emi
yapmalıyım. Nesne varlık kontrolü sağlanmazsa istek hatalı demektir.

// Örnek middleware tanımlaması. Bu şekilde tanımlama yapılarak devam
edilmelidir.

    public function AuthorizationMiddleware($request, Closure $next) {
    
        // Yukarıda belirtilen işlemlerin yapılacağı middleware.
        
        return $next($request);
    
    }

    Route::prefix('user')->group(['middleware' => ['middleware.authorization']], function() {
    
        Route::post('/insert', 'UserController@insert');
        
        Route::get('/list', 'UserController@list');
        
        Route::put('/update/{user}', 'UserController@update');
        
        Route::delete('/delete/{user}', 'UserController@delete');
        
        Route::delete('/destroy/{user}', 'UserController@destroy'); //İstisna olarak, bu route'un, verilen modeli tamamen silmesini istiyorum.
    
    });

## Kısıtlamalar

1. Key olmadan istek atan bir kişi, dakikada 30 istekten fazla atarsa farklı bir engel
olarak, o IP'nin diğer hiç bir url ye erişmemesi gerekir.
2. Belirtilen UserModel'ı için bir Request sınıfı hazırlanacak ve gönderilecek
değerler validation'dan geçecek.
