<!doctype html>
<?php
	require_once "./assets/inc/config.php";
	require_once "./assets/inc/auth.php";
	
	// 沒登入
	if(!isset($_SESSION["user"]))
	{
		echo "<script type='text/javascript'>window.location.href='./index.php';</script>"; 
		exit;
	}
	
	$id = -1;

	if(!empty($_GET["id"]))
	{
		$id = $_GET["id"];
		
		// ID不是數字，回上一頁
		if(!is_numeric($id))	
		{
			echo "<script type='text/javascript'>window.location='./addres.php';</script>"; 
			$pdo = null;
			exit;
		}
		
		$sql = "SELECT * FROM ".$rest_table." WHERE id = ".$id."";
		$result = $pdo-> query($sql)->fetchAll(); 
		if (count($result) > 0) 
		{ 
			foreach($result as $row)
			{
				$name = $row['name'];
				$tel = $row['tel'];
				$address = $row['address'];
				
				if(!empty($row["menu"]) && file_exists("./assets/img/res/menu/".$row["menu"]))
					$menupic = "./assets/img/res/menu/".$row["menu"];
				
				if(!empty($row["cover"]) && file_exists("./assets/img/res/pic/".$row["cover"]))
					$coverpic = "./assets/img/res/pic/".$row["cover"];
			}
		}
		else
		{
			echo "<script type='text/javascript'>window.location='./addres.php';</script>"; 
			$pdo = null;
			exit;
		}
	}
