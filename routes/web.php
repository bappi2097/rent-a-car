<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect(app()->getLocale());
});


Route::group(
    ['prefix' => '{locale}', 'where' => ['locale' => join("|", \App\Models\Language::pluck("code")->all())], 'middleware' => 'setlocale',],
    function () {

        Route::get("/", [\App\Http\Controllers\HomeController::class, "index"])->name('home');
        Route::get("/why-blogs", [\App\Http\Controllers\HomeController::class, "whyBlogs"])->name('why-blogs');
        Route::get("/latest-blogs", [\App\Http\Controllers\HomeController::class, "latestBlogs"])->name('latest-blogs');
        Route::get("/clients", [\App\Http\Controllers\HomeController::class, "clients"])->name('clients');


        Route::name('auth.')->group(function () {
            Route::get('login', [\App\Http\Controllers\Frontend\Auth\AuthController::class, 'loginPage'])->name('login');
            Route::post('login', [\App\Http\Controllers\Frontend\Auth\AuthController::class, 'login'])->name('login');
            Route::post('logout', [\App\Http\Controllers\Frontend\Auth\AuthController::class, 'logout'])->name('logout');
            Route::get('register', [\App\Http\Controllers\Frontend\Auth\AuthController::class, 'registerPage'])->name('register');
            Route::post('register', [\App\Http\Controllers\Frontend\Auth\AuthController::class, 'register'])->name('register');
        });

        Route::get('car-operator', [\App\Http\Controllers\Frontend\Page\CarOperatorController::class, 'index'])->name('car-operator');
        Route::get('blog', [\App\Http\Controllers\Frontend\Page\BlogPageController::class, 'index'])->name('blog');
        Route::get('single-blog/{slug}', [\App\Http\Controllers\Frontend\Page\BlogPageController::class, 'singleBlog'])->name('single-blog');
        Route::get('category/{slug}', [\App\Http\Controllers\Frontend\Page\BlogPageController::class, 'blogCategory'])->name('blog-category');
        Route::get('contact-us', [\App\Http\Controllers\Frontend\Page\ContactUsPageController::class, 'index'])->name('contact-us');
        Route::post('contact-us', [\App\Http\Controllers\Frontend\Page\ContactUsPageController::class, 'store'])->name('contact-store');
        Route::get('privacy-and-policy', [\App\Http\Controllers\Frontend\Page\PageController::class, 'privacyAndPolicy'])->name('privacy-and-policy');
        Route::get('terms-and-condition', [\App\Http\Controllers\Frontend\Page\PageController::class, 'termsAndCondition'])->name('terms-and-condition');
        Route::get('faq', [\App\Http\Controllers\Frontend\Page\PageController::class, 'faq'])->name('faq');


        Route::group(["as" => "customer.", "prefix" => "customer", "middleware" => ["auth", "role:customer", 'prevent-back-history']], function () {
            Route::get("dashboard", [\App\Http\Controllers\Frontend\Customer\DashboardController::class, "index"])->name('dashboard');
            Route::get("notification/{notification}", [\App\Http\Controllers\NotificationController::class, "notification"])->name("notification");

            Route::group(['prefix' => 'my-profile', 'as' => 'my-profile.'], function () {
                Route::get("/", [\App\Http\Controllers\Frontend\Customer\ProfileController::class, "showProfile"])->name('show');
                Route::post("/update", [\App\Http\Controllers\Frontend\Customer\ProfileController::class, "updateProfile"])->name('update');
            });

            Route::group(['prefix' => 'change-password', 'as' => 'change-password.'], function () {
                Route::get("/", [\App\Http\Controllers\Frontend\Customer\ChangePasswordController::class, "show"])->name('show');
                Route::post("/", [\App\Http\Controllers\Frontend\Customer\ChangePasswordController::class, "update"])->name('update');
            });

            Route::group(['prefix' => 'make-trip', 'as' => 'make-trip.'], function () {
                Route::post("/make-trip", [\App\Http\Controllers\Frontend\Customer\TripController::class, "store"])->name('store');
                Route::post("/cancel-trip/{trip}", [\App\Http\Controllers\Frontend\Customer\TripController::class, "cancel"])->name('cancel');
                Route::get("/current-trip", [\App\Http\Controllers\Frontend\Customer\TripController::class, "indexCurrent"])->name('current-trip');
                Route::get("/history-trip", [\App\Http\Controllers\Frontend\Customer\TripController::class, "indexHistory"])->name('history-trip');
                Route::get("/show-trip/{trip}", [\App\Http\Controllers\Frontend\Customer\TripController::class, "showTrip"])->name('show-trip');
                Route::group(['prefix' => 'bid-trip', 'as' => 'bid-trip.'], function () {
                    Route::post("/approve/{tripBid}", [\App\Http\Controllers\Frontend\Customer\BidController::class, "bidApprove"])->name('approve');
                    Route::post("/decline/{tripBid}", [\App\Http\Controllers\Frontend\Customer\BidController::class, "bidDecline"])->name('decline');
                });
            });
        });

        Route::group(["as" => "company.", "prefix" => "company", "middleware" => ["auth", "role:company", 'prevent-back-history']], function () {
            Route::get("dashboard", [\App\Http\Controllers\Frontend\Company\DashboardController::class, "index"])->name('dashboard');
            Route::get("notification/{notification}", [\App\Http\Controllers\NotificationController::class, "notification"])->name("notification");
            Route::group(['prefix' => 'my-profile', 'as' => 'my-profile.'], function () {
                Route::get("/", [\App\Http\Controllers\Frontend\Company\ProfileController::class, "showProfile"])->name('show');
                Route::post("/", [\App\Http\Controllers\Frontend\Company\ProfileController::class, "updateProfile"])->name('update');
            });

            Route::group(['prefix' => 'change-password', 'as' => 'change-password.'], function () {
                Route::get("/", [\App\Http\Controllers\Frontend\Company\ChangePasswordController::class, "show"])->name('show');
                Route::post("/", [\App\Http\Controllers\Frontend\Company\ChangePasswordController::class, "update"])->name('update');
            });

            Route::group(['prefix' => 'car', 'as' => 'car.'], function () {
                Route::get('/', [\App\Http\Controllers\Frontend\Company\CarController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\Frontend\Company\CarController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\Frontend\Company\CarController::class, 'store'])->name('store');
                Route::get('/edit/{car}', [\App\Http\Controllers\Frontend\Company\CarController::class, 'edit'])->name('edit');
                Route::put('/{car}', [\App\Http\Controllers\Frontend\Company\CarController::class, 'update'])->name('update');
                Route::delete('/{car}', [\App\Http\Controllers\Frontend\Company\CarController::class, 'destroy'])->name('destroy');
            });
            Route::group(['prefix' => 'bid', 'as' => 'bid.'], function () {
                Route::get('/', [\App\Http\Controllers\Frontend\Company\BidController::class, 'index'])->name('index');
                Route::get('/{trip}', [\App\Http\Controllers\Frontend\Company\BidController::class, 'show'])->name('show');
                Route::post('/create/{trip}', [\App\Http\Controllers\Frontend\Company\BidController::class, 'create'])->name('create');
            });
            Route::group(['prefix' => 'trip', 'as' => 'trip.'], function () {
                Route::get("/current-trip", [\App\Http\Controllers\Frontend\Company\TripController::class, "indexCurrent"])->name('current-trip');
                Route::get("/history-trip", [\App\Http\Controllers\Frontend\Company\TripController::class, "indexHistory"])->name('history-trip');
                Route::get("/show-trip/{trip}", [\App\Http\Controllers\Frontend\Company\TripController::class, "showTrip"])->name('show-trip');
                Route::post("/finish/{trip}", [\App\Http\Controllers\Frontend\Company\TripController::class, "finish"])->name('finish');
            });
        });

        Route::group(["as" => "driver.", "prefix" => "driver", "middleware" => ["auth", "role:driver", 'prevent-back-history']], function () {
            Route::get("dashboard", [\App\Http\Controllers\Frontend\Driver\DashboardController::class, "index"])->name('dashboard');
            Route::get("notification/{notification}", [\App\Http\Controllers\NotificationController::class, "notification"])->name("notification");
            Route::group(['prefix' => 'my-profile', 'as' => 'my-profile.'], function () {
                Route::get("/", [\App\Http\Controllers\Frontend\Driver\ProfileController::class, "showProfile"])->name('show');
                Route::post("/", [\App\Http\Controllers\Frontend\Driver\ProfileController::class, "updateProfile"])->name('update');
            });

            Route::group(['prefix' => 'change-password', 'as' => 'change-password.'], function () {
                Route::get("/", [\App\Http\Controllers\Frontend\Driver\ChangePasswordController::class, "show"])->name('show');
                Route::post("/", [\App\Http\Controllers\Frontend\Driver\ChangePasswordController::class, "update"])->name('update');
            });

            Route::group(['prefix' => 'car', 'as' => 'car.'], function () {
                Route::get("/", [\App\Http\Controllers\Frontend\Driver\CarController::class, "show"])->name('show');
                Route::get("/edit/{car}", [\App\Http\Controllers\Frontend\Driver\CarController::class, "edit"])->name('edit');
                Route::post("/", [\App\Http\Controllers\Frontend\Driver\CarController::class, "store"])->name('store');
                Route::put("/{car}", [\App\Http\Controllers\Frontend\Driver\CarController::class, "update"])->name('update');
            });
            Route::group(['prefix' => 'bid', 'as' => 'bid.'], function () {
                Route::get('/', [\App\Http\Controllers\Frontend\Driver\BidController::class, 'index'])->name('index');
                Route::get('/{trip}', [\App\Http\Controllers\Frontend\Driver\BidController::class, 'show'])->name('show');
                Route::post('/create/{trip}', [\App\Http\Controllers\Frontend\Driver\BidController::class, 'create'])->name('create');
            });
            Route::group(['prefix' => 'trip', 'as' => 'trip.'], function () {
                Route::get("/current-trip", [\App\Http\Controllers\Frontend\Driver\TripController::class, "indexCurrent"])->name('current-trip');
                Route::get("/history-trip", [\App\Http\Controllers\Frontend\Driver\TripController::class, "indexHistory"])->name('history-trip');
                Route::get("/show-trip/{trip}", [\App\Http\Controllers\Frontend\Driver\TripController::class, "showTrip"])->name('show-trip');
                Route::post("/finish/{trip}", [\App\Http\Controllers\Frontend\Driver\TripController::class, "finish"])->name('finish');
            });
        });
    }
);

