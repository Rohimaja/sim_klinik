use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [LoginController::class, 'login'])
})