?>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="./assets/img/icon.ico"/>
	<link rel="bookmark" href="./assets/img/icon.ico"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>DinBenDon | <?=((!empty($name))?"編輯餐廳":"新增餐廳")?></title>
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
					<form id="resform">
						<input type="hidden" name="resid" value="<?=$id?>">
						<div class="row">
							<div class="col-lg-12">
								<div class="card">
									<div class="card-header card-header-text card-header-rose">
										<div class="card-text">
											<h4 class="card-title">基本資料</h4>
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											<div class='col-lg-12 text-center'>
												<div class='fileinput fileinput-new text-center' data-provides='fileinput' id='uploadteamlogoinput'>
													<div class='fileinput-new thumbnail'>
														<img src="<?=((!empty($coverpic))?$coverpic:"./assets/img/res/pic/unknown.jpg")?>" alt='...' style=''>
													</div>
													<div class='fileinput-preview fileinput-exists thumbnail'></div>
													<div>
														<span class='btn btn-rose btn-round btn-file'>
															<span class='fileinput-new'>選擇圖片</span>
															<span class='fileinput-exists'>變更</span>
															<input type='file' name='cover' id='cover' class='cover' accept='image/jpeg, image/png' />
														</span>
														<a class='btn btn-danger btn-round fileinput-exists' data-dismiss='fileinput'><i class='fas fa-lg fa-times'></i> 移除</a>
														<br>
														<div class='stats'><i class='material-icons text-danger'>warning</i> <font color='#FF0000'>檔案限制: 1 MB, 600x450, jpg/png</font></div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-2 col-form-label">餐廳名字</label>
											<div class="col-sm-10">
												<div class="form-group">
													<input class="form-control" type="text" name="resname" value="<?=((!empty($name))?$name:"")?>"/>			
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-2 col-form-label">餐廳電話</label>
											<div class="col-sm-10">
												<div class="form-group">
													<input class="form-control" type="text" name="tel" value="<?=((!empty($tel))?$tel:"")?>" />
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-2 col-form-label">餐廳地址</label>
											<div class="col-sm-10">
												<div class="form-group">
													<input class="form-control" type="text" name="address" value="<?=((!empty($address))?$address:"")?>" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="card">
									<div class="card-header card-header-text card-header-rose">
										<div class="card-text">
											<h4 class="card-title">菜單圖片</h4>
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											<div class='col-lg-12 text-center'>
												<div class='fileinput fileinput-new text-center' data-provides='fileinput' id='uploadteamlogoinput'>
													<div class='fileinput-new thumbnail'>
														<img src="<?=((!empty($menupic))?$menupic:"./assets/img/res/pic/unknown.jpg")?>" alt='...' style=''>
													</div>
													<div class='fileinput-preview fileinput-exists thumbnail'></div>
													<div>
														<span class='btn btn-rose btn-round btn-file'>
															<span class='fileinput-new'>選擇圖片</span>
															<span class='fileinput-exists'>變更</span>
															<input type='file' name='menupic' id='menupic' class='menupic' accept='image/jpeg, image/png' />
														</span>
														<a class='btn btn-danger btn-round fileinput-exists' data-dismiss='fileinput'><i class='fas fa-lg fa-times'></i> 移除</a>
														<br>
														<div class='stats'><i class='material-icons text-danger'>warning</i> <font color='#FF0000'>檔案限制: 1 MB, jpg/png</font></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-header card-header-text card-header-success">
										<div class="card-text">
											<h4 class="card-title">菜單</h4>
										</div>
									</div>
								<div class="card-body">
									<div class='material-datatables'>
										<table id="menu" class="table col-md-auto nowrap table-rwd">
											<thead class="text-rose">
												<tr class="tr-only-hide">
													<th>項目</th>
													<th>價格</th>
													<th>操作</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>項目</th>
													<th>價格</th>
													<th>操作</th>
												</tr>
											</tfoot>
											<tbody>
												<?php
													if($id != -1)
													{
														$sql = "select * from ".$menu_table." where res_id = '".$id."'";
														$result = $pdo-> query($sql)->fetchAll();  
														if (count($result) > 0)  
														{
															foreach($result as $row)
															{
																?>
																<tr>
																	<td data-th="項目">
																		<input type='text' value='<?=$row["name"]?>' name='name[]' class='namemenu'>
																	</td>
																	<td data-th="價格">
																		<input type='number' value='<?=$row["price"]?>' name='price[]' class='pricemenu'>
																	</td>
																	<td data-th="操作">
																		<button type='button' class='delmenu btn btn-danger btn-link'>
																			<i class='material-icons'>close</i>
																		</button>
																		<div style="display:none">
																			<input type="checkbox" name="del[]" style="" value="<?=$row["id"]?>">
																			<input type="text" name="id[]" style="" value="<?=$row["id"]?>">
																		</div>
																	</td>
																</tr>
																<?php
															}
														}
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="card-footer justify-content-center">
									<input type="button" class='btn btn-primary btn-lg' style="padding: 15px 36px; font-size: 20px;" value="新增菜單" id="newmenub" data-toggle="modal" data-target="#modal_form">
									&emsp;
									<input type="button" class='btn btn-success btn-lg' style="padding: 15px 36px; font-size: 20px;" value="保存資料" id="saveres">
								</div>
							</div>		
						</div>
					</div>
				</div>	
				<footer class="footer">
					<?php include("./assets/inc/footer.php"); ?>
				</footer>
				<a id="btn-top" href="#" class="btn btn-rose btn-round btn-lg btn-top" role="button" title="回頁首" data-toggle="tooltip" data-placement="left">
					<i class="material-icons">
					arrow_upward
					</i>
				</a>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_form" role="dialog" tabindex="-1" style="display:none;" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">新增</h3>
				</div>
				<div class="modal-body form">
					<div class="row">
						<label class="col-sm-2 col-form-label">名稱</label>
						<div class="col-sm-10">
							<div class="form-group bmd-form-group">
								<input class='form-control' type='text' name='modalname' id='modalname' required='true'/>
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-sm-2 col-form-label">價格</label>
						<div class="col-sm-10">
							<div class="form-group bmd-form-group">
							<input class='form-control' type='number' id='modalprice' name='modalprice' required='true'/>
							</div>
						</div>
					</div>
					<br />
				</div>
				<div class="modal-footer">
					<input type="button" id="savemenum" class="btn btn-primary" value="確定" />
				</div>
			</div>
		</div>
	</div>
</body>	
<!-- Core Js  -->					
<script src="./assets/js/core/jquery.min.js"></script>
<script src="./assets/js/core/popper.min.js"></script>
<script src="./assets/js/core/bootstrap-material-design.min.js"></script>
<script src="./assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!-- Plugin for the momentJs  -->
<script src="./assets/js/plugins/moment.min.js"></script>
<!-- Notify -->
<script src="./assets/js/plugins/bootstrap-notify.js"></script>
<!--  Plugin for Sweet Alert -->
<script src="./assets/js/plugins/sweetalert2.js"></script>
<!-- Forms Validations Plugin -->
<script src="./assets/js/plugins/jquery.validate.min.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
<script src="./assets/js/plugins/jquery.dataTables.min.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="./assets/js/plugins/jasny-bootstrap.min.js"></script>
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
<script src="./assets/js/inc/loading.js"></script>
<script type="text/javascript">
	$(document).ready( function () {	
		let menutable = $('#menu').DataTable( {
			"language": {
				"url": "./assets/others/datatables-chinese-traditional.json"
			},
			"lengthMenu": [
				[15, 50, -1],
				[15, 50, "全部"]
			],
			"columnDefs": [ 
				{
			      "targets": 0,
			      "searchable": true,
				  "orderDataType": "dom-text", type: 'string'
			    }, 
				{
			      "targets": 1,
			      "searchable": true,
				  "orderDataType": "dom-text"
			    }, 
				{
			      "targets": 2,
			      "searchable": false,
				  "orderable": false
			    }, 
			],
		})
		
		<?php
			include("./assets/js/inc/loginform.js");
			include("./assets/js/inc/addres.js");
			include("./assets/js/inc/l2d.js");
		?>
	});
</script>
</html>
<?php
	$pdo = null;
?>