<?php
/**
 * Website Master Website
 * Manage CRUD for the Website
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Common;
use Illuminate\Http\Request;
use Lang;

class WebsiteController extends Controller
{
    public function __construct()
    {   
        $this->objModel = new Website;
        Common::defineDynamicConstant('website');
    }
    /**
     * Default Method for the controller
     * List of the Website
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
     * Create Website using this method
     * Add website
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {
        $messages = [
                'name.required' => 'Please enter name',
                'name.regex' => 'Member cannot have character other than a-z AND A-Z and special character.',
                'name.unique' => 'Member already exists',
                'image.required' => 'Please specify Photo Image',
                'image.mimes' => 'Invalid File Extension. The supported file extensions is .png',
                'image.max' => 'File size should be less than 1 MB',
                //'designation_id.required' => 'Please select Designation',
                'website.required' => 'Please enter website',
            ];
        
        $regxvalidator = [
            'name' => 'required | regex:/^[a-zA-Z0-9 ?!@#\$%\^\&*\)\(+=._-]*$/ | unique:website,name',
                'image' => 'required|max:1024',
                //'designation_id' => 'required',
                'website' => 'required',                
            ];
        $arrFile = array('name'=>'img','type'=>'image','resize'=>'150','path'=>'images/website/', 'predefine'=>'', 'except'=>'image_exist');
        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, $arrFile);
        }
        return view(RENDER_URL.'.add', compact([]));
    }
    /**
     * Edit Website using this method
     * Update website
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);
        if (isset($data) && !empty($data)) {
            $messages = [
                'name.required' => 'Please specify Website',
                'name.regex' => 'Website cannot have character other than a-z AND A-Z and special character.',
                'name.unique' => 'Website already exists',
                'image.required' => 'Please specify Photo Image',
                'image.mimes' => 'Invalid File Extension. The supported file extensions is .png',
                'image.max' => 'File size should be less than 1 MB',
                //'designation_id.required' => 'Please select Designation',
                'website.required' => 'Please entery Website',                
            ];
        
        $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z0-9 ?!@#\$%\^\&*\)\(+=._-]*$/ | unique:website,name,'.$data->id.',id',
                'image' => 'required_if:id,null|max:1024',
                //'designation_id' => 'required',
                'website' => 'required',                
            ];
            $arrFile = array('name'=>'img','type'=>'image','resize'=>'150','path'=>'images/website/', 'predefine'=>'', 'except'=>'image_exist', 'existing'=>$data->img);
            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, $arrFile);
            }
            return view(RENDER_URL.'.edit', compact('data','arrFile'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
	 * Delete Website using this method
	 * Remove website by checking dependancy
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function delete(Request $request)
    {
		$arrTableFields = array();
        return Common::commanDeletePage($this->objModel, $request, $arrTableFields);
    }
    /**
     * Toggle Website using this method
     * Active/InActive website status
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function toggleStatus(Request $request)
    {
        return Common::commanTogglePage($this->objModel, $request);
    }
}
