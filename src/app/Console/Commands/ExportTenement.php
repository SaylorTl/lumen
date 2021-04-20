<?php
namespace App\Console\Commands;

use App\Http\Models\UserModel;
use PDO;
use Illuminate\Console\Command;
use App\Http\Models\EmployeeModel;
use App\Http\Models\TenementModel;

class ExportTenement extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:importtenement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate order monitor';

    /**
     * Create a new command instance.
     *
     * @param DripEmailer $drip
     */



    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $realpath =  realpath(dirname(__FILE__));
        $fileName = $realpath."/c.xlsx";
        if (!file_exists($fileName)) {
            exit("文件" . $fileName . "不存在");
        }
        $objPHPExcel = \PHPExcel_IOFactory::load($fileName);//获取sheet表格数目
        $sheetSelected = 0;
        $objPHPExcel->setActiveSheetIndex($sheetSelected);//获取表格行数
        $rowCount = $objPHPExcel->getActiveSheet()->getHighestRow();//获取表格列数
        $columnCount = 'N';

        $yhytagDb = $this->yhytagDb();
        $select_sql = "select `tag_id`,`tag_name` from  yhy_tag where  type_id in ('28','66','129','64','29','26','62','27','65','90','58','25')";
        $tag_arr = $yhytagDb->query($select_sql)
            -> fetchAll(PDO::FETCH_ASSOC);
        $yhypmDb = $this->yhypmDb();
        for ($row = 2; $row <= $rowCount; $row++) {
            $dataArr = [];
            for ($column = 'A'; $column <= $columnCount; $column++) {
                $val = $objPHPExcel->getActiveSheet()->getCell($column . $row)->getValue();
                $dataArr[] = htmlspecialchars($val);
            }
            $P = [];
            if(!isMobile($dataArr[5])){
                continue;
            }
            $resource_url = env('RESOURCE_URL', '');
            $tenement_res = curlPOST($resource_url.'/resource/id/generator', ['type_name'=>'tenement']);
            $tenement_res = json_decode($tenement_res,true);
            if ($tenement_res['code'] != 0 || ($tenement_res['code'] == 0 && empty($tenement_res['content']))) {
                dieJson(1001, $tenement_res['message']);
            }
            $P['tenement_id'] =  $tenement_res['content'];
            $P['project_id'] = $dataArr[0];
            $pm_sql = "select `project_id`,`app_id` from yhy_project where project_id='{$P['project_id']}'";
            $pm_result = $yhypmDb->query($pm_sql)
                -> fetch(PDO::FETCH_ASSOC);
            $P['tenement_type_tag_id'] = !empty($tag_arr[$dataArr[1]])?$tag_arr[$dataArr[1]]['tag_id']:411;
            $P['real_name'] =  $dataArr[2];
            $P['sex'] = !empty($tag_arr[$dataArr[3]])?$tag_arr[$dataArr[3]]['tag_id']:400;
            $P['birth_day'] = $dataArr[4];
            $P['customer_type_tag_id'] = '196';
            $P['mobile'] = $dataArr[5];
            $P['tenement_check_status'] = 'N';
            $P['license_tag_id'] = !empty($tag_arr[$dataArr[6]])?$tag_arr[$dataArr[6]]['tag_id']:413;
            $P['license_num'] = !empty($tag_arr[$dataArr[7]])?$tag_arr[$dataArr[7]]['tag_id']:1;
            $P['app_id'] = $pm_result?$pm_result['app_id']:"GjVbGM7jnS5g";
            $employee_res = EmployeeModel::showUser(['user_name'=>$dataArr[8],'app_id'=>$pm_result['app_id']]);
            $P['liable_employee_id'] = $employee_res?$employee_res[0]['employee_id']:"";
            $insertRes = TenementModel::teneAdd($P);
        }
        die();

    }

    /**
     * @return PDO
     * 连接eparking数据库
     */
    private function yhyuserDb()
    {
        $DB_HOST = env('DB_HOST','');
        $DB_PORT = env('DB_PORT','');
        $DB_DATABASE = env('DB_DATABASE','');
        $username = env('DB_USERNAME','');
        $password = env('DB_PASSWORD','');
        $dsn = "mysql:host=".$DB_HOST.";port=".$DB_PORT.";dbname=".$DB_DATABASE.";charset=utf8";
        $pdo = new PDO($dsn, $username, $password);
        return $pdo;
    }

    /**
     * @return PDO
     * 连接eparking数据库
     */
    private function yhytagDb()
    {
        $DB_HOST = env('DB_TAG_HOST','');
        $DB_PORT = env('DB_TAG_PORT','');
        $DB_DATABASE = env('DB_TAG_DATABASE','');
        $username = env('DB_TAG_USERNAME','');
        $password = env('DB_TAG_PASSWORD','');
        $dsn = "mysql:host=".$DB_HOST.";port=".$DB_PORT.";dbname=".$DB_DATABASE.";charset=utf8";
        $pdo = new PDO($dsn, $username, $password);
        return $pdo;
    }

    /**
     * @return PDO
     * 连接eparking数据库
     */
    private function yhypmDb()
    {
        $DB_HOST = env('DB_PM_HOST','');
        $DB_PORT = env('DB_PM_PORT','');
        $DB_DATABASE = env('DB_PM_DATABASE','');
        $username = env('DB_PM_USERNAME','');
        $password = env('DB_PM_PASSWORD','');
        $dsn = "mysql:host=".$DB_HOST.";port=".$DB_PORT.";dbname=".$DB_DATABASE.";charset=utf8";
        $pdo = new PDO($dsn, $username, $password);
        return $pdo;
    }
}