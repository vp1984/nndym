<?php
namespace App\Library;

use App\Models\Menu;
use App\Models\Setting;
use App\Models\Module;
use App\Models\Category;
use App\Models\UserDocument;
use App\Models\UserSubscription;
use App\Models\UserPaymentHistory;
use App\Models\Subscription;
use App\User;
use App\Models\TempProfile;
use Illuminate\Support\Facades\Storage;
use Auth;
use DB;
use Excel;
use AWS;
use Session;
use Lang;
use Validator;
use \Eloquent;
use Config;
use ReceiptValidator\iTunes\Validator as iTunesValidator;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\City;
use App\Models\Package;

class Common extends Eloquent
{
    private $excel;
    public function __construct()
    {
        //require_once base_path('vendor/phpmailer/phpmailer/PHPMailerAutoload.php');
        //$this->excel = $excel;
    }
    /**
     * Check weather entry has dependancy with relational table or not
     * In case database has dependancy then it will return true
     * Otherwise return false
     *
     * @param integer $arrTableFields
     * @param integer $pkId
     * @return boolean
     *
     * @author ATL
     * @since Jan 2020
     */
    public static function checkDBDependacy($arrTableFields, $pkId)
    {
        if (isset($arrTableFields) && is_array($arrTableFields) && count($arrTableFields) > 0 && isset($pkId) && !empty($pkId)) {
            foreach ($arrTableFields as $key => $val) {
                if (strpos($key, '_samekey') !== false) {
                    $key = substr($key, 0, strpos($key, '_samekey'));
                }
                if (strpos($pkId, ',') !== false) {
                    $arrResult = DB::select("SELECT count(" . $val . ") as cnt FROM " . $key . " WHERE " . $val . " IN (" . $pkId . ")");
                } else {
                    $arrResult = DB::select("SELECT count(" . $val . ") as cnt FROM " . $key . " WHERE " . $val . "='" . $pkId . "'");
                }
                if (isset($arrResult) && !empty($arrResult) && count($arrResult) > 0 && $arrResult[0]->cnt != 0) {
                    return true;
                }
            }
        }
        return false;
    }
    /**
     * Export Excel
     * Otherwise return false
     *
     * @param integer $arrTableFields
     * @param integer $pkId
     * @return boolean
     *
     * @author ATL
     * @since Jan 2020
     */
    public static function exportExcel($classExport, $fileName)
    {
        return Excel::download($classExport, $fileName);
    }
    /**
     * N-Level Category
     * herarchical category with all data
     *
     * @param integer $parent
     * @param string $category
     *
     * @author ATL
     * @since Jan 2020
     */
    public static function fetchMenuTree($parent = 0, $spacing = '', $userTreeArray = '', $typeId = '')
    {
        if (!is_array($userTreeArray)) {
            $userTreeArray = array();
        }

        $dbMenu = new Menu;
        if (isset($typeId) && !empty($typeId)) {
            $menuList = $dbMenu->where(['deleted' => 0, 'parent_id' => $parent, 'menu_type_id' => $typeId])->orderBy('name', 'asc')->get();
        } else {
            $menuList = $dbMenu->where(['deleted' => 0, 'parent_id' => $parent])->orderBy('name', 'asc')->get();
        }

        if (isset($menuList) && !empty($menuList) && count($menuList) > 0) {
            foreach ($menuList as $key => $val) {
                $userTreeArray[] = array("id" => $val->id, "name" => $spacing . $val->name, "url" => $val->url);
                $userTreeArray = Common::fetchMenuTree($val->id, $spacing . ' - ', $userTreeArray);
            }
        }
        return $userTreeArray;
    }
    /**
    * N-Level Category
    * herarchical category with all data
    *
    * @param integer $parent
    * @param string $category
    *
    * @author ATL
    * @since Jan 2020
    */
    public static function fetchCategoryTree($parent = 0, $spacing = '', $userTreeArray = '', $typeId = '')
    {
        if (!is_array($userTreeArray)) {
            $userTreeArray = array();
        }

        $dbCategory = new Category;
        if (isset($typeId) && !empty($typeId)) {
            $categoryList = $dbCategory->where(['deleted' => 0, 'parent_id' => $parent])->orderBy('name', 'asc')->get();
        } else {
            $categoryList = $dbCategory->where(['deleted' => 0, 'parent_id' => $parent])->orderBy('name', 'asc')->get();
        }

        if (isset($categoryList) && !empty($categoryList) && count($categoryList) > 0) {
            foreach ($categoryList as $key => $val) {
                $userTreeArray[] = array("id" => $val->id, "name" => $spacing . $val->name, "url" => $val->url);
                $userTreeArray = Common::fetchCategoryTree($val->id, $spacing . ' - ', $userTreeArray);
            }
        }
        return $userTreeArray;
    }

