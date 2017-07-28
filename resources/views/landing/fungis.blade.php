<?


//*********************************************************************************
// ACCESS FUNCTION
//*********************************************************************************


function functionUserLock(){
if(!isset($_COOKIE["username"]) && !isset($_COOKIE["password"]))
{
?>
<META HTTP-EQUIV="REFRESH" CONTENT="1;URL=login.php">
<?
exit();

}

}


function functionUserBlocked($x1){
	if($x1 == '1'){
	header('location:blocked');
	}
}


function functionAdminLock(){
if(!isset($_COOKIE["useradmin"]) && !isset($_COOKIE["passadmin"]))
{
?>
<META HTTP-EQUIV="REFRESH" CONTENT="1;URL=login.php">
<?
exit();

}

}


function functionUserLockAdminFree(){
	$sessionUsername = $_COOKIE['useradmin'];
	if(empty($sessionUsername)){
	header('location:../index.php');
	}
}



//*********************************************************************************
// MEMBER FUNCTION
//*********************************************************************************


$sql_user = mysql_query("SELECT * FROM tb_users WHERE username!='admin'");
$allMember = mysql_num_rows($sql_user);

$sql_user2 = mysql_query("SELECT * FROM tb_users WHERE suspend!='1' and username!='admin'");
$activeMember = mysql_num_rows($sql_user2);

$sql_user3 = mysql_query("SELECT * FROM tb_users WHERE suspend='1' and username!='admin'");
$suspendMember = mysql_num_rows($sql_user3);

$sql_user4 = mysql_query("SELECT * FROM tb_users WHERE manager='1' and username!='admin'");
$allManager = mysql_num_rows($sql_user4);

function latestMember(){
$lateM = mysql_query("SELECT * FROM tb_users WHERE username!='admin' order by id DESC limit 0,1");
while ($seeM = mysql_fetch_array($lateM)) {
echo "". $seeM["username"] .""; }
}

function latestMemberSuspend(){
$lateM = mysql_query("SELECT * FROM tb_users WHERE username!='admin' and suspend='1' order by id DESC limit 0,1");
while ($seeM = mysql_fetch_array($lateM)) {
echo "". $seeM["username"] .""; }
}

function latestManager(){
$lateM2 = mysql_query("SELECT * FROM tb_users WHERE username!='admin' and manager='1' order by id DESC limit 0,1");
while ($seeM2 = mysql_fetch_array($lateM2)) {
echo "". $seeM2["username"] .""; }
}

function showAllMember($x1){
echo"

<div class=\"table-responsive\">
<table class=\"table table-striped table-hover\">
  <thead>
    <tr>
      <th>User</th>
      <th>Register Date</th>
      <th>Country</th>

    </tr>
      </thead>
        <tbody>
	";

$showM = mysql_query("SELECT * FROM tb_users WHERE username!='admin' order by id DESC limit 0,$x1");
while ($lihatM = mysql_fetch_array($showM)) {
echo "<tr><td><i class=\"fa fa-user\"></i> ". $lihatM["username"] ."</td><td><i class=\"fa fa-calendar\"></i> ". date('d F Y, H:i',$lihatM["joindate"]) ."</td><td><i class=\"fa fa-globe\"></i> ". $lihatM["country"] ."</td></tr>"; }
echo "
</tbody>
</table>
</div>
";
}


function showManagerMember(){
$showM2 = mysql_query("SELECT * FROM tb_users WHERE username!='admin' and manager='1' order by id DESC limit 0,100");
while ($lihatM2 = mysql_fetch_array($showM2)) {
echo "<tr><td>". $lihatM2["username"] ."</td><td>". $lihatM2["kota"] ."</td></tr>"; }
}

function showStockistMember(){
$showM3 = mysql_query("SELECT * FROM tb_users WHERE username!='admin' and stokis='1' order by id DESC limit 0,100");
while ($lihatM3 = mysql_fetch_array($showM3)) {
echo "<tr><td>". $lihatM3["username"] ."</td><td>". $lihatM3["kota"] ."</td></tr>"; }
}

function showSuspendMember(){
$showM4 = mysql_query("SELECT * FROM tb_users WHERE username!='admin' and suspend='1' order by id DESC limit 0,100");
while ($lihatM4 = mysql_fetch_array($showM4)) {
echo "<tr><td>". $lihatM4["username"] ."</td><td>". $lihatM4["kota"] ."</td></tr>"; }
}

function showActiveMember(){
$showM5 = mysql_query("SELECT * FROM tb_users WHERE username!='admin' and suspend!='1' order by id DESC limit 0,100");
while ($lihatM5 = mysql_fetch_array($showM5)) {
echo "<tr><td>". $lihatM5["username"] ."</td><td>". $lihatM5["kota"] ."</td></tr>"; }
}




//*********************************************************************************
// SHOW COUNT PH FUNCTION
//*********************************************************************************


function userPhOrderCheck($x1){
	$sql1 = mysql_query("SELECT * FROM tb_beli WHERE username='$x1'");
	$sql2 = mysql_query("SELECT * FROM tb_jual WHERE username='$x1'");
	$rows1 = mysql_num_rows($sql1);
	$rows2 = mysql_num_rows($sql2);
	if($rows1 == '0'){
		echo"
			<div class='info'>No Transactions Found</div>
		";
	}
}


$sql = mysql_query("SELECT SUM(paket) AS amountTotal FROM tb_ph");
while ($array = mysql_fetch_array($sql)) {
	if($array['amountTotal'] > '0'){
		$totalAllPh = $array['amountTotal'];
	}
	else{
		$totalAllPh = '0';
	}
}


$sql = mysql_query("SELECT SUM(saldo) AS amountTotal FROM tb_ph");
while ($array = mysql_fetch_array($sql)) {
	if($array['amountTotal'] > '0'){
		$totalAllPhNotpair = $array['amountTotal'];
	}
	else{
		$totalAllPhNotpair = '0';
	}
}


$sql = mysql_query("SELECT SUM(paket) AS amountTotal FROM tb_beli where status='sukses'");
while ($array = mysql_fetch_array($sql)) {
	if($array['amountTotal'] > '0'){
		$totalAllPhSukses = $array['amountTotal'];
	}
	else{
		$totalAllPhSukses = '0';
	}
}

$sql = mysql_query("SELECT SUM(paket) AS amountTotal FROM tb_beli where status='pending'");
while ($array = mysql_fetch_array($sql)) {
	if($array['amountTotal'] > '0'){
		$totalAllPhPending = $array['amountTotal'];
	}
	else{
		$totalAllPhPending = '0';
	}
}

$sql = mysql_query("SELECT SUM(paket) AS amountTotal FROM tb_beli where status='problem'");
while ($array = mysql_fetch_array($sql)) {
	if($array['amountTotal'] > '0'){
		$totalAllPhProblem = $array['amountTotal'];
	}
	else{
		$totalAllPhProblem = '0';
	}
}








function showPhMember($x1,$x2){
	echo"
<div class=\"table-responsive\">
<table class=\"table table-striped table-hover\">
  <thead>
    <tr>
      <th>ID Trx</th>
      <th>Date</th>
      <th>Amount</th>
      <th>Pair</th>
      <th>Not Pair</th>
      <th>Status</th>
    </tr>
      </thead>
        <tbody>
	";
	$sql = mysql_query("SELECT * FROM tb_ph WHERE username='$x1' order by id DESC limit 0,$x2");
	while ($frozen = mysql_fetch_array($sql)) {
		$ewdiljx= mysql_fetch_array(mysql_query("select * from settweb"));
		$matauang=$ewdiljx["ecurrency"];
		$desimal=$ewdiljx["desimal"];
	$frozenId = $frozen['id'];
  $frozenIdTrx = $frozen['idtrx'];
	$frozenUsername = $frozen['username'];
	$frozenAmount = number_format($frozen['paket'],$desimal);
	$frozenDate = date('d F Y, H:i',$frozen['date']);
	$frozenPair= number_format($frozen['saldo'],$desimal);
  $frozenNotPaire=$frozenAmount - $frozenPair;
  $frozenNotPair= number_format($frozenNotPaire,$desimal);
	$frozenDateRelease = date('d F Y, H:i',$frozen['date_release']);
	$frozenStatus = $frozen['status'];
  if($frozenStatus=='pending'){$button='info'; $mystats='Pending';} else
  if($frozenStatus=='problem'){$button='warning'; $mystats='Problem';} else
  if($frozenStatus=='reject'){$button='danger'; $mystats='Reject';} else
  if($frozenStatus=='sukses'){$button='success'; $mystats='Success';}
$ewdilj= mysql_fetch_array(mysql_query("select * from settphgh where id='1'"));
$phname=$ewdilj["nama"];
$skph=$ewdilj["singkatan"];
	echo"
		<tr>
    <td>$frozenIdTrx</td>
			<td>$frozenDate</td>
			<td>$matauang $frozenAmount</td>
			<td>$matauang $frozenNotPair</td>
			<td>$matauang $frozenPair</td>
			<td><button type='button' class='btn btn-$button btn-xs'>$mystats</button></td>
		</tr>
	";
	}
    echo "</tbody></table></div>";
}


