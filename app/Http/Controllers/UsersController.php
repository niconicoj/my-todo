<?php
/**
 * Created by PhpStorm.
 * User: njoulin
 * Date: 24/12/2019
 * Time: 15:00
 */

namespace App\Http\Controllers;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UsersController extends Controller
{
    use HasApiTokens, Notifiable;
}