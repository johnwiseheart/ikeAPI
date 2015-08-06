<?php 
$loc = $_GET['loc']; 
?>
<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>IKEA Australia API Client (js)</title>

  
  <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/ikeapi.css">
  

  <script src="js/vendor/custom.modernizr.js"></script>
</head>
<body>
    <div id="wrap">
        <div id="main">
            <div class="row">
                <div class="large-7 columns">
			         <h2><img src="img/ikea.gif" style="height:0.8em;margin-top:-0.22em" /> API Client (js)</h2>
                </div>
                <div class="large-5 columns">
                    <div class="row collapse">
                        <div class="small-6 columns" style="margin-top:10px">
                            <input type="text" id="id" placeholder="Item ID" value="" style="height:50px;font-size:1.5em" />
                        </div>
                        <div class="small-6 columns" style="margin-top:10px">
                            <a id="button" class="button prefix" style="height:50px;font-size:1.5em">Search <?php echo $loc; ?></a>
                        </div>
                      </div>
                </div>
	        </div>

	        <div class="row">
		        <div class="large-12 columns">
                 <div style="margin-top:-20px"><hr /></div>
                    <div class="row">
                       
                        <div class="large-12 columns">
                            <div class="panel" id="panel">
                            <div id="spinme" style="height:60px"></div>
                            <div id="hideDiv">
                                <div style="float:right"><img id="image" style="height:200px;" src=""/><br /><br />

                                <span id="fpricelabel"><strong> Family Price:</strong><br />
                                <span id="fprice"></span><br /><br /></span>

                                <span id="pricelabel"><strong>Price:</strong><br />
                                <span id="price"></span><br /></span></div>

                                <h3 id="name"></h3>
                                <h5 id="type"></h5>

                                <span id="desc"></span><br /><br />
                                
                                <span id="keyfeatlabel"><strong>Key Features:</strong><br /> 
                                <span id="keyfeat"></span><br /><br /></span>

                                <span id="matslabel"><strong>Materials:</strong><br /> 
                                <span id="mats"></span><br /><br /></span>

                                <span id="metriclabel"><strong>Metric:</strong><br /> 
                                <span id="metric"></span></span>

                                <span id="gtklabel"><strong>Good to Know:</strong><br /> 
                                <span id="gtk"></span><br /><br /></span>
                                
                                <span id="carelabel"><strong >Care:</strong><br /> 
                                <span id="care"></span><br /><br /></span>

                                <span id="packInfolabel"><strong>Pack Info:</strong> <br />
                                <span id="packInfo"></span><br /><br /></span>

                                

                                

                                </div>
                                <span id="msg">Please enter an item code.</span>
                            </div>
                            <span style="font-size:10px;">ikeAPI is not associated with or endorsed by IKEA International Group.</span>
                        </div>
                    </div>
		        </div>
            </div>
        </div>
    </div>

<div id="infoModal" class="reveal-modal">
  <h2>Welcome to ikeAPI.</h2>
  <p class="lead">This page is an example client for the IKEA API which I have written.</p>
  <p>By default, the api searches the Australian IKEA website, however by adding <tt>?loc=US</tt> or another country code to the URL, you can change the country - I know that the US works, although I have not tried any other countries.</p>
  <a class="close-reveal-modal">&#215;</a>
</div>



  <script>
  document.write('<script src=' +
  ('__proto__' in {} ? 'js/vendor/zepto' : 'js/vendor/jquery') +
  '.js><\/script>')
  </script>
  
  <script src="js/foundation.min.js"></script>
  
  <script>
    $(document).foundation();
  </script>
<script src="js/jquery.maskedinput.min.js"></script>
<script src="js/spin.min.js"></script>
    <script>
        var opts = {
          lines: 13, // The number of lines to draw
          length: 0, // The length of each line
          width: 10, // The line thickness
          radius: 20, // The radius of the inner circle
          corners: 1, // Corner roundness (0..1)
          rotate: 27, // The rotation offset
          direction: 1, // 1: clockwise, -1: counterclockwise
          color: '#000', // #rgb or #rrggbb or array of colors
          speed: 1.6, // Rounds per second
          trail: 80, // Afterglow percentage
          shadow: false, // Whether to render a shadow
          hwaccel: false, // Whether to use hardware acceleration
          className: 'spinner', // The CSS class to assign to the spinner
          zIndex: 2e9, // The z-index (defaults to 2000000000)
          top: 'auto', // Top position relative to parent in px
          left: 'auto' // Left position relative to parent in px
        };
        var target = document.getElementById('spinme');
        var spinner = new Spinner(opts).spin(target);


        function updateSpan(spanID, data) {
            if (data!='') {
                $('#'+spanID+'label').show();
                $('#'+spanID).html(data);
            } else {
                $('#'+spanID+'label').hide();
            }
        }


        $(function() {
        	$('#infoModal').foundation('reveal', 'open');
            $('#hideDiv').hide();
            $('input').mask("999.999.99");
            $( "#button" ).trigger( "click" );
            $('#spinme').hide();
            $("#button").click( function() {
                $.getJSON("ikeapi.php?id="  + $("#id").val().split('.').join("") 
                                            + '&' +'loc=<?php echo $loc; ?>', function(data) {
                    if (!($.isEmptyObject(data[0]))) {
                        $('#spinme').show();
                        updateSpan('name',data[0].name);
                        updateSpan('type',data[0].type);
                        updateSpan('desc',data[0].description);
                        updateSpan('keyfeat',data[0].keyFeatures);
                        updateSpan('mats',data[0].materials);
                        updateSpan('metric',data[0].metric);
                        updateSpan('gtk',data[0].goodToKnow);
                        updateSpan('care',data[0].care);
                        updateSpan('packInfo',data[0].packInfo);
                        updateSpan('price',data[0].price);
                        updateSpan('fprice',data[0].familyPrice);
                        $('#image').attr("src",data[0].image);
                        $('#msg').html('');
                        $('#spinme').hide();
                        $('#hideDiv').show();

                    } else {
                       $('#hideDiv').hide();
                       $('#msg').html('No item found. Please enter an item code.');
                    }
                });
            });

             $('#id').on('keypress', function (event) {
                if(event.which == '13'){
                    $( "#button" ).trigger( "click" );
                }
            });
            
        });
</script>
</body>
</html>