function showPhOrderMember($x1,$x2){
	echo"
<div class=\"table-responsive\">
<table class=\"table table-striped table-hover\">
  <thead>
    <tr>
      <th>Sender</th>
      <th>Detail Trx</th>
      <th>Receiver</th>

    </tr>
      </thead>
        <tbody>
	";
	$sql = mysql_query("SELECT * FROM tb_beli WHERE username='$x1' order by id DESC limit 0,$x2");
	while ($frozen = mysql_fetch_array($sql)) {
	$frozenId = $frozen['id'];
  $frozenIdTrx = $frozen['token'];
	$frozenUsername = $frozen['username'];
  $frozenEmail = $frozen['email'];
  $frozenPhone = $frozen['phone'];
  $frozenPair = $frozen['referer'];
  $sqlz = mysql_query("SELECT * FROM tb_users WHERE username='$x1'");
  $frozenz = mysql_fetch_array($sqlz);
  $reffgue= $frozenz['referer'];
  $sqlzt = mysql_query("SELECT * FROM tb_users WHERE username='$reffgue'");
  $frozenzt = mysql_fetch_array($sqlzt);
  $phoneref= $frozenzt['phone'];
  $sqlzz = mysql_query("SELECT * FROM tb_users WHERE username='$frozenPair'");
  $frozenzz = mysql_fetch_array($sqlzz);
  $emailPair=$frozenzz['email'];
  $phonePair=$frozenzz['phone'];
  $upPair=$frozenzz['referer'];
  $sqlztt = mysql_query("SELECT * FROM tb_users WHERE username='$upPair'");
  $frozenztt = mysql_fetch_array($sqlztt);
  $phonereft= $frozenztt['phone'];
	$ewdiljx= mysql_fetch_array(mysql_query("select * from settweb"));
	$matauang=$ewdiljx["ecurrency"];
	$desimal=$ewdiljx["desimal"];
	$frozenAmount = number_format($frozen['paket'],$desimal);
	$frozenDate = date('d F Y, H:i',$frozen['date']);
	$frozenStatus = $frozen['status'];
  if($frozenStatus=='pending'){$button='info'; $mystats='Pending';} else
  if($frozenStatus=='problem'){$button='warning'; $mystats='Problem';} else
  if($frozenStatus=='reject'){$button='danger'; $mystats='Reject';} else
  if($frozenStatus=='sukses'){$button='success'; $mystats='Success';}
  $hari = date("H");
  $token=md5($frozenIdTrx.$hari);
$ewdilj= mysql_fetch_array(mysql_query("select * from settphgh where id='1'"));
$phname=$ewdilj["nama"];
$skph=$ewdilj["singkatan"];
	echo"
		<tr>
  	<td>Username : $frozenUsername <br> Email : $frozenEmail <br> Phone : $frozenPhone <br> Upline : $reffgue <br> Upline Phone : $phoneref</td>
    <td>ID Trx : $frozenIdTrx <br> Date : $frozenDate <br> Amount : $matauang $frozenAmount <br> Status : $mystats <br><a href='detailph.php?id=$frozenId&token=$token' class='btn btn-$button btn-xs'>View Detail</a></td>
		<td>Username : $frozenPair <br> Email : $emailPair <br> Phone : $phonePair <br> Upline : $upPair <br> Upline Phone : $phonereft</td>
		</tr>
	";
	}
    echo "</tbody></table></div>";
}




function showListAllOrderMember($x1){

function timeAgo($timestamp){
	    $time = time() - $timestamp;

	    if ($time < 60)
	    return ( $time > 1 ) ? $time . ' seconds' : 'a second';
	    elseif ($time < 3600) {
	    $tmp = floor($time / 60);
	    return ($tmp > 1) ? $tmp . ' minutes' : ' a minute';
	    }
	    elseif ($time < 86400) {
	    $tmp = floor($time / 3600);
	    return ($tmp > 1) ? $tmp . ' hours' : ' a hour';
	    }
	    elseif ($time < 2592000) {
	    $tmp = floor($time / 86400);
	    return ($tmp > 1) ? $tmp . ' days' : ' a day';
	    }
	    elseif ($time < 946080000) {
	    $tmp = floor($time / 2592000);
	    return ($tmp > 1) ? $tmp . ' months' : ' a month';
	    }
	    else {
	    $tmp = floor($time / 946080000);
	    return ($tmp > 1) ? $tmp . ' years' : ' a year';
	    }
    }
	echo"

<div class=\"table-responsive\">
<table class=\"table table-striped table-hover\">
  <thead>
    <tr>
      <th>Sender</th>
      <th>Amount</th>
      <th>Receiver</th>

    </tr>
      </thead>
        <tbody>
	";
	$sql = mysql_query("SELECT * FROM tb_beli order by id DESC limit 0,$x1");
	while ($frozen = mysql_fetch_array($sql)) {
	$frozenId = $frozen['id'];
  $frozenIdTrx = $frozen['token'];
	$frozenUsername = $frozen['username'];
  $frozenEmail = $frozen['email'];
  $frozenPhone = $frozen['phone'];
  $frozenPair = $frozen['referer'];
  $sqlz = mysql_query("SELECT * FROM tb_users WHERE username='$x1'");
  $frozenz = mysql_fetch_array($sqlz);
  $reffgue= $frozenz['referer'];
  $sqlzt = mysql_query("SELECT * FROM tb_users WHERE username='$reffgue'");
  $frozenzt = mysql_fetch_array($sqlzt);
  $phoneref= $frozenzt['phone'];
  $sqlzz = mysql_query("SELECT * FROM tb_users WHERE username='$frozenPair'");
  $frozenzz = mysql_fetch_array($sqlzz);
  $emailPair=$frozenzz['email'];
  $phonePair=$frozenzz['phone'];
  $upPair=$frozenzz['referer'];
  $sqlztt = mysql_query("SELECT * FROM tb_users WHERE username='$upPair'");
  $frozenztt = mysql_fetch_array($sqlztt);
  $phonereft= $frozenztt['phone'];
$ewdilj= mysql_fetch_array(mysql_query("select * from settphgh where id='1'"));
$phname=$ewdilj["nama"];
$skph=$ewdilj["singkatan"];
$ewdiljx= mysql_fetch_array(mysql_query("select * from settweb"));
$matauang=$ewdiljx["ecurrency"];
$desimal=$ewdiljx["desimal"];
	$frozenAmount = number_format($frozen['paket'],$desimal);
	$frozenDate = date('d F Y, H:i',$frozen['date']);
	$frozenDater = $frozen['date'];
	$frozenStatus = $frozen['status'];
  if($frozenStatus=='pending'){$button='info'; $mystats='Pending';} else
  if($frozenStatus=='problem'){$button='warning'; $mystats='Problem';} else
  if($frozenStatus=='reject'){$button='danger'; $mystats='Reject';} else
  if($frozenStatus=='sukses'){$button='success'; $mystats='Success';}
  $hari = date("H");
  $token=md5($frozenIdTrx.$hari);

	echo"

		<tr>
  	<td><i class=\"fa fa-user\"></i> $frozenUsername</td>
    <td><b> <i class=\"fa fa-money\"></i> $matauang $frozenAmount </b> <small> <i class=\"icon-time\"></i> ( ". timeAgo($frozenDater - 60 * 3) ." ago )</small></td>
		<td><i class=\"fa fa-trophy\"></i> $frozenPair</td>
		</tr>
	";
	}
    echo "</tbody></table></div>";
}



