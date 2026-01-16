<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'return_date',
        'returned_at',
        'fine_amount',
        'status'
    ];

    protected $casts = [
        'loan_date'   => 'datetime',
        'return_date' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }




    public function getDueDateAttribute()
    {
        if (!$this->loan_date) {
            return Carbon::now()->addDays(7);
        }
        return $this->loan_date->copy()->addDays(7);
    }


    public function getCurrentFineAttribute()
    {
        // 1. Jika status sudah 'returned', kembalikan denda dari DB
        if ($this->status === 'returned') {
            return $this->fine_amount ?? 0;
        }

        // 2. Setting
        $finePerDay = 1000;
        $maxLoanDays = 7;

        // 3. Normalisasi Tanggal
        $loanDate = $this->loan_date
            ? Carbon::parse($this->loan_date)->setTimezone('Asia/Jakarta')
            : Carbon::now('Asia/Jakarta');

        $deadline = $loanDate->copy()->addDays($maxLoanDays)->endOfDay();
        $now = Carbon::now('Asia/Jakarta');

        // 4. Cek Keterlambatan
        if ($now->gt($deadline)) {
            // AMAN: Tambahkan abs() untuk memastikan angka selalu positif
            $diff = $now->floatDiffInDays($deadline);

            // abs() mengubah -1.5 jadi 1.5
            // ceil() membulatkan 1.1 jadi 2
            $daysLate = ceil(abs($diff));

            return $daysLate * $finePerDay;
        }

        return 0;
    }
}
