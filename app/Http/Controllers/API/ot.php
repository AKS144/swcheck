<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ot extends Controller
{<?php

    namespace App\Http\Controllers\API;

    use App\User;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Route;


    class UserController extends Controller
    {

        public function __construct()
        {
            $this->middleware('auth:api');
        }

        public function index()
        {
            $this->authorize('isAdmin');
            return User::latest()->paginate(5);
        }


        public function create()
        {
            //
        }


        public function store(Request $request)
        {
            $this->validate($request,[
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:users',
                'password' => 'required|string|min:6'
            ]);

            return User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'type' => $request['type'],
                'bio' => $request['bio'],
                'photo' => $request['photo'],
                'password' => Hash::make($request['password']),
            ]);
        }


        public function show($id)
        {
            //
        }


        public function edit($id)
        {
            //
        }

        public function update(Request $request, $id)
        {

            $user = User::findOrFail($id);
            $this->validate($request,[
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
                'password' => 'sometimes|min:6'
            ]);
            $user->update($request->all());
            return ['message' => 'Updated the user info'];
        }

        public function updateProfile(Request $request, $id)
        {
           /* $user = auth('api')->user();
            $this->validate($request,[
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
                'password' => 'sometimes|required|min:6'
            ]);

            $currentPhoto = $user->photo;

            if($request->photo != $currentPhoto){
                $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

                \Image::make($request->photo)->save(public_path('img/profile/').$name);
                $request->merge(['photo' => $name]);

                $userPhoto = public_path('img/profile/').$currentPhoto;
                if(file_exists($userPhoto)){
                    @unlink($userPhoto);
                }
            }

            if(!empty($request->password)){
                $request->merge(['password' => Hash::make($request['password'])]);
            }
            $user->update($request->all());
            return ['message' => "Success"];*/
        }

        public function profile()
        {
            return auth('api')->user();
        }


        public function destroy($id)
        {
            $this->authorize('isAdmin');
            $user = User::findOrFail($id);
            // delete the user
            $user->delete();
            return ['message' => 'User Deleted'];
        }

        public function search(){

            if ($search = \Request::get('q')) {
                $users = User::where(function($query) use ($search){
                    $query->where('name','LIKE',"%$search%")
                            ->orWhere('email','LIKE',"%$search%");
                })->paginate(20);
            }else{
                $users = User::latest()->paginate(5);
            }
           return $users;
        }
    }

    //
}
