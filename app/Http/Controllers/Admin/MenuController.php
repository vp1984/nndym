<?php
/**
 * Menu Master Menu
 * Manage CRUD for the Menu
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Rights;
use Common;
use Excel;
use Illuminate\Http\Request;
use Session;
use Validator;
use Lang;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->objModel = new Menu;
        Common::defineDynamicConstant('menu');
    }
    /**
     * Default Method for the controller
     * List of the Menu
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
     * Create Menu using this method
     * Add Menu
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {
        $dbRights = new Rights;
        $rightModules = $dbRights->getAll('rights.name');
        
        $nLevelMenus = Common::fetchMenuTree();

        $messages = [
                'name.required' => 'Please specify Menu Name',
                'name.unique' => 'Menu Name already exists',
                'name.regex' => 'Menu Name cannot have character other than a-z, A-Z AND -',
                'ordering.numeric' => 'ordering cannot have character other than numeric'
            ];
        
        $regxvalidator = [
                'name' => 'required|regex:/^[a-zA-Z&\- ]*$/ | unique:menus,name,1,deleted',
                'ordering' => 'numeric|nullable',
            ];

        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator);
        }
        return view(RENDER_URL.'.add', compact('rightModules', 'nLevelMenus'));
    }
    /**
     * Edit Menu using this method
     * Update module
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);

        $dbRights = new Rights;
        $rightModules = $dbRights->getAll();
        
        $nLevelMenus = Common::fetchMenuTree();
        
        if (isset($data) && !empty($data)) {
            $messages = [
                'name.required' => 'Please specify Menu Name',
                'name.unique' => 'Menu Name already exists',
                'name.regex' => 'Menu Name cannot have character other than a-z, A-Z AND -',
                'ordering.numeric' => 'ordering cannot have character other than numeric'
        ];

            $regxvalidator = [
            'name' => 'required| regex:/^[a-zA-Z&\- ]*$/ |unique:menus,name,'.$request->id.',id,deleted,0',
            'ordering' => 'numeric|nullable',
        ];

            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id);
            }
            return view(RENDER_URL.'.edit', compact('data','rightModules', 'nLevelMenus'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Delete Menu using this method
     * Remove menu by checking dependancy
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
     * Toggle Menu using this method
     * Active/InActive module status
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
