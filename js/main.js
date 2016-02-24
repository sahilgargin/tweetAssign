$(document).ready(function(){
    
    $(".SearchB").keydown(function(){
        
        if ($(this).val().length >= 2)
        {
            loadFromkw($(this).val());
        }
        else
        {
            document.getElementById("autoFill").innerHTML = "";
            $("#BlockDis").css("display","hidden");
        }
        
    });
    $(".SearchB").keyup(function(){
        if ($(this).val().length >= 2)
        {
            loadFromkw($(this).val());
            console.log($(this).val());
        }
        else
        {
            document.getElementById("autoFill").innerHTML = "";
            $("#BlockDis").css("display","hidden");
        }
    });
    
    function loadFromkw(keyword)
    {
        document.getElementById("autoFill").innerHTML = "";
        
            $.ajax(
	{		
            type: "GET",
            url: window.location.hostname+"/api/userAutoFill.php?kw="+keyword,
            dataType: "json",
            success: function (response)
            {
                if(response.users)
                {
                    
                    var div ="";
                    for (i=0; i< response.users.number_sets; i++)
                    {
                        
                        div += '<a href="" style = "text-decoration: none; color: black; font-family: calibri, helvetica, arial; "><div id="'+response.users.row[i].id+'" class="styleTab">'+response.users.row[i].Name+'</div></a>\r\n';   
                        $("#BlockDis").css("display","block");
                        document.getElementById("autoFill").innerHTML = div;
                        
                        
                    }
                    
                }
            }
        });
    }

});