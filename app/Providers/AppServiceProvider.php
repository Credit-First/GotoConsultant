<?php

namespace App\Providers;

use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Database\Events\TransactionCommitted;
use Illuminate\Database\Events\TransactionRolledBack;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use App\Models\Categories;
use App\Models\Consultant;
use App\Models\Customer;
use Auth;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer('*', function ($view) {
            $user_info = null;
            if (Auth::check()) {
                if (Auth::user()->role == 'consultant') {
                    $user_info = Consultant::where('user_id', Auth::user()->id)->with('profile', 'user', 'company')->first();
                } else if (Auth::user()->role == 'customer') {
                    $user_info = Customer::where('user_id', Auth::user()->id)->with('profile', 'user', 'company')->first();
                }
            }
            $categories = Categories::all();
            $lang = app()->getLocale();
            $view->with(['categories' => $categories, 'user_info' => $user_info, 'lang' => $lang]);
        });


        if ($this->app->environment('local')) {
            error_reporting(E_ALL ^ E_NOTICE);

            \Event::listen(
                [
                    TransactionBeginning::class,
                ],
                function ($event) {
                    //return; // to comment

                    $str   = "  BEGIN; ";
                    $dbLog = new \Monolog\Logger('Query');
                    if (isDeveloperComp()) {
                        $dbLog->pushHandler(new \Monolog\Handler\RotatingFileHandler(storage_path('logs/Query.txt'), 5, \Monolog\Logger::DEBUG));
                        $dbLog->info($str);
                        $dbLog->info('');
                        $dbLog->info('');
                    }
                    writeSqlToLog($str, '', true);
                    writeSqlToLog("");
                    writeSqlToLog("");
                });


            \Event::listen(
                [
                    TransactionCommitted::class,
                ],
                function ($event) {
                    //return; // to comment

                    $str   = "  COMMIT; ";
                    $dbLog = new \Monolog\Logger('Query');
                    if (isDeveloperComp()) {
                        $dbLog->pushHandler(new \Monolog\Handler\RotatingFileHandler(storage_path('logs/Query.txt'), 5, \Monolog\Logger::DEBUG));
                        $dbLog->info($str);
                        $dbLog->info('');
                        $dbLog->info('');
                    }
                    writeSqlToLog($str, '', true);
                    writeSqlToLog("");
                    writeSqlToLog("");
                });


            \Event::listen(
                [
                    TransactionRolledBack::class,
                ],
                function ($event) {
                    //return; // to comment
                    //
                    $str   = "  ROLLBACK; ";
                    $dbLog = new \Monolog\Logger('Query');
                    if (isDeveloperComp()) {
                        $dbLog->pushHandler(new \Monolog\Handler\RotatingFileHandler(storage_path('logs/Query.txt'), 5, \Monolog\Logger::DEBUG));
                        $dbLog->info($str);
                        $dbLog->info('');
                        $dbLog->info('');
                    }
                    writeSqlToLog($str, '', true);
                    writeSqlToLog("");
                    writeSqlToLog("");
                });


            \DB::listen(function ($query) {
                // return; // to comment

                $bindings = [];
                foreach ($query->bindings as $binding) {
                    if ($binding instanceof \DateTime) {
                        $bindings[] = $binding->format('Y-m-d H:i:s');
                        continue;
                    }
                    $bindings[] = $binding;
                }

                $dbLog = new \Monolog\Logger('Query');
                if (isDeveloperComp()) {
                    $dbLog->pushHandler(new \Monolog\Handler\RotatingFileHandler(storage_path('logs/Query.txt'), 5, \Monolog\Logger::DEBUG));
                }
                $str = $query->sql;
                $str = str_replace('%', 'QWERTYQWERTY', $str);
                $str = str_replace('?', "%s", $str);
                if (count(dataWrapper($bindings)) == 1) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'");
                }
                if (count(dataWrapper($bindings)) == 2) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'");
                }
                if (count(dataWrapper($bindings)) == 3) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'", "'" . dataWrapper
                        ($bindings[2]) . "'");
                }
                if (count(dataWrapper($bindings)) == 4) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'", "'" . dataWrapper
                        ($bindings[2]) . "'",
                        "'" . dataWrapper($bindings[3]) . "'");
                }
                if (count(dataWrapper($bindings)) == 5) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'", "'" . dataWrapper
                        ($bindings[2]) . "'",
                        "'" . dataWrapper($bindings[3]) . "'",
                        "'" . dataWrapper($bindings[4]) . "'");
                }
                if (count(dataWrapper($bindings)) == 6) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'", "'" . dataWrapper($bindings[2]) . "'",
                        "'" . dataWrapper($bindings[3]) . "'",
                        "'" . dataWrapper($bindings[4]) . "'", "'" . dataWrapper($bindings[5]) . "'");
                }


                if (count(dataWrapper($bindings)) == 7) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'", "'" . dataWrapper($bindings[2]) . "'",
                        "'" . dataWrapper($bindings[3]) . "'",
                        "'" . dataWrapper($bindings[4]) . "'", "'" . dataWrapper($bindings[5]) . "'", "'" . dataWrapper($bindings[6]) . "'");
                }

                if (count(dataWrapper($bindings)) == 8) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0],0) . "'", "'" . dataWrapper($bindings[1],1) . "'", "'" .
                                                                                                                           dataWrapper($bindings[2],2) . "'",
                        "'" . dataWrapper($bindings[3],3) . "'",
                        "'" . dataWrapper($bindings[4],4) . "'", "'" . dataWrapper($bindings[5],5) . "'",
                        "'" . dataWrapper($bindings[6],6) . "'", "'" . dataWrapper($bindings[7],7) . "'");
                }

                if (count(dataWrapper($bindings)) == 9) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'", "'" . dataWrapper($bindings[2]) . "'",
                        "'" . dataWrapper($bindings[3]) . "'",
                        "'" . dataWrapper($bindings[4]) . "'", "'" . dataWrapper($bindings[5]) . "'", "'" . dataWrapper($bindings[6]) . "'", "'" . dataWrapper($bindings[7]) . "'",
                        "'" . dataWrapper($bindings[8]) . "'");
                }

                if (count(dataWrapper($bindings)) == 10) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'", "'" . dataWrapper($bindings[2]) . "'",
                        "'" . dataWrapper($bindings[3]) . "'",
                        "'" . dataWrapper($bindings[4]) . "'", "'" . dataWrapper($bindings[5]) . "'", "'" . dataWrapper($bindings[6]) . "'", "'" . dataWrapper($bindings[7]) . "'",
                        "'" . dataWrapper($bindings[8]) . "'", "'" . dataWrapper($bindings[9]) . "'");
                }

                if (count(dataWrapper($bindings)) == 11) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'", "'" . dataWrapper($bindings[2]) . "'",
                        "'" . dataWrapper($bindings[3]) . "'",
                        "'" . dataWrapper($bindings[4]) . "'", "'" . dataWrapper($bindings[5]) . "'", "'" . dataWrapper($bindings[6]) . "'", "'" . dataWrapper($bindings[7]) . "'",
                        "'" . dataWrapper($bindings[8]) . "'", "'" . dataWrapper($bindings[9]) . "'", "'" . dataWrapper($bindings[10]) . "'");
                }

                if (count(dataWrapper($bindings)) == 12) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'", "'" . dataWrapper($bindings[2]) . "'",
                        "'" . dataWrapper($bindings[3]) . "'",
                        "'" . dataWrapper($bindings[4]) . "'", "'" . dataWrapper($bindings[5]) . "'", "'" . dataWrapper($bindings[6]) . "'", "'" . dataWrapper($bindings[7]) . "'",
                        "'" . dataWrapper($bindings[8]) . "'", "'" . dataWrapper($bindings[9]) . "'", "'" . dataWrapper($bindings[10]) . "'", "'" . dataWrapper($bindings[11]) . "'");
                }


                if (count(dataWrapper($bindings)) == 13) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'", "'" . dataWrapper($bindings[2]) . "'",
                        "'" . dataWrapper($bindings[3]) . "'",
                        "'" . dataWrapper($bindings[4]) . "'", "'" . dataWrapper($bindings[5]) . "'", "'" . dataWrapper($bindings[6]) . "'", "'" . dataWrapper($bindings[7]) . "'",
                        "'" . dataWrapper($bindings[8]) . "'", "'" . dataWrapper($bindings[9]) . "'", "'" . dataWrapper($bindings[10]) . "'", "'" . dataWrapper($bindings[11]) . "'",
                        "'" . dataWrapper($bindings[12]) . "'");
                }


                if (count(dataWrapper($bindings)) == 14) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'", "'" . dataWrapper($bindings[2]) . "'",
                        "'" . dataWrapper($bindings[3]) . "'",
                        "'" . dataWrapper($bindings[4]) . "'", "'" . dataWrapper($bindings[5]) . "'", "'" . dataWrapper($bindings[6]) . "'", "'" . dataWrapper($bindings[7]) . "'",
                        "'" . dataWrapper($bindings[8]) . "'", "'" . dataWrapper($bindings[9]) . "'", "'" . dataWrapper($bindings[10]) . "'", "'" . dataWrapper($bindings[11]) . "'",
                        "'" . dataWrapper($bindings[12]) . "'", "'" . dataWrapper($bindings[13]) . "'");
                }


                if (count(dataWrapper($bindings)) == 15) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'", "'" . dataWrapper($bindings[2]) . "'",
                        "'" . dataWrapper($bindings[3]) . "'",
                        "'" . dataWrapper($bindings[4]) . "'", "'" . dataWrapper($bindings[5]) . "'", "'" . dataWrapper($bindings[6]) . "'", "'" . dataWrapper($bindings[7]) . "'",
                        "'" . dataWrapper($bindings[8]) . "'", "'" . dataWrapper($bindings[9]) . "'", "'" . dataWrapper($bindings[10]) . "'", "'" . dataWrapper($bindings[11]) . "'",
                        "'" . dataWrapper($bindings[12]) . "'", "'" . dataWrapper($bindings[13]) . "'", "'" . dataWrapper($bindings[14]) . "'");
                }


                if (count(dataWrapper($bindings)) == 16) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'", "'" . dataWrapper($bindings[2]) . "'",
                        "'" . dataWrapper($bindings[3]) . "'",
                        "'" . dataWrapper($bindings[4]) . "'", "'" . dataWrapper($bindings[5]) . "'", "'" . dataWrapper($bindings[6]) . "'", "'" . dataWrapper($bindings[7]) . "'",
                        "'" . dataWrapper($bindings[8]) . "'", "'" . dataWrapper($bindings[9]) . "'", "'" . dataWrapper($bindings[10]) . "'", "'" . dataWrapper($bindings[11]) . "'",
                        "'" . dataWrapper($bindings[12]) . "'", "'" . dataWrapper($bindings[13]) . "'", "'" . dataWrapper($bindings[14]) . "'", "'" . dataWrapper($bindings[15]) . "'");
                }


                if (count(dataWrapper($bindings)) == 17) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'", "'" . dataWrapper($bindings[2]) . "'",
                        "'" . dataWrapper($bindings[3]) . "'",
                        "'" . dataWrapper($bindings[4]) . "'", "'" . dataWrapper($bindings[5]) . "'", "'" . dataWrapper($bindings[6]) . "'", "'" . dataWrapper($bindings[7]) . "'",
                        "'" . dataWrapper($bindings[8]) . "'", "'" . dataWrapper($bindings[9]) . "'", "'" . dataWrapper($bindings[10]) . "'", "'" . dataWrapper($bindings[11]) . "'",
                        "'" . dataWrapper($bindings[12]) . "'", "'" . dataWrapper($bindings[13]) . "'", "'" . dataWrapper($bindings[14]) . "'", "'" . dataWrapper($bindings[15]) . "'",
                        "'" . dataWrapper($bindings[16]) . "'");
                }

                if (count(dataWrapper($bindings)) == 18) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'", "'" . dataWrapper($bindings[2]) . "'",
                        "'" . dataWrapper($bindings[3]) . "'",
                        "'" . dataWrapper($bindings[4]) . "'", "'" . dataWrapper($bindings[5]) . "'", "'" . dataWrapper($bindings[6]) . "'", "'" . dataWrapper($bindings[7]) . "'",
                        "'" . dataWrapper($bindings[8]) . "'", "'" . dataWrapper($bindings[9]) . "'", "'" . dataWrapper($bindings[10]) . "'", "'" . dataWrapper($bindings[11]) . "'",
                        "'" . dataWrapper($bindings[12]) . "'", "'" . dataWrapper($bindings[13]) . "'", "'" . dataWrapper($bindings[14]) . "'", "'" . dataWrapper($bindings[15]) . "'",
                        "'" . dataWrapper($bindings[16]) . "'", "'" . dataWrapper($bindings[17]) . "'");
                }

                if (count(dataWrapper($bindings)) == 19) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'", "'" . dataWrapper($bindings[2]) . "'",
                        "'" . dataWrapper($bindings[3]) . "'",
                        "'" . dataWrapper($bindings[4]) . "'", "'" . dataWrapper($bindings[5]) . "'", "'" . dataWrapper($bindings[6]) . "'", "'" . dataWrapper($bindings[7]) . "'",
                        "'" . dataWrapper($bindings[8]) . "'", "'" . dataWrapper($bindings[9]) . "'", "'" . dataWrapper($bindings[10]) . "'", "'" . dataWrapper($bindings[11]) . "'",
                        "'" . dataWrapper($bindings[12]) . "'", "'" . dataWrapper($bindings[13]) . "'", "'" . dataWrapper($bindings[14]) . "'", "'" . dataWrapper($bindings[15]) . "'",
                        "'" . dataWrapper($bindings[16]) . "'", "'" . dataWrapper($bindings[17]) . "'", "'" . dataWrapper($bindings[18]) . "'");
                }


                if (count(dataWrapper($bindings)) == 20) {
                    $str = sprintf($str, "'" . dataWrapper($bindings[0]) . "'", "'" . dataWrapper($bindings[1]) . "'", "'" . dataWrapper($bindings[2]) . "'",
                        "'" . dataWrapper($bindings[3]) . "'",
                        "'" . dataWrapper($bindings[4]) . "'", "'" . dataWrapper($bindings[5]) . "'", "'" . dataWrapper($bindings[6]) . "'", "'" . dataWrapper($bindings[7]) . "'",
                        "'" . dataWrapper($bindings[8]) . "'", "'" . dataWrapper($bindings[9]) . "'", "'" . dataWrapper($bindings[10]) . "'", "'" . dataWrapper($bindings[11]) . "'",
                        "'" . dataWrapper($bindings[12]) . "'", "'" . dataWrapper($bindings[13]) . "'", "'" . dataWrapper($bindings[14]) . "'", "'" . dataWrapper($bindings[15]) . "'",
                        "'" . dataWrapper($bindings[16]) . "'", "'" . dataWrapper($bindings[17]) . "'", "'" . dataWrapper($bindings[18]) . "'", "'" . dataWrapper($bindings[19]) . "'");
                }


                $str = str_replace('QWERTYQWERTY', '%', $str);

                writeSqlToLog($str, 'Time ' . $query->time . ' : ' . PHP_EOL);
                writeSqlToLog('');
                writeSqlToLog('');
