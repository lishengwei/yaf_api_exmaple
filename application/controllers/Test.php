<?php
/**
 * Created by PhpStorm.
 * User: lishengwei
 * Date: 18-3-20
 * Time: 上午11:38
 */

class TestController extends Yaf_Controller_Abstract
{
    /**
     * 控制器的init方法，会在类初始化时被调用
     * 用来做before action的工作
     */
    public function init()
    {

    }

    public function indexAction()
    {
        echo '<pre>';
        $rows = \databases\Mysql::getInstance()->query("select * from user");
//        var_dump($rows->fetchAll(PDO::FETCH_ASSOC));
//        $requestObj = $this->getRequest();
        //获取到请求的query
//        $getParmas  = $requestObj->getQuery();
//        $postParmas = $requestObj->getPost();
//        $requestObj->getParams();
        throw new \Exception('test', 222);

//        var_dump(file_get_contents('php://input'));
//        var_dump($getParmas, $postParmas);
//        $obj = new SampleModel();
//        echo  $obj->selectSample();
//        \Utils\Logger::notice('test','123 message', ['a' => 1, 'b' => 2]);
    }
}