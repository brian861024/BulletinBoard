<?php
// require "/htdocs/Backend/Model/dao/messageDaoPdo.php";
// require "/htdocs/Backend/Model/bean/message.php";
require "/htdocs/Backend/Controller/messageController.php";

$messageDaoPdo = new messageDaoPdo;

if($a = $messageDaoPdo -> findMessages()){
    echo'<pre>'; print_r($a) ; echo '</pre>';
} else {
    echo 'n';
}


// <!-- 透過分類查找留言的隱藏表單 -->
// <form class="pure-form pure-form-aligned" action="../Backend/Service/messageService.php" method="post" id="findMessageByCategoryForm"  style = "display:none;">
//   <!-- 用來分辨要使用哪一個controller方法 -->
//   <input type="hidden" name="functionName" value="findMessageByCategory">

//   <input type="hidden" name="categoryId" value="' . $category->getId() . '">
// </form>

// <!-- 提交以上之隱藏的表單 -->
// <script>
//   function findMessageByCategory() {
//     document.getElementById("findMessageByCategoryForm").submit();
//   }
// </script>




// $(document).ready(function(){
// 	$("#submitBtn").click(function(){
// 		let period     = $("#period");
// 		let formImport = $("#form_import");
// 		let tableName  = $("#table_name").val();
// 		let upload     = $("#upload");
// 		$(".error").remove();
// 		//未輸入期別，顯示必填
// 		if(period.val() == ""){
// 			period.after($("<label></label>").addClass("error").html("必填")).focus();
// 		}
// 		//未選擇檔案，顯示必填
// 		if(upload.val() == ""){
// 			upload.after($("<label></label>").addClass("error").html("必填"));
// 		}
// 		var errorLength = $(".error").length;
// 		if(errorLength == 0){
// 			var sendData = {"_token" : "{!! csrf_token() !!}", "table_name" : tableName, "period" : period.val() };
// 			$.ajax({
// 				url:"{{ route('XXXX') }}",
// 				data: sendData,
// 				type: "POST",
// 				dataType: "json",
// 				beforeSend:function(){
// 					$.blockUI();
// 				},
// 				success:function(result){
// 	                var exist = result.exist;
// 					var msg = result.msg;
// 					if(exist){
// 						//資料表已存在相同期別資料，顯示confirm告知使用者是否繼續執行匯入						
// 						if(confirm(msg)){
// 							formImport.submit();
// 						}else{
// 							$.unblockUI();
// 						}
// 					}else{
// 						if(msg != ""){
// 							alert(msg);
// 							$.unblockUI();
// 						}else{
// 							formImport.submit();
// 						}
// 					}
// 				},
// 				error:function(xhr, ajaxOptions, thrownError){
// 					alert("期別資料驗證發生錯誤");
// 					$.unblockUI();
// 				},
// 			});
// 		}		
// 	});
// });



?>