//                $dbLog->info($str, ['Time' => $query->time]);
//                $dbLog->info('');
//                $dbLog->info('');

            }); // \DB::listen(function($query) {


        } // if ($this->app->environment('local')) {

    }
}


function formatSql($sql, $is_break_line = true, $is_include_html = true)
{
//    return $sql;
    $space_char = '  ';

    $bold_start = '';
    $bold_end   = '';
    $break_line = PHP_EOL;

    $sql        = ' ' . $sql . ' ';
    $left_cond  = '~\b(?<![%\'])';
    $right_cond = '(?![%\'])\b~i';
    $sql        = preg_replace($left_cond . "insert[\s]+into" . $right_cond, $space_char . $space_char . $bold_start . "INSERT INTO" . $bold_end, $sql);
    $sql        = preg_replace($left_cond . "insert" . $right_cond, $space_char . $bold_start . "INSERT" . $bold_end, $sql);
    $sql        = preg_replace($left_cond . "delete" . $right_cond, $space_char . $bold_start . "DELETE" . $bold_end, $sql);
    $sql        = preg_replace($left_cond . "values" . $right_cond, $break_line . $space_char . $space_char . $bold_start . "VALUES" . $bold_end, $sql);
    $sql        = preg_replace($left_cond . "update" . $right_cond, $space_char . $bold_start . "UPDATE" . $bold_end, $sql);
    $sql        = preg_replace($left_cond . "inner[\s]+join" . $right_cond, $break_line . $space_char . $space_char . $bold_start . "INNER JOIN" . $bold_end,
        $sql);
    $sql        = preg_replace($left_cond . "straight[\s]+join" . $right_cond,
        $break_line . $space_char . $space_char . $bold_start . "STRAIGHT_JOIN" . $bold_end, $sql);
    $sql        = preg_replace($left_cond . "left[\s]+join" . $right_cond, $break_line . $space_char . $space_char . $bold_start . "LEFT JOIN" . $bold_end,
        $sql);
    $sql        = preg_replace($left_cond . "select" . $right_cond, $space_char . $bold_start . "SELECT" . $bold_end, $sql);
    $sql        = preg_replace($left_cond . "from" . $right_cond, $break_line . $space_char . $space_char . $bold_start . "FROM" . $bold_end, $sql);
    $sql        = preg_replace($left_cond . "where" . $right_cond, $break_line . $space_char . $space_char . $bold_start . "WHERE" . $bold_end, $sql);
    $sql        = preg_replace($left_cond . "group by" . $right_cond, $break_line . $space_char . $space_char . "GROUP BY" . $bold_end, $sql);
    $sql        = preg_replace($left_cond . "having" . $right_cond, $break_line . $space_char . $bold_start . "HAVING" . $bold_end, $sql);
    $sql        = preg_replace($left_cond . "order[\s]+by" . $right_cond, $break_line . $space_char . $space_char . $bold_start . "ORDER BY" . $bold_end, $sql);
    $sql        = preg_replace($left_cond . "and" . $right_cond, $space_char . $space_char . $bold_start . "AND" . $bold_end, $sql);
    $sql        = preg_replace($left_cond . "or" . $right_cond, $space_char . $space_char . $bold_start . "OR" . $bold_end, $sql);
    $sql        = preg_replace($left_cond . "as" . $right_cond, $space_char . $space_char . $bold_start . "AS" . $bold_end, $sql);
    $sql        = preg_replace($left_cond . "exists" . $right_cond, $break_line . $space_char . $space_char . $bold_start . "EXISTS" . $bold_end, $sql);

    return $sql;
}

