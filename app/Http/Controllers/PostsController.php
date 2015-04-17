<?php

namespace App\Http\Controllers;
use App\Post;
use App\User;
use App\Categories;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller {
    
        /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Post $post)
	{
		$this->middleware('auth', ['except' => ['index','show','category']]);
                $this->post = $post;
	}
        

	/**
	 * Display a listing of posts
	 *
	 * @return Response
	 */
	public function index()
	{
            $posts = Post::approvedPosts();
            return $posts;
	}

	/**
	 * Show the form for creating a new post
	 *
	 * @return Response
	 */
	public function create(\Illuminate\Http\Request $request)
	{
            $key = $request->only('category');
            if($key == "") $key = "for-sell";
            $category = Categories::whereKey($key)->first();
            return view('posts.create', compact("category"));
	}

	/**
	 * Store a newly created post in storage.
	 *
	 * @return Response
	 */
	public function store(\Illuminate\Http\Request $request)
	{
            $this->validate($request, $this->post->rules);
            
//            if($request->hasFile('file1')){
//                foreach ($request->file() as $file)
//                {
//                    echo $file->getClientOriginalName()."<br/>";
//                }
//            }
//            return "AWESOME";
           
            $post = new Post($request->all());
            $post->active = 1;
            Auth::user()->posts()->save($post);
            if($request->hasFile('file1')){
                $this->post->uploadImage($request->file(),$post->id); 
            } 
            
            
            flash("Your post has been created.");
            return redirect()->route('post.index');
            
            
	}

	/**
	 * Display the specified post.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$post = Post::findOrFail($id);
                return $post;
	}

	/**
	 * Show the form for editing the specified post.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$post = Post::find($id);
                
                //Verify that they are the owner
                
                if(!$post->user_id == Auth::id()) return response('Unauthorized.', 401);
//                return view('posts.create', compact('post'));
                $category = Categories::find($post->category_id);
                return view('posts.create', compact(['post',"category"]));
	}

	/**
	 * Update the specified post in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(\Illuminate\Http\Request $request, $id)
	{
            $this->validate($request, $this->post->rules);
            $post = Post::findOrFail($id);
            $input = $request->all();
            
            if(isset($input['approved'])) $post->approved = true;
            else $post->approved = false;
            
            $post->update($input);
            if($request->hasFile('file1')){
                $this->post->uploadImage($request->file(),$post->id); 
            } 
            flash("Your post has been updated.");
            return \Redirect::route('post.show',$id);
	}

	/**
	 * Remove the specified post from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Post::destroy($id);
                
                flash()->warning("Your post has been deleted.");
		return Redirect::route('posts.index');
	}
        
        /**
         * Shows list of all posts with passed category_id
         * 
         * @param type $id
         * 
         */
        public function category($key){
            $category = Categories::whereKey($key)->first();
            $posts = $category->posts()->whereApproved(true)->whereActive(true)->orderBy('id', 'desc')->get();
            return view('posts.index', compact('posts','category'));
        }
        
        public function approve($id){
            if( Post::approve($id) ){                
                flash("Your post has been Approved.");
                return \Redirect::back();
            }else return response('Unauthorized.', 401); 
        }
        
        /**
         * Remove the image from the post and delete it in the file.
         */
        public function delete_image(\Illuminate\Http\Request $request){
            $id = $request->only('id');
            $image = \App\Image::find($id['id']);
            
//            return $image;
            unlink(public_path(). "/images/posts/$image->url");
//            $file = new \League\Flysystem();
//            $file->delete();
            
            $image->delete();
            return "true";
        }

}
