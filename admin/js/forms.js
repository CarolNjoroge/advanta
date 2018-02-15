//submit item

$("#submititem").click(function()
{
var form = $('#product_form').get(0); 
var fd = new FormData(form);
fd.append('fileupload',$("#fileupload").val());
fd.append('product_name',$('#product_name').val());
fd.append('product_desc',$('#product_desc').val());
fd.append('product_price',$('#product_price').val());
//console.log(fd);

var fileupload = $("#fileupload").val();
var product_name = $("#product_name").val();
var product_desc = $("#product_desc").val();
var product_price = $("#product_price").val();

if (product_name == "" || product_name == "Please enter a valid name")
{
	$("#product_name").val("Please enter a valid name").addClass('error');
	return false;
}
 else if (product_desc == "" || product_desc == "Please enter a valid description")
{
	$("#product_desc").val("Please enter a valid description").addClass('error');
	return false;
}
	else if (product_price == "" || product_price == "Please enter a valid price (plain number)" || isNaN(product_form.product_price.value))
{
	$("#product_price").val("Please enter a valid price (plain number)").addClass('error');
	return false;
}

else
{
	//var values=$('#product_form').serialize();

	$.ajax({
		url: "ajax.php",
		type: "post",
		data: fd, task: 'sub_item',
		processData: false,  //Add this
		contentType: false, //Add this
		//data: values,
		success: function(html){
			html=$.trim(html);	
			

				$("#success").html('Item has been added').removeClass('error').addClass('success-msg').fadeIn(100, function() {
					$("#success").delay(4000).fadeOut(400);
				});
			
		},
		error:function(){
		}
	});
}

});

//submit edited item
$("#submitedititem").click(function()
{
var form = $('#editproduct_form').get(0); 
var fd = new FormData(form);
fd.append('fileupload',$("#fileupload").val());
fd.append('product_name',$('#product_name').val());
fd.append('product_desc',$('#product_desc').val());
fd.append('product_price',$('#product_price').val());
fd.append('id',$('#id').val());
//console.log(fd);

var fileupload = $("#fileupload").val();
var product_name = $("#product_name").val();
var product_desc = $("#product_desc").val();
var product_price = $("#product_price").val();
var id = $("#id").val();

if (product_name == "" || product_name == "Please enter a valid name")
{
	$("#product_name").val("Please enter a valid name").addClass('error');
	return false;
}
 else if (product_desc == "" || product_desc == "Please enter a valid description")
{
	$("#product_desc").val("Please enter a valid description").addClass('error');
	return false;
}
	else if (product_price == "" || product_price == "Please enter a valid price (plain number)")
{
	$("#product_price").val("Please enter a valid price (plain number)").addClass('error');
	return false;
}

else
{
	//var values=$('#editproduct_form').serialize();

	$.ajax({
		url: "ajax.php",
		type: "post",
		data: fd, task: 'edit_item',
		processData: false,  //Add this
		contentType: false, //Add this
		//data: values,
		success: function(html){
			html=$.trim(html);					

				$("#success").html('Item has been edited').removeClass('error').addClass('success-msg').fadeIn(100, function() {
					$("#success").delay(4000).fadeOut(400);
				});
		},
		error:function(){
		}
	});
}

});

//product_name
	 $("#product_name").click(function()
    {
        var product_name = $("#product_name").val();

        if (product_name == "Please enter a valid name")
        {
            $("#product_name").val("");
            return false;
        }
    });


    $("#product_name").on("keyup", function()
    {
        var product_name = $("#product_name").val();
        if (product_name != "Please enter a valid name" && product_name != "")
        {
            $("#product_name").removeClass('error');

        }
    });

//product_desc
	 $("#product_desc").click(function()
    {
        var product_desc = $("#product_desc").val();

        if (product_desc == "Please enter a valid description")
        {
            $("#product_desc").val("");
            return false;
        }
    });


    $("#product_desc").on("keyup", function()
    {
        var product_desc = $("#product_desc").val();
        if (product_desc != "Please enter a valid description" && product_desc != "")
        {
            $("#product_desc").removeClass('error');

        }
    });

//product_price
	 $("#product_price").click(function()
    {
        var product_price = $("#product_price").val();

        if (product_price == "Please enter a valid price (plain number)")
        {
            $("#product_price").val("");
            return false;
        }
    });


    $("#product_price").on("keyup", function()
    {
        var product_price = $("#product_price").val();
        if (product_price != "Please enter a valid price (plain number)" && product_price != "")
        {
            $("#product_price").removeClass('error');

        }
    });
