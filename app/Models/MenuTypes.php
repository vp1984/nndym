<?php
/**
 * MenuTypes Model
 * Manage CRUD for the MenuTypes
 *
 * @author ATL
 * @since Jan 2020
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class MenuTypes extends Model
{
    /**     
    * Returns all records
    *
    * @author ATL
    * @since Jan 2019
    */
    function getAll()
    {   
        return MenuTypes::where(['deleted' => 0])
            ->select('*', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as status'))
            ->get();
    }    

    function getOne($id)
    {   
        return MenuTypes::where(['id' => $id])
                    ->select('*')
                    ->first();
    }

    /**     
    * Delete specific records
    *
    * @author ATL
    * @since Jan 2019
    */
    function deleteAll($ids,$arrUpdate)
    {     
        return MenuTypes::whereIn('id', explode(',',$ids))->update($arrUpdate);
    }

    /**     
    * Delete specific record
    *
    * @author ATL
    * @since Jan 2019
    */
    function deleteOne($id,$arrUpdate)
    {     
        return MenuTypes::where('id', $id)->update($arrUpdate);
    }


    /**     
    * Update records in bulk
    *
    * @author ATL
    * @since Jan 2019
    */
    function bulkUpdate($ids,$arrUpdate)
    {     
        return MenuTypes::whereIn('id', explode(',',$ids))->update($arrUpdate);
    }

    /**     
    * Update specific record
    *
    * @author ATL
    * @since Jan 2019
    */
    function updateOne($id,$arrUpdate)
    {     
        return MenuTypes::where('id', $id)->update($arrUpdate);
    }

    /**     
    * Returns contry details based on id
    *
    * @author ATL
    * @since Jan 2019
    */
    function getCountByCriteria($id = null, $criteria)
    {   
        if($id != null){
            return MenuTypes::where($criteria)->where('id', '<>',  $id )->where('menu_type_id', '=',  $menuTypeId)->count();
        }else{
            return MenuTypes::where($criteria)->count();    
        }
        
    }

    /**     
    * Returns all records to export
    *
    * @author ATL
    * @since Jan 2019
    */
    function getAllToExport()
    {   
        return MenuTypes::where(['deleted' => 0])
            ->select('name as Name', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as Status'))
            ->get()
            ->toArray();
    }
}
