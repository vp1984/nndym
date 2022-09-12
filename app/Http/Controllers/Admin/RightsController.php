<?php
/**
 * Rights Master Rights
 * Manage CRUD for the Rights
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use App\Models\Rights;
use App\Models\Module;
use Common;
use Excel;
use Illuminate\Http\Request;
use Session;
use Validator;
use Lang;

class RightsController extends Controller
{
    public function __construct()
    {
        $this->objModel = new Rights;
        Common::defineDynamicConstant('rights');
    }
    /**
     * Default Method for the controller
     * List of the Rights
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
     * Create Rights using this method
     * Add module
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {
        $dbModule = new Module;
        $arrModules = $dbModule->getAll('name');

        $messages = [
                'module_id.required' => 'Please select Module Name',
                'name.required' => 'Please specify Rights',
                'name.regex' => 'Name cannot have character other than a-z AND A-Z',
                'name.unique' => 'Rights already exists for selected Module',
                'routes.required' => 'Please specify Route'
            ];
        
        $regxvalidator = [
                'module_id' => 'required',
                'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:rights,name,1,deleted,module_id,'.$request->module_id,
                'routes' => 'required',
            ];

        
        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator);
        }
        return view(RENDER_URL.'.add', compact('arrModules'));
    }
    /**
     * Edit Rights using this method
     * Update module
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function edit(Request $request, $id = null)
    {
        $dbModule = new Module;
        $arrModules = $dbModule->getAll();
        $data = $this->objModel->getOne($id);

        if (isset($data) && !empty($data)) {
            $messages = [
                'module_id.required' => 'Please select Module Name',
                'name.required' => 'Please specify Rights',
                'name.regex' => 'Name cannot have character other than a-z AND A-Z',
                'name.unique' => 'Rights already exists for selected Module',
                'routes.required' => 'Please specify Route',
             ];

            $regxvalidator = [
                'module_id' => 'required',
                'name' => 'required|regex:/^[a-zA-Z ]*$/ | unique:rights,name,'.$request->id.',id,deleted,0,module_id,'.$request->module_id,
                'routes' => 'required',
            ];

            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id);
            }
            return view(RENDER_URL.'.edit', compact('data', 'arrModules'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Delete Rihgts using this method
     * Remove rihgts by checking dependancy
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
     * Toggle Rights using this method
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
