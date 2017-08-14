<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="UTF-8">
  <title>微信<?php echo $title;?>记录</title>
</head>
<body>
<table border="1" cellcollapse="1" cellspacing="0">
    <tr>
        <td>姓名</td>
        <td>电话</td>
        <?php if($all==0){ ?>
        <td>时间</td>
        <?php } ?>
        <td><?php echo $title;?>数量</td>
    </tr>
    <?php if(is_array($list))
    {
        foreach ($list as $row)
        {
    ?>
    <tr>
        <td><strong><?php echo base64_decode($row['name']);?></strong></td>
        <td>'<?php echo $row['tel'];?></td>
        <?php if($all==0){ ?>
            <td><?php echo $row['dateflag'];?></td>
        <?php } ?>
        <td><?php echo $row['c'];?></td>
    </tr>
    <?php
        }
    }?>
</table>
</body>
</html>
