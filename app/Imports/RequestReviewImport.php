<?php

namespace App\Imports;

use App\Models\RequestReview;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RequestReviewImport implements ToModel, WithValidation, SkipsOnError,
    WithHeadingRow,
    WithChunkReading,
    SkipsEmptyRows,
    ShouldQueue
{
    use Importable, SkipsErrors;

    protected $authClinicId;
    protected $googleReviewUrl;

    public function __construct($authClinicId, $googleReviewUrl)
    {
        $this->authClinicId = $authClinicId;
        $this->googleReviewUrl = $googleReviewUrl;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * @param \Throwable $e
     */
    public function onError(\Throwable $e)
    {
        info($e->getMessage());
    }

    /**
     * @param array $rows
     * @return RequestReview
     */
    public function model(array $rows)
    {
        $time = Carbon::now();
        $slugTitle = $rows['patient'].'-'.$time->getPreciseTimestamp(3);
        return new RequestReview([
            'clinic_id' => $this->authClinicId,
            'slug' => Str::slug($slugTitle),
            'review_url' => $this->googleReviewUrl,
            'patient' => $rows['patient'],
            'dob' => date('Y-m-d', strtotime($rows['dob'])),
            'mobile_phone' => $rows['mobilephone'] ?? $rows['homephone'],
            'appointment_date' => date('Y-m-d', strtotime($rows['appointmenttime'])),
            'provider' => $rows['seenby'],
            'location' => $rows['facility'],
        ]);
    }

    /**
     * @return \string[][]
     */
    public function rules(): array
    {
        return [
            '*.patient' => ['required'],
            '*.dob' => ['nullable'],
            '*.mobilephone' => ['nullable'],
            '*.appointmenttime' => ['required'],
            '*.seenby' => ['nullable'],
            '*.facility' => ['nullable'],
        ];
    }
}
