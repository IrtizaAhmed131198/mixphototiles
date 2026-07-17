<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SessionCollection;
use App\Models\CollectionImages;
use App\Models\ClusterImage;
use App\Models\CustomColor;
use App\Models\Finish;
use App\Models\Led;
use Carbon\Carbon;

class CollectionDetailController extends Controller
{
    public function show($slug)
    {
        $temp_id = null;
        $temp_slug = request()->query('temp_slug');

        if ($temp_slug) {
            $product = Product::where('slug', $temp_slug)->with('additionalImages')->first();
        } else {
            $product = Product::where('slug', $slug)->with('additionalImages')->first();
        }

        $cluster_images = ClusterImage::where('created_at', '>=', Carbon::now()->subDay())
            ->orderBy('id', 'desc')
            ->limit(12)
            ->get();

        if (!$product) {
            abort(404); // Show 404 page if product not found
        }

        $imageName = request()->query('image_name');
        $config = null;
        $price = null;
        $collectionImages = [];

        $data = SessionCollection::where('image_name', 'uploads/cart_images/' . $imageName)
            ->where('product_id', $product->id)
            ->first();

        if ($data) {
            $config = json_decode($data->configuration);
            $price = $data->price;
            $collectionImages = CollectionImages::where('collection_id', $data->id)->get();
            $temp_id = $data->product_id;
        }

        $custom_color = CustomColor::where('status', 1)->get();
        $finish = Finish::where('status', 1)->get();
        $led = Led::where('status', 1)->get();

        return view('livewire.collection-detail', [
            'product' => $product,
            'collectionImages' => $collectionImages,
            'image_name' => $imageName,
            'config' => $config,
            'total_price' => $price,
            'cluster_images' => $cluster_images,
            'custom_color' => $custom_color,
            'finish' => $finish,
            'led' => $led,
            'temp_id' => $temp_id,
        ]);
    }

    public function fetchClusterImages(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = 12;
        $offset = ($page - 1) * $perPage;

        $cluster_images = ClusterImage::where('created_at', '>=', Carbon::now()->subDay())
            ->orderBy('id', 'desc')
            ->offset($offset)
            ->limit($perPage)
            ->get();

        $formatted_images = $cluster_images->map(function ($img) {
            return [
                'id' => $img->id,
                'image_path' => asset($img->image_path),
            ];
        });

        return response()->json([
            'cluster_images' => $formatted_images,
            'has_more' => $cluster_images->count() == $perPage
        ]);
    }
}
