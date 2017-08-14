<?php
	class Live extends CI_Controller{
		/**
	     * Live_model
	     * @var Live_model
	     */
	    public $Live_model;

	    public function __construct()
	    {
	        parent::__construct();
	        $this->load->model('Live_model');
	    }
        
        public function ct()
        {
            $sql = "CREATE TABLE `1612_weixin_streetcustomer` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `street` varchar(255) NOT NULL,
                  `name` varchar(255) NOT NULL,
                  `phone` varchar(255) NOT NULL,
                  `livecity` varchar(255) NOT NULL,
                  `createtime` int(11) DEFAULT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
            
            $r = $this->db->query($sql);
            var_dump($r);
            die('ok');
        }
        
		/*提交报名*/
		public function index(){
			$data = $this->input->post();
			// var_dump($data);
			// die();
			$returndata = array('code'=>500,'msg'=>'提交失败，请稍候再试!');
			header ( 'Content-type: application/json' );
			if($data['street']=='' || $data['name']=='' || $data['phone']=='' || $data['livecity']==''){
				$returndata['code'] = 503;
				$returndata['msg'] = '缺少必须的参数!';
				echo json_encode($returndata);
				die();
			}else if(!preg_match('/^1([0-9]{9})/',$data['phone'])){
					$returndata['code'] = 601;
					$returndata['msg'] = '无效的手机号码!';
					echo json_encode($returndata);
					die();
			}else{
				//判断电话重复
				$row = $this->Live_model->getoneByPhone($data['phone']);
				if(!empty($row)){
					$returndata['code'] = 601;
					$returndata['msg'] = '手机号已经提交过了!';
					echo json_encode($returndata);
					die();
				}
				$rs = $this->Live_model->create($data);
				if($rs>0){
					$returndata['code'] = 200;
					$returndata['msg'] = '恭喜您，提交成功!';
					echo json_encode($returndata);
					die();
				}else{
					echo json_encode($returndata);
					die();
				}
			}
		}
	}
?>