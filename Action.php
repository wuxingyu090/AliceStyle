<?php
class AliceStyle_Action extends Widget_Abstract_Contents implements Widget_Interface_Do 
{

    public function action()
    {
        $options = Helper::options();
		$appkey = $options->plugin('AliceStyle')->appkey;
		$talkContent = ""; 
		$info=addslashes($_POST['info']);
		$userid=addslashes($_POST['userid']);

                //使用方法
                $data = array(
                    'reqType' => 0,
                    'perception' => array(
                        'inputText' => array('text' => $info)
                    ),
                    'userInfo' => array(
                        'apiKey' => $appkey,
                        'userId' => $userid
                    )
                );

                $post_data = json_encode($data);
		  
                function send_post($url, $post_data) {

                  //$postdata = http_build_query($post_data);
                  $options = array(
                        'http' => array(
                          'method' => 'POST',
                          'header' => 'Content-type:application/json',
                          'content' => $post_data,
                          'timeout' => 15 * 60 // 超时时间（单位:s）
                        )
                  );
                  $context = stream_context_create($options);
                  $result = file_get_contents($url, false, $context);

                  return $result;
                }


		if($appkey==""){
			$talkContent = '{"code":"500","text":"我还没学会聊天功能，快和站长联系吧！"}';
		}
		else{
			// $talkContent = send_post('http://www.tuling123.com/openapi/api', $post_data);
                        $talkContent = send_post('http://openapi.turingapi.com/openapi/api/v2', $post_data);
		}
		header('Content-type:text/json');
		echo $talkContent;
    }
}
