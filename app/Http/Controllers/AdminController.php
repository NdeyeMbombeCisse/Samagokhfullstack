<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    // function __construct()
    // {
    //      $this->middleware('permission:admin-list|admin-create|admin-edit|admin-delete', ['only' => ['index','show']]);
    //      $this->middleware('permission:admin-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:admin-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:admin-delete', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 10);
        $data = User::with('roles')->latest()->paginate($perPage);
  
        return response()->json($data);
    }

    //Inscrire un Maire sur le platforme
       public function store(StoreUserRequest $request)
       {
           $user = new User();
       $user->fill($request->validated());
   
       if ($request->hasFile('photo')) {
           $photo = $request->file('photo');
           $user->photo = $photo->store('users', 'public');
       }
   
       $user->password = Hash::make($request->password);
       $user->save();
   
       // Attribuer le rôle "user"
       $userRole = Role::findByName('maire');
       $user->assignRole($userRole);
   
       return response()->json([
           'status' => true,
           'message' => 'User registered successfully and assigned user role',
           'data' => [
               'user' => $user,
               'photo' => $user->photo
           ]
       ], 201);
       }
    

    public function destroy($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}