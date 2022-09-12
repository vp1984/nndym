<?php
/**
 * MenuTypes Master Module
 * Manage CRUD for the MenuTypes
 *
 * @author ATL
 * @since Jan 2020
*/
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MenuTypes;
use App\Models\Menu;
use Validator;
use Common;
use Session;
use DB;
class MenuTypesController extends Controller
{
    public function __construct()
    {
        $this->objModel = new MenuTypes;
        Common::defineDynamicConstant('menu-types');
    }
	/**
	 * Default Method for the controller
	 * List of the MenuTypes
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function index(Request $request){
        return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
    }
	/**
	 * Create MenuTypes using this method
	 * Add module
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function add(Request $request){
        $messages = [
            'name.required' => 'Please specify Menutype Name',
            'name.unique' => 'Menutype Name already exists',
            'name.regex' => 'Menutype Name cannot have character other than a-z AND A-Z',
        ];
    
        $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:menu_types,name,1,deleted',
            ];

        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator);
        }
        
        return view(RENDER_URL.'.add');
    }
	/**
	 * Edit MenuTypes using this method
	 * Update module
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function edit(Request $request, $id = null){
        $data = $this->objModel->getOne($id);

        if (isset($data) && !empty($data)) {
            $messages = [
                'name.required' => 'Please specify Menutype Name',
                'name.unique' => 'Menutype Name already exists',
                'name.regex' => 'Menutype Name cannot have character other than a-z AND A-Z',
            ];

            $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:menu_types,name,'.$request->id.',id,deleted,0',
            ];
            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id);
            }
            return view(RENDER_URL.'.edit', compact('data'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Delete Menutype using this method
     * Remove menutype by checking dependancy
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
     * Toggle Gift using this method
     * Active/InActive gift status
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
	/**
     * Reorder using this method
     * Change order of the menu items and their parent child relationship
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
	public function orderMenuTypes(Request $request, $id = null){
        $dbMenus = new Menu;
        $dbMenuTypes = new MenuTypes;
        $menuTypeDetails = $dbMenuTypes->getOne($id);
        $nLevelMenus = Common::nLevelMenuHTML(0,1,$id , 'ol');
        if(isset($nLevelMenus) && !empty($nLevelMenus)){
            if($request->isMethod('post') && isset($id) && !empty($id)){
                $data = $request->input();
                $arrReorder = json_decode($data['reorder']);
                if(isset($arrReorder) && !empty($arrReorder)){
                    $arrayReorder = Common::pushParentInChildren($arrReorder);
                    Common::iterateRecursiveMenuOrder($arrayReorder);
                }
                return redirect('/admin/menu-types')->with('flash_message_success13', 'Menu reordered successfully');
            }
            return view('admin.menu-types.order', compact('menuTypeDetails','nLevelMenus'));
        }else{
            return redirect('/admin/menu-types')->with('flash_message_error13', 'Invalid argument supplied');
        }
    }
}