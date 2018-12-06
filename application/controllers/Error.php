<?php
/**
 * @name ErrorController
 * @desc 错误控制器, 在发生未捕获的异常时刻被调用
 * 此时会将异常写入warn日志，并进行返回统一的输出
 * @see http://www.php.net/manual/en/yaf-dispatcher.catchexception.php
 * @author lishengwei
 */
class ErrorController extends Yaf_Controller_Abstract
{

	//从2.1开始, errorAction支持直接通过参数获取异常
	public function errorAction()
    {
        $exception = $this->getRequest()->getException();
        $codes404 = [
            YAF_ERR_NOTFOUND_ACTION,
            YAF_ERR_NOTFOUND_CONTROLLER,
            YAF_ERR_NOTFOUND_MODULE,
            YAF_ERR_NOTFOUND_VIEW,
            YAF_ERR_DISPATCH_FAILED,
        ];
        $code = $exception->getCode();

        if (in_array($code, $codes404)) {
            header('HTTP/1.0 404 NOT FOUND');
        } else {
            $errInfos = [
                'file'      => $exception->getFile(),
                'line'      => $exception->getLine(),
                'message'   => $exception->getMessage(),
                'code'      => $code,
            ];
            \utils\Logger::warning('errorAction', 'catch an error', $errInfos);

            header('Content-type:application/json;charset=utf-8');
            echo json_encode(['code' => $exception->getCode(), 'msg' => $exception->getMessage()]);
        }
        exit;
	}
}