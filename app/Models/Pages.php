<?php
/**
 * Pages Model
 * Manage CRUD for the Pages
 *
 * @author ATL
 * @since Jan 2020
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pages extends Model
{
    /**
    * Returns all records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getAll($orderby=null, $where=array(), $dynamicWhere='', $start='', $limit='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Pages::query();
        
        if (is_array($orderby) && !empty($orderby)) {
            $query->orderBy($orderby[0], $orderby[1]);
        } elseif (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('id', 'desc');
        }

        if (!empty($where)) {
            $query->where($where);
        }

        if ($start!='' && $limit!='') {
            $query->skip($start)->take($limit);
        }


        return $query->where(['pages.deleted' => 0])
                    ->select('pages.*','types.name as typename','page_types.name as pagetypename',  DB::raw('CASE WHEN pages.status = 1 THEN "Active" ELSE "Inactive" END as status'))
                    ->leftJoin('types','types.id','=','pages.type_id')
                    ->leftJoin('page_types','page_types.id','=' ,'pages.type_id')
                    ->whereRaw($dynamicWhere)
                    ->get();

                    // return $query->where(['email_templates.deleted' => 0])
                    // ->select('email_templates.*','email_templates.name as name','email_template_types.name as templatename', DB::raw('CASE WHEN email_templates.status = 1 THEN "Active" ELSE "Inactive" END as status'))
                    // ->leftJoin('email_template_types', 'email_templates.email_Template_type_id', '=', 'email_template_types.id')
                    // ->whereRaw($dynamicWhere)
                    // //->groupBy('email_templates.id')
                    // ->get();
    }

    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getOne($id)
    {
        return pages::where(['page_id' => $id])->first();
    }

    /**
    * Delete specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function deleteOne($id, $arrUpdate)
    {
        return pages::where('page_id', $id)->update($arrUpdate);
    }

    /**
    * Update specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function updateOne($id, $arrUpdate)
    {
        return pages::where('page_id', $id)->update($arrUpdate);
    }
}
