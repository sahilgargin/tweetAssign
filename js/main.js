$(document).ready(function(){
    
   
    $("#sbox").keydown(function(){
        
        if ($(this).val().length >= 1)
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
            url: "api/userAutoFill.php?kw="+keyword,
            dataType: "json",
            success: function (response)
            {
                //console.log(response);
                if(response.users)
                {
                    
                    var div ="";
                    for (i=0; i< response.users.number_sets; i++)
                    {
                        div += '<a  href="#" onclick="getTweetData('+response.users.row[i].id+');  return false;"   style = "text-decoration: none; color: black; font-family: calibri, helvetica, arial; "><div id="'+response.users.row[i].id+'" class="styleTab">'+response.users.row[i].name+'</div></a>\r\n';   
                        $("#BlockDis").css("display","block");
                        document.getElementById("autoFill").innerHTML = div;
                        
                        
                    }
                    
                }
            }
        });
    }


});

    function getTweetData(id)
    {
        
            $.ajax(
           {        
            type: "GET",
            url: "api/userAutoFill.php?twid="+id,
            dataType: "json",
            success: function (response)
            {
                document.getElementById("autoFill").innerHTML = "";
                var nsOptions =
                    {
                        sliderId: "ninja-slider",
                        transitionType: "slide", //"fade", "slide", "zoom", "kenburns 1.2" or "none"
                        autoAdvance: true,
                        delay: "default",
                        transitionSpeed: "default",
                        aspectRatio: "4:1",
                        initSliderByCallingInitFunc: true,
                        shuffle: false,
                        startSlideIndex: 0, //0-based
                        navigateByTap: true,
                        pauseOnHover: false,
                        keyboardNav: true,
                        before: null,
                        license: "mylicense"
                    };

                    var nslider = new NinjaSlider(nsOptions);
                //nslider.toggle();
                document.getElementById("ninja-slider").innerHTML = "";
                innerCon = "<div class='slider-inner'><ul>";
                if(response.users)
                {
                    //console.log(response.users.row[0].tweets);
                    
                        for (j=0; j<response.users.row[0].tweets.length; j++)
                        {
                            innerCon = innerCon+"<li><div class='content'><img src='' /><h3>"+response.users.row[0].tweets[j].text+"</h3><p>"+response.users.row[0].tweets[j].created_at+"</p></div></li>";
                            
                        }
                    
                }
                innerCon = innerCon+"<div class='fs-icon' title='Expand/Close'></div></div></div>";
                document.getElementById("ninja-slider").innerHTML = innerCon;
                nslider.init();
               


            }
        });
       
        return false;
    }