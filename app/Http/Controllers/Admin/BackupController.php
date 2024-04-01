<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDO;

class BackupController extends Controller
{
    public function index()
    {
        // Return the view with the form for entering database credentials
        return view('admin.backup.backup');
    }

    public function authorized()
    {
        Log::info('Accessing the authorized panel.');
        // Your existing logic to determine if the user is authorized
    if (!session('backup_authorized')) {
        Log::warning('Unauthorized access attempt to backup panel.');
        return redirect()->route('home')->withErrors('You are not authorized to access this page.');
    }
        return view('admin.backup.backup_page');
    }

    public function store(Request $request)
    {
        Log::info('Attempting to store backup credentials.');

        // Validate the request data using the correct form field names
        // $validated = $request->validate([
        //     'server' => 'required',
        //     'username' => 'required',
        //     'password' => 'required',
        //     'dbname' => 'required',
        // ]);

        Log::info('Validation successful.');

        // Attempt to set and verify the temporary database connection
        Config::set('database.connections.temp', [
            'driver' => 'mysql',
            'host' => $request->input('server'),
            'database' => $request->input('dbname'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ]);

        try {
            DB::connection('temp')->getPdo(); // Attempt to connect with the provided credentials
            Log::info('Database connection successful.');

            // If successful, set session variable and redirect to the backup page
            session(['backup_authorized' => true]); 
            return redirect()->route('admin.backup.panel');
        } catch (\Exception $e) {
            Log::error('Failed to connect to the database with the provided credentials: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to connect to the database with the provided credentials.']);
        }
    }

    public function backup_database()
    {
        $backup_name = "mybackup.sql";
        //ENTER THE RELEVANT INFO BELOW
        $mysqlHostName      = env('DB_HOST');
        $mysqlUserName      = env('DB_USERNAME');
        $mysqlPassword      = env('DB_PASSWORD');
        $DbName             = env('DB_DATABASE');

        $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword",array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $tables = $statement->fetchAll(PDO::FETCH_COLUMN);
        $result = $statement->fetchAll();


        $output = '';
        foreach($tables as $table)
        {
         $show_table_query = "SHOW CREATE TABLE " . $table . "";
         $statement = $connect->prepare($show_table_query);
         $statement->execute();
         $show_table_result = $statement->fetchAll();

         foreach($show_table_result as $show_table_row)
         {
          $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
         }
         $select_query = "SELECT * FROM " . $table . "";
         $statement = $connect->prepare($select_query);
         $statement->execute();
         $total_row = $statement->rowCount();

         for($count=0; $count<$total_row; $count++)
         {
          $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
          $table_column_array = array_keys($single_result);
          $table_value_array = array_values($single_result);
          $output .= "\nINSERT INTO $table (";
          $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
          $output .= "'" . implode("','", $table_value_array) . "');\n";
         }
        }
        $file_name = 'database_backup_on_' . date('y-m-d') . '.sql';
        $file_handle = fopen($file_name, 'w+');
        fwrite($file_handle, $output);
        fclose($file_handle);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
           header('Pragma: public');
           header('Content-Length: ' . filesize($file_name));
           ob_clean();
           flush();
           readfile($file_name);
           unlink($file_name);
    }
}