Route::group(
    ["prefix" => "admin", "as" => "admin."],
    function () {

        Route::get('login',  [\App\Http\Controllers\backend\AuthController::class, 'loginPage'])->name('login');
        Route::post('login',  [\App\Http\Controllers\backend\AuthController::class, 'login'])->name('login');

        Route::group(["middleware" => ["auth", "role:admin", 'prevent-back-history']], function () {

            Route::post('logout',  [\App\Http\Controllers\backend\AuthController::class, 'logout'])->name('logout');
            Route::get('dashboard', [\App\Http\Controllers\backend\DashboardController::class, 'index'])->name('dashboard');
            Route::get('profile', [\App\Http\Controllers\backend\ProfileController::class, 'show'])->name('profile');
            Route::post('profile', [\App\Http\Controllers\backend\ProfileController::class, 'update'])->name('update');
            Route::group(['prefix' => 'user', 'as' => 'user.'], function () {

                Route::group(['prefix' => 'admins', 'as' => 'admins.'], function () {
                    Route::get('/', [\App\Http\Controllers\backend\AdminsController::class, 'index'])->name('index');
                    Route::get('/create', [\App\Http\Controllers\backend\AdminsController::class, 'create'])->name('create');
                    Route::post('/', [\App\Http\Controllers\backend\AdminsController::class, 'store'])->name('store');
                    Route::get('/edit/{user}', [\App\Http\Controllers\backend\AdminsController::class, 'edit'])->name('edit');
                    Route::put('/{user}', [\App\Http\Controllers\backend\AdminsController::class, 'update'])->name('update');
                    Route::put('/change-password/{user}', [\App\Http\Controllers\backend\AdminsController::class, 'changePassword'])->name('change-password');
                    Route::delete('/{user}', [\App\Http\Controllers\backend\AdminsController::class, 'destroy'])->name('destroy');
                });

                Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
                    Route::get('/', [\App\Http\Controllers\backend\CustomerController::class, 'index'])->name('index');
                    Route::get('/create', [\App\Http\Controllers\backend\CustomerController::class, 'create'])->name('create');
                    Route::post('/', [\App\Http\Controllers\backend\CustomerController::class, 'store'])->name('store');
                    Route::get('/edit/{user}', [\App\Http\Controllers\backend\CustomerController::class, 'edit'])->name('edit');
                    Route::put('/{user}', [\App\Http\Controllers\backend\CustomerController::class, 'update'])->name('update');
                    Route::put('/change-password/{user}', [\App\Http\Controllers\backend\CustomerController::class, 'changePassword'])->name('change-password');
                    Route::delete('/{user}', [\App\Http\Controllers\backend\CustomerController::class, 'destroy'])->name('destroy');
                });

                Route::group(['prefix' => 'company', 'as' => 'company.'], function () {
                    Route::get('/', [\App\Http\Controllers\backend\CompanyController::class, 'index'])->name('index');
                    Route::get('/create', [\App\Http\Controllers\backend\CompanyController::class, 'create'])->name('create');
                    Route::get('/{user}', [\App\Http\Controllers\backend\CompanyController::class, 'show'])->name('show');
                    Route::post('/', [\App\Http\Controllers\backend\CompanyController::class, 'store'])->name('store');
                    Route::get('/edit/{user}', [\App\Http\Controllers\backend\CompanyController::class, 'edit'])->name('edit');
                    Route::put('/{user}', [\App\Http\Controllers\backend\CompanyController::class, 'update'])->name('update');
                    Route::put('/change-password/{user}', [\App\Http\Controllers\backend\CompanyController::class, 'changePassword'])->name('change-password');
                    Route::delete('/{user}', [\App\Http\Controllers\backend\CompanyController::class, 'destroy'])->name('destroy');

                    Route::group(['prefix' => 'car', 'as' => 'car.'], function () {
                        Route::get('/{company}', [\App\Http\Controllers\backend\CompanyCarController::class, 'index'])->name('index');
                        Route::get('/create/{company}', [\App\Http\Controllers\backend\CompanyCarController::class, 'create'])->name('create');
                        Route::post('/{company}', [\App\Http\Controllers\backend\CompanyCarController::class, 'store'])->name('store');
                        Route::get('/edit/{company}/{car}', [\App\Http\Controllers\backend\CompanyCarController::class, 'edit'])->name('edit');
                        Route::put('/{company}/{car}', [\App\Http\Controllers\backend\CompanyCarController::class, 'update'])->name('update');
                        Route::delete('/{company}/{car}', [\App\Http\Controllers\backend\CompanyCarController::class, 'destroy'])->name('destroy');
                    });
                });

                Route::group(['prefix' => 'driver', 'as' => 'driver.'], function () {
                    Route::get('/', [\App\Http\Controllers\backend\DriverController::class, 'index'])->name('index');
                    Route::get('/create', [\App\Http\Controllers\backend\DriverController::class, 'create'])->name('create');
                    Route::get('/{user}', [\App\Http\Controllers\backend\DriverController::class, 'show'])->name('show');
                    Route::post('/', [\App\Http\Controllers\backend\DriverController::class, 'store'])->name('store');
                    Route::get('/edit/{user}', [\App\Http\Controllers\backend\DriverController::class, 'edit'])->name('edit');
                    Route::put('/{user}', [\App\Http\Controllers\backend\DriverController::class, 'update'])->name('update');
                    Route::put('/change-password/{user}', [\App\Http\Controllers\backend\DriverController::class, 'changePassword'])->name('change-password');
                    Route::delete('/{user}', [\App\Http\Controllers\backend\DriverController::class, 'destroy'])->name('destroy');

                    Route::group(['prefix' => 'car', 'as' => 'car.'], function () {
                        Route::get('/create/{driver}', [\App\Http\Controllers\backend\DriverCarController::class, 'create'])->name('create');
                        Route::post('/{driver}', [\App\Http\Controllers\backend\DriverCarController::class, 'store'])->name('store');
                        Route::put('/{driver}/{car}', [\App\Http\Controllers\backend\DriverCarController::class, 'update'])->name('update');
                    });
                });

                Route::group(['prefix' => 'company-type', 'as' => 'company-type.'], function () {
                    Route::get('/', [\App\Http\Controllers\backend\CompanyTypeController::class, 'index'])->name('index');
                    Route::get('/create', [\App\Http\Controllers\backend\CompanyTypeController::class, 'create'])->name('create');
                    Route::post('/', [\App\Http\Controllers\backend\CompanyTypeController::class, 'store'])->name('store');
                    Route::get('/edit/{companyType}', [\App\Http\Controllers\backend\CompanyTypeController::class, 'edit'])->name('edit');
                    Route::put('/{companyType}', [\App\Http\Controllers\backend\CompanyTypeController::class, 'update'])->name('update');
                    Route::delete('/{companyType}', [\App\Http\Controllers\backend\CompanyTypeController::class, 'destroy'])->name('destroy');
                });
            });

            Route::group(['prefix' => 'cars', 'as' => 'cars.'], function () {
                Route::get('/', [\App\Http\Controllers\backend\CarController::class, 'index'])->name('index');
                Route::get('/user/{car}', [\App\Http\Controllers\backend\CarController::class, 'user'])->name('user');
                Route::post('/accept/{car}', [\App\Http\Controllers\backend\CarController::class, 'accept'])->name('accept');
                Route::post('/reject/{car}', [\App\Http\Controllers\backend\CarController::class, 'reject'])->name('reject');
                Route::get('/edit/{car}', [\App\Http\Controllers\backend\CarController::class, 'edit'])->name('edit');
                Route::put('/{car}', [\App\Http\Controllers\backend\CarController::class, 'update'])->name('update');
                Route::delete('/{car}', [\App\Http\Controllers\backend\CarController::class, 'destroy'])->name('destroy');
            });

            Route::group(['prefix' => 'car-category', 'as' => 'car-category.'], function () {
                Route::get('/', [\App\Http\Controllers\backend\CarCategoryController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\backend\CarCategoryController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\backend\CarCategoryController::class, 'store'])->name('store');
                Route::get('/edit/{carCategory}', [\App\Http\Controllers\backend\CarCategoryController::class, 'edit'])->name('edit');
                Route::put('/{carCategory}', [\App\Http\Controllers\backend\CarCategoryController::class, 'update'])->name('update');
                Route::delete('/{carCategory}', [\App\Http\Controllers\backend\CarCategoryController::class, 'destroy'])->name('destroy');
            });

            Route::group(['prefix' => 'car-size-category', 'as' => 'car-size-category.'], function () {
                Route::get('/', [\App\Http\Controllers\backend\CarSizeCategoryController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\backend\CarSizeCategoryController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\backend\CarSizeCategoryController::class, 'store'])->name('store');
                Route::get('/edit/{carSizeCategory}', [\App\Http\Controllers\backend\CarSizeCategoryController::class, 'edit'])->name('edit');
                Route::put('/{carSizeCategory}', [\App\Http\Controllers\backend\CarSizeCategoryController::class, 'update'])->name('update');
                Route::delete('/{carSizeCategory}', [\App\Http\Controllers\backend\CarSizeCategoryController::class, 'destroy'])->name('destroy');
            });

            Route::group(['prefix' => 'car-weight-category', 'as' => 'car-weight-category.'], function () {
                Route::get('/', [\App\Http\Controllers\backend\CarWeightCategoryController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\backend\CarWeightCategoryController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\backend\CarWeightCategoryController::class, 'store'])->name('store');
                Route::get('/edit/{carWeightCategory}', [\App\Http\Controllers\backend\CarWeightCategoryController::class, 'edit'])->name('edit');
                Route::put('/{carWeightCategory}', [\App\Http\Controllers\backend\CarWeightCategoryController::class, 'update'])->name('update');
                Route::delete('/{carWeightCategory}', [\App\Http\Controllers\backend\CarWeightCategoryController::class, 'destroy'])->name('destroy');
            });

            Route::group(['prefix' => 'language', 'as' => 'language.'], function () {
                Route::get('/', [\App\Http\Controllers\backend\LanguageController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\backend\LanguageController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\backend\LanguageController::class, 'store'])->name('store');
                Route::get('/edit/{language}', [\App\Http\Controllers\backend\LanguageController::class, 'edit'])->name('edit');
                Route::put('/{language}', [\App\Http\Controllers\backend\LanguageController::class, 'update'])->name('update');
                Route::delete('/{language}', [\App\Http\Controllers\backend\LanguageController::class, 'destroy'])->name('destroy');
            });


            Route::group(['prefix' => 'car-covered-category', 'as' => 'car-covered-category.'], function () {
                Route::get('/', [\App\Http\Controllers\backend\CarCoveredCategoryController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\backend\CarCoveredCategoryController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\backend\CarCoveredCategoryController::class, 'store'])->name('store');
                Route::get('/edit/{carCoveredCategory}', [\App\Http\Controllers\backend\CarCoveredCategoryController::class, 'edit'])->name('edit');
                Route::put('/{carCoveredCategory}', [\App\Http\Controllers\backend\CarCoveredCategoryController::class, 'update'])->name('update');
                Route::delete('/{carCoveredCategory}', [\App\Http\Controllers\backend\CarCoveredCategoryController::class, 'destroy'])->name('destroy');
            });


            Route::group(['prefix' => 'car-brand-category', 'as' => 'car-brand-category.'], function () {
                Route::get('/', [\App\Http\Controllers\backend\CarBrandCategoryController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\backend\CarBrandCategoryController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\backend\CarBrandCategoryController::class, 'store'])->name('store');
                Route::get('/edit/{carBrandCategory}', [\App\Http\Controllers\backend\CarBrandCategoryController::class, 'edit'])->name('edit');
                Route::put('/{carBrandCategory}', [\App\Http\Controllers\backend\CarBrandCategoryController::class, 'update'])->name('update');
                Route::delete('/{carBrandCategory}', [\App\Http\Controllers\backend\CarBrandCategoryController::class, 'destroy'])->name('destroy');
            });

            Route::group(['prefix' => 'car-model-category', 'as' => 'car-model-category.'], function () {
                Route::get('/', [\App\Http\Controllers\backend\CarModelCategoryController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\backend\CarModelCategoryController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\backend\CarModelCategoryController::class, 'store'])->name('store');
                Route::get('/edit/{carModelCategory}', [\App\Http\Controllers\backend\CarModelCategoryController::class, 'edit'])->name('edit');
                Route::put('/{carModelCategory}', [\App\Http\Controllers\backend\CarModelCategoryController::class, 'update'])->name('update');
                Route::delete('/{carModelCategory}', [\App\Http\Controllers\backend\CarModelCategoryController::class, 'destroy'])->name('destroy');
            });

            Route::group(['prefix' => 'car-trip-category', 'as' => 'car-trip-category.'], function () {
                Route::get('/', [\App\Http\Controllers\backend\CarTripCategoryController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\backend\CarTripCategoryController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\backend\CarTripCategoryController::class, 'store'])->name('store');
                Route::get('/edit/{carTripCategory}', [\App\Http\Controllers\backend\CarTripCategoryController::class, 'edit'])->name('edit');
                Route::put('/{carTripCategory}', [\App\Http\Controllers\backend\CarTripCategoryController::class, 'update'])->name('update');
                Route::delete('/{carTripCategory}', [\App\Http\Controllers\backend\CarTripCategoryController::class, 'destroy'])->name('destroy');
            });

            Route::group(['prefix' => 'product-type', 'as' => 'product-type.'], function () {
                Route::get('/', [\App\Http\Controllers\backend\ProductTypeController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\backend\ProductTypeController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\backend\ProductTypeController::class, 'store'])->name('store');
                Route::get('/edit/{productType}', [\App\Http\Controllers\backend\ProductTypeController::class, 'edit'])->name('edit');
                Route::put('/{productType}', [\App\Http\Controllers\backend\ProductTypeController::class, 'update'])->name('update');
                Route::delete('/{productType}', [\App\Http\Controllers\backend\ProductTypeController::class, 'destroy'])->name('destroy');
            });

            Route::group(['prefix' => 'blog-category', 'as' => 'blog-category.'], function () {
                Route::get('/', [\App\Http\Controllers\backend\BlogCategoryController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\backend\BlogCategoryController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\backend\BlogCategoryController::class, 'store'])->name('store');
                Route::get('/edit/{blogCategory}', [\App\Http\Controllers\backend\BlogCategoryController::class, 'edit'])->name('edit');
                Route::put('/{blogCategory}', [\App\Http\Controllers\backend\BlogCategoryController::class, 'update'])->name('update');
                Route::delete('/{blogCategory}', [\App\Http\Controllers\backend\BlogCategoryController::class, 'destroy'])->name('destroy');
            });

            Route::group(['prefix' => 'blog', 'as' => 'blog.'], function () {
                Route::get('/', [\App\Http\Controllers\backend\BlogController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\backend\BlogController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\backend\BlogController::class, 'store'])->name('store');
                Route::get('/edit/{blog}', [\App\Http\Controllers\backend\BlogController::class, 'edit'])->name('edit');
                Route::put('/{blog}', [\App\Http\Controllers\backend\BlogController::class, 'update'])->name('update');
                Route::delete('/{blog}', [\App\Http\Controllers\backend\BlogController::class, 'destroy'])->name('destroy');
            });
            Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
                Route::get('/', [\App\Http\Controllers\backend\ContactController::class, 'index'])->name('index');
                Route::get('/{contact}', [\App\Http\Controllers\backend\ContactController::class, 'show'])->name('show');
                Route::delete('/{contact}', [\App\Http\Controllers\backend\ContactController::class, 'destroy'])->name('destroy');
            });
            Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
                Route::group(['prefix' => 'slider', 'as' => 'slider.'], function () {
                    Route::get('/', [\App\Http\Controllers\backend\SliderController::class, 'index'])->name('index');
                    Route::get('/create', [\App\Http\Controllers\backend\SliderController::class, 'create'])->name('create');
                    Route::post('/', [\App\Http\Controllers\backend\SliderController::class, 'store'])->name('store');
                    Route::get('/edit/{slider}', [\App\Http\Controllers\backend\SliderController::class, 'edit'])->name('edit');
                    Route::put('/{slider}', [\App\Http\Controllers\backend\SliderController::class, 'update'])->name('update');
                    Route::delete('/{slider}', [\App\Http\Controllers\backend\SliderController::class, 'destroy'])->name('destroy');
                });
                Route::group(['prefix' => 'client', 'as' => 'client.'], function () {
                    Route::get('/', [\App\Http\Controllers\backend\ClientController::class, 'index'])->name('index');
                    Route::get('/create', [\App\Http\Controllers\backend\ClientController::class, 'create'])->name('create');
                    Route::post('/', [\App\Http\Controllers\backend\ClientController::class, 'store'])->name('store');
                    Route::get('/edit/{client}', [\App\Http\Controllers\backend\ClientController::class, 'edit'])->name('edit');
                    Route::put('/{client}', [\App\Http\Controllers\backend\ClientController::class, 'update'])->name('update');
                    Route::delete('/{client}', [\App\Http\Controllers\backend\ClientController::class, 'destroy'])->name('destroy');
                });
            });
        });
    }
);

Route::get("login", function () {
    return redirect("/");
})->name("login");

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');