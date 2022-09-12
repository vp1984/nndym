<?php
/**
 * Role Model
 * Manage CRUD for the Role
 *
 * @author ATL
 * @since Jan 2020
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Role extends Model
{
    /**
    * Returns all records
    *
    * @author ATL
    * @since Jan 2019
    */
    public function getRole()
    {
        return Role::where(['deleted' => 0])->get();
    }

    /**
    * Returns all records
    *
    * @author ATL
    * @since Jan 2019
    */
    public function getOneRoleById($roleId)
    {
        return Role::where(['id' => $roleId])->first();
    }

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
        
        $query = Role::query();
        if (!empty($where)) {
            $query->where($where);
        }
        
        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('id', 'desc');
        }

        return $query->where(['deleted' => 0])
            ->select('*', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as status'))
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
        return Role::where(['id' => $id])->first();
    }

    /**
    * Delete specific records
    *
    * @author ATL
    * @since Jan 2019
    */
    public function deleteAll($ids, $arrUpdate)
    {
        return Role::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    /**
    * Delete specific record
    *
    * @author ATL
    * @since Jan 2019
    */
    public function deleteOne($id, $arrUpdate)
    {
        return Role::where('id', $id)->update($arrUpdate);
    }


    /**
    * Update records in bulk
    *
    * @author ATL
    * @since Jan 2019
    */
    public function bulkUpdate($ids, $arrUpdate)
    {
        return Role::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    /**
    * Update specific record
    *
    * @author ATL
    * @since Jan 2019
    */
    public function updateOne($id, $arrUpdate)
    {
        return Role::where('id', $id)->update($arrUpdate);
    }

    /**
    * Returns contry details based on id
    *
    * @author ATL
    * @since Jan 2019
    */
    public function getCountByCriteria($id = null, $criteria)
    {
        if ($id != null) {
            return Role::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return Role::where($criteria)->count();
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
        return Role::where(['deleted' => 0])->select('name as Name', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as Status'));
    }
}
