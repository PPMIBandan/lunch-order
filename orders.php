<!doctype html>
<?php
	require_once "./assets/inc/config.php";
	require_once "./assets/inc/auth.php";
	
	if(!isset($_SESSION["user"]))
	{
		echo "<script type='text/javascript'>window.location.href='./index.php';</script>"; 
		$pdo = null;
		exit;
	}

	$money = 0;
	$count = 0;

	$sql = "SELECT
		".$menu_table.".price AS price,
		".$order_table.".qty AS qty
	FROM
		".$order_table.",
		".$menu_table.",
		".$class_table.",
		".$student_table."
	WHERE
		".$menu_table.".id = ".$order_table.".menu_id AND 
		DATE(".$order_table.".date) = CURDATE() AND
		".$student_table.".class = ".$class_table.".id AND
		".$order_table.".stu_num = ".$student_table.".id AND
		".$class_table.".id = '".$_SESSION['class']."'
	ORDER BY ".$order_table.".menu_id DESC";

	$result = $pdo->query($sql)->fetchAll(); 
	if(count($result)>0){
		foreach($result as $row){
			$money += $row['price']*$row['qty'];
			$count += $row['qty'];
		}
	}
?>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="./assets/img/icon.ico"/>
	<link rel="bookmark" href="./assets/img/icon.ico"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>DinBenDon | 今日訂單</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!--  Material Dashboard CSS    -->
	<link href="./assets/css/material-dashboard.min.css" rel="stylesheet" />
	<!--     Fonts and icons     -->
	<link href="./assets/css/font-awesome.css" rel="stylesheet" />
	<link href="./assets/css/googlefonts.css" rel="stylesheet" />
	<link href="./assets/css/custom.css" rel="stylesheet" />
	<link href="./assets/css/l2d.css" rel="stylesheet" />
	<link href="./assets/css/viewbox.css" rel="stylesheet" />
	<link rel="manifest" href="./assets/others/manifest.json">
</head>

<body class="off-canvas-sidebar">
	<?php include("./assets/inc/bg.php"); ?>
    <?php include("./assets/inc/nav.php");	?>
	<div class="wrapper wrapper-full-page" style="display:none">
		<div class="" style="padding-top: 13vh;">
			<div class="content">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="card" style="padding: 20px">
								<div class="card-content">
									<?php
										if(isset($today_res) && !empty($today_res))
										{?>
											<div id="info" style='text-align:center;'>
												<a href="res.php?id=<?=$today_res?>"><h2><?=$today_name?></h2></a>
												<h4>電話:<?=$today_tel?><br>地址:<?=$today_address?></h4>
											</div>
										<?php
										}
										else
										{?>
											<div id="info" style='text-align:center;'>
												<h2>今天還沒有人訂餐喔</h2>	
											</div>
										<?php
										}
									?>
									<hr>
									<div class="material-datatables">
										<table id="ordertable" class="table col-md-auto nowrap table-rwd" style="width:100%	">
											<thead class="text-rose">
												<tr class="tr-only-hide">
													<th>便當</th>
													<th>價格</th>
													<th>數量</th>
													<th>訂餐者</th>
												</tr>
											</thead>
											<tbody>
												<?php
												
												?>
											</tbody>
										</table>
									</div>
									<br>
									<p class="text-danger text-center">
										紅色的名字代表有備註
									</p>
									<p class="text-danger text-center">
										總金額：<span id="money"><?=$money?></span><br>
										總數量：<span id="total"><?=$count?></span><br>
										<button class="btn btn-success" id="btn-csv">
											<i class="fas fa-download"></i>&emsp;下載值日生用 CSV
										</button>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<footer class="footer">
					<?php include("./assets/inc/footer.php"); ?>
				</footer>
			</div>
		</div>
    </div>
