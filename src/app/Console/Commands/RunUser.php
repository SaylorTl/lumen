<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/17
 * Time: 14:18
 */

namespace App\Console\Commands;

use PDO;
use App\Http\Models\IceModel;
use Illuminate\Console\Command;

class RunUser extends Command{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:runuser {mobile}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate order monitor';

    /**
     * Create a new command instance.
     *
     * @param  DripEmailer  $drip
     */



    private $userDb;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle(){
        date_default_timezone_set('Asia/Shanghai');
        set_time_limit(0);
        $mobile = $this->argument('mobile');
        $this->userDb = $this->etuserDb();
        $this->delUser($mobile);
    }

    /**
     * oa账号
     */
    public function delUser($mobile){
        $user_res = $this->userDb->query("select user_id,mobile from yhy_users where mobile='".$mobile."'")
            -> fetchall(PDO::FETCH_ASSOC);

        if(!empty($user_res)){
             $tenement_arr = $this->userDb->query("select tenement_id from yhy_tenement  where user_id='".$user_res[0]['user_id']."'")
                -> fetchall(PDO::FETCH_ASSOC);
             if(!empty($tenement_arr)){
                 foreach($tenement_arr as $value){
                     $this->userDb->exec("delete from yhy_tenement_car  where tenement_id='".$value['tenement_id']."'");

                     $this->userDb->exec("delete from yhy_tenement_family  where tenement_id='".$value['tenement_id']."'");

                     $this->userDb->exec("delete from yhy_tenement_house  where tenement_id='".$value['tenement_id']."'");

                     $this->userDb->exec("delete from yhy_tenement_label  where tenement_id='".$value['tenement_id']."'");
                 }
             }

            $visit_arr = $this->userDb->query("select visit_id from yhy_visitor  where user_id='".$user_res[0]['user_id']."'")
                -> fetchall(PDO::FETCH_ASSOC);
            if(!empty($visit_arr)){
                foreach($visit_arr as $val){

                    $this->userDb->exec("delete from yhy_visitor_car  where visit_id='".$val['visit_id']."'");

                    $this->userDb->exec("delete from yhy_visitor_follow  where visit_id='".$val['visit_id']."'");

                    $this->userDb->exec("delete from yhy_visitor_label  where visit_id='".$val['visit_id']."'");

                }
            }

            $this->userDb->exec("delete from yhy_tenement  where user_id='".$user_res[0]['user_id']."'");

            $this->userDb->exec("delete from yhy_visitor  where user_id='".$user_res[0]['user_id']."'");

            $this->userDb->exec("delete from yhy_users  where user_id='".$user_res[0]['user_id']."'");

            $this->userDb->exec("delete from yhy_client  where user_id='".$user_res[0]['user_id']."'");
        }


    }

    /**
     * 私有账号
     */
    public function runPrivateUser($i=0){
        //前端用户
        $pagesize =200;
        $isFinish = false;
        $offset = 0;
        while(!$isFinish){
            $result = $this->pdo2->query("select * from et_member where mobile!='' and type='2'
             limit ".$offset.",".$pagesize)
                -> fetchall(PDO::FETCH_ASSOC);
            $offset = $offset +$pagesize;
            if(count($result) <200){
                $isFinish = true;
            }
            foreach($result as $value){
                $res = $this->userDb->query("select user_id,mobile from et_users where mobile='{$value['mobile']}'")
                    -> fetchall(PDO::FETCH_ASSOC);
                $create_at = date("Y-m-d H:i:s",time());
                $update_at = date("Y-m-d H:i:s",time());
                if(empty($res)){
                    $username = !empty($value['username'])?$value['username']:$value['mobile'];
                    $this->userDb->exec("INSERT INTO `et_users` (
	                `username`,`mobile`,`fullname`,`create_at`,`update_at`
                     )VALUES('{$username}','{$value['mobile']}','{$value['fullname']}'
                     ,'{$create_at}','{$update_at}');");
                    $user_id = $this->userDb->lastInsertId();
                }else{
                    $user_id = $res[0]['user_id'];
                };

                $data = $this->userDb->query("select * from et_member where member_id='{$value['id']}'")
                    -> fetchall(PDO::FETCH_ASSOC);
                if(empty($data)){
                    $this->userDb->exec("INSERT INTO `et_member` (
                `member_id`,`user_id`,`type`,`password`,`oa`,`role_id`,`dept`,
                `is_lock`,`companies`,`last_login_time`,`last_login_ip`,
                `create_at`,`update_at`)VALUES
                ('{$value['id']}','{$user_id}','{$value['type']}','{$value['password']}','{$value['oa']}',
                 '{$value['role_id']}','{$value['dept']}',
                 '{$value['is_lock']}','{$value['company']}',
                 '{$value['last_login_time']}','{$value['last_login_ip']}','{$create_at}','{$update_at}'
                );");
                }else{
                    $this->userDb->exec("UPDATE `et_member` SET 
                         `user_id` = '{$user_id}' 
                         WHERE (`member_id` = '{$value['id']}')");
                    echo "更新私有账号".$value['id']."\n";
                }
                echo "共已执行".($offset-200+count($result))."条数据\n";
                $i++;
            }
        }
        die("执行完成,总共导入".$i."\n");
    }

    /**
     * @return PDO
     * 连接etback数据库
     */
    private function etuserDb(){
        $DB_HOST = env('DB_HOST','');
        $DB_PORT = env('DB_PORT','');
        $DB_DATABASE = env('DB_DATABASE','');
        $username = env('DB_USERNAME','');
        $password = env('DB_PASSWORD','');
        $dsn = "mysql:host=".$DB_HOST.";port=".$DB_PORT.";dbname=".$DB_DATABASE.";charset=utf8";
        $pdo = new PDO($dsn, $username, $password);
        return $pdo;
    }

}