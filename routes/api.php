<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\EventsApiController;

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
