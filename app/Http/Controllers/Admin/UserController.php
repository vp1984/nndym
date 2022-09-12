<?php
/**
 * Module Master Module
 * Manage CRUD for the Module
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Role;
use App\Models\Country;
use App\Models\States;
use App\Models\City;
use App\Library\Common;
use Excel;
use Illuminate\Http\Request;
use Lang;
use Session;
use Validator;
use Hash;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->objModel = new User;
        Common::defineDynamicConstant('user');
    }
    /**
     * Default Method for the controller
     * List of the Module
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function index(Request $request)
    {
        return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
    }
    /**
     * Create User using this method
     * Add user
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {   
        $dbrole = new Role;
        $arrRole = $dbrole->getAll();        
        $messages = [
                'name.required' => 'Please specify Name',
                'name.unique' => 'Name already exists',
                'name.regex' => 'Name cannot have character other than a-z AND A-Z',
            ];
        
        $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:modules,name,1,deleted',
            ];
        $arrFile = array('name'=>'profile_photo','type'=>'image','resize'=>'50','path'=>'images/users/', 'predefine'=>'', 'except'=>'file_exist');
        if ($request->isMethod('post')) {
            $request->merge(["password"=>Hash::make(trim($request->password))]);
            if(is_array($request->role_id)){
                $request->merge(["role_id"=>join(',',$request->role_id)]);
            }
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, $arrFile);
        }
        return view(RENDER_URL.'.add', compact('arrRole'));
    }
    /**
     * Edit User using this method
     * Update user
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function edit(Request $request, $id = null)
    {
        $dbrole = new Role;
        $arrRole = $dbrole->getAll();        
        $data = $this->objModel->getOne($id);
        if (isset($data) && !empty($data)) {
            $messages = [
                'name.required' => 'Please specify Name',
                'name.unique' => 'Name already exists',
                'name.regex' => 'Name cannot have character other than a-z AND A-Z',
               
            ];

            $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:users,name,'.$request->id.',id,deleted,0',
              
            ];
            $arrFile = array('name'=>'profile_photo','type'=>'image','resize'=>'50','path'=>'images/users/', 'predefine'=>'', 'except'=>'file_exist','existing'=>$data->profile_photo);
            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                $request->merge(["role_id"=>join(',',$request->role_id)]);
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, $arrFile);
            }
            return view(RENDER_URL.'.edit', compact('data','arrRole','arrFile'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * View User using this method
     * View user and override user specific role
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function view(Request $request, $id = null)
    {
        $dbUsers = new User;
        $userDetails = $dbUsers->getOne($id);
        $dbRoles = new Role;
        $roles = $dbRoles->getAll();
        $moduelsRights = $dbUsers->getModules();
        if(isset($userDetails) && !empty($userDetails)){
            if($request->isMethod('post') && isset($id) && !empty($id)){
                $data = $request->input();
                $arrUpdate['rights'] = join(",",$data['rights']);
                $dbUsers->where('id',$id)->update($arrUpdate);

                return redirect('/admin/user/view/'.$id)->with('flash_message_success8', 'Module Permission updated successfully');
            }
            return view('admin.user.view', compact('userDetails','roles','moduelsRights'));
        }else{
            return redirect('/admin/user')->with('flash_message_error8', 'Invalid argument supplied');
        }
    }
	/**
	 * Delete user using this method
	 * Remove user by checking dependancy
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function delete(Request $request)
    {
		$arrTableFields = array();
        return Common::commanDeletePage($this->objModel, $request);
    }
    /**
     * Toggle Module using this method
     * Active/InActive module status
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function toggleStatus(Request $request)
    {
        return Common::commanTogglePage($this->objModel, $request, $arrTableFields);
    }
    /**
     * Export Module using this method
     * export module with all data
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function export(Request $request)
    {
        $arrHeading = array('Module Name', 'Status');
        return Excel::download(new MainExport(MODELNAME, $arrHeading), 'module.xlsx');
    }
	/**
     * Retrive User Profile using this method
     * Get user profile
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function myprofile(Request $request, $id = null)
    {
        $dbrole = new Role;
        $arrRole = $dbrole->getAll();
        $data = $this->objModel->getOne($id);
        if (isset($data) && !empty($data)) {
            $messages = [
                'name.required' => 'Please specify User Name',
                'name.unique' => 'User Name already exists',
                'name.regex' => 'User Name cannot have character other than a-z AND A-Z',
            ];

            $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:users,name,'.$request->id.',id,deleted,0',
            ];
            $arrFile = array('name'=>'profile_photo','type'=>'image','resize'=>'50','path'=>'images/users/', 'predefine'=>'', 'except'=>'file_exist');
            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                 Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, $arrFile);
                 return redirect('admin/myprofile/'.$id.'');
            }
            return view(RENDER_URL.'.profile', compact('data', 'arrRole','arrFile'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Update User Password using this method
     * Change user password
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function changepassword(Request $request, $id = null)
    {
        if ($id == Session::get('id')) {
            $data = $this->objModel->getOne($id);
            
            if (isset($data) && !empty($data)) {
                if ($request->isMethod('post') && isset($id) && !empty($id)) {
                    $messages = [
                        'current_password.required' => 'Please enter Current Password',
                        'password.required' => 'Please enter New Password',
                        'password_confirmation.required' => 'Please Confirm New Password',
                    ];
                    $validator = Validator::make($request->all(), [
                        'current_password' => 'required',
                        'password' => 'required',
                        'password' => 'required |same:password_confirmation',
                        'password_confirmation' => 'required',
                    ], $messages);
                
                    if ($validator->fails()) {
                        $msg = $validator->errors()->all();
                        $msg = implode('<br>', $msg);
                        Session::flash('flash_error', $msg);
                    } else {
                        if (trim($request->current_password) != trim($request->password)) {
                            if (Hash::check(trim($request->current_password), trim($data->password))) {
                                $user_id = Auth::User()->id;
                                $obj_user = User::find($user_id);
                                $obj_user->password = Hash::make(trim($request->password));
                                $obj_user->save();
                                Session::flash('flash_message_success', Lang::get('common_message.correct_current_pwd', [MODULE_NAME => MODELNAME]));
                            } else {
                                Session::flash('flash_error', Lang::get('common_message.correct_current_pwd', [MODULE_NAME => MODELNAME]));
                            }
                        } else {
                            Session::flash('flash_error', Lang::get('common_message.correct_new_match', [MODULE_NAME => MODELNAME]));
                        }
                    }
                }
                return view(RENDER_URL.'.changepassword', compact('data'));
            } else {
                return redirect('admin/myprofile/'.Session::get('id'))->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
            }
        } else {
            return redirect('admin/myprofile/'.Session::get('id'))->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Get User Rights using this method
     * Retrive user rights
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function getRights(Request $request){
        $data = $request->input();
        $dbRoles = new Role;
        $roleId = $data['role_id'];
        $roleDetails = $dbRoles->getOne($roleId);
		$dbModules = new User;
        $moduelsRights = $dbModules->getModules();
        $html = '<div class="card"><div class="card-body"><h4 class="card-title">Module Permission</h4><div class="card m-b-0 no-border"><div class="col-md-12"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="checkAll"><label class="custom-control-label" for="checkAll">Check / Uncheck Permission</label></div><div class="row row-eq-height">';
		if(isset($moduelsRights) && !empty($moduelsRights)):
            $arrModules = array();
			foreach($moduelsRights as $key => $val):
				if($key== 0){
					$preModules = $val->modulesName;
				}else{
					$preModules = $moduelsRights[$key-1]->modulesName;
					if($preModules != $val->modulesName){
						$html .= '</div></div></div></fieldset></div>';
					}
				}
                if(!in_array($val->modulesName,$arrModules)):
                    $modulesName = str_replace(' ', '_', $val->modulesName);
					$html .= '<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 col-container m10" id="heading-'.$key.'" ><div class="card-header col bdr-full"><fieldset class="group"> <legend><div class="custom-control custom-checkbox bdr"><input type="checkbox" class="checkAllByModule custom-control-input" id="'.$modulesName.'"><label class="custom-control-label header" for="'.$modulesName.'">'. $val->modulesName.'</label></div></legend>';
				endif;
				if(!in_array($val->modulesName,$arrModules)):
					/*if($key == 0):
						$html .= '<div id="collapse-'.$key.'" class="multi-collapse  collapse  show" style=""><div class="card-body widget-content">';
					else:*/
						$html .= '<div id="'.$key.'" class="" style="padding-bottom:20px;"><div class="card-body widget-content">';
					/*endif;*/
					$arrModules[] = $val->modulesName;
				endif;
				$html .= '<div class="col-md-6" style="float:left"><div class="custom-control custom-checkbox">';
                $modulesName = str_replace(' ', '_', $val->modulesName);
                if(isset($data['id']) && !empty($data['id'])){
                    $dbUsers = new User;
                    $id = $data['id'];
                    $userRoleDetails = $dbUsers->getOne($id);
                    if(isset($userRoleDetails->rights) && !empty($userRoleDetails->rights)):
						$existRights = explode(",",$userRoleDetails->rights);
                    else:
                        $existRights = explode(",",$roleDetails->rights);
					endif;
				}else{	
					$existRights = explode(",",$roleDetails->rights);
                }
                if(in_array($val->rightsId,$existRights)):
					$html .= '<input type="checkbox" checked class="checkbox custom-control-input '.$modulesName.'" id="rights-'.$key.'" name="rights[]" value="'.$val->rightsId.'">';
				else:
					$html .= '<input type="checkbox" class="checkbox custom-control-input '.$modulesName.'" id="rights-'.$key.'" name="rights[]" value="'.$val->rightsId.'">';
				endif;
					$html .= '<label class="custom-control-label" for="rights-'.$key.'">'.$val->rightsName.'</label></div></div>';
			endforeach;
		endif;
		$html .= '</div></div></div></div></div>';
        $arrResult['result'] = $html;
		echo json_encode($arrResult);die;
    }
	/**
     * Get State using this method
     * Fetch State
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function getStates(Request $request) 
    {
        $dbStates  = new States;
        $state = $dbStates->getStateByCountryId($request->countryId);
        return response()->json($state);   
    }
	/**
     * Get City using this method
     * Fetch City
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function getCities(Request $request) 
    {
        $dbCities  = new City;
        $cities = $dbCities->getCityByStateId($request->stateID);
        return response()->json($cities);   
    }
}
