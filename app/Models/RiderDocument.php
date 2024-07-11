<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;

class RiderDocument extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = ['rider_id', 'document_id', 'is_verified', 'expire_date'];

    protected $casts = [
        'rider_id' => 'integer',
        'document_id' => 'integer',
        'is_verified' => 'integer'
    ];

    public function rider()
    {
        return $this->belongsTo(User::class, 'rider_id', 'id');
    }
    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id', 'id');
    }

    public static function verifyRiderDocument($rider_id)
    {
        $documents = Document::where('is_required', 1)->where('status', 1)->withCount([
            'driverDocument',
            'driverDocument as is_verified_document' => function ($query) use ($rider_id) {
                $query->where('is_verified', 1)->where('rider_id', $rider_id);
            }
            // ->where('has_expiry_date',1)->where('rider_id', $rider_id)
            // ,
            // 'driverDocument as expire_date_document' => function ($query) use($rider_id) {
            //     $query->whereDate('expire_date', Carbon::today());//->where('rider_id', $rider_id);
            // }
        ])->get();

        $is_verified = $documents->where('is_verified_document', 1);

        if (count($documents) == count($is_verified)) {
            return true;
        } else {
            return false;
        }
    }

    public function scopeMyDocument($query)
    {
        $user = auth()->user();
        if ($user->hasRole('admin') || $user->hasRole('demo_admin')) {
            $query =  $query;
        }

        if ($user->hasRole('rider')) {
            $query = $query->where('rider_id', $user->id);
        }

        if ($user->hasRole('fleet')) {
            return $query->whereHas('driver', function ($q) use ($user) {
                $q->where('fleet_id', $user->id);
            });
        }

        return $query->whereHas('document', function ($q) {
            $q->where('status', 1);
        });
    }
}
