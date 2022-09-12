<?php
/**
 * Menu Model
 * Manage CRUD for the Menu
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * Returns all records
     *
     * @author ATL
     * @since Jan 2019
     */
    public function getAll($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Menu::query();
        
        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('menus.name');
        }

        if (!empty($where)) {
            $query->where($where);
        }
        return $query->where(['menus.deleted' => 0])
            ->leftjoin('menus as m', 'm.id', '=', 'menus.parent_id')
            ->select('menus.*', DB::raw('CASE WHEN menus.status = 1 THEN "Active" ELSE "Inactive" END as status'), 'm.name as parent')
            ->whereRaw($dynamicWhere)
            ->get();
    }

    /**
     * Returns count of records
     *
     * @author ATL
     * @since Jan 2019
     */
    public function getOne($id)
    {
        return Menu::where(['id' => $id])->first();
    }

    /**
     * Delete specific records
     *
     * @author ATL
     * @since Jan 2019
     */
    public function deleteAll($ids, $arrUpdate)
    {
        return Menu::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    /**
     * Delete specific record
     *
     * @author ATL
     * @since Jan 2019
     */
    public function deleteOne($id, $arrUpdate)
    {
        return Menu::where('id', $id)->update($arrUpdate);
    }

    /**
     * Update records in bulk
     *
     * @author ATL
     * @since Jan 2019
     */
    public function bulkUpdate($ids, $arrUpdate)
    {
        return Menu::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    /**
     * Update specific record
     *
     * @author ATL
     * @since Jan 2019
     */
    public function updateOne($id, $arrUpdate)
    {
        return Menu::where('id', $id)->update($arrUpdate);
    }

    /**
     * Returns contry details based on id
     *
     * @author ATL
     * @since Jan 2019
     */
    public function getCountByCriteria($id = null, $criteria, $menuTypeId = null)
    {
        if ($id != null) {
            return Menu::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return Menu::where($criteria)->count();
        }
    }

    /**
     * Returns all records to export
     *
     * @author ATL
     * @since Jan 2019
     */
    public function getAllToExport()
    {
        return Menu::where(['menus.deleted' => 0])
            ->leftjoin('menus as m', 'm.id', '=', 'menus.parent_id')
            ->select('menus.name as Name', 'm.name as Parent', DB::raw('CASE WHEN menus.status = 1 THEN "Active" ELSE "Inactive" END as Status'));
    }

    /**
     * Returns menu and rights
     *
     * @author ATL
     * @since Jan 2019
     */
    public function getMenusWithRights($parent = 0, $order = 'menus.name')
    {
        return Menu::where(['menus.deleted' => 0, 'menus.parent_id' => $parent, 'menus.status' => 1])
            ->leftjoin('rights as r', 'r.id', '=', 'menus.right_id')
            ->select('menus.*', 'r.routes as routes')
            ->orderBy($order)
            ->get();
    }
}