//*********************************************************************************
// SHOW COUNT GH FUNCTION
//*********************************************************************************

function userGhOrderCheck($x1){
	$sql1 = mysql_query("SELECT * FROM tb_beli WHERE username='$x1'");
	$sql2 = mysql_query("SELECT * FROM tb_jual WHERE username='$x1'");
	$rows1 = mysql_num_rows($sql1);
	$rows2 = mysql_num_rows($sql2);
	if($rows2 == '0'){
		echo"
			<div class='info'>No Transactions Found</div>
		";
	}
}

$sql = mysql_query("SELECT SUM(paket) AS amountTotal FROM tb_gh");
while ($array = mysql_fetch_array($sql)) {
	if($array['amountTotal'] > '0'){
		$totalAllGh = $array['amountTotal'];
	}
	else{
		$totalAllGh = '0';
	}
}



$sql = mysql_query("SELECT SUM(saldo) AS amountTotal FROM tb_gh");
while ($array = mysql_fetch_array($sql)) {
	if($array['amountTotal'] > '0'){
		$totalAllGhNotpair = $array['amountTotal'];
	}
	else{
		$totalAllGhNotpair = '0';
	}
}


$sql = mysql_query("SELECT SUM(paket) AS amountTotal FROM tb_jual where status='sukses'");
while ($array = mysql_fetch_array($sql)) {
	if($array['amountTotal'] > '0'){
		$totalAllGhSukses = $array['amountTotal'];
	}
	else{
		$totalAllGhSukses = '0';
	}
}

$sql = mysql_query("SELECT SUM(paket) AS amountTotal FROM tb_jual where status='tunggu transfer'");
while ($array = mysql_fetch_array($sql)) {
	if($array['amountTotal'] > '0'){
		$totalAllGhPending = $array['amountTotal'];
	}
	else{
		$totalAllGhPending = '0';
	}
}

$sql = mysql_query("SELECT SUM(paket) AS amountTotal FROM tb_jual where status='problem'");
while ($array = mysql_fetch_array($sql)) {
	if($array['amountTotal'] > '0'){
		$totalAllGhProblem = $array['amountTotal'];
	}
	else{
		$totalAllGhProblem = '0';
	}
}


//*********************************************************************************
// SHOW GH MEMBER FUNCTION
//*********************************************************************************



function showGhMemberKanan($x1,$x2){
	echo"
<div class=\"table-responsive\">
<table class=\"table table-striped table-hover\">
        <tbody>
	";
	$sql = mysql_query("SELECT * FROM tb_gh WHERE username='$x1' order by id DESC limit 0,$x2");
	while ($frozen = mysql_fetch_array($sql)) {
		$ewdiljx= mysql_fetch_array(mysql_query("select * from settweb"));
		$matauang=$ewdiljx["ecurrency"];
		$desimal=$ewdiljx["desimal"];
	$frozenId = $frozen['id'];
  $frozenIdTrx = $frozen['idtrx'];
	$frozenUsername = $frozen['username'];
	$frozenAmount = number_format($frozen['paket']);
	$frozenDate = date('d F Y, H:i',$frozen['date']);
	$frozenNotPair= number_format($frozen['saldo']);
  $frozenPair=$frozenAmount - $frozenNotPair;
  
	$frozenDateRelease = date('d F Y, H:i',$frozen['date_release']);
	$frozenStatus = $frozen['status'];
  if($frozenStatus=='pending'){$button='info'; $mystats='Pending';} else
  if($frozenStatus=='problem'){$button='warning'; $mystats='Problem';} else
  if($frozenStatus=='reject'){$button='danger'; $mystats='Reject';} else
  if($frozenStatus=='sukses'){$button='success'; $mystats='Success';} else
  if($frozenStatus=='dikunci'){$button='warning'; $mystats='Wait To Open Pair';}
if($frozenAmount==$frozenNotPair){$deletePair='<a href="deletetrx2.php?id=$frozenId" class="btn btn-danger btn-xs">DELETE REQUEST</a>';} else {$deletePair='';}
$ewdilj= mysql_fetch_array(mysql_query("select * from settphgh where id='2'"));
$ghname=$ewdilj["nama"];
$skgh=$ewdilj["singkatan"];
	echo"
		<tr>
<td>Request <b>$skgh # $frozenIdTrx</b> <BR> User:  $frozenUsername <br> Date : $frozenDate <br> Amount : $matauang $frozenAmount <br> Pair : $matauang $frozenPair <br> Not Pair : $matauang $frozenNotPair <br> Status : $mystats <br>
<a data-target=\"#modal-responsiveGH$frozenIdTrx\" data-toggle=\"modal\" class=\"btn btn-success btn-xs\">VIEW DETAIL</a><br>

</td>
			<td>
<div id=\"trxgh\"><p class=\"icon\"><i class=\"icon fa fa-arrow-circle-o-left\"></i></p> </div>
</td>
				</tr>
	";
	}
    echo "</tbody></table></div>";
}


function showGhMember($x1,$x2){
	echo"
<div class=\"table-responsive\">
<table class=\"table table-striped table-hover\">
  <thead>
    <tr>
      <th>ID Trx</th>
      <th>Date</th>
      <th>Amount</th>
      <th>Pair</th>
      <th>Not Pair</th>
      <th>Status</th>
    </tr>
      </thead>
        <tbody>
	";
	$sql = mysql_query("SELECT * FROM tb_gh WHERE username='$x1' order by id DESC limit 0,$x2");
	while ($frozen = mysql_fetch_array($sql)) {
		$ewdiljx= mysql_fetch_array(mysql_query("select * from settweb"));
		$matauang=$ewdiljx["ecurrency"];
		$desimal=$ewdiljx["desimal"];
	$frozenId = $frozen['id'];
  $frozenIdTrx = $frozen['idtrx'];
	$frozenUsername = $frozen['username'];
	$frozenAmount = number_format($frozen['paket'],$desimal);
	$frozenDate = date('d F Y, H:i',$frozen['date']);
	$frozenPair= number_format($frozen['saldo'],$desimal);
  $frozenNotPaire=$frozenAmount - $frozenPair;
  $frozenNotPair= number_format($frozenNotPaire,$desimal);
	$frozenDateRelease = date('d F Y, H:i',$frozen['date_release']);
	$frozenStatus = $frozen['status'];
  if($frozenStatus=='pending'){$button='info'; $mystats='Pending';} else
  if($frozenStatus=='problem'){$button='warning'; $mystats='Problem';} else
  if($frozenStatus=='reject'){$button='danger'; $mystats='Reject';} else
  if($frozenStatus=='sukses'){$button='success'; $mystats='Success';}
$ewdilj= mysql_fetch_array(mysql_query("select * from settphgh where id='2'"));
$ghname=$ewdilj["nama"];
$skgh=$ewdilj["singkatan"];
	echo"
		<tr>
    <td>$frozenIdTrx</td>
			<td>$frozenDate</td>
			<td>$matauang $frozenAmount</td>
			<td>$matauang $frozenNotPair</td>
			<td>$matauang $frozenPair</td>
			<td><button type='button' class='btn btn-$button btn-xs'>$mystats</button></td>
		</tr>
	";
	}
    echo "</tbody></table></div>";
}


