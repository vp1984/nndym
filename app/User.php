<?php

namespace App;
use DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public function getAll($orderby=null, $where=array(), $dynamicWhere='', $start='', $limit='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = User::query();
        
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


        return $query->where(['deleted' => 0])
                    ->select('*', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as status'), DB::raw('(SELECT GROUP_CONCAT( name ) FROM roles WHERE FIND_IN_SET(id, role_id))  as assigned_role'))
                    ->whereRaw($dynamicWhere)
                    ->get();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getOne($id)
    {
        return User::where(['id' => $id])->first();
    }

    /**
    * Delete specific records
    *
    * @author ATL
    * @since Jan 2019
    */
    public function deleteAll($ids, $arrUpdate)
    {
        return User::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    /**
    * Delete specific record
    *
    * @author ATL
    * @since Jan 2019
    */
    public function deleteOne($id, $arrUpdate)
    {
        return User::where('id', $id)->update($arrUpdate);
    }


    /**
    * Update records in bulk
    *
    * @author ATL
    * @since Jan 2019
    */
    public function bulkUpdate($ids, $arrUpdate)
    {
        return User::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    /**
    * Update specific record
    *
    * @author ATL
    * @since Jan 2019
    */
    public function updateOne($id, $arrUpdate)
    {
        return User::where('id', $id)->update($arrUpdate);
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
            return User::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return User::where($criteria)->count();
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
        return User::where(['deleted' => 0])->select('name as Name', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as Status'));
    }

    /**
    * Returns rights of Module
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getModuleRights()
    {
        return Module::leftJoin('rights', 'rights.module_id', '=', 'modules.id')
                        ->where(['modules.deleted' => 0])
                        ->where(['rights.deleted' => 0])
                        ->select('rights.id as rightsId', 'rights.name as rightsName', 'modules.id as moduleId', 'modules.name as moduleName')
                        //->groupBy('rights.id')
                        ->orderBy('modules.name')
                        ->orderBy('rights.name')
                        ->get();
    }

    function getModules()
    {
        return DB::table('modules')->leftJoin('rights','rights.module_id','=','modules.id')
        ->where(['modules.deleted' => 0])
        ->where(['rights.deleted' => 0])
        ->select('rights.id as rightsId','rights.name as rightsName','modules.id as modulesId','modules.name as modulesName')
        ->groupBy('rights.id')
        ->orderBy('modules.name')
        ->orderBy('rights.name')
        ->get();
    }
}