function writeSqlToLog($contents, string $descr_text = '', bool $is_sql = false, string $file_name = '')
{
    $debug = config('app.debug');
    if ( ! $debug) {
        return;
    }

    $url = config('app.url');

    $pos = strpos($url, 'local-hostels3.com');
    if ( ! ($pos === false)) {
//        return;
    }

    if (empty($descr_text)) {
        $descr_text = '';
    }
    try {
        if (empty($file_name)) {
            $file_name = storage_path() . '/logs/sql-tracing-' /*. (strftime("%y-%m-%d"))*/ . '.txt';
        }
//        echo '<pre>$file_name::'.print_r($file_name,true).'</pre>';
//                $fd = fopen($file_name, ($is_clear_text ? "w+" : "a+"));
        $fd = fopen($file_name, "a+");

//        echo '<pre>$contents::'.print_r($contents,true).'</pre>';
        if (is_array($contents)) {
            $contents = print_r($contents, true);
        }
        $is_sql = 1;
        if ($is_sql) {
            fwrite($fd, $descr_text . formatSql($contents, true) . chr(13));
        } else {
            fwrite($fd, $descr_text . $contents . chr(13));
        }
        //                     echo '<b><I>' . gettype($Var) . "</I>" . '&nbsp;$Var:=<font color= red>&nbsp;' . AppUtil::showFormattedSql($Var) . "</font></b></h5>";
//        echo '<pre>++$contents::'.print_r($contents,true).'</pre>';

        fclose($fd);

//        die("-1 XXZ writeSqlToLog");
        return true;
    } catch (Exception $lException) {
        return false;
    }
}


function isDeveloperComp($check_debug = false)
{
    if ($check_debug) {
        $debug = config('app.debug');
        if ( ! $debug) {
            return;
        }
    }

//    if ( $this->isRunningUnderDocker() ) {
//        return true;
//    }

    $url = config('app.url');
    $pos = strpos($url, 'local-ads-backend-api.com');
    if ( ! ($pos === false)) {
        return true;
    }

    return false;
}

function dataWrapper($value,$index=null) {
    return $value;

    if (gettype($value) == 'object') {
        return $value->format("d-m-Y");
    }
    return $value;
}
