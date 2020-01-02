<?php namespace App\Http\Controllers\Administrador;


use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralController;
use App\Http\Models\Cats\CatProfile;
use App\Http\Models\Transaction;
use App\User;
use DB;

use Exception;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = $request->all();

            $users = User::with('profile')
                ->search($data['search'])
                ->where('isActive', true)
                ->orderBy('cat_profile_id', 'DESC')
                ->paginate($data['perPage']);

            return response()->json([
                'users'   => $users,
                'success' => true
            ]);

        }
        catch ( Exception $e ) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        try {
            $user = User::find(decrypt($id));
            $profiles = CatProfile::where('isActive', 1)->get(['id', 'name']);

            $userform = [
                'cat_profile_id'  => $user->cat_profile_id,
                'name'            => $user->name,
                'firstName'       => $user->firstName,
                'secondName'      => $user->secondName
            ];

            return response()->json([
                'profiles'  => $profiles,
                'userForm'  => $userform,
                'success'   => true
            ]);

        }
        catch ( Exception $e ) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $user = User::find(decrypt($id));

            $user->fill($request->all());
            $user->save();


            GeneralController::saveTransactionLog(3, 'Edita al usuario: ' . $user->username);

            DB::commit();

            return response()->json([
                'success' => true
            ], 200);
        }
        catch ( Exception $e ) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

}
