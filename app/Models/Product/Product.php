<?php
namespace Base\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {

    use SoftDeletes;
	
    protected $dates = ['deleted_at'];
    
	protected $table = 'products';
	
	protected $fillable = [
		'live',
		'slug',
		'title',
		'description',
		'price',
        'stock',
        'sale'
    ];

    public $quantity = null;

    public function order() {
        return $this->belongsToMany(Order::class, 'orders_products')->withPivot('quantity');
    }

    public function hasLowStock() {
        if($this->outOfStock()) {
            return false;
        }

        return (bool) ($this->stock <= 5);
    }

    public function outOfStock() {
        return $this->stock === 0;
    }

    public function inStock() {
        return $this->stock >= 1;
    }

    public function hasStock($quantity) {
        return $this->stock >= $quantity;
    }
	
}