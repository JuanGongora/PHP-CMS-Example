/**
 * https://stackoverflow.com/questions/3535996/jquery-javascript-functione-what-is-e-why-is-it-needed-what-does-it-ac
 *
 * Send links of class "delete" via post after a confirmation dialog
 *
 * If user has Javascript turned off in their browser, then the PHP version that was
 * already built (i.e. delete-article.php, delete-article-image.php) will be run instead
 */
$("a.delete").on("click", function(e) {

    e.preventDefault()

    if (confirm("Are you sure?")) {

        //creates an html form element on the fly in order to reference a post method
        //JavaScript creates a form in code and submits that to the URL in the href attribute of the link (forms are not actioned through urls but with JS we are able to do this)
        var frm = $("<form>");
        frm.attr('method', 'post');
        //this is creating an action that links to a delete url that is described in the id tag that #delete-article comes from (delete-article.php)
        frm.attr('action', $(this).attr('href'));
        //adds this dynamic form into the body of the html page as it's submitted through the delete action
        frm.appendTo("body");
        frm.submit();
    }
});

//created a custom validator for publication dates
$.validator.addMethod("dateTime", function(value, element) {
    return (value == "") || ! isNaN(Date.parse(value));
}, "Must be a valid date and time!");

/**
 * form will now dynamically check that all subjects are set, this is all done without checking for validation
 * through the server as would be required by the PHP logic that was previously set in Article.php, thus its faster
 * its important to note however, that it's still necesarry to keep the server side validations (like the deletes above)
 * in case Javascript is turned off by client
 */
$("#formArticle").validate({
   rules: {
       title: {
           required: true
       },
       content: {
           required: true
       },
       published_at: {
           dateTime: true
       }
   }
});

$("button.publish").on("click", function (e) {

    //$this variable represents the button class being clicked, with the .data function
    //passing in the name of the data attribute we want, without the 'data' prefix
    var id = $(this).data("id");

    //using this to later reference the <td> tag which encapsulates its operation
    var button = $(this);

    //use ajax to direct to article id of page as a post request
    $.ajax({
        url: '/admin/publish-article.php',
        type: 'POST',
        data: {id: id}
    })
        .done(function (data) {

            //selecting the <td> tag, then passing in the data from the enclosed request
            //which replaces the content within the <td> with the <time> element from ajax
            button.parent().html(data);
        });
});