function showGhOrderMember($x1,$x2){
	echo"
<div class=\"table-responsive\">
<table class=\"table table-striped table-hover\">
  <thead>
    <tr>
      <th>Sender</th>
      <th>Detail Trx</th>
      <th>Receiver</th>

    </tr>
      </thead>
        <tbody>
	";
	$sql = mysql_query("SELECT * FROM tb_beli WHERE referer='$x1' order by id DESC limit 0,$x2");
	while ($frozen = mysql_fetch_array($sql)) {
	$frozenId = $frozen['id'];
  $frozenIdTrx = $frozen['token'];
	$frozenUsername = $frozen['username'];
  $frozenEmail = $frozen['email'];
  $frozenPhone = $frozen['phone'];
  $frozenPair = $frozen['referer'];
  $sqlz = mysql_query("SELECT * FROM tb_users WHERE username='$x1'");
  $frozenz = mysql_fetch_array($sqlz);
  $reffgue= $frozenz['referer'];
  $sqlzt = mysql_query("SELECT * FROM tb_users WHERE username='$reffgue'");
  $frozenzt = mysql_fetch_array($sqlzt);
  $phoneref= $frozenzt['phone'];
  $sqlzz = mysql_query("SELECT * FROM tb_users WHERE username='$frozenPair'");
  $frozenzz = mysql_fetch_array($sqlzz);
  $emailPair=$frozenzz['email'];
  $phonePair=$frozenzz['phone'];
  $upPair=$frozenzz['referer'];
  $sqlztt = mysql_query("SELECT * FROM tb_users WHERE username='$upPair'");
  $frozenztt = mysql_fetch_array($sqlztt);
  $phonereft= $frozenztt['phone'];
$ewdilj= mysql_fetch_array(mysql_query("select * from settphgh where id='2'"));
$ghname=$ewdilj["nama"];
$skgh=$ewdilj["singkatan"];
$ewdiljx= mysql_fetch_array(mysql_query("select * from settweb"));
$matauang=$ewdiljx["ecurrency"];
$desimal=$ewdiljx["desimal"];
	$frozenAmount = number_format($frozen['paket'],$desimal);
	$frozenDate = date('d F Y, H:i',$frozen['date']);
	$frozenStatus = $frozen['status'];
  if($frozenStatus=='pending'){$button='info'; $mystats='Pending';} else
  if($frozenStatus=='problem'){$button='warning'; $mystats='Problem';} else
  if($frozenStatus=='reject'){$button='danger'; $mystats='Reject';} else
  if($frozenStatus=='sukses'){$button='success'; $mystats='Success';}
  $hari = date("H");
  $token=md5($frozenIdTrx.$hari);

	echo"
		<tr>
  	<td>Username : $frozenUsername <br> Email : $frozenEmail <br> Phone : $frozenPhone <br> Upline : $reffgue <br> Upline Phone : $phoneref</td>
    <td>ID Trx : $frozenIdTrx <br> Date : $frozenDate <br> Amount : $matauang $frozenAmount <br> Status : $mystats <br><a href='detailph2.php?id=$frozenId&token=$token' class='btn btn-$button btn-xs'>View Detail</a></td>
		<td>Username : $frozenPair <br> Email : $emailPair <br> Phone : $phonePair <br> Upline : $upPair <br> Upline Phone : $phonereft</td>
		</tr>
	";
	}
    echo "</tbody></table></div>";
}



//*********************************************************************************
// PH GH FORM FUNCTION
//*********************************************************************************

function cekPHNotSukses($x1){
$sqle = "SELECT COUNT(*) AS cnt FROM tb_ph WHERE username='$x1' and status!='sukses'";
$resulte = mysql_query($sqle);        
$rowe = mysql_fetch_array($resulte);
$pend = $rowe['cnt'];
$ewdilj= mysql_fetch_array(mysql_query("select * from settphgh where id='1'"));
$phname=$ewdilj["nama"];
$skph=$ewdilj["singkatan"];
$ewdiljX= mysql_fetch_array(mysql_query("select * from settphgh where id='2'"));
$ghname=$ewdiljX["nama"];
$skgh=$ewdiljX["singkatan"];
if ($pend > 0)
{
$error = 1;
$errormsg .= "
<b>Sorry, you cannot request $phname / $ghname !</b><br>
You Have a $phname transaction and not completed. Finishing it FIRST!
";
}
}

function cekPHOrderNotSukses($x1){
$sqle = "SELECT COUNT(*) AS cnt FROM tb_beli WHERE username='$x1' and status!='sukses'";
$resulte = mysql_query($sqle);        
$rowe = mysql_fetch_array($resulte);
$pend = $rowe['cnt'];
$ewdilj= mysql_fetch_array(mysql_query("select * from settphgh where id='1'"));
$phname=$ewdilj["nama"];
$skph=$ewdilj["singkatan"];
$ewdiljX= mysql_fetch_array(mysql_query("select * from settphgh where id='2'"));
$ghname=$ewdiljX["nama"];
$skgh=$ewdiljX["singkatan"];
if ($pend > 0)
{
$error = 1;
$errormsg .= "
<b>Sorry, you cannot request $phname / $ghname !</b><br>
You Have a $phname transaction and not completed. Finishing it FIRST!
";
}
}

function cekGHNotSukses($x1){
$sqle = "SELECT COUNT(*) AS cnt FROM tb_gh WHERE username='$x1' and status!='sukses'";
$resulte = mysql_query($sqle);        
$rowe = mysql_fetch_array($resulte);
$pend = $rowe['cnt'];
$ewdilj= mysql_fetch_array(mysql_query("select * from settphgh where id='1'"));
$phname=$ewdilj["nama"];
$skph=$ewdilj["singkatan"];
$ewdiljX= mysql_fetch_array(mysql_query("select * from settphgh where id='2'"));
$ghname=$ewdiljX["nama"];
$skgh=$ewdiljX["singkatan"];
if ($pend > 0)
{
$error = 1;
$errormsg .= "
<b>Sorry, you cannot request $phname / $ghname!</b><br>
You Have a $ghname transaction and not completed. Finishing it FIRST!
";
}
}

function cekGHOrderNotSukses($x1){
$sqle = "SELECT COUNT(*) AS cnt FROM tb_jual WHERE username='$x1' and status!='sukses'";
$resulte = mysql_query($sqle);        
$rowe = mysql_fetch_array($resulte);
$pend = $rowe['cnt'];
$ewdilj= mysql_fetch_array(mysql_query("select * from settphgh where id='1'"));
$phname=$ewdilj["nama"];
$skph=$ewdilj["singkatan"];
$ewdiljX= mysql_fetch_array(mysql_query("select * from settphgh where id='2'"));
$ghname=$ewdiljX["nama"];
$skgh=$ewdiljX["singkatan"];
if ($pend > 0)
{
$error = 1;
$errormsg .= "
<b>Sorry, you cannot request $phname / $ghname !</b><br>
You Have a $ghname transaction and not completed. Finishing it FIRST!
";
}
}







function cekUpLevel($x1){
$sqle = "SELECT * FROM tb_users WHERE username='$x1'";
$resulte = mysql_query($sqle);        
$rowe = mysql_fetch_array($resulte);
$leva = $rowe["leva"];
$levb = $rowe["levb"];
$levc = $rowe["levc"];
$levd = $rowe["levd"];
$leve = $rowe["leve"];
$levf = $rowe["levf"];
$levg = $rowe["levg"];
$levh = $rowe["levh"];
$levi = $rowe["levi"];
$levj = $rowe["levj"];
$upline = $rowe["referer"];
$manager = $rowe["referer"];
$user=$rowe["username"];
$namalengkap=$rowe["namalengkap"];
$email=$rowe["email"];
$phone=$rowe["phone"];
$bbm=$rowe["bbm"];

$bank=$rowe["bank"];
$norek=$rowe["norek"];
$nama=$rowe["nama"];

$bitcoin=$rowe["bitcoin"];
$fasapay=$rowe["fasapay"];
$perfectmoney=$rowe["perfectmoney"];
}








//*********************************************************************************
// MEMBER SETTING
//*********************************************************************************

