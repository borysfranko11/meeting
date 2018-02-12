<?php
/**
 * Created by PhpStorm.
 * Desc:
 * User: jzco
 * Date: 2017/2/13
 * Time: 15:59
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    protected $_link = '';
    protected $_table = '';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * des: 解析过程的路由, 负责将每个处理分配到各个执行方法
     * @param: $conditions [type|array]
     */
    protected function parseRouter( $conditions=[] )
    {
        $dup = $conditions;

        foreach( $dup as $key => $condition )
        {
            switch( $key )
            {
                case 'wherein':
                    $this -> parseWherein( $conditions['wherein'] );
                break;
                case 'where':
                    $this -> parseWheres( $conditions['where'] );
                break;
            }
        }
    }

    /**
     * des: 解析 wherein 子句, 并建立查询基本关系
     * @param: $params
     */
    protected function parseWherein( $params )
    {
        // 备份参数, 避免操作中改变原参数集
        $dup = $params;

        foreach( $dup as $key => $values )
        {
            // 过滤掉无数据的操作请求
            if( empty( $values ) )
            {
                continue;
            }

            $this -> _link -> wherein( $key, $values['value'] );
        }
    }

    /**
     * des: 解析 where 子句, 并建立查询基本关系
     * @param: $params
     */
    protected function parseWheres( $params )
    {
        // 备份参数, 避免操作中改变原参数集
        $dup = $params;

        foreach( $dup as $key => $values )
        {
            // 过滤掉无数据的操作请求
            if( empty( $values ) )
            {
                continue;
            }

            $this -> _link -> where( $key, $values['symbol'], $values['value'] );
        }
    }
}