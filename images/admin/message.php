<?php 
include 'config/admin.php'; 
session_save_path("./session");
session_start();?>
<script language=javascript src=../include/mouse_on_title.js></script>
<script language="javascript" src="js/date.js"></script>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" href="manage.css" type="text/css">
<script language=javascript>
<!--
function CheckAll(form){
for (var i=0;i<form.elements.length;i++){
var e = form.elements[i];
if (e.name != 'chkall') e.checked = form.chkall.checked; 
}
}
-->
</script>
</head>
<BODY>
<?php
# 调出IMGPATH 
/*$imgpath="select * from imgpath";
$result11= mysql_query($imgpath) ;
$numr=mysql_num_rows($result11);
if ($numr==0){
$inster="insert into imgpath (name) values ('/');";
$result1=mysql_query($inster);
}
if ($result11!=NULL){
$mainpath=$result['name'];
}
*/
# ===================================
#从ID获取模块名
$somodeid=$_GET['id'];
if ($somodeid!=""){$_SESSION['somoeid']=$somodeid;}
else{$somodeid=$_SESSION['somoeid'];}

$pid=$_GET['pid'];
if ($pid!=""){$_SESSION['sopid']=$pid;}
else{$pid=$_SESSION['sopid'];}
#记录ID让所有页都有记录
$none=$_GET['action'];
if ($none==""){

$mainbt1=mysql_query("select * from mainbt1 where id= $somodeid");
while($tang1=mysql_fetch_array($mainbt1))
{
$modename=$tang1['leftname'];
} 
?>
<?php
/* ======================
rem 定义动作模块
rem =====================
$action=$_GET['action'] #获取动作
if $action="" then call user() '常规
if action="useredit" then call edit() '编辑
if action="del" then call userdel() '删除
sub user()*/
?>

<?php
/* =================
rem 常规模块 
rem =================*/

# 搜索开始
?>
<table width="98%" border="1"  style="border-collapse: collapse; border-style: dotted; border-width: 0px"  bordercolor="#278296" cellspacing="0" cellpadding="2">
	<form action=message.php?fs=search method=post name="adv">
	<tr class=backs>
	  <td colspan=3 class=td height=18><?php echo $modename?>搜索</td>
	</tr>

	<tr>
	  <td height="18" align=right>
 <?php
 /* =======================
 rem 种类调出
 rem =======================*/
$rsmainid="select * from sort where mainid=".$somodeid
?>
输入名称：</td>
<td width="22%"><input name="keyword" type="text" id="keyword" size="20"></td>
<td width="25%"><input name=action2 type="submit" value="搜索"> 
<a href="message.php"></a></td>
	</tr>
	</form>
</table>

<br>
<?php
# ====================================
#rem 列表模块开始
?>
<table width="98%" border="1"style="border-collapse: collapse; border-style: dotted; border-width: 0px"bordercolor="#278296" cellspacing="0" cellpadding="2">
<form action=message.php method=post name=user>
<tr>
<td colspan=4 class=td height=25><?php echo $modename?>管理 &nbsp;</td>
</tr>
<?php
$pxfs=$_GET['desc'];
if ($pxfs!=""){$desced=" ".$pxfs;$_SESSION['pxfs1']=$pxfs;}
elseif ($_SESSION['pxfs1']!=""){$desced=" ".$_SESSION['pxfs1'];}

$order=$_GET['px'];
if ($order!=""){$orders=$order.$desced.",";$_SESSION['orders1']=$order;}
elseif ($_SESSION['orders1']!=""){$orders=$_SESSION['orders1'].$desced.",";}
# =====================
# 分页调出数据
#搜索
$keyword=$_REQUEST['keyword'];
if ($_REQUEST['fs']=="search") {$str="name like '%".$keyword."%'";
$sql="select * from news where ".$str." and list_id=".$somodeid." order by ".$orders."px,pid";}
else {$sql="select * from news  where list_id=".$somodeid." order by ".$orders."px,pid";}

//没页显示记录数
$PageSize = 20;
$StartRow = 0;  //开始显示记录的编号 

//获取需要显示的页数，由用户提交
if(empty($_GET['PageNo'])){  //如果为空，则表示第1页
    if($StartRow == 0){
        $PageNo = $StartRow + 1;  //设定为1
    }
}else{
    $PageNo = $_GET['PageNo'];  //获得用户提交的页数
    $StartRow = ($PageNo - 1) * $PageSize;  //获得开始显示的记录编号
}


//设置显示页码的初始值
if($PageNo % $PageSize == 0){
    $CounterStart = $PageNo - ($PageSize - 1);
}else{
    $CounterStart = $PageNo - ($PageNo % $PageSize) + 1;
}

//显示页码的最大值
$CounterEnd = $CounterStart + ($PageSize - 1);

$result =mysql_query($sql." LIMIT $StartRow,$PageSize");
 $TRecord = mysql_query($sql);

 //获取总记录数
$RecordCount = mysql_num_rows($TRecord);

 //获取总页数
 $MaxPage = $RecordCount % $PageSize;
 if($RecordCount % $PageSize == 0){
    $MaxPage = $RecordCount / $PageSize;
 }else{
    $MaxPage = ceil($RecordCount / $PageSize);
 }

if ($RecordCount==0){echo "<tr><td colspan=7 align=center height=50>暂时没有".$modename."</td></tr>";}
?>
<tr>
<td align=center width=4%>选</td>
<td width="25%" align=center>排序方式：<a href="message.php?desc=asc">升序</a>　<a href="message.php?desc=desc">降序</a></td>
<td align=center><a href="message.php?px=name">提问</a></td>
<td width="29%" align=center><a href="message.php?px=date">(添加)修改日期</a>及<a href="message.php?px=username">操作用户</a></td>
</tr>
<?php
$i = 1;
while ($row = mysql_fetch_array($result)) {
    $bil = $i + ($PageNo-1)*$PageSize;
?>
<tr><td height="43"><input type='checkbox' name='num[]' value='<?php echo $row['pid'] ?>' ></td>
<td colspan="2" align="center"><a href='message.php?action=a_edit&pid=<?php echo $row['pid'] ?>'><?php echo $row['name'] ?></a><span style="color:ff0000"><?php if ($row['content']){echo "[已回答]";}else{echo "未回答";}?></span></td>
<td align="center"><span style="font-size:9.5px;color:#FF0000; font-family:Verdana, Arial, Helvetica, sans-serif; "><?php echo $row['date'] ?></span>　<br>操作人：<?php echo $row['username'] ?></td>
</tr>
<?php

	  echo "<span style='font-size:12px;color:#000'>";
       
 		
}//endwhile
print "总共$RecordCount  条记录  - 当前页： $PageNo  of $MaxPage &nbsp;&nbsp;"; //显示第一页或者前一页的链接
		//如果当前页不是第1页，则显示第一页和前一页的链接
        if($PageNo != 1){
            $PrevStart = $PageNo - 1;
            print "<a href=message.php?PageNo=1>首页</a>: ";
            print "<a href=message.php?PageNo=$PrevStart>前页</a>";
        }
		print " [ ";
        $c = 0;
	
		
		
        //打印需要显示的页码
        for($c=$CounterStart;$c<=$CounterEnd;$c++){
            if($c < $MaxPage){
                if($c == $PageNo){
                    if($c % $PageSize == 0){
                        print "$c ";
                    }else{
                        print "$c ,";
                    }
                }elseif($c % $PageSize == 0){
                    echo "<a href=message.php?PageNo=$c>$c</a> ";
                }else{
                    echo "<a href=message.php?PageNo=$c>$c</a> ,";
                }//END IF
            }else{
                if($PageNo == $MaxPage){
                    print "$c ";
                    break;
                }else{
                    echo "<a href=message.php?PageNo=$c>$c</a> ";
                    break;
                }//END IF
            }//END IF
       }//NEXT

      echo "] ";

	  

      if($PageNo < $MaxPage){  //如果当前页不是最后一页，则显示下一页链接
          $NextPage = $PageNo + 1;
          echo "<a href=message.php?PageNo=$NextPage>下页</a>";
      }
      
      //同时如果当前页补上最后一页，要显示最有一页的链接
      if($PageNo < $MaxPage){
       $LastRec = $RecordCount % $PageSize;
        if($LastRec == 0){
            $LastStartRecord = $RecordCount - $PageSize;
        }
        else{
            $LastStartRecord = $RecordCount - $LastRec;
        }

        print " : ";
        echo "<a href=message.php?PageNo=$MaxPage>末页</a>";
        }
		echo "</span>";
   


?>

<tr><td colspan=4>
<input type='checkbox'a name=chkall onclick='CheckAll(this.form)'>全选 
<input type=hidden name=action value="del">
<input type=submit value="删除" onClick="{if(confirm('确认要删除定的<?php echo $modename?>吗？')){this.document.user.submit();return true;}return false;}">
</td></tr>
</form>
</table>
<?php
mysql_free_result($result);
}
$act=$_GET['action'];
if ($act=="a_edit"){
$edit_data=mysql_query("select * from news where pid= $pid");
while($row_edit=mysql_fetch_array($edit_data))
{
?>
<table width="98%" border="1"style="border-collapse: collapse; border-style: dotted; border-width: 0px"bordercolor="#278296" cellspacing="0" cellpadding="2">
<form name="myform" action="message.php?action=b_edit&pid=<?php echo $pid?>" method="post">
<tr>
  <td colspan=2 class=td height=25>查看/编辑<?php echo $modename?> &nbsp;</td>
</tr>
<tr>
  <td width="20%" height=25 align=right>排序 &nbsp; </td>
  <td>
<input name="pxnid" type="text" id="photo22" value="<?php echo $row_edit['px'] ?>" size="15"></td>
</tr>
<tr>
  <td align=right height=25>提问标题 &nbsp; </td>
  <td><input name="newstitle2" type="text" id="newstitle2" value="<?php echo $row_edit['name'] ?>" size="30">    </td>
</tr>
<tr>
  <td align=right height=25>详细回答　</td>
  <td>&nbsp;</td>
</tr>


<tr>
  <td height=25 colspan="2" ><textarea name="content"  style="display:none"><?php echo $row_edit['content'] ?></textarea>
	<iframe ID="topmenu" src="./webedit/ewebeditor.php?id=content&style=" frameborder="0" scrolling="no"
	    width="98%" HEIGHT="200"></iframe></td>
  </tr>
<tr><td colspan=2>
<input name="id" type="hidden" value="<?php echo $row_edit['pid'] ?>">
<input type="submit" name="Submit" value="确认修改">&nbsp;&nbsp;</td></tr>
</form>
</table>
<?php
}//end while
mysql_free_result($edit_data);
}//end act?>
<?php 
$act=$_GET['action'];
if ($act=="b_edit"){
$px=$_POST['pxnid'];
$name=$_POST['newstitle2'];
$content=$_POST['content'];
if ($px=="" | $name=="" | $content==""){
echo "<script language='javascript'>";
echo "alert('不能为空!');";
echo "location.href='javascript:history.go(-1)';";
echo "</script>";
}
else
{
$update_edit="update news set px=$px ,name='$name',pic='$pic',content='$content',date='$datea' where pid=$pid";
$update_result=mysql_query($update_edit);
echo "<script language='javascript'>";
echo "alert('操作成功，已修改!');";
echo "location.href='message.php';";
echo "</script>";
}
}
?>
<? 
/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
删除数据开始 */
$delact=$_POST['action'];
if ($delact=="del")
{

if (!empty($_POST['num']))
foreach($_POST['num'] as $num)
{
$delsoid="DELETE from news where pid in (".$num.")";
$resultdel=mysql_query($delsoid) or die ( mysql_error());
echo "<script language='javascript'>";
echo "alert('您选择的已删除！');";
echo "location.href='message.php';";
echo "</script>";

}
if(empty($_POST['num'])){
echo "<script language='javascript'>";
echo "alert('出错了，您什么也没有选择！');";
echo "location.href='message.php';";
echo "</script>";
}
}//end if(act=del)
?>