if(isset($_SESSION['username'])){
$sessionUsername = $_SESSION['username'];
$sessionPassword = $_SESSION['password'];
$memberdata= mysql_fetch_array(mysql_query("select * from tb_users where username='$sessionUsername' AND password='$sessionPassword'"));

$usernameku=$memberdata["username"];
$namalengkapku=$memberdata["namalengkap"];

$bankku=$memberdata["bank"];
$norekku=$memberdata["norek"];
$namaku=$memberdata["nama"];
$btcku=$memberdata["bitcoin"];
$pmku=$memberdata["perfectmoney"];
$payeerku=$memberdata["payeer"];

$emailku=$memberdata["email"];
$hpku=$memberdata["phone"];
$bbmku=$memberdata["bbm"];
$waku=$memberdata["wa"];

$sponsorku=$memberdata["referer"];

$avatarku=$memberdata["avatar"];

$alamatku=$memberdata["alamat"];
$kotaku=$memberdata["kota"];
$posku=$memberdata["kodepos"];
$negaraku=$memberdata["country"];

$ipku=$memberdata["ip"];
$lastipku=$memberdata["lastiplog"];
$joinku=$memberdata["joindate"];
$lastlogku=$memberdata["lastlogdate"];

$saldoku=$memberdata["money"];
$bonusku=$memberdata["moneys"];
$tiketku=$memberdata["saldotiket"];

$suspendku=$memberdata["suspend"];

$phawalku=$memberdata["phawal"];

$stokisku=$memberdata["stokis"];

$gauthku=$memberdata["gauth"];
$gauthexpku=$memberdata["gauthexp"];

$sponsordata= mysql_fetch_array(mysql_query("select * from tb_users where username='$sponsorku'"));

$usernamemu=$sponsordata["username"];
$namalengkapmu=$sponsordata["namalengkap"];

$bankmu=$sponsordata["bank"];
$norekmu=$sponsordata["norek"];
$namamu=$sponsordata["nama"];
$btcmu=$sponsordata["bitcoin"];
$pmmu=$sponsordata["perfectmoney"];
$payeermu=$sponsordata["payeer"];

$emailmu=$sponsordata["email"];
$hpmu=$sponsordata["phone"];
$bbmmu=$sponsordata["bbm"];
$wamu=$sponsordata["wa"];

$sponsormu=$sponsordata["referer"];

$avatarmu=$sponsordata["avatar"];

$alamatmu=$sponsordata["alamat"];
$kotamu=$sponsordata["kota"];
$posmu=$sponsordata["kodepos"];
$negaramu=$sponsordata["country"];

$ipmu=$sponsordata["ip"];
$lastipmu=$sponsordata["lastiplog"];
$joinmu=$sponsordata["joindate"];
$lastlogmu=$sponsordata["lastlogdate"];

$saldomu=$sponsordata["money"];
$bonusmu=$sponsordata["moneys"];
$tiketmu=$sponsordata["saldotiket"];

$suspendmu=$sponsordata["suspend"];

$phawalmu=$sponsordata["phawal"];

$stokismu=$sponsordata["stokis"];

$gauthmu=$sponsordata["gauth"];
$gauthexpmu=$sponsordata["gauthexp"];

}




//*********************************************************************************
// PH SETTING
//*********************************************************************************


function cekPHTiket($x1){
$ewdilj=mysql_fetch_array(mysql_query("select * from settph where id='1'"));
$tiketph=$ewdilj["tiket"];
$jmltiketph=$ewdilj["jmltiket"];

if($tiketph=='1'){
$butuhtiket=$jmltiketph;    
$rowe = mysql_fetch_array(mysql_query("SELECT FROM tb_users WHERE username='$x1'"));
$tiketku=$rowe["saldotiket"];

if($tiketku < $butuhtiket){
$error = 1;
$errormsg .= "
<b>Sorry, Transaction failed!</b><br>
You Dont Have Enaugh Ticket. Please Buy Ticket First!
"; 
} else {}
} else {}
}


function cekPHon(){
$ewdilj= mysql_fetch_array(mysql_query("select * from settph where id='1'"));
$phon=$ewdilj["status"];
if($phon=='1'){} else {
$error = 1;
$errormsg .= "
Sorry, Request Was Closed. Please wait to activated. "; 
}
}





//*********************************************************************************
// ACAK ANGKA SETTING
//*********************************************************************************


function acakAngkaHuruf1($panjang)
{
	$karakter= '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$string = '';
	for ($i = 0; $i < $panjang; $i++) {
		$pos = rand(0, strlen($karakter)-1);
		$string .= $karakter{$pos};
	}
	return $string;
}

function acakAngkaHuruf2($panjang)
{
	$karakter= '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$string = '';
	for ($i = 0; $i < $panjang; $i++) {
		$pos = rand(0, strlen($karakter)-1);
		$string .= $karakter{$pos};
	}
	return $string;
}



//*********************************************************************************
// SHOW LIST PH MEMBER KANAN FUNCTION
//*********************************************************************************


function showPhOrderMemberKananModal($x1,$x2){
	
$ewdilj= mysql_fetch_array(mysql_query("select * from settphgh where id='1'"));
$phname=$ewdilj["nama"];
$skph=$ewdilj["singkatan"];

$ewdiljp= mysql_fetch_array(mysql_query("select * from settphgh where id='2'"));
$ghname=$ewdiljp["nama"];
$skgh=$ewdiljp["singkatan"];

$ewdiljxo= mysql_fetch_array(mysql_query("select * from settweb"));
$matauang=$ewdiljxo["ecurrency"];
		$desimal=$ewdiljxo["desimal"];

$tabla = mysql_query("SELECT * FROM tb_ph where username='$x1' and id='$x2'"); 
while ($registro = mysql_fetch_array($tabla)) { 
$sisaphnya=$pecahan * $registro["saldo"];
$ferpax=$registro["id"];
$ferpa=$registro["paket"];
$ferp=$registro["saldo"];
$pairnya=$ferpa - $ferp;
$frozenStatus=$registro["status"];
if($frozenStatus=='pending'){$button='info'; $mystats='Pending';} else
  if($frozenStatus=='problem'){$button='warning'; $mystats='Problem';} else
  if($frozenStatus=='reject'){$button='danger'; $mystats='Reject';} else
  if($frozenStatus=='sukses'){$button='success'; $mystats='Success';} else
  if($frozenStatus=='dilock'){$button='warning'; $mystats='Wait Transfer DP';}
  if($frozenStatus=='dikunci'){$button='warning'; $mystats='Wait To Open Pair';}
echo "
<div id_order=\"". $registro["idtrx"] ."\" class=\"ordin \" id=\"order_in_". $registro["idtrx"] ."\" style=\"cursor: pointer;\">
<table border=\"0\" cellpadding=\"0\" cellspacing=\"6\" width=\"100%\">
<tbody><tr>
<td><img src=\"/img/strelka32.png\" height=\"32\" width=\"32\"></td>
<td class=\"ord_title\"><span class=\"translate\">Request to $skph </span><br><span class=\"order_in_id\"> <b>$skph ". $registro["idtrx"] ."</b></span></td>
</tr>
<tr>
<td colspan=\"2\" class=\"ord_body\">
<div class=\"ord_body_info\">
<span class=\"translate\">Participant</span> : 
<span class=\"order_in_fio\"> ". $registro["username"] ." </span><br>
<span class=\"translate\">Amount</span> : <span class=\"order_in_amount\">$matauang ". number_format($registro["paket"]) ."</span> <span class=\"order_in_currency\"></span><br>
<span class=\"rest_in\"><span class=\"translate\">Balance Remaining</span> : <span class=\"order_in_rest\">$matauang ". number_format($registro["saldo"]) ."</span> <span class=\"order_in_currency\"></span><br></span>
<span class=\"translate\">Date</span> : <span class=\"order_in_date\">". date("l, d M Y ",$registro["date"]) ."</span><br>
<span class=\"translate\">Status</span> : <span class=\"order_in_status\">". $mystats ."</span>
</div>
<div class=\"ord_body_is_avto\"><img src=\"/img/avto37.png\" alt=\"\"></div>
</td>
</tr>
</tbody></table>
</div> ";
}
}





