<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use ZipArchive;


class BackupController extends Controller
{
    

public function index()
{
    $files = File::files(storage_path('app'));

    return view('backup.index', compact('files'));
}
    public function run()
{
    try {
        $filename = 'backup_db_' . date('Y-m-d_H-i-s') . '.sql';
        $path = storage_path('app/' . $filename);

        $tables = DB::select('SHOW TABLES');
        $dbName = env('DB_DATABASE');

        $sql = '';

        foreach ($tables as $table) {
            $tableName = $table->{"Tables_in_$dbName"};

            // Estructura
            $createTable = DB::select("SHOW CREATE TABLE $tableName")[0];
            $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";
            $sql .= $createTable->{"Create Table"} . ";\n\n";

            // Datos
            $rows = DB::table($tableName)->get();

            foreach ($rows as $row) {
                $values = array_map(function ($value) {
                    return addslashes($value);
                }, (array)$row);

                $sql .= "INSERT INTO `$tableName` VALUES ('" . implode("','", $values) . "');\n";
            }

            $sql .= "\n\n";
        }

        // Guardar archivo .sql
        file_put_contents($path, $sql);

        return back()->with('success', '✅ Backup de base de datos generado');

    } catch (\Exception $e) {
        return back()->with('error', '❌ Error: ' . $e->getMessage());
    }
}
   public function download($file)
{
    $path = storage_path('app/' . $file);

    return response()->download($path);
}    
}