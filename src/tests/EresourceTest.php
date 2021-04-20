<?php

// use Laravel\Lumen\Testing\DatabaseTransactions;
// use Illuminate\Foundation\Testing\WithoutMiddleware;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

class EresourceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBaseExample()
    {
        // $this->get('/resources/show?caseId=1&operatorId=1&operator=1');
        // die($this->response->getContent());

        $this->get('/resources/show?caseId=1&operatorId=1&operator=1')->seeJson(['code'=>0]);

        $randId = date('YmdHis').rand(10,99);
        $args = [
            'caseId' => $randId,
            'operatorId' => $randId,
            'operator' => $randId,
            'station' => '创业花园',      //小区名称
            'buyer' => 'baidu',         //广告商
            'contract' => '20160122',   //合同编号
            'amount' => '300',      //合同金额
            'installer' => '安装师傅'
        ];
        $this->post('/resources/add',$args)->seeJson(['code'=>0]);
    }

}
