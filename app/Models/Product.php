<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property integer $code
 * @property float $price
 * @property boolean $status
 */
class Product extends Model
{
    use HasFactory, softDeletes;

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function organizations()
    {
        return $this->belongsToMany(Organizations::class, 'organization_has_product', 'product_id', 'organization_id');
    }

    public function stock()
    {
        return $this->hasMany(OrganizationHasProducts::class,  'product_id', 'id');
    }

    public function imageable()
    {
        return $this->morphMany(Images::class, 'imageable');
    }
}
