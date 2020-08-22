<?php
	ob_start();
	// include(dirname(__FILE__).'/res/pdf_demo.php');
	require_once('conn.php');

	$id = $_GET['id'];

 	$consulta_invoice = mysqli_query($connect, "SELECT * FROM joborders WHERE id='$id' ");

  while ($extraido_email = mysqli_fetch_array($consulta_invoice)) {
	
		$client_id= $extraido_email['client_id'];
		$supplier_id= $extraido_email['supplier_id'];	
		$agent_id= $extraido_email['agent_id'];		
		$service= $extraido_email['service'];
		$commodity= $extraido_email['commodity'];
		$remark= $extraido_email['remark'];
		$payment= $extraido_email['payment'];
		$wh_receipt= $extraido_email['wh_receipt'];
		$fecha= $extraido_email['fecha'];
		$fondo='';
    }

	$consulta_supplier = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$supplier_id' ORDER BY id asc ") or die ("Error al traer los datos222");
	while ($rowsupplier = mysqli_fetch_array($consulta_supplier)){  
		$supplier_company=$rowsupplier['company'];
		$supplier_name=$rowsupplier['name'];
		$supplier_email=$rowsupplier['email'];
		$supplier_address1=$rowsupplier['address_1'];
		$supplier_address2=$rowsupplier['address_2'];
		$supplier_city=$rowsupplier['city'];
		$supplier_state=$rowsupplier['state'];
		$supplier_country=$rowsupplier['country'];
		$supplier_telf1=$rowsupplier['telf1'];
		$supplier_telf2=$rowsupplier['telf2'];
		$supplier_qq=$rowsupplier['qq'];
		$supplier_wechat=$rowsupplier['wechat'];
		$supplier_address= $supplier_address1.' '.$supplier_address2.' | '.$supplier_city.', '.$supplier_state.' - '.$supplier_country.'.';
	    if ($supplier_telf1!='') {$supplier_telf1=' - Mobile: '.$supplier_telf1;}
		if ($supplier_telf2!='') {$supplier_telf2=' - Office: '.$supplier_telf2;}
		if ($supplier_qq!='') {$supplier_qq=' - QQ: '.$supplier_qq;}
		if ($supplier_wechat!='') {$supplier_wechat=' - WeChat: '.$supplier_wechat;}
		$supplier_telf=$supplier_telf1.$supplier_telf2.$supplier_qq.$supplier_wechat;
	}

	$consulta_customer = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$client_id' ORDER BY id asc ") or die ("Error al traer los datos222");
	while ($rowcustomer = mysqli_fetch_array($consulta_customer)){  
	
		$customer_company=$rowcustomer['company'];
		$customer_name=$rowcustomer['name'];
		$customer_email=$rowcustomer['email'];
		$customer_address1=$rowcustomer['address_1'];
		$customer_address2=$rowcustomer['address_2'];
		$customer_city=$rowcustomer['city'];
		$customer_state=$rowcustomer['state'];
		$customer_country=$rowcustomer['country'];
		$customer_telf1=$rowcustomer['telf1'];
		$customer_telf2=$rowcustomer['telf2'];
		$customer_qq=$rowcustomer['qq'];
		$customer_wechat=$rowcustomer['wechat'];
		$customer_address= $customer_address1.' '.$customer_address2.' | '.$customer_city.', '.$customer_state.' - '.$customer_country.'.';
		if ($customer_telf1!='') {$customer_telf1=' - Mobile: '.$customer_telf1;}
		if ($customer_telf2!='') {$customer_telf2=' - Office: '.$customer_telf2;}
		if ($customer_qq!='') {$customer_qq=' - QQ: '.$customer_qq;}
		if ($customer_wechat!='') {$customer_wechat=' - WeChat: '.$customer_wechat;}
	
		$customer_telf=$customer_telf1.$customer_telf2.$customer_qq.$customer_wechat;
	}

	$consulta_agent = mysqli_query($connect, "SELECT * FROM agents WHERE id='$agent_id' ORDER BY id asc ") or die ("Error al traer los datos222");
	while ($rowagent = mysqli_fetch_array($consulta_agent)){  
	
		$agent_name=$rowagent['name'];
		$agent_email=$rowagent['email'];
	}
	require_once(dirname(__FILE__).'/tc-barcode/vendor/autoload.php');
	$barcode = new \Com\Tecnick\Barcode\Barcode();
	$targetPath = "barcode/";
    
    if (! is_dir($targetPath)) {
        mkdir($targetPath, 0777, true);
    }
	$MRP = $id;
	$data=strtotime($fecha);
	$productData = $id;
	// echo $data;
	$barcode = new \Com\Tecnick\Barcode\Barcode();
	$productData = str_pad($id, 4, '0', STR_PAD_LEFT);
    $bobj = $barcode->getBarcodeObj('C128', "{$productData}", 150, 30, 'black', array(
        0,
        0,
        0,
        0
    ));
    
    $imageData = $bobj->getPngData();
    $timestamp = time();
    
	file_put_contents($targetPath . $id . '.png', $imageData);
	
	$img=$targetPath . $id . '.png';

	$content = ob_get_clean();
	$content = '';

	
    $content .= '
	
    <style>
		
		table {
			border-collapse: collapse;
			display: table;
			width:100%;
		}
		td{
			border: 2px solid #000;
			vertical-align: inherit;
			padding: 5px 0px;
			
		}
		p{
			padding:0px;
			margin:2px;
		}
		.small_text{
			font-size:10px;
		}
		.sm_text{
			font-size:12px;	
		}
		#box_pieces td{
			border: 1px solid #333;
			font-size:10px;
			vertical-align: inherit;
		}
		h3{
			font-weight:800;
		}
		h2,h3,h4{
			margin-top:3px;
			margin-bottom:0px;
		}
		</style>
		<div style="width:750px;">		
			<div style="margin-left:30px; margin-right:30px;">
				<table style="width:100%; margin-top:-30px;">
					<tr>
						<td style="width:150px;border:none;">
							<img src="./img/logoChina.png" alt="" style="width:100px; height:120px;">
						</td>
						<td style="width:300px;text-align:center;border:none">
							<img src="./img/a.jpg" alt="" style="width:300px; margin-top:30px;">
						</td>
						<td style="width:240px; text-align:right;border:none">
							<h4 style="margin-top:40px;margin-bottom:0px;">Warehouse Entry N° <strong style="color:red">'.$id.'</strong></h4>					
							<img style="text-align:right;padding-top:10px;" src="'.$img.'" alt=""  >	
						</td>
					</tr>
				</table>
								
			</div>
			<div style="margin-left:30px; margin-right:30px; margin-top:20px;">				
				<table style="width:100%;">
					<tr>
						<td colspan="2" style="width:690px; text-align:center;border-left:none;border-right:none">
							<img src="./img/b.jpg" alt="" style="width:690px">
						</td>						
					</tr>
					<tr>
						<td colspan="2" style="width:690px; text-align:center;border-left:none;border-right:none">
							<img src="./img/c.jpg" alt="" style="width:560px">
						</td>						
					</tr>
					<tr>
						<td  style="width:345px;border-left:none;padding:0px">
							<p class="sm_text"><img style="width:60px;" src="./img/text1.png"></p>
							<p >&nbsp;</p>
						</td>
						<td  style="width:345px;border-right:none;padding:0px">
							<p class="sm_text"><img style="width:180px;" src="./img/text2.png"></p>
							<p >'.$supplier_name.' / '.$supplier_company.'<br> [Supplier Account #'.$supplier_id.'].'.'</p>
						</td>						
					</tr>
					<tr>
						<td  style="width:345px;border-left:none;">						
							<div style="width:300px;float:left;display:inline"><p >'.$service.' to ['.$customer_city.', '.$customer_state.'].'.'</p></div>
							<div style="width:40px;float:left;display:inline;text-align:center"><img src="./img/venezuela.png" style="width:40px;margin:auto;margin-top:10px;"></div>
						</td>
						<td  style="width:345px;border-right:none;padding:0px">
							<p class="sm_text"><img style="width:160px;" src="./img/text3.png"></p>
							<p >'.$customer_name.' / '.$customer_company.'<br> [Customer Account #'.$client_id.'].'.'</p>
						</td>						
					</tr>
				</table>				
			</div>
			<div style="margin-left:30px; margin-right:30px;border-top:3x solid #000">				
				<table style="width:100%; max-width:690px;">					
					<tr>
						<td  style="width:100px;border-left:none;">						
							<p class="sm_text"><img style="width:30px; height:20px" src="./img/text4.png"></p>
							<p class="sm_text">SHIPPING MARK</p>
						</td>
						<td  style="width:166px;">
							<p class="sm_text"><img style="width:60px; height:20px" src="./img/text5.png"></p>
							<p class="sm_text">COMMODITY</p>							
						</td>						
						<td  style="width:100px;">
							<p class="sm_text" style="margin-top:25px;">VAULE($)</p>
						</td>
						<td  style="width:100px;">
							<p class="sm_text"><img style="width:30px; height:20px" src="./img/text6.png"></p>
							<p class="sm_text">PACKAGES</p>
						</td>
						<td  style="width:100px;">
							<p class="sm_text"><img style="width:60px; height:20px" src="./img/text5.png"></p>
							<p class="sm_text">VOLUME</p>
						</td>
						<td  style="width:100px;border-right:none">
							<p class="sm_text"><img style="width:60px; height:20px" src="./img/text5.png"></p>
							<p class="sm_text">WEIGHT</p>
						</td>						
					</tr>
					<tr>
						<td  style="border-left:none;width:100px;">						
							<p>&nbsp;</p>
						</td>
						<td style="width:166px;">
							<span>'.$commodity.'</span>						
						</td>						
						<td style="width:100px;">
							<p>&nbsp;</p>
						</td>
						<td style="width:100px;">
							<p>&nbsp;</p>
						</td>
						<td style="width:100px;">
							<p>&nbsp;</p>
						</td>
						<td  style="border-right:none;width:100px;">	
							<p>&nbsp;</p>						
						</td>						
					</tr>
					<tr>
						<td  style="border-left:none;width:100px;">						
							<p>&nbsp;</p>
						</td>
						<td style="width:166px;">
							<span>'.$commodity.'</span>						
						</td>						
						<td style="width:100px;">
							<p>&nbsp;</p>
						</td>
						<td style="width:100px;">
							<p>&nbsp;</p>
						</td>
						<td style="width:100px;">
							<p>&nbsp;</p>
						</td>
						<td  style="border-right:none;width:100px;">	
							<p>&nbsp;</p>						
						</td>						
					</tr>
					<tr>
						<td  style="border-left:none;width:100px;">						
							<p>&nbsp;</p>
						</td>
						<td style="width:166px;">
							<span>'.$commodity.'</span>						
						</td>						
						<td style="width:100px;">
							<p>&nbsp;</p>
						</td>
						<td style="width:100px;">
							<p>&nbsp;</p>
						</td>
						<td style="width:100px;">
							<p>&nbsp;</p>
						</td>
						<td  style="border-right:none;width:100px;">	
							<p>&nbsp;</p>						
						</td>						
					</tr>					
				</table>				
			</div>
			<div style="margin-left:80px; margin-right:80px; margin-top:20px;">				
				<table style="width:100%;">
					<tr>						
						<td style="width:590px;border:none;">							
							<img style="width:560px; margin-top:20px;" src="./img/map.jpg">				
						</td>				
					</tr>									
				</table>				
			</div>
		</div>';
		require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
		try
		{
			$html2pdf = new HTML2PDF('P', 'A4', 'en');
			$html2pdf->setDefaultFont('javiergb');
		
			$html2pdf->pdf->SetDisplayMode('fullpage');
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			$html2pdf->Output('JobOrder_'.$id.'.pdf'); 
		}
		catch(HTML2PDF_exception $e) { echo $e; }
				