</body>
<!-- Core Js  -->					
<script src="./assets/js/core/jquery.min.js"></script>
<script src="./assets/js/core/popper.min.js"></script>
<script src="./assets/js/core/bootstrap-material-design.min.js"></script>
<script src="./assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!-- Notify -->
<script src="./assets/js/plugins/bootstrap-notify.js"></script>
<!--  Plugin for Sweet Alert -->
<script src="./assets/js/plugins/sweetalert2.js"></script>
<!-- Forms Validations Plugin -->
<script src="./assets/js/plugins/jquery.validate.min.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
<script src="./assets/js/plugins/jquery.dataTables.min.js"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="./assets/js/plugins/nouislider.min.js"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="./assets/js/plugins/core.js"></script>
<!-- Library for adding dinamically elements -->
<script src="./assets/js/plugins/arrive.min.js"></script>
<!-- Custom orders for datatables -->
<script src="./assets/js/plugins/datatables-order.js"></script>
<!-- Responsive datatables -->
<script src="./assets/js/plugins/responsive.bootstrap.js"></script>
<!-- Live 2D Plugin -->
<script src="./assets/js/plugins/live2d.js"></script>
<!-- TweenMax -->
<script src="./assets/js/plugins/TweenMax.min.js"></script>
<script src="./assets/js/plugins/TimelineMax.min.js"></script>
<!-- Custom JS -->
<script src="./assets/js/plugins/custom.js"></script>
<!-- Material dashboard JS -->
<script src="./assets/js/core/material-dashboard.min.js"></script>
<script async defer src="./assets/js/plugins/buttons.js"></script>
<!-- Loading bar JS -->
<script src="./assets/js/plugins/loading-bar.js"></script>
<!-- Export Excel -->
<script src="./assets/js/plugins/xlsx.mini.min.js"></script>
<script src="./assets/js/inc/loading.js"></script>
<script type="text/javascript">
	$(function () {
		let ordertable = $('#ordertable').DataTable( {
            "language": {
                "url": "./assets/others/datatables-chinese-traditional.json"
            },
			"lengthMenu": [
                [30, 50, -1],
                [30, 50, "全部"]
            ],
			"columns": [
            	{ data: 'name'},
            	{ data: 'price'},
            	{ data: 'count'},
				{ data: 'people'}
          	],
			"columnDefs": [ 
				{
			      "targets": 0,
				  "createdCell":  function (td, cellData, rowData, row, col) {
         			  $(td).attr('data-th', '便當'); 
					}
				},
				{
			      "targets": 1,
				  "createdCell":  function (td, cellData, rowData, row, col) {
         			  $(td).attr('data-th', '價格'); 
					}
				},
				{
			      "targets": 2,
				  "createdCell":  function (td, cellData, rowData, row, col) {
         			  $(td).attr('data-th', '數量'); 
					}
				},
				{
			      "targets": 3,
			      "searchable": false,
				  "orderable": false,
				  "createdCell":  function (td, cellData, rowData, row, col) {
         			  $(td).attr('data-th', '訂餐者'); 
					}
				}
			],
			"ajax": "./assets/inc/api.php?do=getorder",
			drawCallback: function () {
				let money = 0, total = 0;
				$('[data-toggle="popover"]').popover();
				$('#ordertable').find("tbody tr").each(function(){
					let m = $(this).find("td").eq(1).text()*1;
					let t = $(this).find("td").eq(2).text()*1;
					money += (m*t);
					total += t;
				})
				$("#money").text(money);
				$("#total").text(total);
				
				let temp = []
				$("[id^=popover]").each(function(){
					let top = $(this).css("top")
					let left = $(this).css("left")
					let json = {top, left}
					let has = temp.filter(t=>{
						return t === json
					})
					if(has) {
						$(this).remove()
					}
					else {
						temp.push(json)
					}
				})
			}
        });
	
		setInterval( function () {
			ordertable.ajax.reload();
		}, 3000 );

		$("#btn-csv").click(function(){
			$.get("./assets/inc/api.php?do=getcsv", function(data) {
				let csvdata = [
					['座號', '姓名', '價格']
				]
				console.log(data)
				for(let i=0;i<data.length;i++) {
					csvdata.push([data[i].num, data[i].sname, data[i].total])
				}
				let wb = XLSX.utils.book_new()
				let ws = XLSX.utils.aoa_to_sheet(csvdata);
				XLSX.utils.book_append_sheet(wb, ws, "");
				XLSX.writeFile(wb, "點餐.csv");
			}, "json")
		})

		<?php
			include("./assets/js/inc/loginform.js");
			include("./assets/js/inc/l2d.js");
		?>
	});
</script>
</html>
<?php
$pdo = null;
?>