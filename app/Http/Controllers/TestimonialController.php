<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        if (in_array(Auth::user()->role, ['super_admin', 'admin'])) {
            return view('profile.testimonials');
        } else {
            abort(403);
        }
    }

    public function getData()
    {
        $query = Testimonial::orderBy('sort_order', 'asc')->orderBy('id', 'desc')->get();

        return DataTables::of($query)
            ->addColumn('id', function ($row) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('image', function ($row) {
                $img = $row->avatar ?: $row->product_image;
                if (!empty($img) && file_exists(public_path($img))) {
                    return '<img src="' . asset($img) . '" alt="' . htmlspecialchars($row->name) . '" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 1px solid #e2e8f0;">';
                }
                return '<div style="width: 44px; height: 44px; border-radius: 50%; background: #fdf2f6; color: #eb2371; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">' . strtoupper(substr($row->name, 0, 1)) . '</div>';
            })
            ->addColumn('name', function ($row) {
                $html = '<div class="fw-bold">' . htmlspecialchars($row->name) . '</div>';
                if (!empty($row->designation)) {
                    $html .= '<small class="text-muted">' . htmlspecialchars($row->designation) . '</small>';
                }
                return $html;
            })
            ->addColumn('rating', function ($row) {
                $stars = '<div style="display: flex; gap: 2px;">';
                for ($i = 1; $i <= 5; $i++) {
                    $color = $i <= $row->rating ? '#f59e0b' : '#d1d5db';
                    $stars .= '<span style="color:' . $color . '; font-size: 16px;">★</span>';
                }
                $stars .= '</div>';
                return $stars;
            })
            ->addColumn('review', function ($row) {
                return '<span title="' . htmlspecialchars($row->review) . '" style="font-size: 13px;">' . htmlspecialchars(Str::limit($row->review, 70)) . '</span>';
            })
            ->addColumn('is_featured', function ($row) {
                return $row->is_featured
                    ? '<span class="badge bg-warning text-dark"><i class="fa fa-star me-1"></i>Featured</span>'
                    : '<span class="badge bg-secondary">Standard</span>';
            })
            ->addColumn('status', function ($row) {
                return $row->status
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-brand-dark edit-testimonial me-1" data-id="' . $row->id . '">Edit</button>
                        <button class="btn btn-sm btn-brand-dark delete-testimonial" data-id="' . $row->id . '">Delete</button>';
            })
            ->rawColumns(['id', 'image', 'name', 'rating', 'review', 'is_featured', 'status', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'review'        => 'required|string',
            'rating'        => 'required|integer|min:1|max:5',
            'designation'   => 'nullable|string|max:255',
            'is_featured'   => 'nullable|boolean',
            'status'        => 'required|boolean',
            'sort_order'    => 'nullable|integer',
            'avatar'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarFile = $request->file('avatar');
            $avatarName = time() . '_avatar.' . $avatarFile->getClientOriginalExtension();
            $avatarFile->move(public_path('uploads/testimonials'), $avatarName);
            $avatarPath = 'uploads/testimonials/' . $avatarName;
        }

        $productImgPath = null;
        if ($request->hasFile('product_image')) {
            $productImgFile = $request->file('product_image');
            $productImgName = time() . '_frame.' . $productImgFile->getClientOriginalExtension();
            $productImgFile->move(public_path('uploads/testimonials'), $productImgName);
            $productImgPath = 'uploads/testimonials/' . $productImgName;
        }

        $isFeatured = $request->has('is_featured') && $request->is_featured ? 1 : 0;
        if ($isFeatured) {
            // Unset previous featured if setting this as featured
            Testimonial::where('is_featured', 1)->update(['is_featured' => 0]);
        }

        $testimonial = new Testimonial();
        $testimonial->name = $request->name;
        $testimonial->review = $request->review;
        $testimonial->rating = $request->rating;
        $testimonial->designation = $request->designation ?: 'Verified Buyer';
        $testimonial->avatar = $avatarPath;
        $testimonial->product_image = $productImgPath;
        $testimonial->is_featured = $isFeatured;
        $testimonial->status = $request->status;
        $testimonial->sort_order = $request->sort_order ?: 0;
        $testimonial->save();

        return response()->json(['success' => true, 'message' => 'Testimonial added successfully']);
    }

    public function edit($id)
    {
        $testimonial = Testimonial::find($id);
        if (!$testimonial) {
            return response()->json(['success' => false, 'message' => 'Testimonial not found'], 404);
        }

        return response()->json([
            'success' => true,
            'testimonial' => $testimonial,
            'avatar_url' => $testimonial->avatar ? asset($testimonial->avatar) : null,
            'product_image_url' => $testimonial->product_image ? asset($testimonial->product_image) : null,
        ]);
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::find($id);
        if (!$testimonial) {
            return response()->json(['success' => false, 'message' => 'Testimonial not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'review'        => 'required|string',
            'rating'        => 'required|integer|min:1|max:5',
            'designation'   => 'nullable|string|max:255',
            'is_featured'   => 'nullable|boolean',
            'status'        => 'required|boolean',
            'sort_order'    => 'nullable|integer',
            'avatar'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar && file_exists(public_path($testimonial->avatar))) {
                @unlink(public_path($testimonial->avatar));
            }
            $avatarFile = $request->file('avatar');
            $avatarName = time() . '_avatar.' . $avatarFile->getClientOriginalExtension();
            $avatarFile->move(public_path('uploads/testimonials'), $avatarName);
            $testimonial->avatar = 'uploads/testimonials/' . $avatarName;
        }

        if ($request->hasFile('product_image')) {
            if ($testimonial->product_image && file_exists(public_path($testimonial->product_image))) {
                @unlink(public_path($testimonial->product_image));
            }
            $productImgFile = $request->file('product_image');
            $productImgName = time() . '_frame.' . $productImgFile->getClientOriginalExtension();
            $productImgFile->move(public_path('uploads/testimonials'), $productImgName);
            $testimonial->product_image = 'uploads/testimonials/' . $productImgName;
        }

        $isFeatured = $request->has('is_featured') && $request->is_featured ? 1 : 0;
        if ($isFeatured && !$testimonial->is_featured) {
            Testimonial::where('is_featured', 1)->where('id', '!=', $id)->update(['is_featured' => 0]);
        }

        $testimonial->name = $request->name;
        $testimonial->review = $request->review;
        $testimonial->rating = $request->rating;
        $testimonial->designation = $request->designation ?: 'Verified Buyer';
        $testimonial->is_featured = $isFeatured;
        $testimonial->status = $request->status;
        $testimonial->sort_order = $request->sort_order ?: 0;
        $testimonial->save();

        return response()->json(['success' => true, 'message' => 'Testimonial updated successfully']);
    }

    public function destroy(Request $request)
    {
        $testimonial = Testimonial::find($request->id);
        if (!$testimonial) {
            return response()->json(['success' => false, 'message' => 'Testimonial not found'], 404);
        }

        if ($testimonial->avatar && file_exists(public_path($testimonial->avatar))) {
            @unlink(public_path($testimonial->avatar));
        }
        if ($testimonial->product_image && file_exists(public_path($testimonial->product_image))) {
            @unlink(public_path($testimonial->product_image));
        }

        $testimonial->delete();

        return response()->json(['success' => true, 'message' => 'Testimonial deleted successfully']);
    }
}

