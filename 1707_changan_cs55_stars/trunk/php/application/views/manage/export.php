<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 <head>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
  <style id="Classeur1_16681_Styles"></style>
 </head>
 <body>
  <div id="Classeur1_16681" align=center x:publishsource="Excel">
   <table cellpadding=0 cellspacing=0 border=0>
            <tr style="background: #F0F0F0;">
                <td>姓名</td>
                <!-- <td>头像</td> -->
                <td>电话</td>
                <!-- <td>昵称</td> -->
                <td>时间</td>
                <td>已有碎片</td>
            </tr>
        <?php
        if(!empty($list)){
            foreach ($list as $item){
                ?>
                <tr>
                    <td><?php echo $item['name'];?></td>
                    <td><?php echo $item['tel'];?></td>
                    <td><?php echo $item['create_time'];?></td>
                    <td><?php echo $item['num'];?></td>
                </tr>
                <?php
            }
        }
        ?>
        </table>
  </div>
 </body>
</html>