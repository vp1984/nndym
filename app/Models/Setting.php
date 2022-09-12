<?php
/**
 * Setting Model
 * Manage CRUD for the Setting
 *
 * @author ATL
 * @since Jan 2020
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Setting extends Model
{
    
    /**
     * Returns setting details
     *
     * @author ATL
     * @since Jan 2020
    */
    public function getAllSetting($orderby=null, $where=array())
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Setting::query();
        
        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('id', 'desc');
        }

        if (!empty($where)) {
            $query->where($where);
        }

        return $query->where(['settings.deleted' => 0])
                    ->join('setting_types', 'setting_types.id', '=', 'settings.setting_type_id')
                    ->select('settings.*', 'setting_types.name as settingtypes')
                    ->whereRaw($dynamicWhere)
                    ->get();
    }

    /**
    * Returns all records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getAll($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        return Setting::where(['settings.deleted' => 0])
            ->join('setting_types', 'setting_types.id', '=', 'settings.setting_type_id')
            ->select('settings.*', DB::raw('CASE WHEN settings.status = 1 THEN "Active" ELSE "Inactive" END as status'), 'setting_types.name as settingtype')
            ->whereRaw($dynamicWhere)
            ->get();
    }
    /**
    * Returns single Record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getOneRecord($id)
    {
        return Setting::where(['settings.id' => $id])
        ->join('setting_types', 'setting_types.id', '=', 'settings.setting_type_id')
        ->select('settings.*', 'setting_types.name as settingtype')
        ->first();
    }
    /**
    * Returns count of records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getOne($id)
    {
        return Setting::where(['id' => $id])->first();
    }

    /**
    * Delete specific records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function deleteAll($ids, $arrUpdate)
    {
        return Setting::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    /**
    * Delete specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function deleteOne($id, $arrUpdate)
    {
        return Setting::where('id', $id)->update($arrUpdate);
    }


    /**
    * Update records in bulk
    *
    * @author ATL
    * @since Jan 2020
    */
    public function bulkUpdate($ids, $arrUpdate)
    {
        return Setting::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    /**
    * Update specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function updateOne($id, $arrUpdate)
    {
        return Setting::where('id', $id)->update($arrUpdate);
    }

    /**
    * Returns contry details based on id
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getCountByCriteria($id = null, $criteria)
    {
        if ($id != null) {
            return Setting::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return Setting::where($criteria)->count();
        }
    }

    /**
    * Returns all records to export
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getAllToExport()
    {
        return Setting::where(['settings.deleted' => 0])
            ->join('setting_types', 'setting_types.id', '=', 'settings.setting_type_id')
            ->select('settings.name as Name', 'setting_types.name as Settingtype', DB::raw('CASE WHEN settings.status = 1 THEN "Active" ELSE "Inactive" END as Status'))
            ->get()
            ->toArray();
    }
    /**
    * Returns all records on regarding setting type
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getbyname($arrSettingName)
    {
        return Setting::whereIn('name', $arrSettingName)
                ->select('name', 'value')->get();
    }

    public function getSettingByName($arrSettingName)
    {
        return Setting::where('settings.name', $arrSettingName)
        ->join('setting_types', 'setting_types.id', '=', 'settings.setting_type_id')
        ->select('settings.*', 'setting_types.name as settingtype')
        ->first();
    }
}
