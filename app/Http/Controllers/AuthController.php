<?php

namespace App\Http\Controllers;

use App\Notifications\NotifyUser;
use Exception;
use App\Helpers\PasswordHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{

    /**
     * Retrieve basic ems user data.
     *
     * @return array
     */
    public function getAllUsers(): object
    {
        $users = User::select('id', 'email', 'first_name', 'last_name', 'is_admin')->get()->toArray();
    
        return response ([
            'data' => $users
        ], 200);
    }


    /**
     * Only for EMS admins.
     * Add new EMS user.
     *
     * @param Request $request
     * @return Response
     */
    public function register(Request $request): object
    {
        if (!auth()->user()->is_admin) {
            return response(['message' => 'permit deny'], 403);
        }

        $fields = $request->validate([
            'email' => 'required|string|unique:users,email|max:250|',
            'first_name' => 'required|string|min:3|max:45',
            'last_name' => 'required|string|min:3|max:45',
            'password' => 'required|string|max:250',
            'is_admin' => 'required'
        ]);
        try {
            $user = User::create([
                'email' => $fields['email'],
                'first_name' => $fields['first_name'],
                'last_name' => $fields['last_name'],
                'password' => PasswordHelper::hashPassword($fields['password']),
                'is_admin' => $fields['is_admin']
            ]);

            $response = [
                'user' => $user,
                'message' => 'New EMS user created'
            ];

            $user->notify(new NotifyUser(
                'Welcome to EMS',
                'Your login and password to EMS system:',
                [$fields['email'], $fields['password']]));

            return response($response, 201);

        } catch (Exception $e) {
           return response([
                'message' => 'Can not create user',
                'error' => $e], 401);
        }

    }

    /**
     * After login returns personal user token.
     * After 3 login attempts login is blocked for 2 minutes.
     *
     * @param Request $request
     * @return Response user and token
     */
    public function login(Request $request): object
    {
        // $attempts = config('setup.lock_params.attempts');   //number of attempts before lock
        // $time = config('setup.lock_params.time');           //time to wait in minutes
        // $redis = Redis::connection('rconn');

        $fields = $request->validate([
            'email' => 'required|string|max:250',
            'password' => 'required|string|max:250'
        ]);

        // // check if there aren't too many login attempts with this email
        // if ($redis->exists($fields['email'])) {
        //     $user_login_data = json_decode($redis->get($fields['email']));
        //     if ($user_login_data[0] >= $attempts and (time() - $user_login_data[1]) <= (60 * $time)) {
        //         $time_to_wait = ceil($time - (time() - $user_login_data[1]) / 60);

        //         return response([
        //             'message' => ('Too many failed login attempts. Wait ' . $time_to_wait . ' minutes.')
        //         ], 403);

        //     } elseif ((time() - $user_login_data[1]) > (60 * $time)) {
        //         $redis->del($fields['email']);
        //     }
        // }

        $user = User::where([
            ['email', $fields['email']],
            ['password', PasswordHelper::hashPassword($fields['password'])],
        ])->first();

        if (!$user) {
        //     // saving data about failed login attempt
        //     if ($redis->exists($fields['email'])) {
        //         $user_login_data = json_decode($redis->get($fields['email']));
        //         $user_login_data[0]++;
        //         $user_login_data[1] = time();
        //         $redis->set($fields['email'], json_encode($user_login_data));
        //     } else {
        //         $user_login_data = array(1, time());
        //         $redis->set($fields['email'], json_encode($user_login_data));
        //     }
        //     if ($user_login_data[0] >= $attempts) {
        //         return response([
        //             'message' => ('Incorrect email or password. Try again after ' . $time . ' minutes.')
        //         ], 401);
        //     } else {
                return response([
                    'message' => ('Incorrect email or password.')
                ], 401);
            };
        // }
        // //after successful login clear login attempt counter
        // $redis->del($fields['email']);

        
        $token = $user->createToken('emc')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'message' => 'Login successful'
        ];

        return response($response, 201);
    }

    /**
     * With logout delete all user bearer tokens.
     *
     * @return object
     */
    public function logout(): object
    {
        auth()->user()->tokens()->where('tokenable_id', Auth::id())->delete();

        return response([
            'message' => 'Logged out.'
        ], 200);
    }

    /**
     * Only for EMS admins.
     * Update EMS user password and admin permission.
     *
     * @param Request $request
     * @return Response
     */
    public function updateUser(Request $request)
    {
        if (!auth()->user()->is_admin) {
            return response(['message' => 'permit deny'], 403);
        }

        try {
            User::where('id', $request->id)
                ->when($request->has('email'), function ($query) use ($request) {
                    $query->update(['email' => $request->email]);
                })
               ->when($request->has('first_name'), function ($query) use ($request) {
                    $query->update(['first_name' => $request->first_name]);
                })
                ->when($request->has('last_name'), function ($query) use ($request) {
                    $query->update(['last_name' => $request->last_name]);
                })
                ->when($request->has('password'), function ($query) use ($request) {
                    $query->update(['password' => PasswordHelper::hashPassword($request->password)]);
                })
                ->when($request->has('is_admin'), function ($query) use ($request) {
                    $query->update(['is_admin' => $request->is_admin]);
                });
                

            $user = User::find($request->id);
            if (isset($request->password)) {
                $user->notify(new NotifyUser(
                    'Your EMS data has been updated',
                    'Your new password to EMS system: ' . $request->password));
            }

            return response([
                'user' => $user,
                'message' => 'User data updated'
            ], 200);

        } catch (Exception $e) {
            return response([
                'message' => 'Can not update user data'
            ], 401);
        }


    }

    /**
     * Only for EMS admins.
     * Delete EMS user.
     *
     * @param Request $request
     * @return Response
     */
    public function deleteUser(Request $request): object
    {
        if (!auth()->user()->is_admin) {
            return response(['message' => 'permit deny'], 403);
        }

        try {
            User::destroy($request->id);

            return response([
                'user' => $request->id,
                'message' => 'User deleted'
            ], 200);

        } catch (Exception $e) {
           
            return response([
                'message' => 'Can not delete user'
            ], 403);
        }
    }
}