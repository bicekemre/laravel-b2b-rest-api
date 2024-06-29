<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationHasProducts extends Model
{
    use HasFactory;


    protected $table = 'organization_has_product';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function imageable()
    {
        return $this->morphMany(Images::class, 'imageable');
    }

    public function organization()
    {
        return $this->belongsTo(Organizations::class);
    }

}
