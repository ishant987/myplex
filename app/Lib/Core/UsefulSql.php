<?php
namespace  App\Lib\Core;

class UsefulSql
{
    public static function getData($sql)
	{
		$data = collect(\DB::select($sql))->first();

		$data = current( (Array)$data );
		
		return $data;
	}
	
	public static function getRow($sql)
	{
		$row = collect(\DB::select($sql))->first();
		
		return $row;
	}

	public static function getSingleValue($tableName,$field,$whereField,$whereFieldVal)
    {
        $sql = \DB::table($tableName)
                    ->select(\DB::raw($field))
                    ->where($whereField, '=', $whereFieldVal)
                    ->first();
        if(!empty($sql))
            return $sql->$field;
        return false;
    }

    public static function getSingleRecord($tableName,$fields,$whereField,$whereFieldVal)
    {
        $sql = \DB::table($tableName)
                    ->select(\DB::raw($fields))
                    ->where($whereField, '=', $whereFieldVal)
                    ->first();
        if(!empty($sql))
            return $sql;
        return false;
    }

    public static function updateSingleRecord($tableName,$whereFldArr,$updFldArr)
    {
        $sql = \DB::table($tableName)
                    ->where($whereFldArr)
                    ->update($updFldArr);
        if(!empty($sql))
            return true;
        return false;
    }
}