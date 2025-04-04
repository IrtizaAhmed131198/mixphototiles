<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\SessionCollection;
use App\Models\CollectionImages;
use App\Models\ClusterImage;
use App\Models\CustomColor;
use App\Models\Finish;

class CollectionDetail extends Component
{
    public $slug;
    public $product;
    public $imageName;
    public $collectionImages;
    public $config;
    public $price;
    public $cluster_images;
    public $custom_color;
    public $finish;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->product = Product::where('slug', $slug)->with('additionalImages')->first();
        $this->cluster_images = ClusterImage::all();

        if (!$this->product) {
            abort(404); // Show 404 page if product not found
        }

        $this->imageName = request()->query('image_name');
        $data = SessionCollection::where('image_name', 'uploads/cart_images/'.$this->imageName)
            ->where('product_id', $this->product->id)
            ->first();
        if($data){
            $this->config = json_decode($data->configuration);
            $this->price = $data->price;
            $this->collectionImages = CollectionImages::where('collection_id', $data->id)->get();
        }

        $this->custom_color = CustomColor::where('status', 1)->get();

        $this->finish = Finish::where('status', 1)->get();

    }

    public function render()
    {
        return view('livewire.collection-detail', [
            'product' => $this->product,
            'collectionImages' => $this->collectionImages,
            'image_name' => $this->imageName,
            'config' => $this->config,
            'total_price' => $this->price,
            'cluster_images' => $this->cluster_images,
            'custom_color' => $this->custom_color,
            'finish' => $this->finish,
        ]);
    }
}