    /**
     * N-Level Category UL LI
     * herarchical category with all data
     *
     * @param integer $parent
     * @param string $level
     * @param string $typeId
     * @param string $list
     *
     * @author ATL
     * @since Jan 2020
     */
    public static function nLevelMenuHTML($parent = 0, $level, $typeId = '', $list = 'ul')
    {
        $dbMenu = new Menu;
        if (isset($typeId) && !empty($typeId)) {
            $menuList = DB::select("SELECT * FROM menus LEFT OUTER JOIN (SELECT parent_id, COUNT(*) AS counter FROM menus GROUP BY parent_id) submenus ON menus.id = submenus.parent_id WHERE menus.deleted = 0 AND menus.parent_id = $parent AND menu_type_id = $typeId ORDER BY ordering");
        } else {
            $menuList = DB::select("SELECT * FROM menus LEFT OUTER JOIN (SELECT parent_id, COUNT(*) AS counter FROM menus GROUP BY parent_id) submenus ON menus.id = submenus.parent_id WHERE menus.deleted = 0 AND menus.parent_id = $parent ORDER BY ordering");
        }
        $html = "<" . $list . " class='dd-list'>";
        foreach ($menuList as $keyMenu => $valMenu) {
            if ($valMenu->counter > 0) {
                $html .= "<li data-id='" . $valMenu->id . "' class='dd-item dd3-item '><div class='dd-handle dd3-handle'></div><div class='dd3-content'>" . $valMenu->name . "</div>";
                if (!isset($level)) {
                    $level = 0;
                }
                $html .= Common::nLevelMenuHTML($valMenu->id, $level + 1, $typeId, $list);
                $html .= "</li>";
            } elseif ($valMenu->counter == 0) {
                $html .= "<li data-id='" . $valMenu->id . "' class='dd-item dd3-item'><div class='dd-handle dd3-handle'></div><div class='dd3-content'>" . $valMenu->name . "</div></li>";
            } else {
                ;
            }
        }
        $html .= "</" . $list . ">";
        return $html;
    }
    /**
     * Herarchical category with all data
     *
     * @param integer $arrData
     *
     * @author ATL
     * @since Jan 2020
     */
    public static function iterateRecursiveMenuOrder(&$arrData)
    {
        $dbMenus = new Menu;
        $orderChild = $order = 0;
        foreach ($arrData as $keyArray => &$array) {
            if ($keyArray == 0) {
                $order = 0;
            }

            if (isset($array['children'])) {
                if ($keyArray == 0) {
                    $orderChild = 0;
                }

                Common::iterateRecursiveMenuOrder($array['children']);
                $arrUpdate = array();
                $arrUpdate['ordering'] = $orderChild;
                $arrUpdate['parent_id'] = $array['parent_id'];
                $dbMenus->where('id', $array['id'])->update($arrUpdate);
                $orderChild++;
            }
            $arrUpdate = array();
            $arrUpdate['ordering'] = $order;
            $arrUpdate['parent_id'] = $array['parent_id'];
            $dbMenus->where('id', $array['id'])->update($arrUpdate);
            $order++;
        }
        return;
    }
    /**
     * Push Parent in array if not there
     *
     * @param integer $arrData
     *
     * @author ATL
     * @since Jan 2020
     */
    public static function pushParentInChildren($arrInput, $parent = 0)
    {
        foreach ($arrInput as $key => $value) {
            if (is_numeric($key)) {
                $arrInput = $value;
                $arrOutput[$key] = Common::pushParentInChildren($arrInput, $parent);
            } else {
                $arrOutput[$key] = $value;
                if ($key == "id") {
                    $arrOutput['parent_id'] = $parent;
                    $parent = $value;
                } elseif ($key == "children") {
                    $arrInput = $value;
                    $arrOutput[$key] = Common::pushParentInChildren($arrInput, $parent);
                }
            }
        }
        return $arrOutput;
    }
    /**
     * Slug for Pages using this method
     * Unique Slug page with all data
     *
     * @param string $title
     * @param string $table_name
     * @param string $field_name
     *
     * @author ATL
     * @since Jan 2019
     */
    public static function slug($title, $table_name, $field_name, $primary_field_name = "", $primary_field_value = "")
    {
        $slug = preg_replace("/-$/", "", preg_replace('/[^a-z0-9]+/i', "-", strtolower($title)));
        if (isset($primary_field_name) && !empty($primary_field_name)) {
            $results = collect(\DB::select("SELECT COUNT(*) AS NumHits FROM $table_name WHERE  $field_name  LIKE '$slug%' AND $primary_field_name <>  $primary_field_value"))->first();
        } else {
            $results = collect(\DB::select("SELECT COUNT(*) AS NumHits FROM $table_name WHERE  $field_name  LIKE '$slug%'"))->first();
        }
        return ($results->NumHits > 0) ? ($slug . '-' . $results->NumHits) : $slug;
    }
    /**
     * Slug for Pages using this method
     * Unique Slug page with all data
     *
     * @param string $title
     * @param string $table_name
     * @param string $field_name
     *
     * @author ATL
     * @since Jan 2019
     */
    public static function getLatLong($address)
    {
        if (!empty($address)) {
            //Formatted address
            $formattedAddr = str_replace(' ', '+', $address);
            //Send request and receive json data by address
            $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddr . '&key=' . Session::get('settings')['GOOGLE_API_KEY']);
            $output = json_decode($geocodeFromAddr);
            //Get latitude and longitute from json data
            if (isset($output->results[0]) && !empty($output->results[0])) {
                $data['latitude'] = $output->results[0]->geometry->location->lat;
                $data['longitude'] = $output->results[0]->geometry->location->lng;
            }
            //Return latitude and longitude of the given address
            if (!empty($data)) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    /**
     * Slug for Pages using this method
     * Unique Slug page with all data
     *
     * @param string $title
     * @param string $table_name
     * @param string $field_name
     *
     * @author ATL
     * @since Jan 2019
     */
    public static function getSettings()
    {
        if (empty(Session::get('settings'))) {
            $dbSettings = new Setting;
            $settings = $dbSettings->where(['settings.deleted' => 0])->join('setting_types', 'setting_types.id', '=', 'settings.setting_type_id')->select('settings.*', 'setting_types.name as settingtypes')->get();
            if (isset($settings) && !empty($settings)) {
                $arrSettings = array();
                foreach ($settings as $keySettings => $valSettings) {
                    $arrSettings[$valSettings->name] = $valSettings->value;
                }
                if (isset($arrSettings) && !empty($arrSettings)) {
                    Session::put('settings', $arrSettings);
                }
            }
        }
    }

    /**
     * Set API success response using this method
     * Unique Slug page with all data
     *
     * @param string $message
     * @param string $responseValue
     *
     * @author ATL
     * @since Apr 2019
     */
    public static function respSuccess($msg, $result, $resp_code=200)
    {
        return response()->json([
                'status' => '1',
                'message' => $msg,
                'responseValue' => $result
            ], $resp_code);
    }

    /**
     * Set API failure response using this method
     * Unique Slug page with all data
     *
     * @param string $message
     * @param string $responseValue
     *
     * @author ATL
     * @since Apr 2019
     */
    public static function respError($msg, $result = array(), $resp_code = 400)
    {
        return response()->json([
                'status' => '0',
                'message' => $msg,
                'responseValue' => $result
            ], $resp_code);
    }

    public static function defineDynamicConstant($constmodel)
    {
        define('MODEL', $constmodel);
        define('URL', '/admin/'.MODEL);
        define('MODELNAME', ucfirst(MODEL));
        define('RENDER_URL', 'admin.'.MODEL);
        define('VIEW_INFO', array('url' => URL, 'title' => ucfirst(MODEL)));
        define('FLASH_MESSAGE_SUCCESS', 'flash_message_success');
        define('MODULE_NAME', 'module_name');
        define('FLASH_MESSAGE_ERROR', 'flash_message_error');
        define('COMMON_MSG_INVALID_ARGUE', 'common_message.invalid_argument');
    }

    public static function commanListPage($model, $orderby=null, $where=array(), $dynamicWhere='', $searchData='', $is_globle='', $start='', $limit='')
    {
        $data = $model->getAll($orderby, $where, $dynamicWhere, $start, $limit);
        $totalFiltered = $model->getAll($orderby, $where, $dynamicWhere);
        if ($is_globle) {
            $resp['data'] = $data;
            $resp['recordsTotal'] = count($totalFiltered);
            $resp['recordsFiltered'] = count($totalFiltered);
            return response()->json($resp);
        }        
        return view(RENDER_URL.'.index', compact('data', 'searchData'));
    }

    public static function commanAddPage($objModel, $request, $messages, $regxvalidator, $arrFile=array(), $additopnalOperation=array())
    {
        $validator = Validator::make($request->all(), $regxvalidator, $messages);
        if ($validator->fails()) {
            $msg = $validator->errors()->all();
            $msg = implode('<br>', $msg);
            Session::flash('flash_error', $msg);
            return redirect(URL.'/add')->withInput();
        } else {
            if (isset($arrFile['name']) && !empty($arrFile['name']) && $request->hasFile(str_replace('_exist','',$arrFile['except']))) {
                $img_name = Common::resizeFile($request, $arrFile);
                $request->merge([$arrFile['name']=>$img_name]);
            }
            $request->merge(["created_by"=>Session::get('id')]);
            if (isset($arrFile['except']) && !empty($arrFile['except'])){
                $objModel->insert($request->except(['_token', $arrFile['except'],str_replace('_exist','',$arrFile['except'])]));
            }else{
                $objModel->insert($request->except(['_token']));
            }

            if(isset($additopnalOperation) && !empty($additopnalOperation)){
                $id = DB::getPdo()->lastInsertId();
                $additopnalOperation[$additopnalOperation['pk_id']] = $id;
                $objModel->additionalOperation($additopnalOperation);
            }
            
            return redirect(URL)->with(FLASH_MESSAGE_SUCCESS, Lang::get('common_message.add', [MODULE_NAME => MODELNAME]));
        }
    }

    public static function commanEditPage($objModel, $request, $messages, $regxvalidator, $id, $arrFile=array(), $additopnalOperation=array())
    {
        $validator = Validator::make($request->all(), $regxvalidator, $messages);
               
        if ($validator->fails()) {
            $msg = $validator->errors()->all();
            $msg = implode('<br>', $msg);
            Session::flash('flash_error', $msg);
            return redirect(URL.'/edit/'.$id)->withInput();
        } else {
            if (isset($arrFile['name']) && !empty($arrFile['name']) && $request->hasFile(str_replace('_exist','',$arrFile['except']))) {
                $img_name = Common::resizeFile($request, $arrFile);
                $request->merge([$arrFile['name']=>$img_name]);
            }
            $request->merge(["updated_by"=>Session::get('id')]);
            if (isset($arrFile['except']) && !empty($arrFile['except'])){
                $objModel->updateOne($id, $request->except('_token', $arrFile['except'],str_replace('_exist','',$arrFile['except'])));
            }else{
                $objModel->updateOne($id, $request->except('_token'));
            }
            
            if(isset($additopnalOperation) && !empty($additopnalOperation)){
                $objModel->additionalOperation($additopnalOperation);
            }

            return redirect(URL)->with(FLASH_MESSAGE_SUCCESS, Lang::get('common_message.update', [MODULE_NAME => MODELNAME]));
        }
    }

    public static function commanCopyPage($objModel, $request)
    {
        $data = $request->input();
        $copyDetails = $objModel::find($data['id']);
        if(isset($copyDetails) && !empty($copyDetails)){
            if(isset($data['id']) && !empty($data['id'])){
                $copyData = $copyDetails->replicate();
                $copyData->name = $copyDetails->name.' copy';
                $copyData->save();
                return redirect(URL)->with(FLASH_MESSAGE_SUCCESS, Lang::get('common_message.copy', [MODULE_NAME => MODELNAME]));
            }
        }else{
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }

    public static function commanDeletePage($objModel, $request, $arrTableFields = array())
    {
        $data = $request->input();
        if (strpos($data['id'], 'on,') !== false) {
            $data['id'] = str_replace('on,','',$data['id']);
        }
        $isDependacyExist = Common::checkDBDependacy($arrTableFields, $data['id']);
        if ($request->isMethod('post')) {
            if (isset($isDependacyExist) && !empty($isDependacyExist)) {
                return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get('common_message.not_deleted_dependency'));
            } else {
                $update = array(
                    'deleted' => 1,
                    'deleted_by' => Session::get('id')
                );
                if (strpos($data['id'], ',') !== false) {
                    $objModel->deleteAll($data['id'], $update);
                } else {
                    $objModel->deleteOne($data['id'], $update);
                }
                return redirect(URL)->with(FLASH_MESSAGE_SUCCESS, Lang::get('common_message.delete', [MODULE_NAME => MODELNAME]));
            }
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }

    public static function commanTogglePage($objModel, $request)
    {
        $data = $request->input();
        if ($request->isMethod('post')) {
            $update = array(
                'status' => $data['status'],
                'updated_by' => Session::get('id')
            );
            if (strpos($data['id'], ',') !== false) {
                $objModel->bulkUpdate($data['id'], $update);
            } else {
                $objModel->updateOne($data['id'], $update);
            }

            return redirect(URL)->with(FLASH_MESSAGE_SUCCESS, Lang::get('common_message.toggle_status', [MODULE_NAME => MODELNAME]));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }

    /**
    * Returns all users field name
    *
    * @author ATL
    * @since Jan 2019
    */
    public static function getAllFields($table)
    {
        $raw = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = '".$table."' 
        GROUP BY column_name
        ORDER BY ORDINAL_POSITION";
        return DB::select($raw);
    }

    /**
    * Query build in filter
    *
    * @author ATL
    * @since March 2019
    */
    public static function buildQuery($searchData, $formData, $map = false)
    {
        $keywords = '';
        $fields = '';
        $param ='';
        $mapping = '';
        if (isset($formData) && !empty($formData !='')) {
            $type = explode("|", $formData);
            $arr = $searchData['field'];
            $param .= " 1=1 ";
            if (count($type) >= 1) {
                foreach ($type as $t) {
                    if (isset($t) && !empty($t)) {
                        $keys = explode(":", $t);
                        if (isset($keys) && !empty($keys) && is_array($keys)) {
                            if (in_array($keys[0], array_keys($arr))):
                                    $operatorValue = $keys[1];
                            $operate = Common::searchOperation($operatorValue);
                            if ($operate == 'like') {
                                if ($keys[0] == 'status' && $keys[2] == '2') {
                                    $mapping .= '';
                                } else {
                                    if ($keys[0] == 'mobileNumber') {
                                        $param .= " AND CONCAT('+',countryCode, ' ', mobileNumber) LIKE '%".$keys[2]."%%' ";
                                        $mapping .= $keys[0].' LIKE '.$keys[2]. ' ';
                                    } else {
                                        $param .= " AND ".$keys[0]." LIKE '%".$keys[2]."%%' ";
                                        $mapping .= $keys[0].' LIKE '.$keys[2]. ' ';
                                    }
                                }
                            } elseif ($operate =='is_null') {
                                $param .= " AND ".$keys[0]." IS NULL"." OR ".$keys[0]."=''";
                                $mapping .= $keys[0].' IS NULL ';
                            } elseif ($operate =='not_null') {
                                $param .= " AND ".$keys[0]." IS NOT NULL "." AND ".$keys[0]." !='' ";
                                $mapping .= $keys[0].' IS NOT NULL ';
                            } elseif ($operate =='between') {
                                $param .= " AND (".$keys[0]." BETWEEN '".$keys[2]."' AND '".$keys[3]."' ) ";
                                $mapping .= $keys[0].' BETWEEN '.$keys[2]. ' - '. $keys[3] .' ';
                            } else {
                                if ($keys[0] == 'status' && $keys[2] == '2') {
                                    $mapping .= '';
                                } elseif ($keys[0] == 'mobileNumber') {
                                    $param .= " AND CONCAT('+',countryCode, ' ', mobileNumber) LIKE '%".$keys[2]."%%' ";
                                    $mapping .= $keys[0].' LIKE '.$keys[2]. ' ';
                                } else {
                                    $param .= " AND ".$keys[0]." ".Common::searchOperation($keys[1])." '".$keys[2]."' ";
                                    $mapping .= $keys[0].' '.Common::searchOperation($keys[1]).' '.$keys[2]. '<br />';
                                }
                            }
                            endif;
                        }
                    }
                }
            }
        }
        return $param;
    }

    public static function searchOperation($operate)
    {
        $val = '';
        switch ($operate) {
                case 'equal':
                    $val = '=' ;
                    break;
                case 'bigger_equal':
                    $val = '>=' ;
                    break;
                case 'smaller_equal':
                    $val = '<=' ;
                    break;
                case 'smaller':
                    $val = '<' ;
                    break;
                case 'bigger':
                    $val = '>' ;
                    break;
                case 'not_null':
                    $val = 'not_null' ;
                    break;

                case 'is_null':
                    $val = 'is_null' ;
                    break;

                case 'like':
                    $val = 'like' ;
                    break;

                case 'between':
                    $val = 'between' ;
                    break;

                default:
                    $val = '=' ;
                    break;
            }
        return $val;
    }

    /**
    * Unique field in filter
    *
    * @author ATL
    * @since March 2019
        */
    public static function buildSearchFields($field, $forms = array(), $bulk=false, $value ='')
    {
        $type = '';
        $bulk = ($bulk == true ? '[]' : '');
        $mandatory = '';
        $form ='';
        //dd($field);
        foreach ($forms as $f) {
            // dd($f['lookup_table']);
            if ($field == $f['column_name']) {
                switch ($f['type']) {

                    case 'text':
                        $form = "<input  type='text' name='".$f['column_name']."{$bulk}' class='form-control input-sm' $mandatory value='{$value}'/>";
                        break;
                    case 'textarea':
                        $form = "<input  type='text' name='".$f['column_name']."{$bulk}' class='form-control input-sm' $mandatory value='{$value}'/>";
                        break;
                    case 'text_date':
                        $form = "<input  type='date' name='".$f['column_name']."{$bulk}' class='date form-control input-sm' $mandatory value='{$value}'/> TO ";
                        $form.= "<input  type='date' name='".$f['column_name']."_end"."{$bulk}' class='date form-control input-sm' $mandatory value='{$value}'/> ";
                        break;

                    case 'text_datetime':
                        $form = "<input  type='text' name='".$f['column_name']."{$bulk}'  class='date form-control input-sm'  $mandatory value='{$value}'/> ";
                        break;

                    case 'select':
                        
                        if ($f['lookup-table']) {
                            if ($f['order-by']) {
                                $data = DB::table($f['lookup-table'])->where(['deleted' => 0])->orderBy($f['order-by'], 'desc')->get();
                            } else {
                                $data = DB::table($f['lookup-table'])->where(['deleted' => 0])->orderBy('id', 'desc')->get();
                            }
                            $opts = '';
                            foreach ($data as $row):
                                $selected = '';
                            if (isset($row->{'id'}) && $f['lookup-table'] == 'subscription_plans') {
                                $opts .= "<option $selected value='".$row->{'id'}."' $mandatory > ".$row->{'name'} ."(".$row->{'type'}.") </option> ";
                            } elseif (isset($row->{'id'})) {
                                $opts .= "<option $selected value='".$row->{'id'}."' $mandatory > ".$row->{'name'}." </option> ";
                            } elseif (isset($row->{'level_id'})) {
                                $opts .= "<option $selected value='".$row->{'level_id'}."' $mandatory > ".$row->{'title'}." </option> ";
                            }
                            endforeach;
                            $form = "<select name='".$f['column_name']."{$bulk}'  class='form-control' $mandatory >
                                    <option value=''> -- Select  -- </option>
                                    $opts
                                </select>";
                        } elseif ($f['lookup']) {
                            $opts = '';
                            $data = $f['lookup'];
                            foreach ($data as $row):
                                $selected = '';
                            $opts .= "<option $selected value='".$row['data']."' $mandatory > ".$row['data']." </option> ";
                            endforeach;
                            $form = "<select name='".$f['column_name']."{$bulk}'  class='form-control' $mandatory >
                                    <option value=''> -- Select  -- </option>
                                    $opts
                                </select>";
                        }
                        break;
                    default:
                }
            }
        }
        //dd($form);
        return $form;
    }

    public static function sendSMS($Message, $countryCode, $mobileNumber)
    {
        $sms = AWS::createClient('sns');
    
        $smsresp = $sms->publish([
                    'Message' => $Message,
                    'PhoneNumber' => '+'.$countryCode.$mobileNumber.'',
                    'MessageAttributes' => [
                    'AWS.SNS.SMS.SMSType'  => [
                        'DataType'    => 'String',
                        'StringValue' => 'Transactional',
                     ]
                 ],
                ]);
        return $smsresp['MessageId'];
    }

    public static function sendPush($title, $message, $token, $devicetype)
    {
        $setting  = new Setting;
        $androidArn = $setting->getSettingByName([Config::get('constants.ANDROID_PUSH_ARN')]);
        $iosArn = $setting->getSettingByName([Config::get('constants.IOS_PUSH_ARN')]);

        $platformApplicationArn = '';
        if (isset($devicetype) && $devicetype == 'android') {
            $platformApplicationArn = $androidArn['value'];
        }
        if (isset($devicetype) && $devicetype == 'ios') {
            $platformApplicationArn = $iosArn['value'];
        }

        $sns = AWS::createClient('sns');

        $result = $sns->createPlatformEndpoint(array(
            'PlatformApplicationArn' => $platformApplicationArn,
            'Token' => $token,
        ));
        
        $arn = isset($result['EndpointArn']) ? $result['EndpointArn'] : '';

        $notificationTitle = $title;
        $notificationMessage = $message;
        $data = [
            "type" => "Manual Notification" // You can add your custom contents here
        ];

        $endPointArn = array("EndpointArn" => $arn);

        $endpointAtt = $sns->getEndpointAttributes($endPointArn);

        if ($endpointAtt != 'failed' && $endpointAtt['Attributes']['Enabled'] != 'false') {
            $fcmPayload = json_encode(
                [
                        "notification" =>
                            [
                                "title" => $notificationTitle,
                                "body" => $notificationMessage,
                                "sound" => 'default'
                            ],
                        "data" => $data // data key is used for sending content through notification.
                    ]
                );
            $message = json_encode(["default" => $notificationMessage, "GCM" => $fcmPayload]);
            $sns->publish([
                    'TargetArn' => $arn,
                    'Message' => $message,
                    'MessageStructure' => 'json'
                ]);
        }
    }

    public static function getAge($dateOfBirth)
    {
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        return $age = $diff->format('%y');
    }

    public static function addProfileTemp($dateOfBirth, $request)
    {
        $user = new User();
        $tempProfile = new TempProfile();

        $age = Common :: getAge($dateOfBirth);
        //dd($age);
        if ($age < 18) {
            $request->merge(["user_id"=>auth()->user()->id]);
            $tempProfile->insert($request->all());
                
            $profilestatus['childProfileApprovalStatus'] = 'pending';
            $result = $user->updateOne(auth()->user()->id, $profilestatus);
        }
    }

    public static function getUserHealthReport($user_id)
    {
        $userdoc = new UserDocument();
        $user = new User();

        $updateHealth = $userdoc->getUserHealthReport('', array('user_id'=>$user_id, 'user_documents.deleted'=>'0'));

        foreach ($updateHealth as $key => $value) {
            if ($value['healthReportStatus']=='Positive') {
                $health['healthStatus'] = 'unhealthy';
                break;
            } elseif ($value['healthReportStatus'] == null || $value['healthReportStatus'] == '') {
                $health['healthStatus'] = 'unknown';
                break;
            } else {
                $health['healthStatus'] = 'healthy';
            }
        }
        if (empty($updateHealth)) {
            $health['healthStatus'] = 'unknown';
        }
                
        return $user->updateOne($user_id, $health);
    }

    public static function manageProfileStatus($user_id, $is_suspend=0)
    {
        $userdoc = new UserDocument();
        $user = new User();
        $category = new Category;

        $userData = $user->getOne($user_id);
        
        $applicable_qry = '';
        if ($userData->gender=='Male') {
            $applicable_qry .= ' categories.applicable_for IN ("All","Male") ';
        } elseif ($userData->gender=='Female') {
            $applicable_qry .= ' categories.applicable_for IN ("All","Female") ';
        } else {
            $applicable_qry .= ' categories.applicable_for IN ("All") ';
        }

        /*mandatory category logic is only for std report id.same is applied in mobile side. */
        $whereData = [
            ['categories.status', '1'],
            ['categories.parent_id', '=', '1']
        ];

        $totalUploadDoc = $userdoc->getUserHealthReport('', array('user_id'=>$user_id, 'user_documents.deleted'=>'0'), $applicable_qry);
        $totalRequiredDoc = $category->getAll('', $whereData, $applicable_qry);

        if ($is_suspend==0 && count($totalUploadDoc) > 0) {
            foreach ($totalUploadDoc as $key => $value) {
                if ($userData->profileStatus === 'suspended' &&  $value['isApproved']==0) {
                    $profile['profileStatus'] = 'suspended';
                    break;
                } elseif (count($totalUploadDoc) != count($totalRequiredDoc)) {
                    $profile['profileStatus'] = 'pendingUpload';
                    break;
                } else {
                    if ($value['isApproved']=='' || $value['isApproved']==null) {
                        $profile['profileStatus'] = 'notVerified';
                        break;
                    } else {
                        $profile['profileStatus'] = 'verified';
                    }
                }
            }
        } elseif ($is_suspend) {
            $profile['profileStatus'] = 'suspended';
        } else {
            if ($userData->profileStatus === 'suspended') {
                $profile['profileStatus'] = 'suspended';
            } else {
                $profile['profileStatus'] = 'pendingUpload';
            }
        }

        return $user->updateOne($user_id, $profile);
    }

    /**
    * Method for the controller
    * Create PreSigned Url
    *
    * @param string $request
    *
    * @author ATL
    * @since Jan 2020
    */

    public static function createPreSignedUrl($method, $bucket, $file)
    {
        $s3 = \Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $expiry = "+10 minutes";
        $command = $client->getCommand($method, [
            'Bucket' => $bucket,
            'Key'    => $file,
            'ServerSideEncryption' => 'AES256',
        ]);
        $request = $client->createPresignedRequest($command, $expiry);
        return (string) $request->getUri();
    }

    public static function verifyReceipt($receipt)
    {
        $secretId = Config::get('constants.SECRET_ID');
        $validator = new iTunesValidator(iTunesValidator::ENDPOINT_SANDBOX); // Or iTunesValidator::ENDPOINT_SANDBOX if sandbox testing
        $receiptBase64Data = $receipt;

        try {
            $response = $validator->setReceiptData($receiptBase64Data)->validate();
            $sharedSecret = $secretId; // Generated in iTunes Connect's In-App Purchase menu
            $response = $validator->setSharedSecret($sharedSecret)->setReceiptData($receiptBase64Data)->validate(); // use setSharedSecret() if for recurring subscriptions
        } catch (Exception $e) {
            $data['got error'] =  $e->getMessage();
        }
        return $response;
    }

    public static function manageSubscriptionStatus($status, $id)
    {
        $user = new User();

        $subscption['subscriptionStatus'] = $status;
        $userResult = $user->updateOne($id, $subscption);
    }

    public static function verifyIosReceipt($request)
    {
        $user = new User();
        $updatedUser = array();

        $response = Common :: verifyReceipt($request->receipt);
        
        if ($response->isValid()) {
            $actionResult = Common :: performActionOnIosReceipt($response, auth()->user()->id, "", "ios");
            if (gettype($actionResult)=="string" && $actionResult == "INUSE") {
                return Common :: respError('Your Receipt is already in use with another user', []);
            }
            if (gettype($actionResult)=="string" && $actionResult == '1') {
                return Common :: respError('Your account goes to update,previous will be removed.', []);
            }


            $updatedUser = $user->getOne(auth()->user()->id);

            return Common :: respSuccess('Your Receipt is verified', ['user'=>$updatedUser]);
        } else {
            $resp['code'] = $response->getResultCode();
        }

        return Common :: respError('Your Receipt is invalid', ['response'=>$resp,'user'=>$updatedUser]);
    }

    public static function performActionOnIosReceipt($response, $user_id, $flag, $type, $request = "")
    {
        DB::table('verifyreceipt_logs')->insert(array('log'=>$request,'type'=>'performaction','user_id'=>$user_id));

        $userSub = new UserSubscription();
        $subscriptionPlan = new Subscription();
                
        $resp['receipt'] = json_decode(json_encode($response->getReceipt()));
        $resp['latest_receipt'] = $response->getLatestReceipt();
        $resp['pending_renewal_info'] = $response->getPendingRenewalInfo();
       
        if (Common :: checkIosReceiptExists($user_id, $resp['receipt']->in_app[0]->original_transaction_id)) {
            if ($flag == "cronjob" || $flag == "notification") {
                return;
            } else {
                return "INUSE";
            }
        }
        
        $receiptData = $response->getLatestReceiptInfo();
        $latestReceiptInfo = $receiptData[0];
        
        if (isset($latestReceiptInfo)) {
            $latestInfo = $latestReceiptInfo;
        } else {
            $latestInfo = json_decode(json_encode(end($resp['receipt']->in_app)), true);
        }
        
        $subscriptionInfo =  $subscriptionPlan->getAll('', ["app_product_id" => $latestInfo['product_id'],"type" => $type]);
        
        $expireDate = explode(' ', $latestInfo['expires_date']);
        $purchaseDate = explode(' ', $latestInfo['purchase_date']);
        $originalPurchaseDate = explode(' ', $latestInfo['original_purchase_date']);
        
        $userInfo = $userSub->getAll('', ["user_id" => $user_id]);

        if (count($userInfo) > 0) {
            $userObj = $userInfo[0];
        } else {
            $userResp['user_id'] = $user_id;
            $userResp['product_id'] = $latestInfo['product_id'];
            $userObj = json_decode(json_encode($userResp));
        }
        
        
        if ($flag == "cronjob") {
            $userExists = 1;
        } else {
            $userExists = (count($userInfo) > 0) ? 1 : 0;
        }
        
        $data = array();
        
        if (isset($request->notification_type)) {
            if (isset($request->latest_receipt_data['cancellation_date'])) {
                $cancellationDate = explode(' ', $request->latest_receipt_data['cancellation_date']);
                $data['cancellation_date'] = $cancellationDate[0].' '.$cancellationDate[1];
            }
            
            
            if (isset($request->latest_receipt_data['cancellation_reason'])) {
                $data['json_field'] = "cancellation_reason";
                $data['json_key'] = $request->latest_receipt_data['cancellation_reason'];
            }
            
            $data['auto_renew_product_id'] = $request->auto_renew_product_id;
            $data['notification_type'] = $request->notification_type;
            $data['auto_renew_status'] = $request->auto_renew_status;
        }


        $data['user_id'] = $user_id;
        $data['subscription_type'] = $type;
        $data['subscription_id'] = $subscriptionInfo[0]->id;
        $data['product_id'] = $latestInfo['product_id'];
        $data['transaction_id'] = $latestInfo['transaction_id'];
        $data['original_transaction_id'] = $latestInfo['original_transaction_id'];
        $data['expires_date'] = $expireDate[0].' '.$expireDate[1];
            
        $latestInfo['expires_date_cust'] = $expireDate[0].' '.$expireDate[1];

        if (!$userExists) {
            $data['subscription_type'] = $type;
            $data['initial_receipt'] = $resp['latest_receipt'];
            $data['original_purchase_date'] = $originalPurchaseDate[0].' '.$originalPurchaseDate[1];
            
            $result = $userSub->insert($data);
            
            unset($data['initial_receipt']);
            unset($data['subscription_type']);
        }
        $data['purchase_date'] = $purchaseDate[0].' '.$purchaseDate[1];
        $data['web_order_line_item_id'] = $latestInfo['web_order_line_item_id'];
        $accountUpdate = '0';
        if (count($userInfo) > 0 && $userInfo[0]->original_transaction_id != $latestInfo['original_transaction_id'] && $flag != "notification") {
            $subUpdate['expires_date'] = $data['expires_date'];
            $subUpdate['initial_receipt'] = $resp['latest_receipt'];
            $subUpdate['transaction_id'] = $latestInfo['transaction_id'];
            $subUpdate['original_transaction_id'] = $latestInfo['original_transaction_id'];
            $accountUpdate = '1';
            $result = $userSub->updateOne($user_id, $subUpdate);
        } else {
            $subUpdate['expires_date'] = $data['expires_date'];
            $subUpdate['initial_receipt'] = $resp['latest_receipt'];

            $result = $userSub->updateOne($user_id, $subUpdate);
        }
            

        $data = Common :: performPendingRenewalInfo($resp, $data, $user_id); // change userstatus and add more info in data
        $resultProduct = Common :: performProductDuplication($userObj, $subscriptionInfo, $latestInfo);
        $result = Common :: performTransactionDuplication($data, $latestInfo);
        if ($accountUpdate == '1') {
            return $accountUpdate;
        }
        return true;
    }

    public static function performActionOnIosExpiredReceipt($getUser, $flag, $type, $request = "")
    {
        $userSub = new UserSubscription();
        $subscriptionPlan = new Subscription();
                
        $cancellationDate = '';
        $subscriptionInfo =  $subscriptionPlan->getAll('', ["app_product_id" => $request->latest_receipt_data['product_id'],"type" => 'ios']);
        $seconds = $request->latest_receipt_data['expires_date'] / 1000;
        $expirydate = date("Y-m-d H:i:s", $seconds);
        $purchaseDate = explode(' ', $request->latest_receipt_data['purchase_date']);
        $orignalPurchaseDate = explode(' ', $request->latest_receipt_data['original_purchase_date']);
        if (isset($request->latest_receipt_data['cancellation_date'])) {
            $cancellationDate = explode(' ', $request->latest_receipt_data['cancellation_date']);
        }
                
        $arrData['user_id'] = $getUser[0]->user_id;
        $arrData['auto_renew_product_id'] = $request->auto_renew_product_id;
        $arrData['subscription_id'] = $subscriptionInfo[0]->id;
        $arrData['subscription_type'] = "ios";
        $arrData['product_id'] = $request->latest_receipt_data['product_id'];
        $arrData['transaction_id'] = $request->latest_receipt_data['transaction_id'];
        $arrData['original_transaction_id'] = $request->latest_receipt_data['original_transaction_id'];
        $arrData['expires_date'] = $expirydate;
        $arrData['purchase_date'] = $purchaseDate[0].' '.$purchaseDate[1];
        $arrData['original_purchase_date'] = $orignalPurchaseDate[0].' '.$orignalPurchaseDate[1];
        $arrData['notification_type'] = $request->notification_type;
        $arrData['web_order_line_item_id'] = $request->latest_receipt_data['web_order_line_item_id'];
        $arrData['auto_renew_status'] = $request->auto_renew_status;
        if ($cancellationDate) {
            $arrData['cancellation_date'] = $cancellationDate[0].' '.$cancellationDate[1];
        }
        if (isset($request->latest_receipt_data['cancellation_reason'])) {
            $arrData['json_field'] = "cancellation_reason";
            $arrData['json_key'] = $request->latest_receipt_data['cancellation_reason'];
        }

        //check product id. if new then update
        $request->latest_receipt_data['expires_date_cust'] = $expirydate;
        $result = Common :: performProductDuplication($getUser[0], $subscriptionInfo, $request->latest_receipt_data);
                
        //check trans id duplication. if exists then update
        $result = Common :: performTransactionDuplication($arrData, $request->latest_receipt_data);
        $result = $userSub->updateOne($getUser[0]->user_id, array("expires_date"=>$expirydate));


        return true;
    }

    public static function checkIosReceiptExists($user_id, $original_transaction_id)
    {
        $userSub = new UserSubscription();

        $where = [
                ['user_id', '!=', $user_id],
                ['original_transaction_id', $original_transaction_id],
                ['deleted', '0']
            ];

        $checkValidUser = $userSub->getAll('', $where);

        if (count($checkValidUser) > 0) {
            return true;
        }
        return false;
    }

    public static function performPendingRenewalInfo($resp, $data, $user_id)
    {
        if (isset($resp['pending_renewal_info']) && count($resp['pending_renewal_info']) > 0) {
            $infoData = $resp['pending_renewal_info'][0];

            if (isset($infoData['is_in_billing_retry_period'])) {
                $data['is_in_billing_retry_period'] = $infoData['is_in_billing_retry_period'];
            }
            if (isset($infoData['expiration_intent'])) {
                $data['json_field'] = 'expiration_intent';
                $data['json_key'] = $infoData['expiration_intent'];
            }
            if (isset($infoData['auto_renew_product_id'])) {
                $data['auto_renew_product_id'] = $infoData['auto_renew_product_id'];
            }
            if (isset($infoData['auto_renew_status'])) {
                $data['auto_renew_status'] = $infoData['auto_renew_status'];
            }
            if (isset($infoData['expiration_intent']) || (isset($infoData['is_in_billing_retry_period']) && isset($infoData['is_in_billing_retry_period'])==1)) {
                Common :: manageSubscriptionStatus('Expired', $user_id);
                return $data;
            }
        }
        Common :: manageSubscriptionStatus('Active', $user_id);
        
        return $data;
    }

    public static function performTransactionDuplication($data, $latestInfo)
    {
        $paymentHistory = new UserPaymentHistory();
        /* Deleted field for user payment history is for skip previous payment.*/
        if (isset($data['json_field']) && $data['json_field']!='') {
            $where = [
                    ['original_transaction_id', $latestInfo['original_transaction_id']],
                    ['transaction_id', $latestInfo['transaction_id']],
                    ['user_payment_history.json_field', $data['json_field']],
                    ['deleted', '0']
                 ];
        } else {
            $where = [
                    ['original_transaction_id', $latestInfo['original_transaction_id']],
                    ['transaction_id', $latestInfo['transaction_id']],
                    ['deleted', '0']
                 ];
        }

        $getPaymentHistory = $paymentHistory->getAll('', $where);
        $result = 1;
        if (count($getPaymentHistory) > 0) {
            //$result = $paymentHistory->updateOne(['transaction_id',$latestInfo['transaction_id']], $data);
        } else {
            $result = $paymentHistory->insert($data);
        }
        return $result;
    }

    public static function performProductDuplication($userData, $subscriptionInfo, $latest_receipt_data)
    {
        $userSub = new UserSubscription();
        
        if ($userData->product_id != $latest_receipt_data['product_id']) {
            $data['subscription_id'] = $subscriptionInfo[0]->id;
            $data['subscription_type'] = "ios";
            $data['product_id'] = $latest_receipt_data['product_id'];
            $data['transaction_id'] = $latest_receipt_data['transaction_id'];
            $data['expires_date'] = $latest_receipt_data['expires_date_cust'];
            $result = $userSub->updateOne($userData->user_id, $data);
        }
    }

    public static function verifyAndroidReceipt($request, $user_id, $type)
    {
        $androiddata = array();
        $userSub = new UserSubscription();
        $subscriptionPlan = new Subscription();
        $paymentHistory = new UserPaymentHistory();
        $user = new User();
        $updatedUser = array();

        $googleClient = new \Google_Client();
        $googleClient->setScopes([\Google_Service_AndroidPublisher::ANDROIDPUBLISHER]);
        $googleClient->setApplicationName(env('APP_NAME'));
        $googleClient->setAuthConfig(public_path().Config::get('constants.GOOGLE_APPLICATION_CREDENTIALS'));
        $googleAndroidPublisher = new \Google_Service_AndroidPublisher($googleClient);
        $validator = new \ReceiptValidator\GooglePlay\Validator($googleAndroidPublisher);
        
        try {
            /* $txt = "\nSuccess:- ".date("Y-m-d h:i:s")."\n".$request;
            $myfile = file_put_contents('androidServerNotificationLogsVerifyReceipt.txt', $txt.PHP_EOL, FILE_APPEND | LOCK_EX);
            */

            $response = $validator->setPackageName($request->receipt["packageName"])
            ->setProductId($request->receipt["productId"])
            ->setPurchaseToken($request->receipt["purchaseToken"])
            ->validateSubscription();
        } catch (\Exception $e) {
            return Common :: respSuccess('Your Token is invalid', [$e->getMessage()]);
            // example message: Error calling GET ....: (404) Product not found for this application.
        }
        // success
        $responseData = $response->getRawResponse();
        //dd($responseData);

        if ($user_id == null) {
            /** check for linkedPurchase */
            if (isset($responseData->linkedPurchaseToken)) {
                $updatedTokenUser = $userSub->getAll('', ["original_transaction_id" => $responseData->linkedPurchaseToken]);
                $user_id = $updatedTokenUser[0]->user_id;
            }
        }
        if ($user_id > 0) {
            if (isset($request->receipt["purchaseTime"])) {
                $seconds = $request->receipt["purchaseTime"] / 1000;
                $purchaseDate = date("Y-m-d H:i:s", $seconds);
                $androiddata['original_purchase_date'] = $purchaseDate;
            }
            $seconds = $responseData->expiryTimeMillis / 1000;
            $expiryDate = date("Y-m-d H:i:s", $seconds);
            
            $subscriptionInfo =  $subscriptionPlan->getAll('', ["app_product_id" => $request->receipt["productId"],"type" => $type]);
            $androiddata['user_id'] = $user_id;
            $androiddata['subscription_id'] = $subscriptionInfo[0]->id;
            $androiddata['subscription_type'] = "android";
            $androiddata['product_id'] = $request->receipt["productId"];
            $androiddata['transaction_id'] = $responseData->orderId;
            $androiddata['original_transaction_id'] = $request->receipt["purchaseToken"];
            $androiddata['expires_date'] = $expiryDate;
            
            //dd($data);

            $checkExist = $userSub->getAll('', ["user_id" => $user_id]);

            if (count($checkExist) == 0) {
                $androiddata['initial_receipt'] = $request->receipt["purchaseToken"];
                
                $result = $userSub->insert($androiddata);
                
                unset($androiddata['initial_receipt']);
            } else {
                $updateData["expires_date"] = $androiddata['expires_date'];

                if ($checkExist[0]->original_transaction_id != $request->receipt["purchaseToken"]) {
                    $updateData['original_transaction_id'] = $request->receipt["purchaseToken"];
                    $updateData['subscription_type'] = "android";
                    $updateData['subscription_id'] = $subscriptionInfo[0]->id;
                    $updateData['product_id'] = $request->receipt["productId"];
                    $updateData['transaction_id'] = $responseData->orderId;
                    $updateData['original_purchase_date'] = $androiddata['original_purchase_date'];
                }
                $userSub->updateOne($user_id, $updateData);
            }
            if (isset($request->receipt["purchaseTime"])) {
                $androiddata['purchase_date'] = $purchaseDate;
            }
            
            $androiddata['auto_renew_status'] = $responseData->autoRenewing;
            if (isset($responseData->cancelReason)) {
                $androiddata['json_field'] = 'cancelReason';
                $androiddata['json_key'] = $responseData->cancelReason;
            }
            
            if (isset($request->receipt["notificationType"])) {
                $androiddata['notification_type'] = $request->receipt["notificationType"];
                /* Deleted field for user payment history is for skip previous payment.*/
                $where = [
                    ['original_transaction_id', $androiddata['original_transaction_id']],
                    ['notification_type', $request->receipt["notificationType"]],
                    ['deleted', '0'],
                    ['transaction_id', $androiddata['transaction_id']]
                 ];
            } else {
                $where = [
                    ['original_transaction_id', $androiddata['original_transaction_id']],
                    ['transaction_id', $androiddata['transaction_id']],
                    ['deleted', '0']
                 ];
            }
            
            if (isset($responseData->paymentState) && $responseData->paymentState == 0) {
                $androiddata['json_field'] = 'paymentState';
                $androiddata['json_key'] = $responseData->paymentState;
            }
           
            $getPaymentHistory = $paymentHistory->getAll('', $where);
            $result = 1;
            if (count($getPaymentHistory) > 0) {
                //$result = $paymentHistory->updateOne(['transaction_id',$latestInfo['transaction_id']], $data);
            } else {
                DB::enableQueryLog();

                $result = $paymentHistory->insert($androiddata);
                $txt = "\nData:- ".date("Y-m-d h:i:s")."\n".print_r(DB::getQueryLog(), true);
                $myfile = file_put_contents('testdata.txt', $txt.PHP_EOL, FILE_APPEND | LOCK_EX);
            }

            if ((isset($responseData->cancelReason) && $responseData->cancelReason == '1') || $responseData->paymentState=='0' || (isset($request->receipt["notificationType"]) && in_array($request->receipt["notificationType"], [3,12,13]) && $user_id > 0)) {
                Common :: manageSubscriptionStatus('Expired', $user_id);
            } else {
                Common :: manageSubscriptionStatus('Active', $user_id);
            }

            $userData = $user->getOne($user_id);

            return Common :: respSuccess('Your Token is verified', ['user'=>$userData]);
        }

        return Common :: respSuccess('User not found', ['user'=>array()]);
    }
    public static function resizeFile($request, $arrFile)
    {
        if (isset($arrFile['resize']) && !empty($arrFile['resize']) && isset($arrFile['existing']) && !empty($arrFile['existing']) && file_exists(public_path($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/' .$arrFile['existing']))) {
            @unlink(public_path($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/' .$arrFile['existing']));
            @unlink(public_path($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/' .str_replace(pathinfo($arrFile['existing'], PATHINFO_EXTENSION),'png',$arrFile['existing'])));
        }elseif (isset($arrFile['existing']) && !empty($arrFile['existing']) && file_exists(public_path($arrFile['path'].'/' .$arrFile['existing']))) {
            @unlink(public_path($arrFile['path'].'/' .$arrFile['existing']));
            @unlink(public_path($arrFile['path'].'/' .str_replace(pathinfo($arrFile['existing'], PATHINFO_EXTENSION),'png',$arrFile['existing'])));
        }

        $image     = $request->file(str_replace('_exist','',$arrFile['except']));
        $extension = $image->getClientOriginalExtension();
        $img_name  = $arrFile['predefine']?$arrFile['predefine']:rand().time().'.'.$extension;
        if(in_array($extension,array('png','jpg','jpeg','bmp'))){
            $image_resize = Image::make($image->getRealPath());
            if(isset($arrFile['resize']) && !empty($arrFile['resize'])){
                $image_resize->fit($arrFile['resize'], $arrFile['resize']);
                $image_resize->save(public_path($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/' .$img_name));
            }else{
                $image_resize->save(public_path($arrFile['path'].'/' .$img_name));
            }
        }else if(in_array($extension,array('mp4'))){
            //$image->move(public_path($arrFile['path'].'/' .$img_name), $img_name);
            if(isset($arrFile['resize']) && !empty($arrFile['resize'])){
                $image->move(public_path($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize']), $img_name);
            }else{
                $image->move(public_path($arrFile['path']), $img_name);
            }
            exec("ffmpeg -i ".public_path($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/'. $img_name)." -r 1 -ss 00:00:05 -t 00:00:01 -s ".$arrFile['resize'].'x'.$arrFile['resize']." -f image2 ". public_path($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/'. str_replace($extension,'png',$img_name)));
        }else{
            if(isset($arrFile['resize']) && !empty($arrFile['resize'])){
                $image->move(public_path($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize']),$img_name);
            }else{
                $image->move(public_path($arrFile['path'].'/' .$img_name));
            }
        }

        return $img_name;
    }
    public static function differenceInMinutes($startDateTime, $endDateTime)
    {
        return abs(strtotime($endDateTime) - strtotime($startDateTime)) / 60;
    }
    public static function getCommonCityList(){
        $dbCity = new City();
        $dynamicWhere = 'city.status = 1';
        return $arrCity = $dbCity->getAll($orderby=null, $where=array(), $dynamicWhere);
    }
    public static function getCommonPacakgeList(){
        $dbPackage = new Package();
        $orderby = "package.order";
        if(!empty(Session::get('city_id'))){
            $dynamicWhere = 'package.status = 1 AND package_city.city_id ='.Session::get('city_id');
        }else{
            $dynamicWhere = 'package.status = 1';
        }
        return $arrPackage = $dbPackage->getAllPackages($orderby, $where=array(), $dynamicWhere);
    }
    public static function generateOrderNumber(){
        $today = date("Ymd");
        $rand = strtoupper(substr(uniqid(sha1(time())),0,4));
        $uniqueNumber = $today . $rand;
        $arrResult = DB::select("SELECT count(order_number) as cnt FROM booking WHERE order_number IN ('" . $uniqueNumber . "')");
        if (isset($arrResult) && !empty($arrResult) && count($arrResult) > 0 && $arrResult[0]->cnt != 0) {
            Common::generateOrderNumber();
        }else{
            return $uniqueNumber;
        }
    }
    public static function sentMsg($number, $message){
        // Account details      
  }
}
