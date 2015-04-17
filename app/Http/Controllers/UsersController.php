<?php namespace App\Http\Controllers;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserSignupRequest;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller {

	/**
	 * Display a listing of the resource.
	 * GET /users
	 *
	 * @return Response
	 */
    
        public function __construct(User $user) {
//            $this->middleware('auth', ['except' => ['create','store']]);
//            $this->middleware('role', ['only' => ['index']]);
            $this->user = $user;
        }
	public function index()
	{
//            return "USERS";
            return $this->user->all();
//            return view('users.index', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /users/create
	 *
	 * @return Response
	 */
	public function create()
	{
//            return view('users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /users
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
//            return $this->user->rules;
            $v = Validator::make($request->all(), $this->user->rules);

            if ($v->fails()) {
                return $v->errors()->all();
            }
//            if($this->validate($request, $this->user->rules)->fails()){
//                return "FAILED";
//            }
//            $this->validate($request, [
//                'fname' => 'required|max:255',
//                'lname' => 'required',
//            ]);
            $this->user->fill($request->all());
            return $this->user;
//            return $request->all();
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
            return User::findOrFail($id);
	}
        
        public function get_posts($id){
            return User::findOrFail($id)->posts;
        }

	/**
	 * Show the form for editing the specified resource.
	 * GET /users/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
        
        public function posts($id){
            $user = User::find($id);
            $posts = $user->posts;
            return $posts;
        }

}