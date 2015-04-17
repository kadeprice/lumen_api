<?php namespace App;

use \Illuminate\Database\Eloquent\Model;
class User extends Model  {

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['fname', 'lname', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];
        public $rules = [
            'fname' => 'required|min:2',
            'lname' => 'required|min:2',
            'email' => 'required|email',
            'password' => 'required|min:4',
        ];
        
         //Relationships
        public function roles(){
            return $this->belongsToMany('\Classifieds\Role');            
        }
        
        public function posts(){
            return $this->hasMany('\App\Post');
        }
        
         //Roles
        public function hasRole($name){
            foreach($this->roles as $role){
                if($role->role == $name) return TRUE;
            }           
            return false;
        }
        
        public function assignRole($role){
            return $this->roles()->attach($role);
        }
        
        public function removeRole($role){
            return $this->roles()->detach($role);
        }
        
        public function showRoles(){            
            $roleName=array();
            foreach($this->roles as $role){
                $roleName[]=$role->role;
            }            
            return $roleName;
        }
        
        
        public function setPasswordAttribute($pass){
            $this->attributes['password'] = \Illuminate\Support\Facades\Hash::make($pass);
        }
        

}
