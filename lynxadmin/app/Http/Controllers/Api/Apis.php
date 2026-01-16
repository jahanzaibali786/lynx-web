<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\AddOnCategories;
use App\Models\Addon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\AdmissionApplication;
use App\Models\CareerApplication;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\UpcomingEvent;
use App\Models\News;




class Apis extends Controller
{
    public function Blogs()
    {
        $blogs = Blog::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(6); // 6 per page

        return response()->json($blogs);
    }


    public function BlogSlugs()
    {
        $slugs = Blog::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->pluck('slug'); // only get slugs column

        return response()->json($slugs);
    }

    public function BlogBySlug($slug)
    {
        // Find the requested blog
        $blog = Blog::where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();

        // Fetch latest 3 blogs (excluding the current one)
        $latest = Blog::where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(3)
            ->get();

        return response()->json([
            'Blogs' => $blog,
            'latest' => $latest,
        ]);
    }

    // ---------------- ADMISSION APPLICATIONS ---------------- //
    public function StoreAdmissionApplication(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'child_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'more_about_child' => 'nullable|string',
            'branch' => 'required|string|max:255',
            'class' => 'required|string|max:255',
        ]);

        $application = AdmissionApplication::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Admission application submitted successfully.',
            'data' => $application,
        ], 201);
    }

    // ---------------- CAREER APPLICATIONS ---------------- //
    public function StoreCareerApplication(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:20',
            'career'  => 'required|string|max:255',
            'message' => 'nullable|string',
            'cv'      => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);
    
        if ($request->hasFile('cv')) {
            $data['cv'] = $request->file('cv')->store('resumes', 'public');
        }
    
        $application = CareerApplication::create($data);
    
        return response()->json([
            'success' => true,
            'message' => 'Career application submitted successfully.',
            'data'    => $application,
        ], 201);
    }

    // ---------------- GALLERIES ---------------- //
    public function Galleries()
    {
        $galleries = Gallery::withCount('images')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($galleries);
    }

    // ---------------- GALLERY IMAGES ---------------- //
    public function GalleryImages(Request $request, $galleryId)
    {
        // Get page & per_page from request, default 6
        $perPage = $request->get('per_page', 12);
        $page = $request->get('page', 1);

        $images = GalleryImage::where('gallery_id', $galleryId)
            ->orderBy('created_at', 'desc')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        $total = GalleryImage::where('gallery_id', $galleryId)->count();

        return response()->json([
            'data' => $images,
            'current_page' => (int)$page,
            'per_page' => (int)$perPage,
            'total' => $total,
            'has_more' => $total > $page * $perPage
        ]);
    }



    public function LatestUpcomingEvents()
    {
        $events = UpcomingEvent::orderBy('date', 'asc')
            ->take(3)
            ->get()
            ->makeHidden([
                'description', // hide description
                'images',      // hide raw images JSON
                'image_urls',  // hide all images list
                'created_at',
                'updated_at',
            ]);

        return response()->json($events);
    }

    public function UpcomingEventDetail($id)
    {
        $event = UpcomingEvent::findOrFail($id);

        return response()->json($event);
    }


    public function News()
    {
        $news = News::orderBy('published_at', 'desc')
            ->take(5)
            ->get()
            ->makeHidden(['description', 'image']); // hide heavy fields

        return response()->json($news);
    }

    public function NewsDetail($id)
    {
        $news = News::findOrFail($id);
        return response()->json($news);
    }



    public function image($id)
    {
        $blog = Blog::findOrFail($id);

        // Check if the blog has a featured image
        if (!$blog->featured_image || !Storage::disk('private')->exists($blog->featured_image)) {
            abort(404, 'Image not found');
        }

        // Stream the file to the browser
        return Storage::disk('private')->response($blog->featured_image);
    }

    public function Addons(Request $request)
    {
        $categoryId = $request->query('category');

        // Get all categories
        $categories = AddOnCategories::get(['id', 'category_name']);

        // If category filter applied
        $addons = Addon::query()
            ->when($categoryId, fn($q) => $q->where('category', $categoryId))
            ->select('id', 'category', 'name', 'icon', 'short_detail')
            ->get()
            ->map(function ($addon) {
                return [
                    'id' => $addon->id,
                    'category' => $addon->category,
                    'name' => $addon->name,
                    'icon' => $addon->icon,
                    'short_detail' => $addon->short_detail,
                ];
            });

        return response()->json([
            'categories' => $categories,
            'addons' => $addons,
        ]);
    }

    public function Products()
    {
        $products = Product::all();
        return response()->json($products);
    }

    // Fetch cards for a product
    public function ProductCards(Request $request)
    {
        $productId = $request->query('product_id');

        if (!$productId) {
            return response()->json(['error' => 'Missing product_id'], 400);
        }

        $cards = ProductCard::where('product_id', $productId)->get();
        return response()->json($cards);
    }

    // Fetch features for a card
    public function Features(Request $request)
    {
        $cardId = $request->query('card_id');

        if (!$cardId) {
            return response()->json(['error' => 'Missing card_id'], 400);
        }

        $features = Feature::where('card_id', $cardId)->get();
        return response()->json($features);
    }

    public function Pricing()
    {
        $plans = PricingPlan::all()->map(function ($plan) {
            $monthly = (float) $plan->monthly_price;
            $discount = (int) $plan->yearly_discount; // cast to integer

            $yearly = $monthly * 12;
            $yearly_price = $yearly - ($yearly * $discount / 100);

            return [
                'id' => $plan->id,
                'name' => $plan->name,
                'monthly_price' => $monthly,
                'yearly_discount' => $discount, // now integer
                'yearly_price' => round($yearly_price, 2) // keep 2 decimals
            ];
        });

        $features = PricingFeature::all();

        $matrix = [];
        foreach ($features as $feature) {
            $matrix[$feature->id] = [];

            foreach ($plans as $plan) {
                $exists = PricingFeaturePlan::where('pricing_feature_id', $feature->id)
                    ->where('pricing_plan_id', $plan['id'])
                    ->exists();

                $matrix[$feature->id][$plan['id']] = $exists;
            }
        }

        return response()->json([
            'plans' => $plans,
            'features' => $features,
            'matrix' => $matrix
        ]);
    }

}
