<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\EventsApiController;
use App\Http\Controllers\API\TicketsApiController;
use App\Http\Controllers\EventCheckoutController; 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
 * ---------------
 * Organisers
 * ---------------
 */


/*
 * ---------------
 * Events
 * ---------------
 */
Route::resource('events', API\EventsApiController::class);

Route::get('/events', [EventsApiController::class, 'index']);

Route::get('/events/{event_id}/tickets', [TicketsApiController::class, 'index'])->name('events.tickets');

Route::post('/events/{event_id}/validate-tickets', [EventCheckoutController::class, 'postValidateTickets'])->name('events.validate-tickets');

Route::post('events/{event_id}/complete-order', [EventCheckoutController::class, 'completeOrder'])->name('orders.complete');

/*
 * ---------------
 * Attendees
 * ---------------
 */
Route::resource('attendees', API\AttendeesApiController::class);


/*
 * ---------------
 * Orders
 * ---------------
 */

/*
 * ---------------
 * Users
 * ---------------
 */

/*
 * ---------------
 * Check-In / Check-Out
 * ---------------
 */
