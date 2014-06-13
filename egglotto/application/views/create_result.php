<?php
	$this->load->view("common/header");
	$this->load->view("common/bootstrap");
	
	$option = '<option value="0">Choose game to upload</option>';
	
	foreach($result as $key=>$val){
		$option.='<option value="'.$val['intID'].'">'.$val['strLottoGame'].'</option>';
	}
	if($csv!=0){
		$table_row = "";
		$switch = 0;
		$row_count = 0;
		foreach($csv as $key=>$val){
			
			if($switch==0){
				$class = "active";
				$switch = 1;
			} else {
				$class = "";
				$switch = 0;
			}
			$table_row .= '<tr class="'.$class.'">
								<td class="'.$key.'-0">'.$val[0].'</td>
								<td class="'.$key.'-1">'.$val[1].'</td>
								<td class="'.$key.'-2">'.$val[2].'</td>
								<td class="'.$key.'-3">'.$val[3].'</td>
								<td class="'.$key.'-4">'.$val[4].'</td>
								<td class="'.$key.'-5"><i class="glyphicon glyphicon-download"></i></td>
							</tr>';
			$row_count++;
		}
	} else {
		$table_row = '<tr>
						<td>No Data</td>
						<td>No Data</td>
						<td>No Data</td>
						<td>No Data</td>
						<td>No Data</td>
						<td><i class="glyphicon glyphicon-download"></i></td>
					</tr>';
	}
?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/theme.v1.css">
	<div class="form">
		<div class="div-top">
			<div class="div-selgame">
				<label for="selgame"></label>
				<select name="selgame" id="selgame" class="selgame"><?php echo $option;?></select>
			</div>
			<div class="div-btnupload">
				<button class="btn btn-primary" onclick="get_row();">Save Data</button>
			</div>
		</div>
		<div class="div-progressbar">
			<div class="progressbar">
			</div>
		</div>
		<div class="div-table">
			<table id="datatable" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Game Type</th>
						<th>Draw</th>
						<th>Draw Date</th>
						<th>Price</th>
						<th>Winner</th>
						<th>Save</th>
					</tr>
				</thead>
				<tbody>
<?php
	echo $table_row;
?>
				</tbody>
			</table>
		</div>
	</div>
	<script>
		row_count = <?php echo $row_count;?>;
	</script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/create_result.js"></script>
<?php
	$this->load->view("common/footer");
?>