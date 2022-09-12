<?php
/**
 * Package Model
 * Manage CRUD for the Package
 *
 * @author ATL
 * @since Jan 2020
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Package extends Model
{
    protected $table = 'package';

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

        $query = Package::query();
        
        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('id', 'desc');
        }

        if (!empty($where)) {
            $query->where($where);
        }

        return $query->where(['deleted' => 0])
                    ->select('*', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as status'))
                    ->whereRaw($dynamicWhere)
                    ->get();
    }

    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getOne($id)
    {
        return Package::where(['id' => $id])->first();
    }

    /**
    * Delete specific records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function deleteAll($ids, $arrUpdate)
    {
        return Package::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    /**
    * Delete specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function deleteOne($id, $arrUpdate)
    {
        return Package::where('id', $id)->update($arrUpdate);
    }


    /**
    * Update records in bulk
    *
    * @author ATL
    * @since Jan 2020
    */
    public function bulkUpdate($ids, $arrUpdate)
    {
        return Package::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    /**
    * Update specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function updateOne($id, $arrUpdate)
    {
        return Package::where('id', $id)->update($arrUpdate);
    }

    /**
    * Returns contry details based on id
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getCountByCriteria($id = null, $criteria, $menuTypeId=null)
    {
        if ($id != null) {
            return Package::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return Package::where($criteria)->count();
        }
    }

    /**
    * Returns all records to export
    *
    * @author ATL
    * @since Jan 2020
    */
    public static function getAllToExport()
    {
        return Package::where(['deleted' => 0])
                ->select('name as Name', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as Status'));
    }
    /**
    * Returns all records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function additionalOperation($additopnalOperation)
    {
        if(!empty($additopnalOperation)){
            if (isset($additopnalOperation['city_id']) && !empty($additopnalOperation['city_id'])) {
                foreach ($additopnalOperation['city_id'] as $keyCity => $valCity) {
                    $areaIds = '';
                    if (!empty($additopnalOperation['area_id'][$keyCity]) && count($additopnalOperation['area_id'][$keyCity]) > 0) {
                        $areaIds = join(",", $additopnalOperation['area_id'][$keyCity]);
                    }
                
                    DB::table('package_city')
                    ->updateOrInsert(
                        ['package_id' => $additopnalOperation['package_id'], 'city_id' => $valCity],
                        ['package_id' => $additopnalOperation['package_id'], 'city_id' => $valCity, 'area_id' => $areaIds, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => Session('id'), 'updated_by' => Session('id')]
                    );
                    $packageCityId = DB::table('package_city')->where('package_id', $additopnalOperation['package_id'])->where('city_id', $valCity)->select('id')->first();
                    if (isset($additopnalOperation['package_dates'][$keyCity]) && !empty($additopnalOperation['package_dates'][$keyCity])) {
                        foreach ($additopnalOperation['package_dates'][$keyCity] as $keyDate => $valDate) {
                            DB::table('city_date_package')
                            ->updateOrInsert(
                                ['package_city_id' => $packageCityId->id, 'package_date' => date('Y-m-d', strtotime($valDate))],
                                [
                                    'package_city_id' => $packageCityId->id,
                                    'package_date' => date('Y-m-d', strtotime($valDate)),
                                    'morning_actual_price' => $additopnalOperation['morning_actual_price'][$keyCity][$keyDate],
                                    'morning_discount_price' => $additopnalOperation['morning_discount_price'][$keyCity][$keyDate],
                                    'morning_traveling_time' => $additopnalOperation['morning_traveling_time'][$keyCity][$keyDate],
                                    'morning_active' => $additopnalOperation['morning_active'][$keyCity][$keyDate],
                                    'afternoon_actual_price' => $additopnalOperation['afternoon_actual_price'][$keyCity][$keyDate],
                                    'afternoon_discount_price' => $additopnalOperation['afternoon_discount_price'][$keyCity][$keyDate],
                                    'afternoon_traveling_time' => $additopnalOperation['afternoon_traveling_time'][$keyCity][$keyDate],
                                    'afternoon_active' => $additopnalOperation['afternoon_active'][$keyCity][$keyDate],
                                    'evening_actual_price' => $additopnalOperation['evening_actual_price'][$keyCity][$keyDate],
                                    'evening_discount_price' => $additopnalOperation['evening_discount_price'][$keyCity][$keyDate],
                                    'evening_traveling_time' => $additopnalOperation['evening_traveling_time'][$keyCity][$keyDate],
                                    'evening_active' => $additopnalOperation['evening_active'][$keyCity][$keyDate],
                                    'night_actual_price' => $additopnalOperation['night_actual_price'][$keyCity][$keyDate],
                                    'night_discount_price' => $additopnalOperation['night_discount_price'][$keyCity][$keyDate],
                                    'night_traveling_time' => $additopnalOperation['night_traveling_time'][$keyCity][$keyDate],
                                    'night_active' => $additopnalOperation['night_active'][$keyCity][$keyDate],
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                    'created_by' => Session('id'),
                                    'updated_by' => Session('id')
                                ]
                            );
                        }
                    }
                }
            }
        }
    }
    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getPackageCity($id)
    {
        return DB::table('package_city')->where(['package_id' => $id])->get();
    }
    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getCityDatePackage($packageId,$cityId)
    {
        return DB::table('package_city')->join('city_date_package', 'city_date_package.package_city_id', '=', 'package_city.id')->where(['package_id' => $packageId,'city_id' => $cityId])->where('package_date','>=',date('Y-m-d'))->select('city_date_package.*')->get();
    }
    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getPackageDetails()
    {
        return DB::table('package')->join('package_city', 'package.id', '=', 'package_city.package_id')->join('city_date_package', 'city_date_package.package_city_id', '=', 'package_city.id')->join('city', 'city.id', '=', 'package_city.city_id')->join('team', 'team.city_id', '=', 'city.id')->where('package.status','=','1')->where('package_date','>=',date('Y-m-d'))->select('*','city.name as cityname','package.name as packagename')->get();
    }
    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getPackageDateDetails($orderby=null, $where=array(), $dynamicWhere='')
    {
        return DB::table('package')->join('package_city', 'package.id', '=', 'package_city.package_id')->join('city_date_package', 'city_date_package.package_city_id', '=', 'package_city.id')->join('city', 'city.id', '=', 'package_city.city_id')->where('package_date','>=',date('Y-m-d'))->whereRaw($dynamicWhere)->select('*','city.name as cityname','package.name as packagename')->orderBy('city_date_package.package_date')->get();
    }
    /**
    * Returns all records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getAllPackages($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Package::query();
        if (!empty($orderby)) {
            $query->orderBy($orderby, 'asc');
        } else {
            $query->orderBy('package.id', 'desc');
        }

        if (!empty($where)) {
            $query->where($where);
        }

        return $query->where(['package.deleted' => 0])
                    ->select('package.*', DB::raw('CASE WHEN package.status = 1 THEN "Active" ELSE "Inactive" END as status'), DB::raw('MiN(morning_actual_price) as actual_price'), DB::raw('MiN(morning_discount_price) as discount_price'),'city.name as cityname')
                    ->join('package_city', 'package.id', '=', 'package_city.package_id')
                    ->join('city_date_package', 'city_date_package.package_city_id', '=', 'package_city.id')
                    ->join('city', 'city.id', '=', 'package_city.city_id')
                    ->whereRaw($dynamicWhere)
                    ->groupBy("package.id")
                    ->get();
    }
    /**
    * Returns all records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function retrivePackage($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Package::query();
        
        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('package.id', 'desc');
        }

        if (!empty($where)) {
            $query->where($where);
        }

        return $query->where(['package.deleted' => 0])
                    ->select('package.*', DB::raw('CASE WHEN package.status = 1 THEN "Active" ELSE "Inactive" END as status'), DB::raw('MiN(morning_actual_price) as actual_price'), DB::raw('MiN(morning_discount_price) as discount_price'),'city.name as cityname')
                    ->join('package_city', 'package.id', '=', 'package_city.package_id')
                    ->join('city_date_package', 'city_date_package.package_city_id', '=', 'package_city.id')
                    ->join('city', 'city.id', '=', 'package_city.city_id')
                    ->whereRaw($dynamicWhere)
                    ->groupBy("package.id")
                    ->first();
    }
    /**
    * Returns all records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getDateCityPackage($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Package::query();
        
        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('package.id', 'desc');
        }

        if (!empty($where)) {
            $query->where($where);
        }

        return DB::table('package_city')
                    ->join('city_date_package', 'city_date_package.package_city_id', '=', 'package_city.id')
                    ->join('city', 'package_city.city_id', '=', 'city.id')
                    ->join('package', 'package.id', '=', 'package_city.package_id')
                    ->whereRaw($dynamicWhere)
                    ->select('city_date_package.*','city_date_package.id as citypackageid','package.activity_time','city.morning_start','city.morning_end','city.afternoon_start','city.afternoon_end','city.evening_start','city.evening_end','city.night_start','city.night_end','package.price_for_kids',DB::raw('IF(morning_active = 1 || afternoon_active = 1 || evening_active = 1 || night_active = 1, "Active", "Inactive") as entirestatus'))
                    ->orderBy('city_date_package.package_date','asc')
                    ->get();
    }

    /**
    * Returns all records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getDateCityInventoryPackage($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Package::query();
        
        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('package.id', 'desc');
        }

        if (!empty($where)) {
            $query->where($where);
        }

        return DB::table('package_city')
                    ->join('city_date_package', 'city_date_package.package_city_id', '=', 'package_city.id')
                    ->join('city', 'package_city.city_id', '=', 'city.id')
                    ->join('package', 'package.id', '=', 'package_city.package_id')
                    ->whereRaw($dynamicWhere)
                    ->select('city_date_package.*','city_date_package.id as citypackageid','package.activity_time','city.morning_start','city.morning_end','city.afternoon_start','city.afternoon_end','city.evening_start','city.evening_end','city.night_start','city.night_end','package.price_for_kids',DB::raw('IF(morning_active = 1 || afternoon_active = 1 || evening_active = 1 || night_active = 1, "Active", "Inactive") as entirestatus'))
                    ->orderBy('city_date_package.package_date','asc')
                    ->get();
    }
}
