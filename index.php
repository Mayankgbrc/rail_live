<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Xsonic Rail Live Status | Live Train Tracking | Running Status of Indian Railway</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
          (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-9757289779386871",
            enable_page_level_ads: true
          });
        </script>
        <style type="text/css">
            body{
                font-family: Arail, sans-serif;
            }
            /* Formatting search box */
            .search-box{
                width: 300px;
                position: relative;
                display: inline-block;
                font-size: 14px;
            }
            .search-box input[type="text"]{
                height: 32px;
                padding: 5px 10px;
                border: 1px solid #CCCCCC;
                font-size: 14px;
            }
            .result{
                position: absolute;        
                z-index: 999;
                top: 100%;
                left: 0;
            }
            .search-box input[type="text"], .result{
                width: 100%;
                box-sizing: border-box;
            }
            /* Formatting result items */
            .result p{
                margin: 0;
                padding: 7px 10px;
                border: 1px solid #CCCCCC;
                border-top: none;
                cursor: pointer;
            }
            .result p:hover{
                background: #f2f2f2;
            }
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function(){
            $('.search-box input[type="text"]').on("keyup input", function(){
                /* Get input value on change */
                var inputVal = $(this).val();
                var resultDropdown = $(this).siblings(".result");
                if(inputVal.length){
                    $.get("test.php", {term: inputVal}).done(function(data){
                        // Display the returned data in browser
                        resultDropdown.html(data);
                    });
                } else{
                    resultDropdown.empty();
                }
            });
            
            // Set search input value on click of result item
            $(document).on("click", ".result p", function(){
                var data =$(this).text();
                var arr = data.split(' ');
                $(this).parents(".search-box").find('input[type="text"]').val(arr[0]);
                $(this).parent(".result").empty();
            });
        });
        </script>
        <script>
        function sendto()
        {
                num1 = document.getElementById("in").value;
                document.getElementById("out").value = num1;
        }
        </script>
    </head>
<body >
    <header class="w3-container w3-teal w3-center">
      <h1>Xsonic Rail Tracking</h1>
    </header>
    <div class="w3-container">
        <h3>Enter train number: </h3>
            <div class="search-box">
                <input type="text" autocomplete="off" placeholder="" id="in" required/>
                <div class="result w3-pale-red w3-text-black"></div>
            </div>
        <h3>Choose train start date: </h3>
        <form method="get" action="buffer.php">
            <input type="hidden" name="t_no" id="out" required/>
            <input id="textbox" type="date" name="date" required></input>
    		<button onClick="sendto()" type="submit" class="w3-button w3-black w3-round">Search</button>
        </form>
    </div>
    <footer class="w3-container w3-teal w3-center" style="position:fixed;bottom:0;left:0;width:100%;">
      <h4>Developed with <span class="w3-text-red">&hearts;</span> by <a href="https://www.facebook.com/mayankgbrc" target="_blank">Mayank Gupta</a> </h4>
    </footer>
</body>
</html>
