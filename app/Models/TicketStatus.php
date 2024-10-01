<?php

namespace App\Models;

    /*
      Attendize.com   - Event Management & Ticketing
     */

/**
 * Description of TicketStatuses.
 *
 * @author Dave
 */
class TicketStatus extends \Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;

    public function getTranslatedName()
    {
        $translations = [
            'Sold Out' => 'Agotado',
            'Sales Have Ended' => 'Las ventas han terminado',
            'Not On Sale Yet' => 'Aún no está a la venta',
            'On Sale' => 'En venta',
        ];

        return $translations[$this->name] ?? $this->name;
    }
}
