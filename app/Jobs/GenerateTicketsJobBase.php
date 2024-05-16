<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use PDF;
use Illuminate\Support\Facades\Storage;

class GenerateTicketsJobBase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $attendee;
    public $event;
    public $order;
    public $file_name;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file_name_with_ext = $this->file_name . '.pdf';
        $s3_path = config('attendize.event_pdf_tickets_path') . '/' . $file_name_with_ext;
    
        if (Storage::disk('s3')->exists($s3_path)) {
            Log::info("Use ticket from cache: " . Storage::disk('s3')->url($s3_path));
            return;
        }
    
        $organiser = $this->event->organiser;
        $image_path = $organiser->full_logo_path;
    
    
        $data = [
            'order'     => $this->order,
            'event'     => $this->event,
            'attendees' => $this->attendees,
            'css'       => file_get_contents(public_path('assets/stylesheet/ticket.css')),
            'image'     => base64_encode(file_get_contents(public_path($image_path)))
        ];
        
    
        try {
            $pdf = PDF::loadView('Public.ViewEvent.Partials.PDFTicket', $data);
            $content = $pdf->output();
            Storage::disk('s3')->put($s3_path, $content);
            Log::info("Ticket generated and saved to S3: " . Storage::disk('s3')->url($s3_path));
        } catch (\Exception $e) {
            Log::error("Error generating ticket: " . $e->getMessage());
            $this->fail($e);
        }
    }
    
    
}
