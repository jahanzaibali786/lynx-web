<?php



use App\Http\Controllers\Api\Apis;

use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/blogs', [Apis::class, 'Blogs']);
Route::get('/blogs/{slug}', [Apis::class, 'BlogBySlug']);
Route::get('/blogs/slugs', [Apis::class, 'BlogSlugs']);

Route::post('/admission-applications', [Apis::class, 'StoreAdmissionApplication']);
Route::post('/career-applications', [Apis::class, 'StoreCareerApplication']);

Route::get('/career-opportunities', [Apis::class, 'CareerOpportunities']);
Route::get('/career-opportunities/{id}', [Apis::class, 'CareerOpportunityDetail']);

Route::get('/galleries', [Apis::class, 'Galleries']);
Route::get('/galleries/{galleryId}/images', [Apis::class, 'GalleryImages']);

Route::get('/upcoming-events/latest', [Apis::class, 'LatestUpcomingEvents']);
Route::get('/upcoming-events/{id}', [Apis::class, 'UpcomingEventDetail']);

Route::get('/news', [Apis::class, 'News']);
Route::get('/news/{id}', [Apis::class, 'NewsDetail']);

Route::get('/blogs/{id}/image', [Apis::class, 'image']);



Route::get('/addons', [Apis::class, 'Addons']);

Route::get('/products', [Apis::class, 'Products']);
Route::get('/product_cards', [Apis::class, 'ProductCards']); // expects product_id query param
Route::get('/features', [Apis::class, 'Features']); // expects card_id query param

Route::get('/pricing', [Apis::class, 'Pricing']);

// Auth check route - requires session
Route::middleware(['web'])->group(function () {
    Route::get('/check-auth', [Apis::class, 'CheckAuth']);
});
