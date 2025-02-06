<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'postcode',
    ];

    protected $appends = [
        'url',
    ];

    public function bookings(): HasMany
    {
        /*
         * Support Ticket: Request for Booking Timeline Filter
         * As ticket is 'Low' urgency add ordering to Bookings.
         * This significantly improves UX and solves the customer request very quickly/safely.
         */
        return $this->hasMany(Booking::class)->orderBy('start', 'desc');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function getBookingsCountAttribute()
    {
        return $this->bookings->count();
    }

    public function getUrlAttribute()
    {
        return "/clients/" . $this->id;
    }
}
