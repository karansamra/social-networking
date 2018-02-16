var post = {

    /**
     * Save method saves data on the server and shows
     * a message accordingly.
     * It also triggers the method which displays post.
     * @author Jaskaran Singh
     * @version 1.0
     */
    save: function() {
        var self = this;
        var form = $('form#composePostForm')[0];
        var formData = new FormData(form);
        console.log(formData);

        $.ajax({
            url: "/posts",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            contentType: false,          // The content type used when sending data to the server.
            cache: false,                // To unable request pages to be cached
            processData: false,          // To send DOMDocument or non processed data file it is set to false
            success: function(result,status,xhr) {
                // If success.
                if (xhr.status == '200' || xhr.status == '201') {
                    var msgHtml = self.getMessageHTML(result.message, result.status);
                } else {
                    var msgHtml = self.getMessageHTML(result.message, result.status)
                }

                $("div.postComposerCard").prepend(msgHtml);

                // Remove message after 5 seconds.
                setTimeout(function(){
                    $("div.jsMessage").slideUp(function(){
                        $(this).remove();
                    });
                }, 5000);
                $('form#composePostForm').trigger("reset");
            },
            error: function(xhr,status,error) {
                if (xhr.status == '422'){
                    var msgHtml = self.getMessageHTML("Please upload a valid Image. The extensions allowed are JPEG, PNG, BMP, JPG, GIF, TIFF.", 3);
                } else {
                    var msgHtml = self.getMessageHTML("Oops! some error has occurred! Please try again.", 3)
                }
                $("div.postComposerCard").prepend(msgHtml);


                // Remove message after 5 seconds.
                setTimeout(function() {
                    $("div.jsMessage").slideUp(function(){
                        $(this).remove();
                    });
                }, 5000);
            }
        });
    },

    getByUserId: function(userId) {

    },

    /**
     * Returns the HTML of bootstrap alerts.
     * @param msg
     * @param status (can be 1,2,3; 1 = success, 2 = warning, 3 = error)
     * @author Jaskaran Singh
     * @version 1.0
     */
    getMessageHTML: function(msg, status) {
        var msgHtml = '';
        msgHtml += '<div class="alert jsMessage';
        switch (status) {
            case 1:
            case '1':
                msgHtml += ' alert-success ';
                break;
            case 2:
            case '2':
                msgHtml += ' alert-warning ';
                break;
            case 3:
            case '3':
                msgHtml += ' alert-danger ';
                break;
        }
        msgHtml += '" role="alert">'+msg+'</div>';
        return msgHtml;
    }
}
$(document).ready(function(){

});