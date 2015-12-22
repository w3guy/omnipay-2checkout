<!DOCTYPE html>
<html lang="en">
<head>
    <title>Example Form</title>
    <script type="text/javascript" src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<body>
<form id="myCCForm" action="https://www.mysite.com/examplescript.php" method="post">
    <input name="token" type="hidden" value="" />
    <div>
        <label>
            <span>Card Number</span>
            <input id="ccNo" type="text" value="" autocomplete="off" required />
        </label>
    </div>
    <div>
        <label>
            <span>Expiration Date (MM/YYYY)</span>
            <input id="expMonth" type="text" size="2" required />
        </label>
        <span> / </span>
        <input id="expYear" type="text" size="4" required />
    </div>
    <div>
        <label>
            <span>CVC</span>
            <input id="cvv" type="text" value="" autocomplete="off" required />
        </label>
    </div>
    <input type="submit" value="Submit Payment" />
</form>

<script>
    // Called when token created successfully.
    var successCallback = function(data) {
        var myForm = document.getElementById('myCCForm');

        // Set the token as the value for the token input
        myForm.token.value = data.response.token.token;

        alert(data.response.token.token);
        console.log(data);
        // IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
        //myForm.submit();
    };

    // Called when token creation fails.
    var errorCallback = function(data) {
        // Retry the token request if ajax call fails
        if (data.errorCode === 200) {
            // This error code indicates that the ajax call failed. We recommend that you retry the token request.
        } else {
            alert(data.errorMsg);
            console.log(data);
        }
    };

    var tokenRequest = function() {
        // Setup token request arguments
        var args = {
            sellerId: "901290261",
            publishableKey: "4B2956B5-F307-4133-9889-590EBFB8EEFC",
            ccNo: $("#ccNo").val(),
            cvv: $("#cvv").val(),
            expMonth: $("#expMonth").val(),
            expYear: $("#expYear").val()
        };

        // Make the token request
        TCO.requestToken(successCallback, errorCallback, args);
    };

    $(function() {
        // Pull in the public encryption key for our environment
        TCO.loadPubKey('sandbox');

        $("#myCCForm").submit(function(e) {
            // Call our token request function
            tokenRequest();

            // Prevent form from submitting
            return false;
        });
    });

</script>
</body>
</html>