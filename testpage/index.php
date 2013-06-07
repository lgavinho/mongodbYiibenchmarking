<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>API Test Benchmarking</title>
        <script type="text/javascript" src="jquery-2.0.2.min.js"></script>        
    </head>
    <body>
        <h1>
            Test page to benchmarking test
        </h1>       
        
        <button id="loadEvents">Load events</button>
        
        <hr>

        <div id="grid">
        </div>
        
        <div id="fulldata"></div>
        
        <script type="text/javascript" defer="defer">
            
            var url = "http://beta1.ingresse.com.br/index.php/api/events?from=today&district=AM";
            //var url = "http://localhost/ingresse-api/index.php/api/events?from=today&district=AM";
            
            $('#loadEvents').click(function() {
                
                var createCORSRequest = function(method, url) {
                    var xhr = new XMLHttpRequest();
                    if ("withCredentials" in xhr) {
                      // Most browsers.
                      xhr.open(method, url, true);
                    } else if (typeof XDomainRequest != "undefined") {
                      // IE8 & IE9
                      xhr = new XDomainRequest();
                      xhr.open(method, url);
                    } else {
                      // CORS not supported.
                      xhr = null;
                    }
                    return xhr;
                };
                
                var method = 'GET';
                var xhr = createCORSRequest(method, url);

                xhr.onload = function(e) {
                    // Success code goes here.
                    console.log(e.target.response);
                    var JSONdata = JSON.parse(e.target.response);
                    var events = JSONdata.data; 
                    var grid = $('#grid');
                    grid.empty();

                    for (item in events) {
                        grid.append('<p>' + events[item].title + '</p>');                                
                    }
                    var pageInfo = JSONdata.paginationInfo;
                    grid.append("<p> página " + pageInfo.currentPage + " de " + pageInfo.lastPage + " (" + pageInfo.totalResults + ")");
                };

                xhr.onerror = function() {
                  // Error code goes here.
                };

                xhr.send();
            
 
        /*
                $.support.cors = true;
                $.ajax({
			type: 'GET',
			url: url,
			dataType: 'text',
                        crossDomain: true,
                        contentType: 'application/json',                        
			success: function(data){                                                       
                            var JSONdata = JSON.parse(data);
                            var events = JSONdata.data; 
                            var grid = $('#grid');
                            grid.empty();
                            
                            $('#fulldata').empty();
                            $('#fulldata').append(data);
                            
                            for (item in events) {
                                grid.append('<p>' + events[item].title + '</p>');                                
                            }
                            var pageInfo = JSONdata.paginationInfo;
                            grid.append("<p> página " + pageInfo.currentPage + " de " + pageInfo.lastPage + " (" + pageInfo.totalResults + ")");                            
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            console.log(xhr.status);
                            alert(thrownError);
                        }
		}); */
               
            });
        
        </script>
        
    </body>
</html>
