<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Request $request): View
    {
        abort_if(config('app.feature_hide'), 404);

        $validated = $request->validate(['rating' => 'nullable|integer|between:1,5']);
        $rating = $validated['rating'] ?? null;
        $reviews = Testimonial::where('is_customer_submission', true)
            ->where('status', true)
            ->when($rating, fn ($query) => $query->where('rating', $rating))
            ->latest('id')
            ->paginate(6, ['id', 'name', 'title', 'review', 'rating', 'created_at'])
            ->withQueryString();

        return view('reviews', compact('reviews', 'rating'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_if(config('app.feature_hide'), 404);

        $data = $request->validate([
            'name' => 'required|string|max:80',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|between:1,5',
            'title' => 'nullable|string|max:120',
            'review' => 'required|string|min:10|max:2000',
            'consent' => 'accepted',
        ]);

        $review = new Testimonial();
        $review->name = $data['name'];
        $review->email = $data['email'];
        $review->title = $data['title'] ?? null;
        $review->review = $data['review'];
        $review->rating = $data['rating'];
        $review->designation = 'Customer';
        $review->is_customer_submission = true;
        $review->status = false;
        $review->is_featured = false;
        $review->sort_order = 0;
        $review->save();

        return redirect(route('reviews.index').'#write-review')
            ->with('review_submitted', true);
    }
}
