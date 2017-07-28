<?
session_start();
//*********************************************************************************
// Nama Script : SCRIPT SOCIAL COMMUNITY 2016 LATEST VERSION FULL RESPONSIVE
// Original Script By : Ahmad Saiful Mujab
// Facebook : http://facebook.com/ahsaimu
// Facebook Pages : https://www.facebook.com/1001script
// Twitter : https://twitter.com/ahsaimu
// Phone : 0878 2977 5554 / (0231) 638436
// Pin BBM : 5873732B / 5B2B42BD
// Email : ahmadsaifulmujab@gmail.com
// Website : http://1001script.com
//*********************************************************************************
include "../config.php";
global $c,$loggedin;
include "../data.php";
global $config;
?>
<?
if(!isset($_COOKIE["usNick"]) && !isset($_COOKIE["usPass"]))
{
?>
<META HTTP-EQUIV="REFRESH" CONTENT="1;URL=login.php">
<?
exit();

}

 ?>
<?
include "head.php";
?>

   
<div class="row">
<div class="col-lg-12">
<div class="panel panel-green">
                                            <div class="panel-heading">Marketing Plan</div>
                                            <div class="panel-body">


<form method="post" action="profile">
						
<div class="table-responsive">
<table class="table table-hover table-bordered">

							<tbody>
								
								
								<tr>
									<td style="padding-left:20px;">Profit Daily</td>
									<td><? echo $komdaily; ?>% Daily for <? echo $releasedate; ?> Days. Return Principal at Day of <? echo $releasedate; ?></td>
								</tr>
<tr>
									<td style="padding-left:20px;">Sponsor Commission</td>
									<td><? echo $komsponsor; ?>% x <? echo $skph; ?> Amount Downline</td>
								</tr>
<tr>
									<td style="padding-left:20px;">Level Commission</td>
									<td>
Level 1 = <? echo $komlev1a; ?>% <br> 
Level 2 = <? echo $komlev2a; ?>% <br> 
Level 3 = <? echo $komlev3a; ?>% <br> 
Level 4 = <? echo $komlev4a; ?>% <br> 
Level 5 = <? echo $komlev5a; ?>% <br> 
Level 6 = <? echo $komlev6a; ?>% <br> 
Level 7 = <? echo $komlev7a; ?>% <br> 
Level 8 = <? echo $komlev8a; ?>% <br> 
Level 9 = <? echo $komlev9a; ?>% <br> 
Level 10 = <? echo $komlev10a; ?>% </td>
								</tr>
<tr>
									<td style="padding-left:20px;">Manager Commission</td>
									<td>

Manager Level 1 =  <? echo $commgr1 *100; ?>% <br>
Manager Level 2 =  <? echo $commgr2 *100; ?>% <br>
Manager Level 3 =  <? echo $commgr3 *100; ?>% <br>
Manager Level 4 =  <? echo $commgr4 *100; ?>% <br>
Manager Level 5 =  <? echo $commgr5 *100; ?>% <br>
Manager Level 6 =  <? echo $commgr6 *100; ?>% <br>
Manager Level 7 =  <? echo $commgr7 *100; ?>% <br>
Manager Level 8 =  <? echo $commgr8 *100; ?>% <br>
Manager Level 9 =  <? echo $commgr9 *100; ?>% <br>
Manager Level 10 =  <? echo $commgr10 *100; ?>% <br>

</td>
								</tr>
								
							</tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<br><br>

<?
include "foot.php";
?>