function showPhOrderMemberKananModalList($x1,$x2){
	
$ewdilj= mysql_fetch_array(mysql_query("select * from settphgh where id='1'"));
$phname=$ewdilj["nama"];
$skph=$ewdilj["singkatan"];

$ewdiljp= mysql_fetch_array(mysql_query("select * from settphgh where id='2'"));
$ghname=$ewdiljp["nama"];
$skgh=$ewdiljp["singkatan"];

$ewdiljxo= mysql_fetch_array(mysql_query("select * from settweb"));
$matauang=$ewdiljxo["ecurrency"];
		$desimal=$ewdiljxo["desimal"];

$tabla = mysql_query("SELECT * FROM tb_beli where username='$x1' and idph='$x2'"); 
while ($registro = mysql_fetch_array($tabla)) { 
$derix=$registro["id"];
$deriz=$registro["idph"];
$deric=$registro["iddb"];
$usernamex=$registro["username"];
$phonex=$registro["phone"];
$bankx=$registro["bank"];
$norekx=$registro["norek"];
$namax=$registro["nama"];
$bitcoinx=$registro["amountbtc"];
$tokenx=$registro["token"];
$konf=$registro["konfirmasi"];
$stats=$registro["status"];
$Datex = date('d F Y, H:i',$registro['date']);
$Datexap = date('d F Y, H:i',$registro['autoapp']);
$Expx = date('d F Y, H:i',$registro['exp']);
$Expxa = $registro['exp'];
$tablao = mysql_query("SELECT * FROM tb_jual where token='$tokenx'"); 
$registroo = mysql_fetch_array($tablao);
$idjual= $registroo["id"];
$usernamexo=$registroo["username"];
$bankxo=$registroo["bank"];
$norekxo=$registroo["norek"];
$namaxo=$registroo["nama"];
$bitcoinxo=$registroo["bitcoin"];
$phonexo=$registroo["phone"];
$emailxo=$registroo["email"];

$tablap = mysql_query("SELECT * FROM tb_ph where id='$deriz'"); 
$registrop = mysql_fetch_array($tablap);
$idtrx= $registrop["idtrx"];
if($stats=='pending'){
if($konf=='0'){
$said="Please Transfer Now and Confirm to fast approve";
$saida="img/ok2.png";
$konfp="Expired : $Expx <br> <a href=\"confirm.php?id=". $derix ."\"  style=\"float:right;\" class=\"neoui-greybutton translate\" style=\"float:right;\">Confirm Now!</a>";
} else
if($konf=='1'){
$said="Waiting Approve. Contact your Pair to fast Approve";
$saida="img/ok1.png";
$konfp="Auto Approve : $Datexap <br>
<div id=\"detail\" class=\"small ui neoui-greybutton translate callmodal\"  style=\"float:right;\" data-modal=\"confirm". $derix ."\">View Confirm</div>";
} 
}

if($stats=='sukses'){
if($konf=='0'){
$said="Thanks For Your Participation";
$saida="img/ok.png";
$konfp="
<div id=\"detail\" class=\"small ui neoui-greybutton translate callmodal\"  style=\"float:right;\" data-modal=\"confirm". $derix ."\">View Confirm</div>";

} else
if($konf=='1'){
$said="Thanks For Your Participation";
$saida="img/ok.png";
$konfp="<div id=\"detail\" class=\"small ui neoui-greybutton translate callmodal\"  style=\"float:right;\" data-modal=\"confirm". $derix ."\">View Confirm</div>";
} 
}

if($stats=='problem'){
if($konf=='0'){
$said="Contact Your Pair";
$saida="img/block.png";
$konfp="Expired : $Expx <br><a href=\"confirm.php?id=". $derix ."\" class=\"neoui-greybutton translate\" style=\"float:right;\">Confirm Now!</a>";
} else
if($konf=='1'){
$said="Contact Your Pair or Manager";
$saida="img/block.png";
$konfp="Auto Approve : $Datexap <BR><div id=\"detail\" class=\"small ui neoui-greybutton translate callmodal\" style=\"float:right;\" data-modal=\"confirm". $derix ."\">View Confirm</div>";
} 
}

$sqle = "SELECT COUNT(*) AS cnt FROM messages WHERE idb='$derix'";
$resulte = mysql_query($sqle);        
$rowe = mysql_fetch_array($resulte);
$pend = $rowe['cnt'];

$deri=$registro["status"];
if($deri=='pending'){$status='Pending';}
if($deri=='problem'){$status='Blocked';}
if($deri=='sukses'){$status='Success';}

$apel=$registro["exp"];
$jambu=time();
$jeruk=$apel-$jambu;
$sirsak=floor($jeruk/3600);
$sirsake=floor($jeruk/86400);

if($apel > $jambu){$rambutan="$sirsak hours";} 
else{$rambutan="";}

echo "
<div class=\"arrg arrg_in\" style=\"cursor: pointer;\" width=\"100%\">
<table class=\"arrg_tbarrg\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\" width=\"100%\">
<tbody>
<tr>
<td class=\"arrg_status_name\" colspan=\"8\"> $said (Request $skph $idtrx )</td>
<td class=\"arrg_status_name\" colspan=\"2\">
<span class=\"translate\">Number :<br>".  $registro["token"] ."</span>
</td>
</tr>
<tr>
<td  class=\"arrg_num\" width=\"10%\"><img src=\"/". $saida ."\" class=\"arrg_status_img\" height=\"36\" width=\"36\"><br>
</td>
<td class=\"arrg_num\" width=\"2%\"></td>
<td class=\"arrg_num\" width=\"10%\"><span class=\"arrg_sm10\"><span class=\"translate\">Date of creating :<br> ". date("Y-m-d ",$registro["date"]) ."</span>
</td>
<td class=\"arrg_num\" width=\"2%\"></td>
<td class=\"arrg_name1\"><span class=\"arrg_user_in\">You <br> </span>
<div class=\"arrg_bank_in\">BTC</div></td>
<td class=\"arrg_num\" width=\"2%\"></td>
<td  class=\"arrg_summ\" align=\"center\" class=\"arrg_summ\" align=\"center\">
<span class=\"arrg_amt\">$matauang ".  number_format($registro["paket"]) ." </span><br>
BTC ".  round($bitcoinx,8) ." 
<div class=\"arrg_out_files\" style=\"\">
</div>
</td>
<td class=\"arrg_num\" width=\"4%\"></td>
<td class=\"arrg_name2\" colspan=\"2\"> <span class=\"arrg_user_out\">".  $usernamexo ." <br> ".  $phonexo ." <br> ".  $bankxo ." <br> ".  $norekxo ." <br> ".  $namaxo ."</span>

</td>
</tr>

</tbody>
</table>
</div>
";  }  
}


//*********************************************************************************
// GET BONUS FUNCTION
//*********************************************************************************

function cekGHBTiket($x1){
$jfrtylo="select * from settbonus where id='1'";
$kloyvb=mysql_query($jfrtylo);
$ewdilj=mysql_fetch_array($kloyvb);
$tiketgh=$ewdilj["tiket"];
$jmltiketgh=$ewdilj["jmltiket"];
$ghbname=$ewdilj["nama"];
$dpph=$ewdilj["dp"];
if($tiketgh=='1'){
$butuhtiket=$jmltiketgh;
$sqle = "SELECT FROM tb_users WHERE username='$x1'";
$resulte = mysql_query($sqle);        
$rowe = mysql_fetch_array($resulte);
$tiketku=$rowe["saldotiket"];
if($tiketku < $butuhtiket){
$error = 1;
$errormsg .= "
<b>Sorry, you cannot request $ghbname !</b><br>
You Dont Have Enaugh Ticket. Please Buy Ticket First!
"; 

} else {}
} else {}
}

function cekGHBonuson(){
$ewdilj= mysql_fetch_array(mysql_query("select * from settbonus where id='1'"));
$ghbon=$ewdilj["status"];
$ghbname=$ewdilj["nama"];
$skghb=$ewdilj["singkatan"];
if($ghbon=='1'){} else {
$error = 1;
$errormsg .= "Sorry, $skghb Request Was Closed. Please wait to activated."; 
}

}



//*********************************************************************************
// GET HELP FUNCTION
//*********************************************************************************



function cekGHon(){
$ewdilj= mysql_fetch_array(mysql_query("select * from settgh where id='1'"));
$ghon=$ewdilj["status"];
$ghname=$ewdilj["nama"];
$skgh=$ewdilj["singkatan"];
if($ghon=='1'){} else {
$error = 1;
$errormsg .= " Sorry, $skgh Request Was Closed. Please wait to activated."; 
}
}


function cekGHTiket($x1){
$jfrtylo="select * from settgh where id='1'";
$kloyvb=mysql_query($jfrtylo);
$ewdilj=mysql_fetch_array($kloyvb);
$tiketgh=$ewdilj["tiket"];
$jmltiketgh=$ewdilj["jmltiket"];
$ghname=$ewdilj["nama"];
if($tiketgh=='1'){
$butuhtiket=$jmltiketgh;
$sqle = "SELECT FROM tb_users WHERE username='$x1'";
$resulte = mysql_query($sqle);        
$rowe = mysql_fetch_array($resulte);
$tiketku=$rowe["saldotiket"];
if($tiketku < $butuhtiket){
$error = 1;
$errormsg .= "
<b>Sorry, you cannot request $ghname !</b><br>
You Dont Have Enaugh Ticket. Please Buy Ticket First!
"; 

} else {}
} else {}
}



function cekPHOrderSukses($x1){
$sqle = "SELECT COUNT(*) AS cnt FROM tb_ph WHERE username='$x1' and status='sukses'";
$resulte = mysql_query($sqle);        
$rowe = mysql_fetch_array($resulte);
$pend = $rowe['cnt'];
$ewdiljr= mysql_fetch_array(mysql_query("select * from settgh where id='1'"));
$ghname=$ewdiljr["nama"];
$skgh=$ewdiljr["singkatan"];
$ewdiljro= mysql_fetch_array(mysql_query("select * from settph where id='1'"));
$phname=$ewdiljro["nama"];
$skph=$ewdiljro["singkatan"];
if ($pend < 1)
{
$error = 1;
$errormsg .= "
<b>Sorry, you cannot request $ghname !</b><br>
You Dont Have a $phname transaction completed. Please $skph FIRST!
";
}
}




function showGhOrderMemberKananModal($x1,$x2){
	
$ewdilj= mysql_fetch_array(mysql_query("select * from settphgh where id='1'"));
$phname=$ewdilj["nama"];
$skph=$ewdilj["singkatan"];

$ewdiljp= mysql_fetch_array(mysql_query("select * from settphgh where id='2'"));
$ghname=$ewdiljp["nama"];
$skgh=$ewdiljp["singkatan"];

$ewdiljxo= mysql_fetch_array(mysql_query("select * from settweb"));
$matauang=$ewdiljx["ecurrency"];
		$desimal=$ewdiljx["desimal"];

$tabla = mysql_query("SELECT * FROM tb_gh where username='$x1' and id='$x2'"); 
while ($registro = mysql_fetch_array($tabla)) { 
$sisaphnya=$pecahan * $registro["saldo"];
$ferpax=$registro["id"];
$ferpa=$registro["paket"];
$ferp=$registro["saldo"];
$pairnya=$ferpa - $ferp;
$frozenStatus=$registro["status"];
if($frozenStatus=='pending'){$button='info'; $mystats='Pending';} else
  if($frozenStatus=='problem'){$button='warning'; $mystats='Problem';} else
  if($frozenStatus=='reject'){$button='danger'; $mystats='Reject';} else
  if($frozenStatus=='sukses'){$button='success'; $mystats='Success';} else
  if($frozenStatus=='dilock'){$button='warning'; $mystats='Wait Transfer DP';}
  if($frozenStatus=='dikunci'){$button='warning'; $mystats='Wait To Open Pair';}
echo "
<div id_order=\"". $registro["idtrx"] ."\" class=\"ordout \" id=\"order_in_". $registro["idtrx"] ."\" style=\"cursor: pointer;\">
<table border=\"0\" cellpadding=\"0\" cellspacing=\"6\" width=\"100%\">
<tbody><tr>
<td><img src=\"/img/strelka_32.png\" height=\"32\" width=\"32\"></td>
<td class=\"ord_title\"><span class=\"translate\">Request to $skgh </span><br><span class=\"order_in_id\"> <b>$skgh ". $registro["idtrx"] ."</b></span></td>
</tr>
<tr>
<td colspan=\"2\" class=\"ord_body\">
<div class=\"ord_body_info\">
<span class=\"translate\">Participant</span> : 
<span class=\"order_in_fio\"> ". $registro["username"] ." </span><br>
<span class=\"translate\">Amount</span> : <span class=\"order_in_amount\">$matauang ". number_format($registro["paket"]) ."</span> <span class=\"order_in_currency\"></span><br>
<span class=\"rest_in\"><span class=\"translate\">Pair</span> : <span class=\"order_in_rest\">$matauang ". number_format($pairnya) ."</span> <span class=\"order_in_currency\"></span><br></span>
<span class=\"rest_in\"><span class=\"translate\">Not Pair</span> : <span class=\"order_in_rest\">$matauang ". number_format($registro["saldo"]) ."</span> <span class=\"order_in_currency\"></span><br></span>
<span class=\"translate\">Date</span> : <span class=\"order_in_date\">". date("l, d M Y ",$registro["date"]) ."</span><br>
<span class=\"order_in_mavro\"></span><br>
<span class=\"translate\">Status</span> : <span class=\"order_in_status\">". $mystats ."</span>
</div>
<div class=\"ord_body_is_avto\"><img src=\"/img/avto37.png\" alt=\"\"></div>
</td>
</tr>
</tbody></table>
</div> ";
}
}



function showGhOrderMemberKananModalList($x1,$x2){
	
$ewdilj= mysql_fetch_array(mysql_query("select * from settphgh where id='1'"));
$phname=$ewdilj["nama"];
$skph=$ewdilj["singkatan"];

$ewdiljp= mysql_fetch_array(mysql_query("select * from settphgh where id='2'"));
$ghname=$ewdiljp["nama"];
$skgh=$ewdiljp["singkatan"];

$ewdiljxo= mysql_fetch_array(mysql_query("select * from settweb"));
$matauang=$ewdiljx["ecurrency"];
		$desimal=$ewdiljx["desimal"];

$tabla = mysql_query("SELECT * FROM tb_beli where referer='$x1' and iddb='$x2'"); 
while ($registro = mysql_fetch_array($tabla)) { 
$derix=$registro["id"];
$deriz=$registro["idph"];
$deric=$registro["iddb"];
$usernamex=$registro["username"];
$phonex=$registro["phone"];
$bankx=$registro["bank"];
$norekx=$registro["norek"];
$namax=$registro["nama"];
$bitcoinx=$registro["amountbtc"];
$tokenx=$registro["token"];
$konf=$registro["konfirmasi"];
$stats=$registro["status"];
$Datex = date('d F Y, H:i',$registro['date']);
$Expx = date('d F Y, H:i',$registro['exp']);
$Expxa = $registro['exp'];
$tablao = mysql_query("SELECT * FROM tb_jual where token='$tokenx'"); 
$registroo = mysql_fetch_array($tablao);
$idjual= $registroo["id"];
$usernamexo=$registroo["username"];
$bankxo=$registroo["bank"];
$norekxo=$registroo["norek"];
$namaxo=$registroo["nama"];
$bitcoinxo=$registroo["bitcoin"];
$phonexo=$registroo["phone"];
$emailxo=$registroo["email"];

$tablap = mysql_query("SELECT * FROM tb_gh where id='$deric'"); 
$registrop = mysql_fetch_array($tablap);
$idtrx= $registrop["idtrx"];

if($stats=='pending'){

if($konf=='0'){
$said="Please Contact Your Sender to Transfer";
$saida="img/ok2.png";
$konfp="<a href=\"approve.php?id=". $derix ."\" class=\"neoui-greybutton translate\" style=\"float:right;\">Approve Now!</a><a href=\"reject.php?id=". $derix ."\" class=\"neoui-greybutton translate\" style=\"float:right;\">Reject Now!</a>";
} else
if($konf=='1'){
$said="Waiting Approve. Plese check your BTC and approve soon";
$saida="img/ok1.png";
$konfp="<a href=\"approve.php?id=". $derix ."\" class=\"neoui-greybutton translate\" style=\"float:right;\">Approve Now!</a><a href=\"reject.php?id=". $derix ."\" class=\"neoui-greybutton translate\" style=\"float:right;\">Reject Now!</a>";
} 
}

if($stats=='sukses'){
if($konf=='0'){
$said="Thanks For Your Participation";
$saida="img/ok.png";
$konfp="";
} else
if($konf=='1'){
$said="Thanks For Your Participation";
$saida="img/ok.png";
$konfp="";
} 
}

if($stats=='problem'){
if($konf=='0'){
$said="Contact Your Pair";
$saida="img/block.png";
$konfp="<a href=\"approve.php?id=". $derix ."\" class=\"neoui-greybutton translate\" style=\"float:right;\">Approve Now!</a><a href=\"reject.php?id=". $derix ."\" class=\"neoui-greybutton translate\" style=\"float:right;\">Reject Now!</a>";
} else
if($konf=='1'){
$said="Contact Your Pair or Manager";
$saida="img/block.png";
$konfp="<a href=\"approve.php?id=". $derix ."\" class=\"neoui-greybutton translate\" style=\"float:right;\">Approve Now!</a><a href=\"reject.php?id=". $derix ."\" class=\"neoui-greybutton translate\" style=\"float:right;\">Reject Now!</a>";
} 
}


$sqle = "SELECT COUNT(*) AS cnt FROM messages WHERE idb='$derix'";
$resulte = mysql_query($sqle);        
$rowe = mysql_fetch_array($resulte);
$pend = $rowe['cnt'];

$deri=$registro["status"];
if($deri=='pending'){$status='Pending';}
if($deri=='problem'){$status='Blocked';}
if($deri=='sukses'){$status='Success';}

$apel=$registro["exp"];
$jambu=time();
$jeruk=$apel-$jambu;
$sirsak=floor($jeruk/3600);
$sirsake=floor($jeruk/86400);

if($apel > $jambu){$rambutan="$sirsak hours";} 
else{$rambutan="";}

echo "
<div class=\"arrg arrg_out\" style=\"cursor: pointer;\" width=\"100%\">
<table class=\"arrg_tbarrg\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\" width=\"100%\">
<tbody>
<tr>
<td class=\"arrg_status_name\" colspan=\"8\"> $said (Request $skgh $idtrx )</td>
<td class=\"arrg_status_name\" colspan=\"2\">
<span class=\"translate\">Number :<br>".  $registro["token"] ."</span>
</td>
</tr>
<tr>
<td  class=\"arrg_num\" width=\"10%\"><img src=\"/". $saida ."\" class=\"arrg_status_img\" height=\"36\" width=\"36\"><br>
</td>
<td class=\"arrg_num\" width=\"2%\"></td>
<td class=\"arrg_num\" width=\"10%\"><span class=\"arrg_sm10\"><span class=\"translate\">Date of creating :<br> ". date("Y-m-d ",$registro["date"]) ."</span>
</td>
<td class=\"arrg_num\" width=\"2%\"></td>
<td class=\"arrg_name1\"><span class=\"arrg_user_in\">".  $usernamex ." <br> ".  $phonex ."</span>
<div class=\"arrg_bank_in\">BTC</div></td>
<td class=\"arrg_num\" width=\"2%\"></td>
<td  class=\"arrg_summ\" align=\"center\" class=\"arrg_summ\" align=\"center\">
<span class=\"arrg_amt\">$matauang ".  number_format($registro["paket"]) ." </span><br>
BTC ".  round($bitcoinx,8) ." 
<div class=\"arrg_out_files\" style=\"\">
</div>
</td>
<td class=\"arrg_num\" width=\"2%\"></td>
<td class=\"arrg_name2\" colspan=\"2\"> <span class=\"arrg_user_out\">You <br> ". $phonexo ." <br> </span>

</td>
</tr>

</tbody>
</table>
</div>
";  }  
}




//*********************************************************************************
// PAYMENT USER FUNCTION
//*********************************************************************************

function showBTCku($x1){
$dora= mysql_fetch_array(mysql_query("select * from tb_users where username='$x1'"));
echo "Bitcoin : ". $dora["bitcoin"]." ";
}



//*********************************************************************************
// CONTENT FUNCTION
//*********************************************************************************

function showContent($x1){
$dora= mysql_fetch_array(mysql_query("select * from konten where id='$x1'"));
echo "". $dora["comments"]." ";
}






function showDPOrderMemberKananModal($x1,$x2){
	
$ewdilj= mysql_fetch_array(mysql_query("select * from settphgh where id='1'"));
$phname=$ewdilj["nama"];
$skph=$ewdilj["singkatan"];

$ewdiljp= mysql_fetch_array(mysql_query("select * from settphgh where id='2'"));
$ghname=$ewdiljp["nama"];
$skgh=$ewdiljp["singkatan"];

$ewdiljxo= mysql_fetch_array(mysql_query("select * from settweb"));
$matauang=$ewdiljxo["ecurrency"];
		$desimal=$ewdiljxo["desimal"];

$tabla = mysql_query("SELECT * FROM tb_fee where username='$x1' and id='$x2'"); 
while ($registro = mysql_fetch_array($tabla)) { 
$sisaphnya=$pecahan * $registro["saldo"];
$ferpax=$registro["id"];
$ferpa=$registro["paket"];
$ferp=$registro["saldo"];
$pairnya=$ferpa - $ferp;
$frozenStatus=$registro["status"];
if($frozenStatus=='pending'){$button='info'; $mystats='Pending';} else
  if($frozenStatus=='problem'){$button='warning'; $mystats='Problem';} else
  if($frozenStatus=='reject'){$button='danger'; $mystats='Reject';} else
  if($frozenStatus=='sukses'){$button='success'; $mystats='Success';} else
  if($frozenStatus=='dilock'){$button='warning'; $mystats='Wait Transfer DP';}
  if($frozenStatus=='dikunci'){$button='warning'; $mystats='Wait To Open Pair';}
echo "
<div id_order=\"". $registro["idtrx"] ."\" class=\"ordin \" id=\"order_in_". $registro["idtrx"] ."\" style=\"cursor: pointer;\">
<table border=\"0\" cellpadding=\"0\" cellspacing=\"6\" width=\"100%\">
<tbody><tr>
<td><img src=\"/img/strelka32.png\" height=\"32\" width=\"32\"></td>
<td class=\"ord_title\"><span class=\"translate\">Request to DP </span><br><span class=\"order_in_id\"> <b>$skph ". $registro["idtrx"] ."</b></span></td>
</tr>
<tr>
<td colspan=\"2\" class=\"ord_body\">
<div class=\"ord_body_info\">
<span class=\"translate\">Participant</span> : 
<span class=\"order_in_fio\"> ". $registro["username"] ." </span><br>
<span class=\"translate\">Amount</span> : <span class=\"order_in_amount\">$matauang ". number_format($registro["paket"]) ."</span> <span class=\"order_in_currency\"></span><br>
<span class=\"rest_in\"><span class=\"translate\">Balance Remaining</span> : <span class=\"order_in_rest\">$matauang ". number_format($registro["saldo"]) ."</span> <span class=\"order_in_currency\"></span><br></span>
<span class=\"translate\">Date</span> : <span class=\"order_in_date\">". date("l, d M Y ",$registro["date"]) ."</span><br>
<span class=\"translate\">Status</span> : <span class=\"order_in_status\">". $mystats ."</span>
</div>
<div class=\"ord_body_is_avto\"><img src=\"/img/avto37.png\" alt=\"\"></div>
</td>
</tr>
</tbody></table>
</div> ";
}
}


?>
