<?php
/**
 * Created by PhpStorm.
 * User: shangjinglong
 * Date: 05/09/2017
 * Time: 18:40
 */

namespace Shangjinglong\Dictionary;

use Illuminate\Support\Facades\DB;


class Dictionary
{
    public function getTables()
    {
        $sql = "SHOW TABLES";
        $tables = DB::select($sql);
        $arrTables = array();
        foreach ($tables as $k => $v) {
            $kv = 'Tables_in_' . strtolower(env('DB_DATABASE'));
            $arrTables[$k]['table_name'] = $v->$kv;
        };
        return $arrTables;
    }

    public function getFieldsByTable($table)
    {
        $sql = "SELECT * FROM information_schema.`COLUMNS` WHERE TABLE_SCHEMA='" . strtolower(env('DB_DATABASE')) . "' AND TABLE_NAME='" . $table . "'";
        $fields = DB::select($sql);
        return $fields;
    }

    public function getStructure()
    {
        $arrTables = $this->getTables();
        foreach ($arrTables as $k => $v) {
            $arrFields = $this->getFieldsByTable($v['table_name']);

            $arrTmpFields = array();
            foreach ($arrFields as $k2 => $v2) {
                $arrTmpFields[$k2]['fields_name'] = $v2->COLUMN_NAME;
                $arrTmpFields[$k2]['fields_type'] = $v2->COLUMN_TYPE;
                $arrTmpFields[$k2]['fields_extra'] = $v2->EXTRA;
                $arrTmpFields[$k2]['fields_default'] = $v2->COLUMN_DEFAULT;
                $arrTmpFields[$k2]['fields_comment'] = $v2->COLUMN_COMMENT;
                $arrTmpFields[$k2]['fields_key'] = $v2->COLUMN_KEY;
            }
            $tableName = $v['table_name'];
            $arrDbStructure[$tableName] = $arrTmpFields;
        }
        return $arrDbStructure;
    }


    public function generate()
    {
        $arrDbStructure = $this->getStructure();
        $strTable = '';
        $i = 0;
        foreach ($arrDbStructure as $k => $v) {
            $i += 1;
            $strTable .= '<h4>No.' . $i . '—' . $k . '</h4>';
            $strTable .= '<table border="2">';
            $strTable .= '<tr>
					<th width="150px">Field</th>
					<th width="200px">Type</th>
					<th width="450px">Comment</th>
				 </tr>';
            $str = '';
            foreach ($v as $k1 => $v1) {
                $str .= '<tr><td>' . $v1['fields_name'] . '</td><td>' . $v1['fields_type'] . '</td><td>' . $v1['fields_comment'] . '</td></tr>';
            }
            $strTable .= $str . '</table><br><br>';
        }

        $strTable = '<!DOCTYPE html>
					<html lang="zh-cn">
					<head>
						<meta charset="utf-8" />
						<title>' . env('DB_DATABASE') . ' 数据字典</title>
		
					</head>
					<style type="text/css">
						table{border:1px solid black;border-collapse:collapse;}
						table, td, th{border:1px solid black;}
						tr{width:1200px;}
						td{text-align:left;padding-left:10px;}
							
					</style>
					<body>' . $strTable . '</body></html>';
        //生成html文件
        $filepath = public_path() . '/dictionary.html';
        file_put_contents($filepath, $strTable);
        //生成doc文件
        $filepathdoc = public_path() . '/dictionary.doc';
        file_put_contents($filepathdoc, $strTable);
        //生成excel文件
        $filepathxls = public_path() . '/dictionary.xls';
        file_put_contents($filepathxls, $strTable);

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="author" content="shangjinglong" />
            <title>Database Dictionary Generator v1.0</title>
            <link rel="stylesheet"
                  href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css">
        </head>
        <body>
        <div class="container">
            <div class="page-header">
                <h1>Database Dictionary Generator v1.0</h1>
            </div>
            <div class="row" style="margin-top:180px;">
                <form class="form-horizontal" role="form" method="post">
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-4">';
        $html .= '<a class="btn btn-primary btn-lg btn-block" href="/dictionary.html">Detail</a><br /><br />';
        $html .= '<a class="btn btn-primary btn-lg btn-block" href="/dictionary.doc">Download(.doc)</a><br /><br />';
        $html .= '<a class="btn btn-primary btn-lg btn-block" href="/dictionary.xls">Download(.xls)</a><br /><br />';
        $html .= '</div>
                    </div>
                </form>
            </div>
        </div>
        </body>
        </html>';
        return $html;
    }
}