$(document).ready(function(){
    
   $(".loadinger").css("display", "none");
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
        twId = document.getElementById("twitId").innerHTML;
        document.getElementById("autoFill").innerHTML = "";
        
            $.ajax(
	       {		
            type: "GET",
            url: "api/userAutoFill.php?kw="+keyword+"&tw="+twId,
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
        
        
        $(".loadinger").css("display", "block");
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
                    if(response.users.row[0].tweets != 'undefined')
                    {
                        for (j=0; j<response.users.row[0].tweets.length; j++)
                        {
                            innerCon = innerCon+"<li><div class='content'><img src='' /><h3>"+response.users.row[0].tweets[j].text+"</h3><p>"+response.users.row[0].tweets[j].created_at+"</p></div></li>";
                            
                        } 
                        document.getElementById("whoTweet").innerHTML = "Tweets by "+response.users.row[0].name+":";  
                    }
                    else 
                    {
                         document.getElementById("whoTweet").innerHTML = "No tweets by "+response.users.row[0].name; 
                    }
                    
                }
                innerCon = innerCon+"<div class='fs-icon' title='Expand/Close'></div></div></div>";
                document.getElementById("ninja-slider").innerHTML = innerCon;
                scrollToElement('.tweet_box', 100);
                
                nslider.init();
               


            }
        });
       $(".loadinger").css("display", "none");
        return false;
    }

    var scrollToElement = function(el, ms){
    var speed = (ms) ? ms : 600;
    $('html,body').animate({
        scrollTop: $(el).offset().top
    }, speed);
}
