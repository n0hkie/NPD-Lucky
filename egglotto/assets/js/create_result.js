x = 0;
type = 0;
function get_row(){
	
	if(x<=row_count){
		data_obj(x);
		x++;
	} else {
		x=0;
	}
}
function data_obj(x){
	type = $("#selgame").val();
	if(type!=0){
		if($("."+x+"-0").text()=="" || $("."+x+"-1").text()=="" || $("."+x+"-2").text()=="" || $("."+x+"-3").text()=="" || $("."+x+"-4").text()==""){
			/*skip area*/
			setTimeout(function(){
				get_row();
			},50);			
		} else {	
			$("."+x+"-5").html('<i class="glyphicon glyphicon-refresh"></i>');
			data = {
						"intLottoType":type,
						"0":$("."+x+"-0").text(),
						"1":$("."+x+"-1").text(),
						"2":$("."+x+"-2").text(),
						"3":$("."+x+"-3").text(),
						"4":$("."+x+"-4").text()
					}
			setTimeout(function(){
				save_data(data,x);
			},50);
		}
	} else {
			alert("Choose game to upload.");
	}
}
function save_data(data_sent,x){

	xfunc = base_url+"result/create";
	
	$.ajax({ 
		type: "POST",
		url: xfunc, 
		data: data_sent,
		dataType:'json',
		success: function(result,status,xhr){ 
			
			if(result==0){
				$("."+x+"-5").html('<i class="glyphicon glyphicon-remove"></i> Existing');
			} else {
				console.log(result);
				if(result.error_tbl==1){
					$("."+x+"-5").html('<i class="glyphicon glyphicon-remove"></i> Combination error.');
				} else {				
					if(result.status==0){
						$("."+x+"-5").html('<i class="glyphicon glyphicon-ok"> '+result.message+'</i>');
					} else {
						$("."+x+"-5").html('<i class="glyphicon glyphicon-remove"> '+result.message+'</i>');
					}
				}
			}
		},
		complete: function(xhr,status){ 
			percent = (x/row_count)*100;
			$(".progressbar").width(percent+'%');
			setTimeout(function(){
				get_row();
			},50);					
		},
		error: function(xhr,status,error){
			$("."+x+"-5").html('<i class="glyphicon glyphicon-remove"></i>');
		}
	});
}