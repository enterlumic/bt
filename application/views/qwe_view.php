<script>
  $(function () {

        let url;
        url= "https://api.eposnowhq.com/api/v4/Transaction";
        url= "https://api.eposnowhq.com/api/v4/Device";
        url= "https://api.eposnowhq.com/api/v4/Product";

        var request = {
            url: url,
            type: "GET",
            contentType: "application/json",
            accepts: "application/json",
            dataType: 'json',
            crossDomain: true,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Basic " + "STM4WjVRMTNHUVJXMjZTV0owVkI2NTdYTzVBOURJVTE6MENLR1VTUUc1UUlBVDNHSzcxSUZGTVhLVkZTUEJISE4=");
            },
            success: function(data) {
                console.log("data", data);
            },
            error: function (jqXHR) {
                console.log("ajax error " + jqXHR.status);
            }
        };
        
        $.ajax(request);

  });
</script>
