<?php

namespace App\Models;

use App\Models\Meal;
use App\Models\Room;
use App\Models\Market;
use App\Models\Window;
use App\Models\RateCode;
use App\Models\RoomType;
use App\Models\guest_profile;
use App\Models\companyProfile;
use App\Models\SourceBusiness;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guests extends Model
{

    use LogsActivity;
    use HasFactory;

    protected $fillable = [
        'folio_no',
        'in_date',
        'out_date',
        'original_out_date',
        'no_of_nights',
        'rm_rate',
        'taxes',
        'no_of_pax',
        'hotel_note',
        'client_note',
        'way_of_payment',
        'profile_id',
        'company_id',
        'room_id',
        'room_type_id',
        'rate_code_id',
        'market_segment_id',
        'source_of_business_id',
        'meal_id',
        'created_by',
        'created_inhousGuest_at',
        'checked_out',
        'checkout_by',
        'checkout_at',
        'is_reservation',
        'res_status',
        'is_group',
        'group_code',
        'is_dummy',
        'Is_PM',
        'is_cancel',
        'is_checked_in',
        'res_no',
        'res_status',
        'ref_no',
        'is_online',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->setDescriptionForEvent(fn(string $eventName) => " Guests has been {$eventName}");
    }

    public function profile()
    {
        return $this->hasMany(guest_profile::class,'id','id');
    }

    public function company()
    {
        return $this->hasMany(companyProfile::class,'company_id','id');
    }

    public function room()
    {
        return $this->hasMany(Room::class,'id','room_id');
    }

    public function roomTybe()
    {
        return $this->hasOne(RoomType::class,'id','room_type_id');
    }

    public function rateCode()
    {
        return $this->hasMany(RateCode::class,'id','rate_code_id');
    }

    public function marketSegment()
    {
        return $this->hasMany(Market::class,'id','market_segment_id');
    }

    public function sourceBusiness()
    {
        return $this->hasMany(SourceBusiness::class,'id','source_of_business_id');
    }
    public function meal()
    {
        return $this->hasMany(Meal::class,'id','meal_id');
    }
    public function createdBy()
    {
        return $this->hasMany(User::class,'id','created_by');
    }
    public function window()
    {
        return $this->hasMany(Window::class,'guest_id','id');
    }
}
