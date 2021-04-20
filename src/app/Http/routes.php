<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Http\Request;

$app->get('/', function () use ($app) {
    return response(array('code' => 500, 'message' => '请参考文档请求准确的url地址', 'content' => '', 'contentEncrypt' => ''), 200);
});

//中间件公共服务
$app->group(['namespace' => 'App\Http\Controllers', 'middleware' => ['JaegerTracer']], function () use ($app) {
    $app->post('employee/show', [
        'as' => 'channel',
        'uses' => 'EmployeeController@employee_show'
    ]);

    $app->post('employee/lists', [
        'as' => 'channel',
        'uses' => 'EmployeeController@employee_list'
    ]);

    $app->post('employee/counts', [
        'as' => 'channel',
        'uses' => 'EmployeeController@employee_count'
    ]);

    $app->post('employee/add', [
        'as' => 'channel',
        'uses' => 'EmployeeController@employee_add'
    ]);

    $app->post('employee/update', [
        'as' => 'channel',
        'uses' => 'EmployeeController@employee_update'
    ]);

    $app->post('employee/userlist', [
        'as' => 'channel',
        'uses' => 'EmployeeController@employee_user_show_list'
    ]);

    $app->post('employee/userMemberlist', [
        'as' => 'channel',
        'uses' => 'EmployeeController@employee_user_member_list'
    ]);

    $app->post('employee/updateuser', [
        'as' => 'channel',
        'uses' => 'EmployeeController@employee_update_user'
    ]);

    $app->post('employee/addemployee', [
        'as' => 'channel',
        'uses' => 'EmployeeController@employee_add_user'
    ]);

    $app->post('employee/del', [
        'as' => 'channel',
        'uses' => 'EmployeeController@employee_del'
    ]);

    $app->post('employee/extlist', [
        'as' => 'channel',
        'uses' => 'EmployeeController@employee_ext_list'
    ]);

    $app->post('employeeext/update', [
        'as' => 'channel',
        'uses' => 'EmployeeextController@employeeext_update'
    ]);

    $app->post('member/show', [
        'as' => 'channel',
        'uses' => 'MemberController@member_show'
    ]);

    $app->post('member/lists', [
        'as' => 'channel',
        'uses' => 'MemberController@member_lists'
    ]);

    $app->post('member/counts', [
        'as' => 'channel',
        'uses' => 'MemberController@member_count'
    ]);

    $app->post('member/add', [
        'as' => 'channel',
        'uses' => 'MemberController@member_add'
    ]);

    $app->post('member/update', [
        'as' => 'channel',
        'uses' => 'MemberController@member_update'
    ]);

    $app->post('member/del', [
        'as' => 'channel',
        'uses' => 'MemberController@member_del'
    ]);

    $app->post('member/userlist', [
        'as' => 'channel',
        'uses' => 'MemberController@member_user_show_list'
    ]);

    $app->post('member/checkpassowrd', [
        'as' => 'channel',
        'uses' => 'MemberController@member_check_password'
    ]);

    $app->post('member/checkstatus', [
        'as' => 'channel',
        'uses' => 'MemberController@member_check_status'
    ]);

    $app->post('member/register', [
        'as' => 'channel',
        'uses' => 'MemberController@member_register'
    ]);

    $app->post('lisence/show', [
        'as' => 'channel',
        'uses' => 'LisenceController@lisence_show'
    ]);

    $app->post('lisence/lists', [
        'as' => 'channel',
        'uses' => 'LisenceController@lisence_lists'
    ]);

    $app->post('lisence/count', [
        'as' => 'channel',
        'uses' => 'LisenceController@lisence_count'
    ]);

    $app->post('lisence/add', [
        'as' => 'channel',
        'uses' => 'LisenceController@lisence_add'
    ]);

    $app->post('lisence/update', [
        'as' => 'channel',
        'uses' => 'LisenceController@lisence_update'
    ]);

    $app->post('lisence/del', [
        'as' => 'channel',
        'uses' => 'LisenceController@lisence_del'
    ]);


    $app->post('tenement/userlist', [
        'as' => 'channel',
        'uses' => 'TenementController@tenement_user_lists'
    ]);

    $app->post('tenement/expireListen', [
        'as' => 'channel',
        'uses' => 'TenementController@tenement_expire_listen'
    ]);

    $app->post('tenement/tenementDeviceWatch', [
        'as' => 'channel',
        'uses' => 'TenementController@tenement_device_watch'
    ]);

    $app->post('tenement/lists', [
        'as' => 'channel',
        'uses' => 'TenementController@tenement_lists'
    ]);

    $app->post('tenement/useradd', [
        'as' => 'channel',
        'uses' => 'TenementController@tenement_user_add'
    ]);

    $app->post('tenement/update', [
        'as' => 'channel',
        'uses' => 'TenementController@tenement_update'
    ]);

    $app->post('tenement/del', [
        'as' => 'channel',
        'uses' => 'TenementController@tenement_del'
    ]);

    $app->post('tenement/extlist', [
        'as' => 'channel',
        'uses' => 'TenementController@tenement_ext_list'
    ]);

    $app->post('tenement/userlist', [
        'as' => 'channel',
        'uses' => 'TenementController@tenement_user_lists'
    ]);

    $app->post('tenement/useradd', [
        'as' => 'channel',
        'uses' => 'TenementController@tenement_user_add'
    ]);

    $app->post('tenement/userupdate', [
        'as' => 'channel',
        'uses' => 'TenementController@tenement_user_update'
    ]);

    $app->post('visitor/lists', [
        'as' => 'channel',
        'uses' => 'VisitorController@visitor_lists'
    ]);

    $app->post('visitor/extlist', [
        'as' => 'channel',
        'uses' => 'VisitorController@visitor_ext_list'
    ]);

    $app->post('visitor/userlist', [
        'as' => 'channel',
        'uses' => 'VisitorController@visitor_user_lists'
    ]);

    $app->post('visitor/userGroupList', [
        'as' => 'channel',
        'uses' => 'VisitorController@visitor_user_lists_group'
    ]);

    $app->post('visitor/useradd', [
        'as' => 'channel',
        'uses' => 'VisitorController@visitor_user_add'
    ]);

    $app->post('visitor/userupdate', [
        'as' => 'channel',
        'uses' => 'VisitorController@visitor_user_update'
    ]);

    $app->post('house/show', [
        'as' => 'channel',
        'uses' => 'HouseController@house_show'
    ]);

    $app->post('house/add', [
        'as' => 'channel',
        'uses' => 'HouseController@house_add'
    ]);

    $app->post('house/lists', [
        'as' => 'channel',
        'uses' => 'HouseController@house_lists'
    ]);

    $app->post('house/tenementlists', [
        'as' => 'channel',
        'uses' => 'HouseController@tenement_house_lists'
    ]);

    $app->post('house/count', [
        'as' => 'channel',
        'uses' => 'HouseController@house_count'
    ]);


    $app->post('house/update', [
        'as' => 'channel',
        'uses' => 'HouseController@house_update'
    ]);

    $app->post('house/del', [
        'as' => 'channel',
        'uses' => 'HouseController@house_del'
    ]);

    $app->post('client/show', [
        'as' => 'channel',
        'uses' => 'ClientController@client_show'
    ]);

    $app->post('client/lists', [
        'as' => 'channel',
        'uses' => 'ClientController@client_lists'
    ]);

    $app->post('client/add', [
        'as' => 'channel',
        'uses' => 'ClientController@client_add'
    ]);

    $app->post('client/count', [
        'as' => 'channel',
        'uses' => 'ClientController@client_count'
    ]);

    $app->post('client/update', [
        'as' => 'channel',
        'uses' => 'ClientController@client_update'
    ]);

    $app->post('client/del', [
        'as' => 'channel',
        'uses' => 'ClientController@client_del'
    ]);

    $app->post('clienthouse/show', [
        'as' => 'channel',
        'uses' => 'ClienthouseController@clienthouse_show'
    ]);

    $app->post('clienthouse/lists', [
        'as' => 'channel',
        'uses' => 'ClienthouseController@clienthouse_lists'
    ]);

    $app->post('clienthouse/add', [
        'as' => 'channel',
        'uses' => 'ClienthouseController@clienthouse_add'
    ]);

    $app->post('clienthouse/count', [
        'as' => 'channel',
        'uses' => 'ClienthouseController@clienthouse_count'
    ]);

    $app->post('clienthouse/update', [
        'as' => 'channel',
        'uses' => 'ClienthouseController@clienthouse_update'
    ]);

    $app->post('clienthouse/del', [
        'as' => 'channel',
        'uses' => 'ClienthouseController@clienthouse_del'
    ]);

    $app->post('user/show', [
        'as' => 'channel',
        'uses' => 'UserController@user_show'
    ]);

    $app->post('user/lists', [
        'as' => 'channel',
        'uses' => 'UserController@user_lists'
    ]);

    $app->post('user/add', [
        'as' => 'channel',
        'uses' => 'UserController@user_add'
    ]);

    $app->post('user/count', [
        'as' => 'channel',
        'uses' => 'UserController@user_count'
    ]);

    $app->post('user/update', [
        'as' => 'channel',
        'uses' => 'UserController@user_update'
    ]);

    $app->post('user/del', [
        'as' => 'channel',
        'uses' => 'UserController@user_del'
    ]);




    $app->post('userinvoce/show', [
        'as' => 'channel',
        'uses' => 'UserinvoceController@user_invoce_show'
    ]);

    $app->post('userinvoce/lists', [
        'as' => 'channel',
        'uses' => 'UserinvoceController@user_invoce_lists'
    ]);

    $app->post('userinvoce/add', [
        'as' => 'channel',
        'uses' => 'UserinvoceController@user_invoce_add'
    ]);

    $app->post('userinvoce/count', [
        'as' => 'channel',
        'uses' => 'UserinvoceController@user_invoce_count'
    ]);

    $app->post('userinvoce/update', [
        'as' => 'channel',
        'uses' => 'UserinvoceController@user_invoce_update'
    ]);

    $app->post('userinvoce/del', [
        'as' => 'channel',
        'uses' => 'UserinvoceController@user_invoce_del'
    ]);

    $app->post('visitorapply/show', [
        'as' => 'channel',
        'uses' => 'VisitorapplyController@visitor_apply_show'
    ]);

    $app->post('visitorapply/lists', [
        'as' => 'channel',
        'uses' => 'VisitorapplyController@visitor_apply_lists'
    ]);

    $app->post('visitorapply/add', [
        'as' => 'channel',
        'uses' => 'VisitorapplyController@visitor_apply_add'
    ]);

    $app->post('visitorapply/count', [
        'as' => 'channel',
        'uses' => 'VisitorapplyController@visitor_apply_count'
    ]);

    $app->post('visitorapply/update', [
        'as' => 'channel',
        'uses' => 'VisitorapplyController@visitor_apply_update'
    ]);

    $app->post('visitorapply/del', [
        'as' => 'channel',
        'uses' => 'VisitorapplyController@visitor_apply_del'
    ]);

    $app->post('visitorapply/generate', [
        'as' => 'channel',
        'uses' => 'VisitorapplyController@visitor_apply_generate'
    ]);

    $app->post('visitorapply/check', [
        'as' => 'channel',
        'uses' => 'VisitorapplyController@visitor_apply_check'
    ]);

    $app->post('visitordevice/show', [
        'as' => 'channel',
        'uses' => 'VisitordeviceController@visitor_device_show'
    ]);

    $app->post('visitordevice/lists', [
        'as' => 'channel',
        'uses' => 'VisitordeviceController@visitor_device_lists'
    ]);

    $app->post('visitordevice/add', [
        'as' => 'channel',
        'uses' => 'VisitordeviceController@visitor_device_add'
    ]);

    $app->post('visitordevice/count', [
        'as' => 'channel',
        'uses' => 'VisitordeviceController@visitor_device_count'
    ]);

    $app->post('visitordevice/update', [
        'as' => 'channel',
        'uses' => 'VisitordeviceController@visitor_device_update'
    ]);

    $app->post('visitordevice/del', [
        'as' => 'channel',
        'uses' => 'VisitordeviceController@visitor_device_del'
    ]);

    $app->post('visitordevice/listen', [
        'as' => 'channel',
        'uses' => 'VisitordeviceController@visitor_device_listen'
    ]);

    $app->post('visitordevice/watch', [
        'as' => 'channel',
        'uses' => 'VisitordeviceController@visitor_device_watch'
    ]);

    $app->post('visitordevice/applylisten', [
        'as' => 'channel',
        'uses' => 'VisitordeviceController@visitor_apply_listen'
    ]);

    $app->post('visitordevice/access', [
        'as' => 'channel',
        'uses' => 'VisitordeviceController@visitor_device_use'
    ]);


    $app->post('userdevice/show', [
        'as' => 'channel',
        'uses' => 'UserdeviceController@user_device_show'
    ]);

    $app->post('userdevice/lists', [
        'as' => 'channel',
        'uses' => 'UserdeviceController@user_device_lists'
    ]);

    $app->post('userdevice/add', [
        'as' => 'channel',
        'uses' => 'UserdeviceController@user_device_add'
    ]);

    $app->post('userdevice/count', [
        'as' => 'channel',
        'uses' => 'UserdeviceController@user_device_count'
    ]);

    $app->post('userdevice/update', [
        'as' => 'channel',
        'uses' => 'UserdeviceController@user_device_update'
    ]);

    $app->post('userdevice/del', [
        'as' => 'channel',
        'uses' => 'UserdeviceController@user_device_del'
    ]);

    $app->post('userdevice/userMergeVisitor', [
        'as' => 'channel',
        'uses' => 'UserdeviceController@user_merge_visitor_device'
    ]);

    $app->post('userdevice/userDeviceListen', [
        'as' => 'channel',
        'uses' => 'UserdeviceController@user_device_listen'
    ]);

    $app->post('userext/add', [
        'as' => 'channel',
        'uses' => 'UserextController@user_ext_add'
    ]);

    $app->post('userext/update', [
        'as' => 'channel',
        'uses' => 'UserextController@user_ext_update'
    ]);

    $app->post('userext/del', [
        'as' => 'channel',
        'uses' => 'UserextController@user_ext_del'
    ]);

    $app->post('userext/show', [
        'as' => 'channel',
        'uses' => 'UserextController@user_ext_show'
    ]);

    $app->post('userext/lists', [
        'as' => 'channel',
        'uses' => 'UserextController@user_ext_lists'
    ]);

    $app->post('userext/count', [
        'as' => 'channel',
        'uses' => 'UserextController@user_ext_count'
    ]);



    $app->post('employeejob/show', [
        'as' => 'channel',
        'uses' => 'EmployeejobController@employee_job_show'
    ]);

    $app->post('employeejob/lists', [
        'as' => 'channel',
        'uses' => 'EmployeejobController@employee_job_lists'
    ]);

    $app->post('employeejob/add', [
        'as' => 'channel',
        'uses' => 'EmployeejobController@employee_job_add'
    ]);

    $app->post('employeejob/batchadd', [
        'as' => 'channel',
        'uses' => 'EmployeejobController@employee_job_batch_add'
    ]);

    $app->post('employeejob/count', [
        'as' => 'channel',
        'uses' => 'EmployeejobController@employee_job_count'
    ]);

    $app->post('employeejob/update', [
        'as' => 'channel',
        'uses' => 'EmployeejobController@employee_job_update'
    ]);

    $app->post('employeejob/del', [
        'as' => 'channel',
        'uses' => 'EmployeejobController@employee_job_del'
    ]);


    $app->get('test', 'TestController@index');
    $app->post('test', 'TestController@index');
    $app->put('test', 'TestController@index');
    $app->delete('test', 'TestController@index');
    $app->post('visitor/car/lists', ['as' => 'channel', 'uses' => 'VisitorcarController@visitorcar_lists']);

    $app->post('tenement/car/lists', ['as' => 'channel', 'uses' => 'TenementcarController@tenementcar_lists']);
    $app->post('visitor/car/lists', ['as' => 'channel', 'uses' => 'VisitorcarController@visitorcar_lists']);

    //班次管理
    $app->post('employee/schedule_type/count', [
        'as' => 'schedule_type',
        'uses' => 'EmployeeScheduleTypeController@count'
    ]);
    $app->post('employee/schedule_type/lists', [
        'as' => 'schedule_type',
        'uses' => 'EmployeeScheduleTypeController@lists'
    ]);
    $app->post('employee/schedule_type/show', [
        'as' => 'schedule_type',
        'uses' => 'EmployeeScheduleTypeController@show'
    ]);
    $app->post('employee/schedule_type/add', [
        'as' => 'schedule_type',
        'uses' => 'EmployeeScheduleTypeController@add'
    ]);
    $app->post('employee/schedule_type/update', [
        'as' => 'schedule_type',
        'uses' => 'EmployeeScheduleTypeController@update'
    ]);

    //排班管理
    $app->post('employee/schedule/lists', [
        'as' => 'schedule',
        'uses' => 'EmployeeScheduleController@lists'
    ]);
    $app->post('employee/schedule/count', [
        'as' => 'schedule',
        'uses' => 'EmployeeScheduleController@count'
    ]);
    $app->post('employee/schedule/save', [
        'as' => 'schedule',
        'uses' => 'EmployeeScheduleController@save'
    ]);
    $app->post('employee/schedule/updateScheduleType', [
        'as' => 'schedule',
        'uses' => 'EmployeeScheduleController@updateScheduleType'
    ]);
    $app->post('employee/schedule/show', [
        'as' => 'schedule',
        'uses' => 'EmployeeScheduleController@show'
    ]);
});

