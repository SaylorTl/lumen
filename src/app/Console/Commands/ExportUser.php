<?php
namespace App\Console\Commands;

use PDO;
use Illuminate\Console\Command;
use App\Http\Models\EmployeeModel;

class ExportUser extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:importuser';

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
        $fileName = $realpath."/a.xlsx";
        if (!file_exists($fileName)) {
            exit("文件" . $fileName . "不存在");
        }
        $projectFileName = $realpath."/b.xlsx";
        if (!file_exists($fileName)) {
            exit("文件" . $fileName . "不存在");
        }
        $projectPHPExcel = \PHPExcel_IOFactory::load($projectFileName);//获取sheet表格数目
        $sheetCount = $projectPHPExcel->getSheetCount();//默认选中sheet0表
        $sheetSelected = 0;
        $projectPHPExcel->setActiveSheetIndex($sheetSelected);//获取表格行数
        $rowCount = $projectPHPExcel->getActiveSheet()->getHighestRow();//获取表格列数
        $columnCount = 'B';
        $projectArr = array();
        $yhypmDb = $this->yhypmDb();
        for ($row = 2; $row <= $rowCount; $row++) {
            $dataArr = [];
            for ($column = 'A'; $column <= $columnCount; $column++) {
                $val = $projectPHPExcel->getActiveSheet()->getCell($column . $row)->getValue();
                if ('A' == $column) {
                    $dataArr['project_name'] = htmlspecialchars($val);
                }
                if ('B' == $column) {
                    $dataArr['project_id'] = htmlspecialchars($val);
                }
            }
            $projectArr [] = $dataArr;
        }
        $projectArr = array_column($projectArr, null, 'project_name');
        $startTime = time(); //返回当前时间的Unix 时间戳
        $objPHPExcel = \PHPExcel_IOFactory::load($fileName);//获取sheet表格数目
        $sheetCount = $objPHPExcel->getSheetCount();//默认选中sheet0表
        $sheetSelected = 0;
        $objPHPExcel->setActiveSheetIndex($sheetSelected);//获取表格行数
        $rowCount = $objPHPExcel->getActiveSheet()->getHighestRow();//获取表格列数
        $columnCount = 'N';
        $i = 0;
        $j = 0;
        $select_sql = "select `tag_id`,`tag_name`,`type_id` from  yhy_tag where  type_id in ('15','16','17','19','22','23','60','61')";
        $tag_arr = $this->yhytagDb()->query($select_sql)
            -> fetchAll(PDO::FETCH_ASSOC);
        $tag_arr = array_column($tag_arr,null,'tag_name');
        for ($row = 2; $row <= $rowCount; $row++) {
            $dataArr = [];
            for ($column = 'A'; $column <= $columnCount; $column++) {
                $val = $objPHPExcel->getActiveSheet()->getCell($column . $row)->getValue();
                $dataArr[] = htmlspecialchars($val);
            }
            $P = [];
            if( !empty($dataArr[6])){
                $P['birth_day'] = strtotime(($dataArr[6]))?
                    $dataArr[6]:date('Y-m-d',\PHPExcel_Shared_Date::ExcelToPHP($dataArr[6]));
            }else{
                $P['birth_day'] = '';
            }
            if( !empty($dataArr[10])){
                $P['entry_time'] = !strtotime(($dataArr[10]))?
                    strtotime(date('Y-m-d',\PHPExcel_Shared_Date::ExcelToPHP($dataArr[10]))):strtotime(($dataArr[10]));
            }else{
                $P['entry_time'] = '';
            }
            $pm_sql = "select `frame_id` from yhy_frame where frame_name='{$dataArr[1]}' and is_delete='N'";
            $frame_result = $yhypmDb->query($pm_sql)
                -> fetch(PDO::FETCH_ASSOC);
            $P['frame_id'] = $frame_result?$frame_result['frame_id']:"";
            $P['project_id'] = $projectArr[trim($dataArr[0])]['project_id'] ?? '';
            $P['mobile'] = $dataArr[9];
            $P['license_tag_id'] = '77';
            $P['political_tag_id'] = !empty($tag_arr[$dataArr[7]])?$tag_arr[$dataArr[7]]['tag_id']:117;
            $P['full_name'] = str_replace(' ', '', $dataArr[2]);
            $P['sex'] = !empty($tag_arr[$dataArr[3]])?$tag_arr[$dataArr[3]]['tag_id']:400;
            $P['license_num'] = $dataArr[5];
            $P['address'] = $dataArr[8];
            $P['job_tag_id'] = !empty($tag_arr[$dataArr[13]])?$tag_arr[$dataArr[13]]['tag_id']:0;
            $P['labor_type_tag_id'] = !empty($tag_arr[$dataArr[12]])?$tag_arr[$dataArr[12]]['tag_id']:0;
            $P['employee_status_tag_id'] = !empty($tag_arr[$dataArr[11]])?$tag_arr[$dataArr[11]]['tag_id']:0;
            $P['nation_tag_id'] = !empty($tag_arr[$dataArr[4]])?$tag_arr[$dataArr[4]]['tag_id']:137;
            $P['app_id'] = 'uNoilxyVl7fO0uMKKqCP';
            $info = EmployeeModel::showUser(['mobile'=>$P['mobile'],'app_id'=>'uNoilxyVl7fO0uMKKqCP']);
            if(!empty($info)){
                $P['employee_id'] = $info[0]['employee_id'];
                $updateRes = EmployeeModel::updateUniqueEmployee($P);
                if($updateRes === false){
                    echo "更新失败，".json_encode($P);
                }
                $j++;
                echo "更新第" . $j . "记录\n";
            }else{
                $resource_url = env('RESOURCE_URL', '');
                $employee_res = curlPOST($resource_url.'/resource/id/generator', ['type_name' => 'employee']);
                $employee_res = json_decode($employee_res,true);
                if ($employee_res['code'] != 0 || ($employee_res['code'] == 0 && empty($employee_res['content']))) {
                    dieJson(1001, $employee_res['message']);
                }
                $P['employee_id'] =  $employee_res['content'];
                $result =  EmployeeModel::addEmployee($P);
                if($result === false){
                    echo "添加失败，".json_encode($P);
                }
                $i++;
                echo "添加第" . $i . "记录\n";
            }
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
}