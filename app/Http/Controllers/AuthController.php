<?php
  
namespace App\Http\Controllers;
  
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Validator;
use Illuminate\Http\Request;
  
  
class AuthController extends Controller
{
 
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'adresse' => 'required|string',
            'tel' => 'required|string',
            'date_naissance' => 'required|string',
            'sexe' => 'required|string',
            'image' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
        ]);
  
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
  
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt(request('password'))]
                ));
  
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
   

    public function assignRole(Request $request, $userId)
    {
    //     $user = User::findOrFail($userId);
    //     $role = Role::findOrFail($request->role_id);

    //     // Ajouter le rôle à l'utilisateur s'as  pas ce role avec try catch 
    //     if ($user->roles->contains($role->id)) {
    //         return response()->json(['message' => 'Role already assigned'],400 );
            
    //     }
    //    else{
           
    //     $user->roles()->attach($role->id);  
    //     }
    //     return response()->json(['message' => 'Role assigned successfully'], 200);
    $user = User::find($userId);
    if (!$user) {
        return response()->json(['error' => 'Utilisateur non trouvé'], 404);
    }

    $role = Role::find($request->role_id);
    if (!$role) {
        return response()->json(['error' => 'Rôle non trouvé'], 404);
    }

    // Vérifie directement dans la base de données si le rôle est déjà assigné
    if ($user->roles()->where('role_id', $role->id)->exists()) {
        return response()->json(['message' => 'Rôle déjà assigné'], 400);
    }

    // Assigne le rôle à l'utilisateur
    $user->roles()->attach($role->id);
    return response()->json(['message' => 'Rôle assigné avec succès'], 200);
        
    }

    public function removeRole(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $role = Role::findOrFail($request->role_id);

        // Retirer le rôle de l'utilisateur
        $user->roles()->detach($role->id);

        return response()->json(['message' => 'Rôle retiré avec succès'], 200);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
  
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
  
        return $this->respondWithToken($token);
    }
  
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
  
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
  
        return response()->json(['message' => 'Successfully logged out']);
    }
  
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
  
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}