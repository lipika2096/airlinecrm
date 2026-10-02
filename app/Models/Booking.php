<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Admin;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'booking_no',
        'booking_date',
        'customer_id',
        'customer_type',
        'b2b_partner_id',
        'b2c_customer_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'booking_notes',
        'total_cost',
        'total_sell',
        'profit',
        'status',
        'created_by',
        'created_by_type',
        'updated_by',
        'updated_by_type',
        'invoice_number',
        'invoice_date',
        'invoice_due_date',
        'invoice_tax_rate',
        'invoice_notes',
        'billing_address',
        'shipping_address',
        // B2C Customer Details
        'b2c_first_name',
        'b2c_last_name',
        'b2c_email',
        'b2c_phone',
        'b2c_street',
        'b2c_house_no',
        'b2c_city',
        'b2c_pincode',
        'b2c_state',
        'b2c_country',
        'b2c_language',
        'b2c_responsible',
        'b2c_remarks',
        // B2B Customer Details
        'b2b_group',
        'b2b_company_name',
        'b2b_email',
        'b2b_phone',
        'b2b_street',
        'b2b_house_no',
        'b2b_city',
        'b2b_pincode',
        'b2b_state',
        'b2b_country',
        'b2b_language',
        'b2b_responsible',
        'b2b_remarks',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'total_cost' => 'decimal:2',
        'total_sell' => 'decimal:2',
        'profit' => 'decimal:2',
        'invoice_date' => 'date',
        'invoice_due_date' => 'date',
        'invoice_tax_rate' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function b2bPartner()
    {
        return $this->belongsTo(B2BPartner::class, 'b2b_partner_id');
    }

    public function b2cCustomer()
    {
        return $this->belongsTo(B2CCustomer::class, 'b2c_customer_id');
    }

    public function services()
    {
        return $this->hasMany(BookingService::class);
    }

    public function passengers()
    {
        return $this->hasMany(BookingPassenger::class);
    }

    public function payments()
    {
        return $this->hasMany(BookingPayment::class);
    }

    public function documents()
    {
        return $this->hasMany(BookingDocument::class);
    }

    public function createdBy()
    {
        if ($this->created_by_type === 'staff') {
            return $this->belongsTo(User::class, 'created_by');
        }
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy()
    {
        if ($this->updated_by_type === 'staff') {
            return $this->belongsTo(User::class, 'updated_by');
        }
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    /**
     * Generate the next sequential booking number with thread safety
     */
    public static function generateNextBookingNumber()
    {
        // Use a more robust approach with retry logic for high concurrency
        $maxRetries = 5;
        $attempt = 0;

        while ($attempt < $maxRetries) {
            // Get the last booking number by ordering by booking_no itself
            $lastBooking = self::whereNotNull('booking_no')
                ->orderBy('booking_no', 'desc')
                ->first();

            if ($lastBooking && $lastBooking->booking_no) {
                // Extract the numeric part from the last booking number
                $lastNumber = intval(preg_replace('/[^0-9]/', '', $lastBooking->booking_no));
                $nextNumber = $lastNumber + 1;
            } else {
                // Start from 1 if no bookings exist
                $nextNumber = 1;
            }

            // Format as BK000000 (6 digits)
            $bookingNo = 'BK' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

            // Check if this booking number already exists (handle race conditions)
            if (!self::where('booking_no', $bookingNo)->exists()) {
                return $bookingNo;
            }

            // If it exists, try again with next number
            $attempt++;
        }

        // Fallback: use timestamp-based if all retries fail
        return 'BK' . str_pad(time() % 1000000, 6, '0', STR_PAD_LEFT);
    }
}
