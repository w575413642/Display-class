
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>大文件上传测试</title>
    <link rel="stylesheet" href="">
    <style type="text/css" media="screen">
        input{
          height: 200px;
          width: 150px;
          background: #F00;
        }
    </style>
</head>
<body>
    <?php if(!empty($furl)){?>
        <video autobuffer autoloop loop controls style="width:100%;">
            <source src="<?php echo $furl;?>">
        </video>
    <?php }?>
    <form enctype="multipart/form-data" action="<?php echo base_url('file/upload');?>" method="post" accept-charset="utf-8">
    	<input type="text" name="title" value="测试媒体">
    	<select name="type">
    		<option value="0">video</option>
    		<option value="1">Pic</option>
    	</select>
        <input type="file" name="file" value="" placeholder="" accept="video/*" style="height:200px;">
        <input type="submit" name="" value="上传">
    </form>
</body>
</html>